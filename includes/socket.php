<?php
	class Socket {
		private $clients;
		private $socket;
		
		public function __construct($host, $port) {
			$socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if ($socket != false) {
				$this->socket = $socket;
				unset($socket);
				if (@socket_bind($this->socket, $host, $port)) {
					if (@socket_listen($this->socket)) {
						if (@socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1)) {
							if (@socket_set_nonblock($this->socket)) {
								return true;
							}
						}
					}
				}
			}
			return false;
		}
		
		public function acceptNewClient() {
			if ($newClient = @socket_accept($this->socket)) {
				socket_set_nonblock($newClient);
				
				$i = 1;
				while (isset($this->clients[$i])) {
					$i++;
				}
				$this->clients[$i] = $newClient;
				
				return $i;
			}
			return false;
		}
		
		public function getClientSocketByID($id) {
			return $this->clients[$id];
		}
		
		public function getClientSocketIDs() {
			$ids = array();
			foreach ($this->clients as $id => $value) {
				$ids[] = $id;
			}
			
			return $ids;
		}
		
		public function getClientSockets() {
			return $this->clients;
		}
		
		public function getSocket() {
			return $this->socket;
		}
		
		public function receiveData($id) {
			$status = @socket_recv($this->clients[$id], $buffer, 4096, 0);
			if ($status === 0 && $buffer === null) {
				socket_close($this->clients[$id]);
				$this->clients[$id] = false;
			}
			else {
				if (trim(str_ireplace("\004", null, $buffer)) != null) {
					return $buffer;
				}
			}
			return false;
		}
		
		public function sendData($id, $data) {
			return socket_send($this->clients[$id], trim($data)."\n", strlen(trim($data)."\n"));
		}
	}
?>