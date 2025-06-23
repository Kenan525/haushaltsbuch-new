<?php
declare(strict_types=1);

namespace Src\Model;
class User
{
    public int $id;
    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;
    public string $role;
    public bool $isActive;
    public string $image;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? 0;
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->firstName = $data['first_name'] ?? '';
        $this->lastName = $data['last_name'] ?? '';
        $this->role = $data['role'] ?? '';
        $this->isActive = (bool)$data['is_active'] ?? false;
        $this->image = $data['image'] ?? '';
    }

    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }
}
