<?php

namespace App\Core;

class View
{
    const LAYOUT_FILE = 'layout.php';
    /**
     * @param $template
     * @param array $params
     * @return string
     */
    public function render($template, $params = []): string
    {
        $template_path = VIEWS .
            str_replace('.', '/', $template) . '.php';

        extract($params);

        ob_start();
        include $template_path;
        $content =  ob_get_clean();

        ob_start();
        include VIEWS . self::LAYOUT_FILE;
        $body = ob_get_clean();

        return $body;
    }
}
