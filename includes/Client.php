<?php
	class Client {
		private $sid;
		private $cid;
		private $nick;
		private $ident;
		private $host;
		private $realname;
		private $modes;
		private $socketid;
		
		public function __construct($sid, $cid) {
			$this->sid = $sid;
			$this->cid = $cid;
		}
		
		public function setIdent($ident) {
			if (!preg_match("/[^a-zA-Z0-9_-\[]{}^`|]/", $nick) && $ident != null) {
				$this->nick = $nick;
				return true;
			}
			return false;
		}
		
		public function setNick($nick) {
			if (!preg_match("/[^a-zA-Z0-9_-\[]{}^`|]/", $nick) && $nick != null) {
				$this->nick = $nick;
				return true;
			}
			return false;
		}
		
		public function setRealName($realname) {
			$this->realname = $realname;
			return true;
		}
		
		public function getIdent() {
			return $this->ident;
		}
		
		public function getNick() {
			return $this->nick;
		}
		
		public function getRealName() {
			return $this->realname;
		}
		
		public function sendData($data) {
			$socket = SocketManagement::getSocketByID($this->socketid[0]);
			$socket->sendData($this->socketid[1], $data);
		}
	}
?>