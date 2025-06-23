<?php

use Src\Controller\AdminController;
use Src\Controller\AuthController;
use Src\Controller\CategoryController;
use Src\Controller\ProfileController;
use Src\Controller\TransactionController;
use Src\Utils\Router;
use Src\Controller\DashboardController;

return static function (Router $router) {
    $router->get('/', [AuthController::class, 'start']);
    $router->get('/login', [AuthController::class, 'loginForm']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->get('/logout', [AuthController::class, 'logout']);
    $router->get('/register/form', [AuthController::class, 'registerForm']);
    $router->post('/register/save', [AuthController::class, 'register']);
    $router->get('/dashboard', [DashboardController::class, 'index']);
    $router->get('/categories', [CategoryController::class, 'index']);
    $router->get('/categories/form', [CategoryController::class, 'form']);
    $router->post('/categories/save', [CategoryController::class, 'save']);
    $router->get('/categories/delete', [CategoryController::class, 'delete']);
    $router->get('/transactions', [TransactionController::class, 'index']);
    $router->get('/transactions/form', [TransactionController::class, 'form']);
    $router->post('/transactions/save', [TransactionController::class, 'save']);
    $router->get('/transactions/delete', [TransactionController::class, 'delete']);
    $router->get('/admin/users', [AdminController::class, 'userList']);
    $router->get('/admin/users/toggle', [AdminController::class, 'toggleUser']);
    $router->get('/admin/statistics', [AdminController::class, 'statistics']);
    $router->get('/profile', [ProfileController::class, 'show']);
    $router->post('/profile/update', [ProfileController::class, 'update']);
};
