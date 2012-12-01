<?php
	class ModeManagement {
		private static $channelmodes = array();
		private static $usermodes = array();
		
		public static function channelModeExists($char) {
			foreach (self::$channelmodes as $mode) {
				if ($mode[0] == $char) {
					return true;
				}
			}
			return false;
		}
		
		public static function userModeExists($char) {
			foreach (self::$usermodes as $mode) {
				if ($mode[0] == $char) {
					return true;
				}
			}
			return false;
		}
		
		public static function channelModeRequiresSetParam($char) {
			foreach (self::$channelmodes as $mode) {
				if ($mode[0] == $char) {
					if ($mode[1] == true) {
						return true;
					}
				}
			}
			return false;
		}
		
		public static function userModeRequiresSetParam($char) {
			foreach (self::$channelmodes as $mode) {
				if ($mode[0] == $char) {
					if ($mode[1] == true) {
						return true;
					}
				}
			}
			return false;
		}
		
		public static function channelModeRequiresUnsetParam($char) {
			foreach (self::$channelmodes as $mode) {
				if ($mode[0] == $char) {
					if ($mode[2] == true) {
						return true;
					}
				}
			}
			return false;
		}
		
		public static function userModeRequiresUnsetParam($char) {
			foreach (self::$channelmodes as $mode) {
				if ($mode[0] == $char) {
					if ($mode[2] == true) {
						return true;
					}
				}
			}
			return false;
		}
		
		public static function channelModeCanBeSetMultipleTimes($char) {
			foreach (self::$channelmodes as $mode) {
				if ($mode[0] == $char) {
					if ($mode[3] == true) {
						return true;
					}
				}
			}
			return false;
		}
		
		public static function userModeCanBeSetMultipleTimes($char) {
			foreach (self::$channelmodes as $mode) {
				if ($mode[0] == $char) {
					if ($mode[3] == true) {
						return true;
					}
				}
			}
			return false;
		}
		
		public static function registerChannelMode($char, $reqSetParam, $reqUnsetParam, $setMultipleTimes, $class, $setCallback, $unsetCallback) {
			foreach (self::$channelmodes as $mode) {
				if ($mode[0] != $char && ($reqSetParam == true || $reqSetParam == false) && ($reqUnsetParam == true || $reqUnsetParam == false) && ($setMultipleTimes == true || $setMultipleTimes == false) && is_object($class)) {
					self::$channelmodes[] = array($char, $reqSetParam, $reqUnsetParam, $setMultipleTimes, $class, $setCallback, $unsetCallback);
					return true;
				}
			}
			return false;
		}
		
		public static function registerUserMode($char, $reqSetParam, $reqUnsetParam, $setMultipleTimes, $class, $setCallback, $unsetCallback) {
			foreach (self::$usermodes as $mode) {
				if ($mode[0] != $char && ($reqSetParam == true || $reqSetParam == false) && ($reqUnsetParam == true || $reqUnsetParam == false) && ($setMultipleTimes == true || $setMultipleTimes == false) && is_object($class)) {
					self::$usermodes[] = array($char, $reqSetParam, $reqUnsetParam, $setMultipleTimes, $class, $setCallback, $unsetCallback);
					return true;
				}
			}
			return false;
		}
		
		public static function unregisterChannelMode($char) {
			foreach (self::$channelmodes as $id => $mode) {
				if ($mode[0] == $char) {
					unset(self::$channelmodes[$id]);
					return true;
				}
			}
			return false;
		}
		
		public static function unregisterUserMode($char) {
			foreach (self::$usermodes as $id => $mode) {
				if ($mode[0] == $char) {
					unset(self::$usermodes[$id]);
					return true;
				}
			}
			return false;
		}
	}
?>