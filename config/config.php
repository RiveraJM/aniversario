<?php
// Configuración de la aplicación
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$basePath = trim(dirname($scriptName), '/\\');

if (!empty($basePath) && preg_match('/(^|\/)public$/i', $basePath)) {
    $basePath = preg_replace('/\/public$/i', '', $basePath);
}

if ($basePath !== '' && $basePath !== '.') {
    $basePath = '/' . $basePath;
} else {
    $basePath = '';
}

define('BASE_URL', $protocol . $host . $basePath . '/');
define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Configuración de la base de datos (por ahora solo estructura)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'aniversario_db');

// Configuración de zona horaria
date_default_timezone_set('America/Lima');

// Configuración de errores (solo en desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
