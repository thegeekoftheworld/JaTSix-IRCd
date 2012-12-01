<?php
	class @@CLASSNAME@@ {
		public $name = "User";
		
		public function receiveRawData($params) {
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
						if ($client->setRealName($realname)) {
							if ($client->getNick() != null) {
								ClientManagement::introduceClient();
							}
						}
					}
					else {
						$socket = SocketManagement::getSocketByID($params[0]);
						$clientSocket->sendData($params[1], ":".Server::getServerHost()." NOTICE ".$client->getNick()." ")
					}
				}
			}
		}
		
		public function isInstantiated() {
			EventHandling::registerForEvent("rawDataReceived", $this, "receiveData");
			return true;
		}
	}
?>