<?php

namespace App\Controllers;

use App\Core\Response;
use App\Service\Example;

class HomeController
{
    public function index(Example $example, Response $response): Response
    {
        $items = $example->getList();
        return $response->render('home.index', compact('items'));
    }
}