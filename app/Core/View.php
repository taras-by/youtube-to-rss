<?php

namespace App\Core;

class View
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param $template
     * @param array $params
     * @return string
     */
    public function render(string $template, array $params = []): string
    {
        extract($params);

        ob_start();
        include $this->getTemplatePath($template);
        $content =  ob_get_clean();

        ob_start();
        include $this->getTemplatePath($this->config['layout']);
        $body = ob_get_clean();

        return $body;
    }

    private function getTemplatePath(string $template): string
    {
        return $this->config['views_path'] . str_replace('.', '/', $template) . '.php';
    }
}
