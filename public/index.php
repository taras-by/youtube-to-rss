<?php

use App\Core\Application;

define('ROOT', realpath(__DIR__ . '/..') . '/');
$container = require_once ROOT . 'app/bootstrap.php';

/**
 * @var Application $app
 */
$app = $container->get(Application::class);
$app->run();
