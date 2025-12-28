<?php
function getDBConnection() {
    $host = 'mysql';
    $db   = getenv('MYSQL_DATABASE') ?: 'testdb';
    $user = getenv('MYSQL_USER') ?: 'usuario';
    $pass = getenv('MYSQL_PASSWORD') ?: 'password';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Error de conexión a la base de datos: " . $e->getMessage());
        return null;
    }
}
?>

