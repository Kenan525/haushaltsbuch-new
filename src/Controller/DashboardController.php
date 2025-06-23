<?php
declare(strict_types=1);

namespace Src\Controller;

use Src\Service\TransactionService;
use Src\Service\CategoryService;

class DashboardController extends AbstractController
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
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $user = $this->auth->user();
        $filters = [
            'year' => $_GET['year'] ?? null,
            'month' => $_GET['month'] ?? null,
            'category' => $_GET['category'] ?? null,
            'type' => $_GET['type'] ?? null,
        ];

        $monthly = $this->transactionService->getMonthlySummary((int)$user['id']);
        $filtered = $this->transactionService->getAllForUser((int)$user['id'], $filters);
        $categories = $this->categoryService->all();

        $this->view->render('dashboard', [
            'user' => $user,
            'monthly' => $monthly,
            'filtered' => $filtered,
            'filters' => $filters,
            'categories' => $categories,
            'isAdmin' => $this->auth->isAdmin(),
            'isLoggedIn' => $this->auth->check(),
        ]);
    }
}
