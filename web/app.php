<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$index = $app['controllers_factory'];
$index->get('/', function () { return 'Blog home page'; });



$app->mount('/login/{lang}', include '../login.php');
//$app->mount('/login', include '../login.php');

$app->mount('/register', include '../login.php');
$app->mount('/forgotpw', include '../login.php');
$app->mount('/', include '../index.php');
$app->mount('/shared/{id}', include '../call/call.SharedTraining.php');
$app->run();