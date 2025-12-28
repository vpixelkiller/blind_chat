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
    
    $envFile = '/root/.env';
    $adminUsername = 'admin';
    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            if (strpos($line, 'ADMIN_USERNAME=') === 0) {
                $adminUsername = trim(explode('=', $line, 2)[1]);
                break;
            }
        }
    }
    
    $isAdmin = ($username === $adminUsername);
    $_SESSION['is_admin'] = $isAdmin;
    
    // Generate a custom session token
    $sessionToken = bin2hex(random_bytes(32));
    $_SESSION['session_token'] = $sessionToken;
    $_SESSION['token_created'] = time();
    
    // Store token in database for verification across different ports
    $expiresAt = date('Y-m-d H:i:s', time() + 600); // 10 minutes
    try {
        // Delete any existing sessions for this user
        $stmt = $pdo->prepare("DELETE FROM sessions WHERE user_id = ?");
        $stmt->execute([$user['id']]);
        
        // Insert new session
        $stmt = $pdo->prepare("INSERT INTO sessions (token, user_id, username, is_admin, expires_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$sessionToken, $user['id'], $username, $isAdmin ? 1 : 0, $expiresAt]);
    } catch (PDOException $e) {
        error_log("Error storing session token: " . $e->getMessage());
        // Continue anyway - session will work with PHP sessions, just not cross-port
    }
    
    // Set token as cookie for browser (works when frontend and backend are on same domain/port)
    // Note: Cookies don't work across different ports (localhost:3000 vs localhost:80)
    // That's why we also use localStorage as fallback
    $cookieName = 'session_token';
    $cookieValue = $sessionToken;
    $expireTime = time() + 600; // 10 minutes
    $cookiePath = '/';
    $cookieDomain = ''; // Empty for current domain
    
    // Set secure flag based on HTTPS
    $secure = false;
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $secure = true;
    }
    
    $httponly = true; // Prevent JavaScript access for security
    $samesite = 'Lax'; // Allow cross-site requests from same site
    
    // Set cookie
    setcookie($cookieName, $cookieValue, $expireTime, $cookiePath, $cookieDomain, $secure, $httponly);
    
    echo json_encode(['success' => true, 'message' => 'Login exitoso', 'is_admin' => $isAdmin, 'session_id' => $sessionToken]);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
}
exit;
?>

