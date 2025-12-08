<?php
ini_set('session.cookie_httponly', 1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.gc_maxlifetime', 1800);

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido</title>
</head>
<body>
    <h1>Bienvenido <?php echo htmlspecialchars($_SESSION['user']); ?></h1>
    <p>Has iniciado sesión correctamente.</p>
    <p>ID de Sesión: <?php echo session_id(); ?></p>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>

