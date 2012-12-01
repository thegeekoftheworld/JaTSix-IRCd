<?php
	require_once("includes/eventHandling.php");
	require_once("includes/moduleManagement.php");
	require_once("includes/socket.php");
	require_once("includes/socketManagement.php");
	
	$file = "conf/modules.conf";
	if (file_exists($file) && is_readable($file)) {
		$config = explode("\n", trim(file_get_contents($file)));
		foreach ($config as $module) {
			ModuleManagement::loadModule($module);
		}
	}
	
	while (true) {
		foreach (SocketManagement::getSocketIDs() as $sid) {
			$socket = SocketManagment::getSocketByID($sid);
			foreach ($socket->getClientSocketIDs() as $cid) {
				$clientSocket = $socket->getClientSocketByID($cid);
				$data = $clientSocket->receiveData($cid);
				if ($data != false) {
					EventHandling::triggerEvent("rawDataReceived", array($id, $data));
				}
			}
		}
		usleep(10000);
	}
?>