<?php

namespace App\Controllers;

use App\Core\Response;
use App\Service\Example;

class HomeController extends Controller
{
    public function index(): Response
    {
        $items = (new Example())->getList();
        return $this->response->render('home.index', compact('items'));
    }
}