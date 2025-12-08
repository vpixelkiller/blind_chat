<?php
session_start();
header('Content-Type: application/json');

$host = 'mysql';
$db   = 'testdb';
$user = 'usuario';
$pass = 'password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error BD']);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$user = $data['user'] ?? '';
$password = $data['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE user = ?");
$stmt->execute([$user]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($password, $usuario['password'])) {
    $_SESSION['user'] = $user;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
}
?>

