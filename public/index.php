<?php
declare(strict_types=1);

date_default_timezone_set('America/Argentina/Buenos_Aires');

// Método HTTP
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// URI pedida
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';

// Quitar query string
$path = parse_url($requestUri, PHP_URL_PATH);

// 1. Obtenemos la ruta limpia
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 2. Limpieza agresiva: 
// Esto quita CUALQUIER cosa que esté antes del "public" o del nombre de tu carpeta
// y nos asegura que solo nos quede lo que sigue después.
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

// No encontrada
header('Content-Type: application/json; charset=utf-8');
http_response_code(404);
echo json_encode([
    'error' => 'Not Found',
    'path'  => $path
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
