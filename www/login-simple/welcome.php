<?php
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

