<?php

require_once __DIR__ . '/../app/Defines.php';
require_once ROOT . '/vendor/autoload.php';

$builder = new \DI\ContainerBuilder();
$container = $builder->build();

$app = $container->get('App\Core\Application');
$app->run();