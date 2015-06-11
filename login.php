<?php
/**
 * RUNALYZE
 * 
 * @author Hannes Christiansen <mail@laufhannes.de>
 * @copyright http://www.runalyze.de/
 */
if (!file_exists('config.php')) {
	include 'install.php';
	exit();
}

require 'inc/class.Frontend.php';
$Frontend = new Frontend(true);

if (isset($_GET['delete'])) 
    SessionAccountHandler::logout();

if (isset($_GET['out']))
	SessionAccountHandler::logout();

if (SessionAccountHandler::isLoggedIn()) {
	header('Location: index.php');
	exit;
}

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
echo $Twig->loadTemplate('login.twig')->render(array(
	'RUNALYZE_VERSION' => RUNALYZE_VERSION,
	'numUserOnline' => $NumUserOn,
	'numUser' => $NumUser,
	'numKm' => Runalyze\Activity\Distance::format($NumKm)
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