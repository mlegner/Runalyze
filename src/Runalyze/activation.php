<?php

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

