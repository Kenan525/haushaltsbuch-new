<?php
declare(strict_types=1);

namespace Src\Controller;

use Src\Service\AdminService;

class AdminController extends AbstractController
{
    private AdminService $adminService;
    public function __construct()
    {
        $this->adminService = new AdminService();
        parent::__construct();
    }

    public function userList(): void
    {
        if (!$this->auth->isAdmin()) {
            http_response_code(403);
            $this->view->render('error', ['message' => 'Zugriff verweigert']);
            return;
        }

        $users = $this->adminService->all();
        $this->view->render('admin/users', [
            'users' => $users,
            'isLoggedIn' => $this->auth->check(),
        ]);
    }

    public function toggleUser(): void
    {
        if (!$this->auth->isAdmin()) {
            http_response_code(403);
            $this->view->render('error', ['message' => 'Zugriff verweigert']);
            return;
        }

        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->adminService->toggleActive($id);
        }
        header('Location: /admin/users');
        exit;
    }

    public function statistics(): void
    {
        if (!$this->auth->isAdmin()) {
            http_response_code(403);
            $this->view->render('error', ['message' => 'Zugriff verweigert']);
            return;
        }

        $stat = $this->adminService->getGlobal();
        $totalUsers = $this->adminService->getUserCount();
        $categoryStats = $this->adminService->getCategoryStats();

        $this->view->render('admin/statistics', [
            'stat' => $stat,
            'totalUsers' => $totalUsers,
            'categoryStats' => $categoryStats,
            'isLoggedIn' => $this->auth->check(),
        ]);
    }
}
