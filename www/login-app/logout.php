<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once 'cors_config.php';
require_once 'session_config.php';
header('Content-Type: application/json');

require_once __DIR__ . '/../db_config.php';

// Get token from request or session
$input = file_get_contents('php://input');
$data = json_decode($input, true);
$token = $data['session_id'] ?? $_SESSION['session_token'] ?? null;

// Delete token from database if provided
if ($token) {
    $pdo = getDBConnection();
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("DELETE FROM sessions WHERE token = ?");
            $stmt->execute([$token]);
        } catch (PDOException $e) {
            error_log("Error deleting session: " . $e->getMessage());
        }
    }
}

// Destroy PHP session
session_destroy();

echo json_encode(['success' => true, 'message' => 'Sesión cerrada']);
exit;
?>

