<?php

namespace App\Core;

use DI\Container;
use Symfony\Component\HttpFoundation\Response;

class Application
{
    protected $container;
    protected $router;
    protected $view;

    public function __construct(
        Container $container,
        Router $router,
        View $view
    )
    {
        $this->router = $router;
        $this->container = $container;
        $this->view = $view;
    }

    public function run()
    {
        try {
            $this->router->resolve();

            /** @var AbstractController $controllerObject */
            $controllerObject = $this->container->get($this->router->getControllerClassName())
                ->setContainer($this->container);
            $response = $this->container->call([$controllerObject, $this->router->getAction()], $this->router->getParams());
            if (!$response instanceof Response) {
                throw new \Exception('Required instance of Symfony\Component\HttpFoundation\Response');
            }
        } catch (NotFoundHttpException $e) {
            $response = $this->notFoundResponse($e->getMessage());
        } catch (\Throwable $e) {
            $response = $this->errorResponse($e);
        }

        $response->send();
    }

    public function notFoundResponse(string $message = null): Response
    {
        $content = $this->view->render('error.404', ['message' => $message]);
        return new Response($content, Response::HTTP_NOT_FOUND);
    }

    public function errorResponse(\Throwable $exception): Response
    {
        $content = $this->view->render('error.500', ['exception' => $exception]);
        return new Response($content, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
