<?php
declare(strict_types=1);

namespace Src\Controller;

use Src\Service\CategoryService;

class CategoryController extends AbstractController
{
    private CategoryService $categoryService;
    public function __construct()
    {
        $this->categoryService = new CategoryService();
        parent::__construct();
    }

    public function index(): void
    {
        $categories = $this->categoryService->all();
        $this->view->render('category_list', [
            'categories' => $categories,
            'isLoggedIn' => $this->auth->check(),
        ]);
    }

    public function form(): void
    {
        $category = null;
        if (!empty($_GET['id'])) {
            $category = $this->categoryService->find((int)$_GET['id']);
        }
        $this->view->render('category_form', [
            'category' => $category,
            'isLoggedIn' => $this->auth->check(),
            //'csrf_token' => \Csrf::getToken(),
        ]);
    }

    public function save(): void
    {
        // CSRF prüfen (optional)
        /*if (!\Csrf::validate($_POST['token'] ?? null)) {
            header('Location: /kategorie?error=Ungültiges+Token');
            exit;
        }*/

        $data = [
            'id' => $_POST['id'] ?? null,
            'name' => $_POST['name'] ?? ''
        ];
        $this->categoryService->save($data);

        header('Location: /categories');
        exit;
    }

    public function delete(): void
    {
        if (!empty($_GET['id'])) {
            $this->categoryService->delete((int)$_GET['id']);
        }
        header('Location: /categories');
        exit;
    }
}
