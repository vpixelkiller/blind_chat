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

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Usuario y contraseña son requeridos']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode(['success' => false, 'message' => 'El usuario ya existe']);
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hash]);
    echo json_encode(['success' => true, 'message' => 'Usuario registrado correctamente']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al registrar usuario']);
}
exit;
?>

