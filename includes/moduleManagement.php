<?php
	class ModuleManagement {
		private static $modules = array();
		
		public static function isLoaded($name) {
			foreach (self::$modules as $module) {
				if (strtolower($module->name) == strtolower($name)) {
					return true;
				}
			}
			return false;
		}
		
		public static function getModuleByName($name) {
			foreach (self::$modules as $module) {
				if (strtolower($module->name) == strtolower($name)) {
					return $module;
				}
			}
			return false;
		}
		
		public static function loadModule($name, $suppressNotice = false) {
			if ($suppressNotice == false) {
				echo "Loading module \"".$name."...\"\n";
			}
			
			if (!self::isLoaded($name)) {
				$classname = $name.time().mt_rand();
				$eval = str_ireplace("@@CLASSNAME@@", $classname, substr(trim(file_get_contents("includes/modules/".$name.".php")), 5, -2));
				eval($eval);
				$module = new $classname();
				if ($module->isInstantiated()) {
					self::$modules[] = $module;
					return true;
				}
			}
			return true;
		}
		
		public static function reloadAllModules() {
			foreach (self::$modules as $module) {
				self::reloadModule($module->name);
			}
		}
		
		public static function reloadModule($name) {
			echo "Reloading module \"".$name."...\"\n";
			if (self::isLoaded($name)) {
				self::unloadModule($name, true);
			}
			return self::loadModule($name, true);
		}
		
		public static function unloadModule($name, $suppressNotice = false) {
			if ($suppressNotice == false) {
				echo "Unloading module \"".$name."...\"\n";
			}
			
			if (self::isLoaded($name)) {
				EventHandling::unregisterModule($name);
				foreach (self::$modules as $key => $module) {
					if (strtolower($module->name) == strtolower($name)) {
						unset(self::$modules[$key]);
						return true;
					}
				}
			}
			return false;
		}
		
		public static function newData($connection, $data) {
			foreach (self::$modules as $module) {
				$module->receiveData($connection, $data);
			}
			return true;
		}
	}
?>
