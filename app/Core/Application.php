<?php

namespace App\Core;

use App\Controllers\AbstractController;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;

class Application
{
    protected $container;
    protected $request;
    protected $response;
    protected $router;

    public function __construct(
        Container $container,
        Response $response,
        Router $router
    )
    {
        $this->response = $response;
        $this->router = $router;
        $this->container = $container;
    }

    public function run()
    {
        try {
            $controllerClassName = $this->router->getController();
            $action = $this->router->getAction();
        } catch (\Exception $exception) {
            $this->sendNotFound();
            return;
        }

        try {
            /** @var AbstractController $controllerObject */
            $controllerObject = $this->container->get($controllerClassName);
            $controllerObject->setContainer($this->container);
            $response = $this->container->call([$controllerObject, $action]);
        } catch (DependencyException $e) {
            $this->sendNotFound();
            return;
        } catch (NotFoundException $e) {
            $this->sendNotFound();
            return;
        }

        if ($response instanceof Response) {
            $response->send();
        }
    }

    private function sendNotFound()
    {
        $this->response->notFound();
        $this->response->send();
    }
}
