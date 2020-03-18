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
    protected $view;

    public function __construct(
        Container $container,
        Response $response,
        Router $router,
        View $view
    )
    {
        $this->response = $response;
        $this->router = $router;
        $this->container = $container;
        $this->view = $view;
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
            $this->sendNotFound($e->getMessage());
            return;
        } catch (NotFoundException $e) {
            $this->sendNotFound($e->getMessage());
            return;
        } catch (NotFoundHttpException $e) {
            $this->sendNotFound($e->getMessage());
            return;
        } catch (\Throwable $e) {
            $this->sendError($e);
            return;
        }

        if ($response instanceof Response) {
            $response->send();
        }
    }

    private function sendNotFound(string $message = null)
    {
        $this->notFoundResponse($message)->send();
    }

    public function notFoundResponse(string $message = null): Response
    {
        $this->response->setHeader('HTTP/1.0 404 Not Found');
        $content = $this->view->render('error.404', ['message' => $message]);
        return $this->response->setBody($content);
    }

    private function sendError(\Throwable $exception)
    {
        $this->errorResponse($exception)->send();
    }

    public function errorResponse(\Throwable $exception): Response
    {
        $this->response->setHeader('HTTP/1.0 500 Internal Server Error');
        $content = $this->view->render('error.500', ['exception' => $exception]);
        return $this->response->setBody($content);
    }
}
