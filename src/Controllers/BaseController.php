<?php

namespace App\Controllers;

use App\Views\Twig\AppExtension;
use Laminas\Diactoros\Response\HtmlResponse;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class BaseController
{
    protected Environment $twig;
    protected FilesystemLoader $loader;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($this->loader, [
            'cache' => false,
            'debug' => true,
            'auto_reload'=> true,
        ]);

        $this->twig->addExtension(new DebugExtension());
        $this->twig->addExtension(new AppExtension());
    }

    public function render(string $template, array $data = []): HtmlResponse
    {
        return new HtmlResponse(
            $this->twig->render($template, $data)
        );
    }
}