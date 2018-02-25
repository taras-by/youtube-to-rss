<?php

define('ROOT', realpath(__DIR__ . '/..') . '/');
define('APP', ROOT . 'app/');
define('VIEWS', APP . 'Views/');

require_once ROOT . '/vendor/autoload.php';

$builder = new \DI\ContainerBuilder();
return $builder->build();
