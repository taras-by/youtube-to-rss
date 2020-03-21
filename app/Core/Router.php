<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request;

class Router
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $controllerClassName;

    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $routes;

    /**
     * @var array
     */
    private $route;

    /**
     * @var array
     */
    private $params;

    /**
     * Router constructor.
     * @param Request $request
     * @param array $routes
     */
    public function __construct(Request $request, array $routes)
    {
        $this->routes = $routes;
        $this->request = $request;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function resolve()
    {
        foreach ($this->routes as $route) {
            if (preg_match($route['route'], $this->request->getPathInfo(), $matches)) {
                $this->route = $route;

                $this->params = array_filter($matches, function ($key){
                    return is_string($key);
                }, ARRAY_FILTER_USE_KEY);

                break;
            }
        }

        if ($this->route == null) {
            throw new NotFoundHttpException();
        }

        @list($controller, $this->action) = explode('::', $this->route['action'], 2);

        $this->controllerClassName = sprintf('App\Controllers\\%s', $controller);
        if (!class_exists($this->controllerClassName)) {
            throw new NotFoundHttpException();
        }

        if (!method_exists($this->controllerClassName, $this->action)) {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @return string
     */
    public function getControllerClassName(): string
    {
        return $this->controllerClassName;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }

    /**
     * @param string $path
     * @param array $parameters
     * @return string
     */
    static public function url(string $path, array $parameters = []): string
    {
        return $_SERVER['REQUEST_SCHEME'] .
            '://' . $_SERVER['HTTP_HOST'] .
            '/' . $path .
            ($parameters ? '?' . http_build_query($parameters) : '');
    }
}
