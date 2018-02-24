<?php

namespace App\Core;

use DI\Container;

class Application
{
    protected $container;
    protected $request;
    protected $response;
    protected $router;

    public function __construct(
        Container $container,
        Request $request,
        Response $response,
        Router $router
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->router = $router;
        $this->container = $container;
    }

    public function run()
    {
        try {
            $controller = $this->router->getController();
            $action = $this->router->getAction();
        } catch (\Exception $exception) {
            $this->sendNotFound();
        }

        $response = $this->container->call([$controller, $action]);

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