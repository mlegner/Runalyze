<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/Runalyze/DefaultControllerProvider.php';
require_once __DIR__.'/../inc/class.Frontend.php';
$Frontend = new Frontend(true);
$app = new Silex\Application();
setcookie('acceptcookie', 'true', time()+30*86400);
$Twig = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__.'/../view'));
$Twig->addExtension(new Twig_Extensions_Extension_I18n());
$Twig->registerUndefinedFunctionCallback(function ($name) {
	if (function_exists($name)) {
		return new Twig_SimpleFunction($name, function() use($name) {
			return call_user_func_array($name, func_get_args());
		});
	}

	return false;
});
Twig_Autoloader::register();

$index = $app['controllers_factory'];
$app->mount('/', include '../src/Runalyze/index.php');
$app->mount('/register', include '../src/Runalyze/register.php');
$app->mount('/login', include '../src/Runalyze/login.php');
$app->mount('/forgotpw', include '../src/Runalyze/forgotpw.php');
$app->mount('/activation/{hash}', include '../src/Runalyze/activation.php');
$app->mount('/impressum', include '../src/Runalyze/impressum.php');
$app->run();