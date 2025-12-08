<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once 'session_config.php';
session_destroy();
header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Sesión cerrada']);
exit;
?>

