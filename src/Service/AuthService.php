<?php
namespace Src\Service;

use Src\Database\Database;
use Src\Utils\Logger;

class AuthService
{
    public function login(string $email, string $password): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND is_active = 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role'],
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'image' => $user['image'] ?? null
            ];
            Logger::log($user['id'], 'Login erfolgreich');
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        session_destroy();
        $_SESSION = [];
    }

    public function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public function isAdmin(): bool
    {
        return $this->check() && $_SESSION['user']['role'] === 'admin';
    }
}
