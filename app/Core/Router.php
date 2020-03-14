<?php

namespace App\Core;

use App\Route;
use Symfony\Component\HttpFoundation\Request;

class Router
{
    private $request;
    private $controller;
    private $action;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        @list($this->controller, $this->action) = explode('@', $this->getRoute(), 2);
    }

    /**
     * @return string|null
     */
    public function getRoute()
    {
        return Route::rules()[$this->request->getPathInfo()] ?? null;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getController()
    {
        $controller = 'App\Controllers\\' . $this->controller;

        if ($this->controller && class_exists($controller)) {
            return $controller;
        } else {
            throw new \Exception();
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getAction()
    {
        if ($this->action && method_exists($this->getController(), $this->action)) {
            return $this->action;
        } else {
            throw new \Exception();
        }
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