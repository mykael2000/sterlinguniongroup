<?php
/**
 * Database Configuration
 * X Token Presale Platform
 */

// Prevent direct access
if (!defined('X_TOKEN_APP')) {
    define('X_TOKEN_APP', true);
}

// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'prim_xlaunch');
define('DB_USER', getenv('DB_USER') ?: 'prim_xlaunch');
define('DB_PASS', getenv('DB_PASS') ?: 'Tesxst32324@');
define('DB_CHARSET', 'utf8mb4');

// Site configuration
define('SITE_URL', getenv('SITE_URL') ?: 'https://sterlinguniongroup.com/xlaunch');
define('SITE_NAME', 'X Token Presale');

// Security configuration
define('CSRF_TOKEN_EXPIRY', 3600); // 1 hour
define('SESSION_LIFETIME', 86400); // 24 hours
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minutes

// File upload configuration
define('UPLOAD_MAX_SIZE', 5242880); // 5MB
define('UPLOAD_DIR', __DIR__ . '/../uploads/');

// PDO Database Connection
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Log error (in production, log to file instead of displaying)
    error_log("Database Connection Error: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}

// Global database connection
$GLOBALS['pdo'] = $pdo;

/**
 * Get database connection
 * @return PDO
 */
function getDB() {
    return $GLOBALS['pdo'];
}

// Session security - domain lock
define('SESSION_DOMAIN', $_SERVER['HTTP_HOST']);

// Prevent session fixation
if (isset($_SESSION['HTTP_USER_AGENT'])) {
    if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) {
        session_destroy();
        session_start();
    }
} else {
    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
}