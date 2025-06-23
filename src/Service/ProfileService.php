<?php
declare(strict_types=1);

namespace Src\Service;

use Src\Database\Database;

class ProfileService
{
    public function updateProfile(int $id, string $first, string $last, string $imagePath): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE users SET first_name = :first, last_name = :last, image = :image WHERE id = :id");
        $stmt->execute([
            'first' => $first,
            'last' => $last,
            'image' => $imagePath,
            'id' => $id
        ]);
    }

}
