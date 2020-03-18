<?php

namespace App\Core;

class Response
{
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
     * @param $body
     * @return Response
     */
    public function setBody($body): Response
    {
        $this->body = $body;

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
}