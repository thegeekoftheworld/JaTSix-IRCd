<?php
	class SocketManagement {
		private static $sockets = array();
		
		public static function listenOn($host, $port) {
			$i = 1;
			while (isset(self::$sockets[$i])) {
				$i++;
			}
			
			self::$sockets[$i] = new Socket($host, $port);
		}
		
		public static function getSocketByID($id) {
			return self::$sockets[$id];
		}
		
		public static function getSocketIDs() {
			$ids = array();
			foreach (self::$sockets as $id => $socket) {
				$ids[] = $id;
			}
			
			return $ids;
		}
		
		public static function getSockets() {
			return self::$sockets;
		}
	}
?>