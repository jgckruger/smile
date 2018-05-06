<?php
class DatabaseSettings
{
	var $settings;
	function getSettings()
	{
		// Database variables
		// Host name
		$settings['dbhost'] = 'localhost';
		// Database name
		$settings['dbname'] = 'projeto_joao';
		// Username
		$settings['dbusername'] = 'projeto_joao';
		// Password
		$settings['dbpassword'] = 'Joao@24445';

		return $settings;
	}
}
?>
