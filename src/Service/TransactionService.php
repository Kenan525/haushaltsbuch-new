<?php
namespace Src\Service;

use Src\Database\Database;
use Src\Model\Transaction;

class TransactionService
{
    public function find(int $id): ?Transaction
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM transactions WHERE id = :id AND is_deleted = 0");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? new Transaction($row) : null;
    }

    public function getAllForUser(int $userId, array $filters = []): array
    {
        $db = Database::getConnection();
        $sql = "
            SELECT
                t.id,
                t.transaction_date,
                t.amount,
                t.description,
                GROUP_CONCAT(c.name SEPARATOR ', ') AS category
            FROM transactions t
            LEFT JOIN transaction_category tc ON tc.transaction_id = t.id
            LEFT JOIN categories c ON c.id = tc.category_id
            WHERE t.user_id = :user_id AND t.is_deleted = 0
        ";
        $params = ['user_id' => $userId];

        if (!empty($filters['month'])) {
            $sql .= ' AND MONTH(t.transaction_date) = :month';
            $params['month'] = (int)$filters['month'];
        }
        if (!empty($filters['year'])) {
            $sql .= ' AND YEAR(t.transaction_date) = :year';
            $params['year'] = (int)$filters['year'];
        }
        if (!empty($filters['category'])) {
            $sql .= ' AND EXISTS (SELECT 1 FROM transaction_category tc2 WHERE tc2.transaction_id = t.id AND tc2.category_id = :category)';
            $params['category'] = (int)$filters['category'];
        }
        if (!empty($filters['type'])) {
            if ($filters['type'] === 'income') {
                $sql .= ' AND t.amount > 0';
            } elseif ($filters['type'] === 'expense') {
                $sql .= ' AND t.amount < 0';
            }
        }

        $sql .= ' GROUP BY t.id ORDER BY t.transaction_date DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        $results = [];
        foreach ($stmt->fetchAll() as $row) {
            $results[] = $row;
        }
        return $results;
    }

    public function getMonthlySummary(int $userId): array
    {
        $db = Database::getConnection();
        $sql = "
            SELECT
                YEAR(t.transaction_date) AS year,
                MONTH(t.transaction_date) AS month,
                SUM(CASE WHEN t.amount >= 0 THEN t.amount ELSE 0 END) AS income,
                SUM(CASE WHEN t.amount < 0 THEN t.amount ELSE 0 END) AS expense
            FROM transactions t
            WHERE t.user_id = :user_id AND t.is_deleted = 0
            GROUP BY YEAR(t.transaction_date), MONTH(t.transaction_date)
            ORDER BY YEAR(t.transaction_date) DESC, MONTH(t.transaction_date) DESC
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO transactions (user_id, transaction_date, amount, description) VALUES (:user_id, :date, :amount, :description)");
        $stmt->execute($data);
        return (int) $db->lastInsertId();
    }

    public function update(array $data): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE transactions SET transaction_date = :date, amount = :amount, description = :description WHERE id = :id AND user_id = :user_id");
        $stmt->execute($data);
    }

    public function sync(int $transactionId, array $categoryIds): void
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("DELETE FROM transaction_category WHERE transaction_id = :id");
        $stmt->execute(['id' => $transactionId]);

        $stmt = $db->prepare("INSERT INTO transaction_category (transaction_id, category_id) VALUES (:tid, :cid)");
        foreach ($categoryIds as $catId) {
            $stmt->execute(['tid' => $transactionId, 'cid' => $catId]);
        }
    }

    public function getCategories(int $transactionId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT category_id FROM transaction_category WHERE transaction_id = :id
        ");
        $stmt->execute(['id' => $transactionId]);
        return array_column($stmt->fetchAll(), 'category_id');
    }

    public function softDelete(int $id, int $userId): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE transactions SET is_deleted = 1 WHERE id = :id AND user_id = :user_id");
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }
}
