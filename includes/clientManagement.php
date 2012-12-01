<?php
	class ClientManagement {
		private static $clients = array();
		
		public static function newClient($client) {
			if (is_object($client)) {
				self::$clients[] = $client;
				return true;
			}
			return false;
		}
		
		public static function getClientBySocketID($sid, $cid) {
			foreach (self::$clients as $client) {
				if ($client->getSID() == $sid && $client->getCID() == $cid) {
					return $client;
				}
			}
			return false;
		}
		
		public static function getClientByNick($nick) {
			foreach (self::$clients as $client) {
				if (strtolower($client->getNick()) == strtolower($nick)) {
					return $client;
				}
			}
			return false;
		}
		
		public static function introduceClient() {
			return true;
		}
	}
?>