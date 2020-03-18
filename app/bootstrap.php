<?php

use DI\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use function DI\factory;

define('ROOT', realpath(__DIR__ . '/..') . '/');
define('APP', ROOT . 'app/');
define('VIEWS', APP . 'Views/');

require_once ROOT . '/vendor/autoload.php';

$builder = new ContainerBuilder();

$builder->addDefinitions([
    Request::class => factory([Request::class, 'createFromGlobals']),
]);

return $builder->build();
