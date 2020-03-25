<?php

namespace App\Core;

use DI\Container;
use Exception;

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

    /**
     * @param string $template
     * @param array $params
     * @return string
     * @throws Exception
     */
    protected function render(string $template, array $params = []): string
    {
        /** @var View $view */
        $view = $this->getContainer()->get(View::class);
        return $view->render($template, $params);
    }
}
