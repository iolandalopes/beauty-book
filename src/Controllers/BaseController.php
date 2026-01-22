<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Laminas\Diactoros\Response\HtmlResponse;

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
    }

    public function render(string $template, array $data = []): HtmlResponse
    {
        return new HtmlResponse(
            $this->twig->render($template, $data)
        );
    }
}