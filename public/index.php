<?php
declare(strict_types=1);

date_default_timezone_set('America/Argentina/Buenos_Aires');

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../config/database.php';

use App\Routes\Router;

// Método HTTP
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// 1. Obtenemos la ruta limpia (sin query string)
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// 2. Limpieza agresiva para entornos locales (XAMPP)
$publicPath = '/api-clases/public';
$rootPath = '/api-clases';

if (strpos($path, $publicPath) === 0) {
    $path = substr($path, strlen($publicPath));
} elseif (strpos($path, $rootPath) === 0) {
    $path = substr($path, strlen($rootPath));
}

// 3. Normalización final
$path = '/' . ltrim($path, '/');

// Ruta de prueba
if ($method === 'GET' && $path === '/health') {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);

    echo json_encode([
        'status'      => 'ok',
        'timestamp'   => date('Y-m-d H:i:s'),
        'php_version' => phpversion(),
        'server'      => $_SERVER['SERVER_SOFTWARE'] ?? 'Apache'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    exit;
}

// RUTEO

if ($path === '/items/new') {
    require_once __DIR__ . '/../src/Routes/Router.php';
    exit;
}
elseif ($path === '/items') {
    require_once __DIR__ . '/../src/Routes/Router.php';
    exit;
}


// No encontrada
header('Content-Type: application/json; charset=utf-8');
http_response_code(404);
echo json_encode([
    'error' => 'Not Found',
    'path'  => $path
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
