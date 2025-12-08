<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XAMPP Docker - Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        .info {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🐳 XAMPP Docker - Funcionando</h1>
        
        <div class="info">
            <h2>Información del Sistema</h2>
            <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
            <p><strong>Servidor:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
            <p><strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>
        </div>

        <div class="info">
            <h2>Estado de Conexión MySQL</h2>
            <?php
            $host = 'mysql';
            $user = 'usuario';
            $pass = 'password';
            $db = 'testdb';
            
            try {
                $conn = new mysqli($host, $user, $pass, $db);
                if ($conn->connect_error) {
                    echo "<p style='color: red;'>❌ Error de conexión: " . $conn->connect_error . "</p>";
                } else {
                    echo "<p class='success'>✅ Conexión a MySQL exitosa</p>";
                    echo "<p><strong>Versión MySQL:</strong> " . $conn->server_info . "</p>";
                    $conn->close();
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
            }
            ?>
        </div>

        <div class="info">
            <h2>Extensiones PHP Cargadas</h2>
            <ul>
                <?php
                $extensions = get_loaded_extensions();
                sort($extensions);
                foreach ($extensions as $ext) {
                    echo "<li>$ext</li>";
                }
                ?>
            </ul>
        </div>

        <div class="info">
            <h2>Enlaces Útiles</h2>
            <ul>
                <li><a href="http://localhost:8888" target="_blank">phpMyAdmin (Puerto 8888)</a></li>
                <li><a href="http://localhost" target="_blank">Este sitio (Puerto 80)</a></li>
            </ul>
        </div>
    </div>
</body>
</html>

