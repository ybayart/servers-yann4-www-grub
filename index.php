<?php
	if ($_SERVER['REMOTE_ADDR'] && in_array($_SERVER['REMOTE_ADDR'], array('192.168.1.100', '127.0.0.1')))
	{
		$actions = array('get', 'set');
		if (isset($_GET['action']) && in_array($_GET['action'], $actions))
		{
			if ($_GET['action'] == 'get')
			{
				passthru('cat /boot/grub/grub.cfg|grep -E "^(menuentry|submenu)"|cut -d "\'" -f2|nl -v0 2>&1');
			}
			else if ($_GET['action'] == 'set')
			{
				if (isset($_GET['id']) && is_numeric($_GET['id']))
				{
					passthru('sudo grub-reboot ' . $_GET['id'] . ' && sudo reboot 2>&1');
				}
				else
				{
					exit('ID value not set or invalid');
				}
			}
		}
		else
		{
			$msg = 'Invalid action, please use one of<nl>';
			foreach($actions as $action)
			{
					$msg .= '<li>' . $action . '</li>';
			}
			exit($msg);
		}
	}
	else
	{
		header('HTTP/1.0 403 Forbidden');
		exit('Access denied');
	}
?>
