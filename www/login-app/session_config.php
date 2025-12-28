<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    
    // Set secure flag based on HTTPS
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', 1);
    } else {
        ini_set('session.cookie_secure', 0);
    }
    
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_samesite', 'Lax');
    ini_set('session.gc_maxlifetime', 600);
    ini_set('session.cookie_lifetime', 600);
    ini_set('session.cookie_domain', '');
    ini_set('session.cookie_path', '/');
    session_start();
    
    // Ensure session ID is generated
    if (empty(session_id())) {
        session_regenerate_id(true);
    }
}
?>

