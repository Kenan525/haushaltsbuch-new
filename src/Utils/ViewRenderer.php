<?php
namespace Src\Utils;

class ViewRenderer
{
    private string $templateDir;

    public function __construct(string $templateDir = __DIR__ . '/../../templates/')
    {
        $this->templateDir = realpath($templateDir) . '/';
    }

    public function render(string $template, array $data = [], bool $withLayout = true)
    {
        extract($data, EXTR_SKIP);

        if ($withLayout) {
            ob_start();
            require $this->templateDir . $template . '.php';
            $content = ob_get_clean();
            require $this->templateDir . 'partials/layout.php';
        } else {
            require $this->templateDir . $template . '.php';
        }
    }
}
