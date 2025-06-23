<?php
declare(strict_types=1);

namespace Src\Controller;

use Src\Service\CategoryService;
use Src\Service\TransactionService;
use Src\Utils\Logger;

class TransactionController extends AbstractController
{
    private TransactionService $transactionService;
    private CategoryService $categoryService;
    public function __construct()
    {
        $this->transactionService = new TransactionService();
        $this->categoryService = new CategoryService();
        parent::__construct();
    }
    public function index(): void
    {
        $user = $this->auth->user();
        $transactions = $this->transactionService->getAllForUser($user['id']);
        $this->view->render('transaction_list', [
            'transactions' => $transactions,
            'isLoggedIn' => $this->auth->check(),
        ]);
    }

    public function form(): void
    {
        $transaction = null;
        if (!empty($_GET['id'])) {
            $transaction = $this->transactionService->find((int)$_GET['id']);
        }
        $this->view->render('transaction_form', [
            'transaction' => $transaction,
            'categories' => $this->categoryService->all(),
            'selectedCategories' => $transaction ? $this->transactionService->getCategories((int)$transaction->id) : [],
            'isLoggedIn' => $this->auth->check(),
            //'csrf_token' => \Csrf::getToken(),
        ]);
    }

    public function save(): void
    {
        // CSRF prüfen (optional)
        /*if (!\Csrf::validate($_POST['token'] ?? null)) {
            header('Location: /transactions?error=Ungültiges+Token');
            exit;
        }*/

        $user =  $this->auth->user();
        $id = $_POST['id'] ?? null;
        $data = [
            'user_id' => $user['id'],
            'date' => $_POST['transaction_date'],
            'amount' => $_POST['amount'],
            'description' => $_POST['description']
        ];
        $categories = $_POST['categories'] ?? [];

        if ($id) {
            $data['id'] = $id;
            $this->transactionService->update($data);
            $this->transactionService->sync((int)$id, $categories);
            Logger::log((int)$user['id'], 'Transaktion aktualisiert ' . $id);
        } else {
            $newId = $this->transactionService->create($data);
            $this->transactionService->sync($newId, $categories);
            Logger::log((int)$user['id'], 'Transaktion erstellt ' . $newId);
        }

        header('Location: /transactions');
        exit;
    }

    public function delete(): void
    {
        if (!empty($_GET['id'])) {
            $this->transactionService->softDelete((int)$_GET['id'], $this->auth->user()['id']);
        }
        header('Location: /transactions');
        exit;
    }
}
