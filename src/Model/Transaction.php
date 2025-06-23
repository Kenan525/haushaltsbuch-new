<?php
namespace Src\Model;

class Transaction
{
    public int $id;
    public int $user_id;
    public string $transactionDate;
    public float $amount;
    public string $description;
    public bool $isDeleted;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? 0;
        $this->user_id = $data['user_id'] ?? 0;
        $this->transactionDate = $data['transaction_date'] ?? '';
        $this->amount = (float)($data['amount'] ?? 0.0);
        $this->description = $data['description'] ?? '';
        $this->isDeleted = (bool)($data['is_deleted'] ?? false);
    }
}
