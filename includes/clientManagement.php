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
		
		public static function countVisibleUsers() {
			return count(self::$clients);
		}
		
		public static function countMaxUsers() {
			return count(self::$clients);
		}
		
		public static function countIRCServerOperators() {
			return 0;
		}
		
		public static function introduceClient($sid, $cid) {
			$client = self::getClientBySocketID($sid, $cid);
			$socket = SocketManagement::getSocketByID($sid);
			$socket->sendData($cid, ":".Configuration::getServerName()." 001 ".$client->getNick()." :Welcome to the ".Configuration::getNetworkName()." IRC network, ".$client->getNick()."!");
			$socket->sendData($cid, ":".Configuration::getServerName()." 002 ".$client->getNick()." :Your host is ".Configuration::getServerName().", running version jatsix-v0.9");
			$socket->sendData($cid, ":".Configuration::getServerName()." 003 ".$client->getNick()." :This server was created Sat Dec 01 2012 at 00:25:35 CST");
			$socket->sendData($cid, ":".Configuration::getServerName()." 004 ".$client->getNick()." ".Configuration::getServerName()." jatsix-v0.9 \0 \0 \0 \0");
			$socket->sendData($cid, ":".Configuration::getServerName()." 005 ".$client->getNick()." PREFIX=(ov)@+ CHANTYPES=# :are supported by this server");
			$socket->sendData($cid, ":".Configuration::getServerName()." 251 ".$client->getNick()." :There are ".self::countVisibleUsers()." users and 0 invisible on 1 servers");
			$socket->sendData($cid, ":".Configuration::getServerName()." 252 ".$client->getNick()." ".self::countIRCServerOperators()." :IRC Operators online");
			$socket->sendData($cid, ":".Configuration::getServerName()." 254 ".$client->getNick()." ".ChannelManagement::countVisibleChannels()." :channels formed");
			$socket->sendData($cid, ":".Configuration::getServerName()." 255 ".$client->getNick()." :I have ".self::countVisibleUsers()." clients and 1 servers");
			$socket->sendData($cid, ":".Configuration::getServerName()." 265 ".$client->getNick()." ".self::countVisibleUsers()." ".self::countMaxUsers()." :Current local users ".self::countVisibleUsers().", max ".self::countMaxUsers());
			$socket->sendData($cid, ":".Configuration::getServerName()." 266 ".$client->getNick()." ".self::countVisibleUsers()." ".self::countMaxUsers()." :Current global users ".self::countVisibleUsers().", max ".self::countMaxUsers());
			$socket->sendData($cid, ":".Configuration::getServerName()." 250 ".$client->getNick()." :Highest connection count: ".(self::countMaxUsers() - 1)." (".self::countMaxUsers()." clients) (".self::countMaxUsers()." connections received)");
			$socket->sendData($cid, ":".Configuration::getServerName()." 375 ".$client->getNick()." :- ".Configuration::getServerName()." Message of the Day -");
			foreach (Configuration::getMOTD() as $line) {
				$socket->sendData($cid, ":".Configuration::getServerName()." 372 ".$client->getNick()." :- ".$line);
			}
			$socket->sendData($cid, ":".Configuration::getServerName()." 376 ".$client->getNick()." :End of /MOTD command.");
		}
	}
?>