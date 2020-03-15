<?php


namespace App\Controllers;


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
}
