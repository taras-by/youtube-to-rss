<?php

namespace App\Core;

use DI\Container;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Application
{
    /**
     * @var Container
     */
    protected $container;
    /**
     * @var Router
     */
    protected $router;
    /**
     * @var View
     */
    protected $view;

    /**
     * Application constructor.
     * @param Container $container
     * @param Router $router
     * @param View $view
     */
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

            $controller = $this->container->get($this->router->getControllerClassName());
            if (!$controller instanceof AbstractController) {
                throw new \Exception('The controller must be an instance of App\Core\AbstractController');
            }
            $controller->setContainer($this->container);

            $response = $this->container->call([$controller, $this->router->getAction()], $this->router->getParams());
            if (!$response instanceof Response) {
                throw new \Exception('Required instance of Symfony\Component\HttpFoundation\Response');
            }
        } catch (NotFoundHttpException $e) {
            $response = $this->notFoundResponse($e->getMessage());
        } catch (Throwable $e) {
            $response = $this->errorResponse($e);
        }

        $response->send();
    }

    /**
     * @param string|null $message
     * @return Response
     */
    public function notFoundResponse(string $message = null): Response
    {
        $content = $this->view->render('error.404', ['message' => $message]);
        return new Response($content, Response::HTTP_NOT_FOUND);
    }

    /**
     * @param Throwable $exception
     * @return Response
     */
    public function errorResponse(Throwable $exception): Response
    {
        $content = $this->view->render('error.500', ['exception' => $exception]);
        return new Response($content, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
