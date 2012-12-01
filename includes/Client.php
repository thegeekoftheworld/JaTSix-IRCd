<?php
	class Client {
		private $nick;
		private $ident;
		private $host;
		private $modes;
		private $socketid;
		
		public function setIdent($ident) {
			if (!preg_match("/[^a-zA-Z0-9_-\[]{}^`|]/", $nick)) {
				$this->nick = $nick;
				return true;
			}
			return false;
		}
		
		public function setNick($nick) {
			if (!preg_match("/[^a-zA-Z0-9_-\[]{}^`|]/", $nick)) {
				$this->nick = $nick;
				return true;
			}
			return false;
		}
		
		public function getNick() {
			return $this->nick;
		}
		
		public function sendData($data) {
			$socket = SocketManagement::getSocketByID($this->socketid[0]);
			$socket->sendData($this->socketid[1], $data);
		}
	}
?>