<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\FeedBuilder\Channel;
use App\Services\FeedBuilder\Playlist;
use App\Services\Youtube\VideoInfo;

class HomeController
{
    private $response;
    private $request;

    public function __construct(Response $response, Request $request)
    {
        $this->response = $response;
        $this->request = $request;
    }

    public function channel(Channel $channel): Response
    {
        $channelId = $this->request->get['id'] ?? null;
        if(!$channelId){
            return $this->response->notFound();
        }

        $feed = $channel->getFeed($channelId);
        if(!$feed){
            return $this->response->notFound();
        }

        return $this->response->view($feed)
            ->setHeader('Content-Type: text/xml');
    }

    public function playlist(Playlist $playList): Response
    {
        $playListId = $this->request->get['id'] ?? null;
        if(!$playListId){
            return $this->response->notFound();
        }

        $feed = $playList->getFeed($playListId);
        if(!$feed){
            return $this->response->notFound();
        }

        return $this->response->view($feed)
            ->setHeader('Content-Type: text/xml');
    }

    public function video(): Response
    {
        $videoInfo = new VideoInfo($this->request->get['id']);

        try {
            $url = $videoInfo->getLink();
            return $this->response
                ->setHeader(header('Location: ' . $url));
        } catch (\RuntimeException $exception) {
            return $this->response
                ->view($exception->getMessage())
                ->setHeader(header('HTTP/1.1 406 Not Acceptable'));
        }
    }
}