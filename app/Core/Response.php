<?php

namespace App\Core;

class Response
{
    const LAYOUT_FILE = 'layout.php';

    private $headers = [];
    private $body;

    public function send()
    {
        foreach ($this->headers as $header) {
            header($header);
        }
        echo $this->body;
        exit;
    }

    /**
     * @param $value
     * @return Response
     */
    public function view($value): Response
    {
        $this->body = $value;

        return $this;
    }

    /**
     * @return Response
     */
    public function notFound(): Response
    {
        $this->setHeader('HTTP/1.0 404 Not Found');
        $this->render('error.404');

        return $this;
    }

    /**
     * @param $status
     * @param $message
     * @return Response
     */
    public function error($status, $message): Response
    {
        $this->setHeader('HTTP/1.0 '.$status.' ' . $message);

        $this->body = $status . '. ' . $message;
        return $this;
    }

    /**
     * @param $header
     * @return Response
     */
    public function setHeader($header): Response
    {
        $this->headers[] = $header;

        return $this;
    }

    /**
     * @param $template
     * @param array $params
     * @return Response
     */
    public function render($template, $params = [])
    {
        $template_path = VIEWS .
            str_replace('.', '/', $template) . '.php';

        extract($params);

        ob_start();
        include $template_path;
        $content =  ob_get_clean();

        ob_start();
        include VIEWS . self::LAYOUT_FILE;
        $this->body = ob_get_clean();

        return $this;
    }
}