<?php

namespace App\Core;

use Exception;
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
        $paramPattern = '#{(\w+)}#';
        $paramReplacement = '(?<$1>.+)';

        foreach ($this->routes as $route) {
            $rotePattern = '#^' . preg_replace($paramPattern, $paramReplacement, $route['route']) . '$#';

            if (preg_match($rotePattern, $this->request->getPathInfo(), $matches)) {
                $this->route = $route;

                $this->params = array_filter($matches, function ($key) {
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
     * @param string $routeName
     * @param array $params
     * @return string
     * @throws Exception
     */
    public function url(string $routeName, array $params): string
    {
        $paramPatterns = [];
        $paramReplacements = [];
        $queryParams = [];

        if (!$route = $this->findRoute($routeName)) {
            throw new Exception('Route not found');
        }

        foreach ($params as $name => $value) {
            $paramPattern = '{' . $name . '}';
            if (stripos($route['route'], $paramPattern) !== false) {
                $paramPatterns[] = '#' . $paramPattern . '#';
                $paramReplacements[] = $value;
            } else {
                $queryParams[$name] = $value;
            }
        }

        $query = $queryParams ? '?' . http_build_query($queryParams) : '';

        $urlPath = preg_replace($paramPatterns, $paramReplacements, $route['route']) . $query;

        return $this->request->getUriForPath($urlPath);
    }

    public function getUriForPath(string $urlPath): string
    {
        return $this->request->getUriForPath($urlPath);
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
     * @param string $routeName
     * @return array
     */
    public function findRoute(string $routeName): array
    {
        return $this->routes[$routeName];
    }
}
