<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once 'cors_config.php';
require_once 'session_config.php';
header('Content-Type: application/json');

if (isset($_SESSION['user']) && isset($_SESSION['login_time'])) {
    $elapsed = time() - $_SESSION['login_time'];
    if ($elapsed < 600) {
        echo json_encode(['success' => true, 'user' => $_SESSION['user'], 'time_remaining' => 600 - $elapsed]);
    } else {
        session_destroy();
        echo json_encode(['success' => false, 'message' => 'Sesión expirada']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No hay sesión activa']);
}
exit;
?>

