<?php
$path ="login";
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

if(SessionAccountHandler::isLoggedIn()) { ?>
    <div id="container">
	<div id="main">
		<div id="data-browser" class="panel">
			<div id="data-browser-inner">
				<?php
				$DataBrowser = new DataBrowser();
				$DataBrowser->display();
				?>
			</div>
		</div>

		<div id="statistics" class="panel">
			<ul id="statistics-nav">
				<?php
				$Factory = new PluginFactory();
				$Stats = $Factory->activePlugins( PluginType::Stat );
				foreach ($Stats as $i => $key) {
					$Plugin = $Factory->newInstance($key);

					if ($Plugin !== false) {
						echo '<li'.($i == 0 ? ' class="active"' : '').'>'.$Plugin->getLink().'</li>';
					}
				}

				if (PluginStat::hasVariousStats()) {
					echo '<li class="with-submenu">';
					echo '<a href="#">'.__('Miscellaneous').'</a>';
					echo '<ul class="submenu">';

					$VariousStats = $Factory->variousPlugins();
					foreach ($VariousStats as $key) {
						$Plugin = $Factory->newInstance($key);

						if ($Plugin !== false) {
							echo '<li>'.$Plugin->getLink().'</li>';
						}
					}

					echo '</ul>';
					echo '</li>';
				}
				?>
			</ul>
			<div id="statistics-inner">
				<?php
				if (isset($_GET['id'])) {
					$Context = new Context(Request::sendId(), SessionAccountHandler::getId());
					$View = new TrainingView($Context);
					$View->display();
				} elseif (isset($_GET['pluginid'])) {
					$Factory->newInstanceFor((int)$_GET['pluginid'])->display();
				} else {
					if (empty($Stats)) {
						echo __('<em>There are no statistics available. Activate a plugin in your configuration.</em>');
					} else {
						$Factory->newInstance($Stats[0])->display();
					}
				}
				?>
			</div>
		</div>

	</div>

	<div id="panels">
		<?php $Frontend->displayPanels(); ?>
	</div>
</div>
<?php
}
