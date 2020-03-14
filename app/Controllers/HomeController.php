<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use App\Core\Response;
use App\Services\FeedBuilder\Channel;
use App\Services\FeedBuilder\Playlist;
use App\Services\Generator\LinkGenerator;
use App\Services\Validator\YoutubeLinkValidator;
use App\Services\Youtube\VideoInfo;

class HomeController
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index(LinkGenerator $generator)
    {
        $request = $this->getRequest();
        $youtubeLink = $request->get('youtube_link');
        $submit = $request->isMethod(Request::METHOD_POST);
        $validator = new YoutubeLinkValidator($youtubeLink);
        $generatedUrl = null;
        $errorMessage = null;
        if ($submit && $validator->validate()) {
            if (!$generatedUrl = $generator->generate($youtubeLink)) {
                $errorMessage = 'Error generating link';
            }
        } else {
            $errorMessage = $validator->getMessage();
        }
        return $this->response->render('index', compact('youtubeLink', 'generatedUrl', 'errorMessage', 'submit'));
    }

    public function channel(Channel $channel): Response
    {
        $channelId = $this->getRequest()->get('id');
        if (!$channelId) {
            return $this->response->notFound();
        }

        $feed = $channel->getFeed($channelId);
        if (!$feed) {
            return $this->response->notFound();
        }

        return $this->response->view($feed)
            ->setHeader('Content-Type: text/xml');
    }

    public function playlist(Playlist $playList): Response
    {
        $playListId = $this->getRequest()->get('id');
        if (!$playListId) {
            return $this->response->notFound();
        }

        $feed = $playList->getFeed($playListId);
        if (!$feed) {
            return $this->response->notFound();
        }

        return $this->response->view($feed)
            ->setHeader('Content-Type: text/xml');
    }

    public function video(): Response
    {
        $id = $this->getRequest()->get('id');
        $videoInfo = new VideoInfo($id);

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

    protected function getRequest(): Request
    {
        return Request::createFromGlobals();
    }
}