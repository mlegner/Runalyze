<?php
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
$path = substr(Request::Basename(), 0, 9);
$NumUserOn = SessionAccountHandler::getNumberOfUserOnline();


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

