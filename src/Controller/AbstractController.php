<?php
declare(strict_types=1);

namespace Src\Controller;

use Src\Service\AuthService;
use Src\Utils\ViewRenderer;

class AbstractController
{
    protected ViewRenderer $view;
    protected AuthService $auth;

    public function __construct()
    {
        $this->view = new ViewRenderer();
        $this->auth = new AuthService();
    }
}
