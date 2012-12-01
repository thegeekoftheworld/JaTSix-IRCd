<?php
	class @@CLASSNAME@@ {
		public $name = "Nick";
		
		public function receiveData($params) {
			if (preg_match("/^NICK (.*)/", trim($params[2]), $matches)) {
				$nick = $matches[1];
				if (!stristr($nick, " ")) {
					$client = ClientManagement::getClientBySocketID($params[0], $params[1]);
					if ($client->setNick($nick)) {
						if ($client->getIdent() != null) {
							ClientManagement::introduceClient();
						}
						return true;
					}
				}
				$socket = SocketManagement::getSocketByID($params[0]);
				$socket->sendData($params[1], ":".Configuration::getServerName()." 431 * :No nickname given");
			}
			return false;
		}
		
		public function isInstantiated() {
			EventHandling::registerForEvent("rawDataReceived", $this, "receiveData");
			return true;
		}
	}
?>