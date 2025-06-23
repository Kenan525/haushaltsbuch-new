<?php
declare(strict_types=1);

namespace Src\Model;
class TransactionCategory
{
    public int $transaction_id;
    public int $category_id;

    public function __construct(array $data)
    {
        $this->transaction_id = (int)($data['transaction_id'] ?? 0);
        $this->category_id = (int)($data['category_id'] ?? 0);
    }
}
