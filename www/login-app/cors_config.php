<?php
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (!empty($origin)) {
    $parsedOrigin = parse_url($origin);
    $host = $parsedOrigin['host'] ?? '';
    $port = $parsedOrigin['port'] ?? '';
    
    if (in_array($host, ['localhost', '127.0.0.1', '0.0.0.0']) || $origin === 'null') {
        header("Access-Control-Allow-Origin: $origin");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
    }
} else {
    header("Access-Control-Allow-Origin: *");
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
?>

