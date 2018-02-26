<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\Playlist;

class HomeController
{
    public function playlist(Playlist $playList, Response $response, Request $request): Response
    {
        $feed = $playList->getFeed($request->get['id']);
        return $response->view($feed)
            ->setHeader('Content-Type: text/xml');
    }
}