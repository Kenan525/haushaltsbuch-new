<?php
declare(strict_types=1);

namespace Src\Utils;

use Src\Database\Database;

class Logger
{
    public static function log(int $userId, string $action): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $db = Database::getConnection();

        $stmt = $db->prepare("
            INSERT INTO logs (user_id, action, ip_address, created_at)
            VALUES (:user_id, :action, :ip, NOW())
        ");

        $stmt->execute([
            'user_id' => $userId,
            'action' => $action,
            'ip' => $ip
        ]);
    }
}
