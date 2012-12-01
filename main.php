<?php
	require_once("includes/eventHandling.php");
	require_once("includes/moduleManagement.php");
	require_once("includes/socket.php");
	require_once("includes/socketManagement.php");
	
	while (true) {
		foreach (SocketManagement::getSocketIDs() as $id) {
			$socket = SocketManagment::getSocketByID($id);
			$data = $socket->receiveData($id);
			if ($data != false) {
				EventHandling::triggerEvent("rawDataReceived", array($id, $data));
			}
			usleep(10000);
		}
	}
?>