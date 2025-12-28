<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once 'cors_config.php';
require_once 'session_config.php';
header('Content-Type: application/json');

require_once __DIR__ . '/../db_config.php';

// First try PHP session
if (isset($_SESSION['user']) && isset($_SESSION['user_id']) && isset($_SESSION['login_time'])) {
    $elapsed = time() - $_SESSION['login_time'];
    if ($elapsed < 600) {
        $isAdmin = isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : false;
        echo json_encode(['success' => true, 'user' => $_SESSION['user'], 'user_id' => $_SESSION['user_id'], 'is_admin' => $isAdmin, 'time_remaining' => 600 - $elapsed]);
        exit;
    } else {
        session_destroy();
        echo json_encode(['success' => false, 'message' => 'Sesión expirada']);
        exit;
    }
}

// If PHP session doesn't work, try token from cookie
$token = $_COOKIE['session_token'] ?? null;
if ($token) {
    $pdo = getDBConnection();
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM sessions WHERE token = ? AND expires_at > NOW()");
            $stmt->execute([$token]);
            $session = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($session) {
                $expiresAt = strtotime($session['expires_at']);
                $timeRemaining = max(0, $expiresAt - time());
                
                echo json_encode([
                    'success' => true,
                    'user' => $session['username'],
                    'user_id' => $session['user_id'],
                    'is_admin' => (bool)$session['is_admin'],
                    'time_remaining' => $timeRemaining
                ]);
                exit;
            }
        } catch (PDOException $e) {
            // Continue to return error
        }
    }
}

echo json_encode(['success' => false, 'message' => 'No hay sesión activa']);
exit;
?>

