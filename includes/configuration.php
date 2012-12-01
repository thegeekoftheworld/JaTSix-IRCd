<?php
	class Configuration {
		private static $networkname;
		private static $servername;
		private static $motd;
		
		public static function loadConfigs() {
			$ircd = explode("\n", file_get_contents("conf/ircd.conf"));
			self::$motd = explode("\n", file_get_contents("conf/motd.conf"));
			
			foreach ($ircd as $line) {
				if (preg_match("/^NETNAME=(.*)/", $line, $matches)) {
					self::$networkname = $matches[1];
				}
				if (preg_match("/^SERVNAME=(.*)/", $line, $matches)) {
					self::$servername = $matches[1];
				}
			}
		}
		
		public static function getMOTD() {
			return self::$motd;
		}
		
		public static function getNetworkName() {
			return self::$networkname;
		}
		
		public static function getServerName() {
			return self::$servername;
		}
	}
?>