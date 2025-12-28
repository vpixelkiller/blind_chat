<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once 'cors_config.php';
header('Content-Type: application/json');

require_once __DIR__ . '/../db_config.php';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$pdo = getDBConnection();
if (!$pdo) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}

// Check if we have a session token to verify
$providedToken = null;
if (is_array($data) && isset($data['session_id'])) {
    $providedToken = $data['session_id'];
}

if (!$providedToken) {
    echo json_encode(['success' => false, 'message' => 'No se proporcionó token de sesión']);
    exit;
}

// Verify token in database
try {
    $stmt = $pdo->prepare("SELECT * FROM sessions WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$providedToken]);
    $session = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($session) {
        // Calculate time remaining
        $expiresAt = strtotime($session['expires_at']);
        $timeRemaining = max(0, $expiresAt - time());
        
        echo json_encode([
            'success' => true,
            'user' => $session['username'],
            'user_id' => $session['user_id'],
            'is_admin' => (bool)$session['is_admin'],
            'time_remaining' => $timeRemaining
        ]);
    } else {
        // Token not found or expired, check if it exists at all
        $stmt = $pdo->prepare("SELECT * FROM sessions WHERE token = ?");
        $stmt->execute([$providedToken]);
        $expiredSession = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($expiredSession) {
            // Token exists but expired, clean up
            $stmt = $pdo->prepare("DELETE FROM sessions WHERE token = ?");
            $stmt->execute([$providedToken]);
            echo json_encode(['success' => false, 'message' => 'Sesión expirada']);
        } else {
            // Token doesn't exist
            error_log("Session token not found: " . substr($providedToken, 0, 10) . "...");
            echo json_encode(['success' => false, 'message' => 'Token de sesión no encontrado']);
        }
    }
} catch (PDOException $e) {
    error_log("Error checking session: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error al verificar sesión: ' . $e->getMessage()]);
}
exit;
?>

