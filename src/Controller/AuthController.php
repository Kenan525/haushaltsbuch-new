<?php
declare(strict_types=1);

namespace Src\Controller;

use Src\Database\Database;
use Src\Utils\Logger;

class AuthController extends AbstractController
{
    public function loginForm(): void
    {
        $this->view->render('login', [
            'error' => $_GET['error'] ?? '',
            //'csrf_token' => Csrf::getToken()
        ]);
    }

    public function start(): void
    {
        if ($this->auth->check()) {
            header('Location: /dashboard');
            exit;
        }

        header('Location: /login');
        exit;
    }

    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($this->auth->login($email, $password)) {
            header('Location: /dashboard');
            exit;
        }

        header('Location: /login?error=Login+fehlgeschlagen');
        exit;
    }

    public function logout(): void
    {
        $this->auth->logout();
        header('Location: /login');
        exit;
    }

    public function registerForm(): void
    {
        $this->view->render('register', [
            'error' => $_GET['error'] ?? ''
        ]);
    }

    public function register(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';

        if (empty($email) || empty($password)) {
            header('Location: /register?error=Ungültige+Eingaben');
            exit;
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO users (email, password_hash, first_name, last_name, role, is_active) VALUES (:email, :password_hash, :first_name, :last_name, :role, 1)');
        try {
            $stmt->execute([
                'email' => $email,
                'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'role' => 'user',
            ]);
            Logger::log((int)$pdo->lastInsertId(), 'Registrierung erfolgreich');
            header('Location: /login');
            exit;
        } catch (\Exception $e) {
            header('Location: /register?error=Registrierung+fehlgeschlagen');
            exit;
        }
    }
}
