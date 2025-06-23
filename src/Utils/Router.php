<?php
declare(strict_types=1);

namespace Src\Utils;

class Router
{
    private array $routes = [];

    public function get(string $path, $handler) { $this->routes['GET'][$path] = $handler; }
    public function post(string $path, $handler) { $this->routes['POST'][$path] = $handler; }
    public function put(string $path, $handler) { $this->routes['PUT'][$path] = $handler; }
    public function delete(string $path, $handler) { $this->routes['DELETE'][$path] = $handler; }

    public function dispatch(string $uri, string $method)
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $handler = $this->routes[$method][$path] ?? null;
        if ($handler) {
            if (is_array($handler)) {
                [$class, $fn] = $handler;
                (new $class)->$fn();
            } else {
                $handler();
            }
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
