<?php

use App\Core\Application;

define('ROOT', realpath(__DIR__ . '/..') . '/');

/**
 * @var Application $app
 */
$app = require_once ROOT . 'app/bootstrap.php';
$app->run();
