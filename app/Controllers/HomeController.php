<?php

namespace App\Controllers;

use App\Core\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Response;
use App\Services\FeedBuilder\Channel;
use App\Services\FeedBuilder\Playlist;
use App\Services\Generator\LinkGenerator;
use App\Services\Validator\YoutubeLinkValidator;
use App\Services\Youtube\VideoInfo;

class HomeController extends AbstractController
{
    /**
     * @param Request $request
     * @param LinkGenerator $generator
     * @return Response
     */
    public function index(Request $request, LinkGenerator $generator)
    {
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
        $content = $this->render('index', compact('youtubeLink', 'generatedUrl', 'errorMessage', 'submit'));
        return $this->getResponse()->setBody($content);
    }

    /**
     * @param Request $request
     * @param Channel $channel
     * @return Response
     * @throws NotFoundHttpException
     */
    public function channel(Request $request, Channel $channel): Response
    {
        $channelId = $request->get('id');
        if (!$channelId) {
            throw new NotFoundHttpException('Empty ID parameter');
        }

        $feed = $channel->getFeed($channelId);
        if (!$feed) {
            throw new NotFoundHttpException('Channel not found');
        }

        return $this->getResponse()->setBody($feed)
            ->setHeader('Content-Type: text/xml');
    }

    /**
     * @param Request $request
     * @param Playlist $playList
     * @return Response
     * @throws NotFoundHttpException
     */
    public function playlist(Request $request, Playlist $playList): Response
    {
        $playListId = $request->get('id');
        if (!$playListId) {
            throw new NotFoundHttpException('Empty ID parameter');
        }

        $feed = $playList->getFeed($playListId);
        if (!$feed) {
            throw new NotFoundHttpException('Playlist not found');
        }

        return $this->getResponse()->setBody($feed)
            ->setHeader('Content-Type: text/xml');
    }

    /**
     * @param Request $request
     * @return Response
     * @throws NotFoundHttpException
     */
    public function video(Request $request): Response
    {
        $id = $request->get('id');
        if (!$id) {
            throw new NotFoundHttpException('Empty ID parameter');
        }

        $videoInfo = new VideoInfo($id);

        try {
            $url = $videoInfo->getLink();
            return $this->getResponse()
                ->setHeader(header('Location: ' . $url));
        } catch (\RuntimeException $exception) {
            return $this->getResponse()
                ->setBody($exception->getMessage())
                ->setHeader(header('HTTP/1.1 406 Not Acceptable'));
        }
    }
}
