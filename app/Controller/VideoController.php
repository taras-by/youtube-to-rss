<?php

namespace App\Controller;

use App\Core\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Service\VideoInfo;

class VideoController extends AbstractController
{
    /**
     * @param string $videoId
     * @return Response
     */
    public function video(string $videoId): Response
    {
        $videoInfo = new VideoInfo($videoId);

        try {
            $url = $videoInfo->getLink();
            return new RedirectResponse($url);
        } catch (\RuntimeException $exception) {
            return new Response($exception->getMessage(), Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}
