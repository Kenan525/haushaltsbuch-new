<?php
declare(strict_types=1);

use Src\Utils\Router;

session_start();
spl_autoload_register(static function ($class) {
    $prefix = 'Src\\';
    $base_dir = __DIR__ . '/../src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

require_once __DIR__ . '/../config/config.php';

$router = new Router();
$routeSetup = require __DIR__ . '/../config/routes.php';
$routeSetup($router);
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
