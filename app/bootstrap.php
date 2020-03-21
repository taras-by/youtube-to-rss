<?php

use App\Core\Router;
use App\Core\View;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

require_once ROOT . 'vendor/autoload.php';

Dotenv::createImmutable(ROOT)->load();
$config = require_once ROOT . 'app/config.php';

$builder = new ContainerBuilder();

$builder->addDefinitions([
    Request::class => DI\factory([Request::class, 'createFromGlobals']),
    Router::class => DI\create()->constructor(DI\get(Request::class), $config['routes']),
    View::class => DI\create()->constructor($config['views']),
    Google_Client::class => DI\create()->constructor($config['google']),
    Google_Service_YouTube::class => DI\create()->constructor(DI\get(Google_Client::class)),
]);

return $builder->build();
