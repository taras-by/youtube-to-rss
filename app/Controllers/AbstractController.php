<?php


namespace App\Controllers;

use App\Core\View;
use DI\Container;

abstract class AbstractController
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @return Container
     */
    protected function getContainer(): ?Container
    {
        return $this->container;
    }

    /**
     * @param Container $container
     * @return AbstractController
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }

    protected function render(string $template, array $params = []): string
    {
        /** @var View $view */
        $view = $this->getContainer()->get(View::class);
        return $view->render($template, $params);
    }
}
