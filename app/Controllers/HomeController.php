<?php

namespace App\Controllers;
use App\Models\Post;

/**
 * Class HomeController
 * @package App\Controllers
 */
class HomeController extends Controller
{
    public function index()
    {
        $posts = (new Post())->getAll();
        return $this->response->render('home.index', compact('posts'));
    }
}