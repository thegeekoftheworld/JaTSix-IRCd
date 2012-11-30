<?php
	class EventHandling {
		private static $events;
		
		public static function registerForEvent($event, $class, $callback) {
			self::$events[] = array($event, $class, $callback);
		}
		
		public static function unregisterForEvent($event, $class) {
			foreach (self::$events as $id => $entry) {
				if (strtolower($entry[0]) == strtolower($event) && strtolower($entry[1]->name) == strtolower($class->name)) {
					unset(self::$events[$id]);
				}
			}
		}
		
		public static function unregisterModuleFromEvents($module) {
			foreach (self::$events as $id => $entry) {
				if (strtolower($entry[1]->name) == strtolower($module)) {
					unset(self::$events[$id]);
				}
			}
		}
		
		public static function triggerEvent($event, $params) {
			foreach (self::$events as $event) {
				if (strtolower($event[0]) == strtolower($event)) {
					$module = $event[1];
					$callback = $event[2];
					$module->$callback($params);
				}
			}
		}
	}
?>