<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once 'cors_config.php';
require_once 'session_config.php';
header('Content-Type: application/json');

require_once __DIR__ . '/../db_config.php';

$pdo = getDBConnection();
if (!$pdo) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!is_array($data)) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

$username = $data['user'] ?? '';
$password = $data['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $username;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['login_time'] = time();
    echo json_encode(['success' => true, 'message' => 'Login exitoso']);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
}
exit;
?>

