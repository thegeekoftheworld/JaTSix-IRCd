<?php
	class @@CLASSNAME@@ {
		public $name = "Nick";
		
		public function receiveData($params) {
			if (preg_match("/^NICK(.*)/", ltrim($params[2]), $matches)) {
				$client = ClientManagement::getClientBySocketID($params[0], $params[1]);
				$nick = trim($matches[1]);
				if ($nick != null) {
					if (!stristr($nick, " ")) {
						if (ClientManagement::getClientByNick($nick) == false) {
							if ($client->setNick($nick)) {
								if ($client->getIdent() != null) {
									ClientManagement::introduceClient($params[0], $params[1]);
								}
								return true;
							}
							else {
								$socket = SocketManagement::getSocketByID($params[0]);
								$sendToNick = $client->getNick();
								if ($sendToNick == null) {
									$sendToNick = "*";
								}
								$socket->sendData($params[1], ":".Configuration::getServerName()." 432 ".$sendToNick." ".$nick." :Erroneous Nickname");
							}
						}
						else {
							$socket = SocketManagement::getSocketByID($params[0]);
							$sendToNick = $client->getNick();
							if ($sendToNick == null) {
								$sendToNick = "*";
							}
							$socket->sendData($params[1], ":".Configuration::getServerName()." 433 ".$sendToNick." ".$nick." :Nickname is already in use");
						}
					}
				}
				else {
					$socket = SocketManagement::getSocketByID($params[0]);
					$sendToNick = $client->getNick();
					if ($sendToNick == null) {
						$sendToNick = "*";
					}
					$socket->sendData($params[1], ":".Configuration::getServerName()." 431 ".$sendToNick." :No nickname given");
				}
			}
			return false;
		}
		
		public function isInstantiated() {
			EventHandling::registerForEvent("rawDataReceived", $this, "receiveData");
			return true;
		}
	}
?>