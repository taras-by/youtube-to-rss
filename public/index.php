<?php

$container = require_once __DIR__ . '/../app/bootstrap.php';

/**
 * @var \App\Core\Application $app
 */
$app = $container->get('App\Core\Application');
$app->run();