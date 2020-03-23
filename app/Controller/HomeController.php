<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Validator\YoutubeLinkValidator;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Generator\LinkGenerator;

class HomeController extends AbstractController
{
    /**
     * @param Request $request
     * @param LinkGenerator $generator
     * @return Response
     * @throws Exception
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
        return new Response($content);
    }
}
