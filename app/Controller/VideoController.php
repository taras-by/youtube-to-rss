<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Service\YoutubeVideoService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends AbstractController
{
    /**
     * @param string $videoId
     * @param YoutubeVideoService $service
     * @return Response
     */
    public function video(string $videoId, YoutubeVideoService $service): Response
    {
        try {
            $video = $service->getVideoInfo($videoId);
        } catch (\RuntimeException $exception) {
            return new Response($exception->getMessage(), Response::HTTP_NOT_ACCEPTABLE);
        }

        return new RedirectResponse($video->getMediumQualityFormat()->getUrl());
    }
}
