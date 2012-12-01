<?php
	class @@CLASSNAME@@ {
		public $name = "CMode_o";
		
		public function setChannelMode($param) {
			
		}
		
		public function unsetChannelMode($param) {
			
		}
		
		public function isInstantiated() {
			ModeManagement::registerChannelMode("o", true, true, true, $this, "setChannelMode", "unsetChannelMode");
			return true;
		}
	}
?>