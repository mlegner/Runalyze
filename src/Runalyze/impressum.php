<?php

echo $Twig->loadTemplate('impressum.twig')->render(array(
	'RUNALYZE_VERSION' => RUNALYZE_VERSION,
));

