<?php
	class @@CLASSNAME@@ {
		public $name = "PingManagement";
		
		public function checkPings($params) {
			$sid = $params[0];
			$cid = $params[1];
			$socket = SocketManagement::getSocketByID($sid);
			$client = ClientManagement::getClientBySocketID($sid, $cid);
			
			if ($socket->getClientSocketByID($cid) != false) {
				if ((time() - $client->lastPing) > 120) {
					socket_getpeername($socket->getClientSocketByID($cid), $remote);
					$client->sendData("ERROR :Closing Link: ".$remote." (Ping timeout: 121 seconds)");
					$socket->killClient($cid);
				}
				elseif ((time() - $client->lastPing) >= 60 && $client->sentPing == false) {
					$client->sendData("PING :".Configuration::getServerName());
					$client->sentPing = true;
				}
			}
		}
		
		public function isInstantiated() {
			EventHandling::registerForEvent("clientLoopFinished", $this, "checkPings");
			return true;
		}
	}
?>