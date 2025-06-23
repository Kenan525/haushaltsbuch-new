<?php
declare(strict_types=1);

namespace Src\Service;

use Src\Database\Database;
use Src\Model\User;

class AdminService
{
    /**
     * @return User[]
     */
    public function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query('SELECT id, email, first_name, last_name, role, is_active FROM users ORDER BY id');
        $result = [];
        while ($row = $stmt->fetch()) {
            $result[] = new User($row);
        }
        return $result;
    }

    public function toggleActive(int $id): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE users SET is_active = IF(is_active = 1, 0, 1) WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function getUserCount(): int
    {
        $db = Database::getConnection();
        return (int)$db->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    public function getGlobal(): array
    {
        $db = Database::getConnection();
        $row = $db->query('
            SELECT 
                COUNT(*) AS total_transactions,
                SUM(CASE WHEN amount > 0 THEN amount ELSE 0 END) AS total_income,
                SUM(CASE WHEN amount < 0 THEN amount ELSE 0 END) AS total_expense,
                SUM(amount) AS total_amount,
                AVG(amount) AS avg_transaction
            FROM transactions
            WHERE is_deleted = 0
        ')->fetch();
        return $row ?: [];
    }

    public function getCategoryStats(): array
    {
        $db = Database::getConnection();
        return $db->query('
            SELECT c.name, COUNT(tc.transaction_id) AS count
            FROM categories c
            LEFT JOIN transaction_category tc ON tc.category_id = c.id
            GROUP BY c.id
            ORDER BY count DESC, c.name ASC
        ')->fetchAll();
    }
}
