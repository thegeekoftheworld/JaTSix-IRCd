<?php
	class @@CLASSNAME@@ {
		public $name = "User";
		
		public function receiveData($params) {
			if (preg_match("/^USER (.*)/", trim($params[2]), $matches)) {
				$matches = explode(" ", trim($matches[1]));
				if (count($matches) > 2) {
					$ident = $matches[0];
					unset($matches[0]);
					unset($matches[1]);
					unset($matches[2]);
					if (count($matches) > 1) {
						$realname = substr(implode(" ", $matches), 1);
					}
					else {
						$realname = substr($matches[3], 1);
					}
					unset($matches);
				
					$client = ClientManagement::getClientBySocketID($params[0], $params[1]);
					if ($client->setIdent($ident)) {
						$client->setRealName($realname);
						if ($client->getNick() != null) {
							ClientManagement::introduceClient();
						}
					}
					else {
						$socket = SocketManagement::getSocketByID($params[0]);
						$sendToNick = $client->getNick();
						if ($sendToNick == null) {
							$sendToNick = "*";
						}
						socket_getpeername($socket->getClientSocketByID($params[1]), $remote);
						$socket->sendData($params[1], ":".Configuration::getServerName()." NOTICE ".$sendToNick." :*** Your username is invalid.  Please make sure that your username contains only alphanumeric characters.");
						$socket->sendData($params[1], "ERROR :Closing Link: ".$remote." (Invalid username)");
						$socket->killClient($params[1]);
					}
				}
				else {
					$socket = SocketManagement::getSocketByID($params[0]);
					$socket->sendData($params[1], ":".Configuration::getServerName()." 461 * USER :Not enough parameters");
				}
			}
		}
		
		public function isInstantiated() {
			EventHandling::registerForEvent("rawDataReceived", $this, "receiveData");
			return true;
		}
	}
?>