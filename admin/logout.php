<?php
// Mulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kosongkan dan hancurkan session
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// Alihkan kembali ke halaman login
header("Location: login.php");
exit;
?>
