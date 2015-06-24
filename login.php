<?php
/**
 * RUNALYZE
 * 
 * @author Hannes Christiansen <mail@laufhannes.de>
 * @copyright http://www.runalyze.de/
 */


require 'inc/class.Frontend.php';
$Frontend = new Frontend(true);

if (isset($_GET['delete'])) 
    SessionAccountHandler::logout();

if (isset($_GET['out']))
	SessionAccountHandler::logout();



setcookie('acceptcookie', 'true', time()+30*86400);


DB::getInstance()->stopAddingAccountID();

$NumUser = Cache::get('NumUser', 1);
if ($NumUser == NULL) {
    $NumUser = DB::getInstance()->query('SELECT COUNT(*) FROM '.PREFIX.'account WHERE activation_hash = ""')->fetchColumn();
    Cache::set('NumUser', $NumUser, '500', 1);
}

$NumKm = Cache::get('NumKm', 1);
if ($NumKm == NULL) {
    $NumKm = DB::getInstance()->query('SELECT SUM(distance) FROM '.PREFIX.'training')->fetchColumn();
    Cache::set('NumKm', $NumKm, '500', 1);
}
DB::getInstance()->startAddingAccountID();

$NumUserOn = SessionAccountHandler::getNumberOfUserOnline();

Twig_Autoloader::register();

$Twig = new Twig_Environment(new Twig_Loader_Filesystem(FRONTEND_PATH.'../view'));
$Twig->addExtension(new Twig_Extensions_Extension_I18n());
$Twig->registerUndefinedFunctionCallback(function ($name) {
	if (function_exists($name)) {
		return new Twig_SimpleFunction($name, function() use($name) {
			return call_user_func_array($name, func_get_args());
		});
	}

	return false;
});

$path = substr(Request::Basename(), 0, 9);
if(!in_array($path, array('login', 'register', 'forgotpw')))
        $path = 'login';

if (isset($_POST['new_username'])) {
        $Errors = AccountHandler::tryToRegisterNewUser();
        if (!is_array($Errors)) {
            if(System::isAtLocalhost())
		$registersuccess =  __('You can login now. Enjoy Runalyze!');
            else
		$registersuccess =  __('Thanks for your registration. You should receive an email within the next minutes with further instructions for activating your account.');
        }
}


echo $Twig->loadTemplate('login.twig')->render(array(
	'RUNALYZE_VERSION' => RUNALYZE_VERSION,
	'numUserOnline' => $NumUserOn,
	'numUser' => $NumUser,
	'numKm' => Runalyze\Activity\Distance::format($NumKm),
        'errorType' => SessionAccountHandler::$ErrorType,
        'errorRegister' => $Errors,
        'registersuccess' => $registersuccess,
        'acceptcookie' => $_COOKIE['acceptcookie'],
        'USER_CANT_LOGIN' => USER_CANT_LOGIN,
        'USER_CAN_REGISTER' => USER_CAN_REGISTER,
        'urlpath' => $path,
));

/*$title = 'Runalyze v'.RUNALYZE_VERSION.' - '.__('Please login');
$tpl   = 'tpl.loginWindow.php';

if (isset($_GET['chpw']))
	$tpl = 'tpl.loginWindow.setNewPassword.php';
if (isset($_GET['activate']))
	$tpl = 'tpl.loginWindow.activateAccount.php';
if (isset($_GET['delete'])) 
    $tpl = 'tpl.loginWindow.deleteAccount.php';


include 'inc/tpl/tpl.installerHeader.php';
include 'inc/tpl/'.$tpl;
include 'inc/tpl/tpl.installerFooterText.php';
include 'inc/tpl/tpl.installerFooter.php';*/