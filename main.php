<?php
	require_once("includes/channel.php");
	require_once("includes/channelManagement.php");
	require_once("includes/client.php");
	require_once("includes/clientManagement.php");
	require_once("includes/configuration.php");
	require_once("includes/eventHandling.php");
	require_once("includes/modeManagement.php");
	require_once("includes/moduleManagement.php");
	require_once("includes/socket.php");
	require_once("includes/socketManagement.php");
	
	Configuration::loadConfigs();
	
	$file = "conf/modules.conf";
	if (file_exists($file) && is_readable($file)) {
		$config = explode("\n", trim(file_get_contents($file)));
		foreach ($config as $module) {
			ModuleManagement::loadModule($module);
		}
	}
	
	SocketManagement::listenOn("127.0.0.1", "6667");
	SocketManagement::listenOn("127.0.0.1", "6697");
	
	$startTime = time();
	
	while (true) {
		foreach (SocketManagement::getSocketIDs() as $sid) {
			$socket = SocketManagement::getSocketByID($sid);
			
			$newClientID = $socket->acceptNewClient();
			if ($newClientID != false) {
				ClientManagement::newClient(new Client($sid, $newClientID));
			}
			
			foreach ($socket->getClientSocketIDs() as $cid) {
				$data = $socket->receiveData($cid);
				if ($data != false) {
					EventHandling::triggerEvent("rawDataReceived", array($sid, $cid, $data));
				}
				EventHandling::triggerEvent("clientLoopFinished", array($sid, $cid));
			}
		}
		usleep(10000);
	}
?>