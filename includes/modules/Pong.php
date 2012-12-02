<?php
	class @@CLASSNAME@@ {
		public $name = "Pong";
		
		public function receiveData($params) {
			$sid = $params[0];
			$cid = $params[1];
			$socket = SocketManagement::getSocketByID($sid);
			$client = ClientManagement::getClientBySocketID($sid, $cid);
			
			if (preg_match("/^PONG (.*)/i", $params[2], $matches)) {
				$client->lastPing = time();
				$client->sentPing = false;
			}
		}
		
		public function isInstantiated() {
			EventHandling::registerForEvent("rawDataReceived", $this, "receiveData");
			return true;
		}
	}
?>