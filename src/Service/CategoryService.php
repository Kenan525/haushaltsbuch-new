<?php
namespace Src\Service;

use Src\Database\Database;
use Src\Model\Category;

class CategoryService
{
    public function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM categories ORDER BY name");
        $categories = [];
        while ($row = $stmt->fetch()) {
            $categories[] = new Category($row);
        }
        return $categories;
    }

    public function find(int $id): ?Category
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? new Category($row) : null;
    }

    public function save(array $data): void
    {
        $db = Database::getConnection();
        if (!empty($data['id'])) {
            $stmt = $db->prepare("UPDATE categories SET name = :name WHERE id = :id");
            $stmt->execute([
                'id' => $data['id'],
                'name' => $data['name'],
            ]);
        } else {
            $stmt = $db->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->execute([
                'name' => $data['name'],
            ]);
        }
    }

    public function delete(int $id): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
