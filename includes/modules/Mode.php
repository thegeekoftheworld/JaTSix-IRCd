<?php
	class @@CLASSNAME@@ {
		public $name = "Mode";
		
		public function receiveData($params) {
			if (preg_match("/^MODE (.*)/", trim($params[2]), $matches)) {
				//Check for Permission when op is implemented!
				$matches = explode(" ", trim($matches[1]));
				$target = $matches[0];
				unset($matches[0]);
				
				if (count($matches) > 1) {
					$modeString = $matches[1];
				}
				else {
					$modeString = implode(" ", $matches);
				}
				
				if (substr($modeString, 0, 1) == ":") {
					$modeString = substr($modeString, 0, 1);
				}
				
				$type = "u";
				if (substr($target, 0, 1) == "#") {
					$type = "c";
				}
				
				$modes = $this->parseModes($modeString, $type);
				echo trim(var_export($modes, true))."\n";
			}
		}
		
		private function countRequiredParams($modes, $type) {
			for ($i = 0; $i < strlen($modes); $i++) {
				$char = substr($modes, $i, 1);
				if ($char == "+") {
					$setOperation = "+";
				}
				elseif ($char == "-") {
					$setOperation = "-";
				}
				else {
					if ($type == "c") {
						if (ModeManagement::channelModeExists($char)) {
							if ($setOperation == "+") {
								if (ModeManagement::channelModeRequiresSetParam($char)) {
									$paramReq++;
								}
							}
							else {
								if (ModeManagement::channelModeRequiresUnsetParam($char)) {
									$paramReq++;
								}
							}
						}
						else {
							return false;
						}
					}
					else {
						if (ModeManagement::userModeExists($char)) {
							if ($setOperation == "+") {
								if (ModeManagement::userModeRequiresSetParam($char)) {
									$paramReq++;
								}
							}
							else {
								if (ModeManagement::userModeRequiresUnsetParam($char)) {
									$paramReq++;
								}
							}
						}
						else {
							return false;
						}
					}
				}
			}
			return $paramReq;
		}
		
		private function parseModes($modeString, $type) {
			$setModes = array();
			$unsetModes = array();
			$paramString = explode(" ", $modeString);
			$modes = $paramString[0];
			unset($paramString[0]);
			$params = explode(" ", implode(" ", $paramString));
			if (count($params) < $this->countRequiredParams($modes, $type)) {
				return false;
			}
			$j = 0;
			for ($i = 0; $i < strlen($modes); $i++) {
				$char = substr($modes, $i, 1);
				if ($char == "+") {
					$setOperation = "+";
				}
				elseif ($char == "-") {
					$setOperation = "-";
				}
				else {
					if ($type == "c") {
						if (ModeManagement::channelModeExists($char)) {
							if ($setOperation == "+") {
								if (ModeManagement::channelModeRequiresSetParam($char)) {
									$setModes[] = array($char, $params[$j]);
									$j++;
								}
								else {
									$setModes[] = array($char);
								}
							}
							else {
								if (ModeManagement::channelModeRequiresUnsetParam($char)) {
									$unsetModes[] = array($char, $params[$j]);
									$j++;
								}
								else {
									$unsetModes[] = array($char);
								}
							}
						}
						else {
							return false;
						}
					}
					else {
						if (ModeManagement::userModeExists($char)) {
							if ($setOperation == "+") {
								if (ModeManagement::userModeRequiresSetParam($char)) {
									$setModes[] = array($char, $params[$j]);
									$j++;
								}
								else {
									$setModes[] = array($char);
								}
							}
							else {
								if (ModeManagement::userModeRequiresUnsetParam($char)) {
									$unsetModes[] = array($char, $params[$j]);
									$j++;
								}
								else {
									$unsetModes[] = array($char);
								}
							}
						}
						else {
							return false;
						}
					}
				}
			}
			return array($setModes, $unsetModes);
		}
		
		public function isInstantiated() {
			EventHandling::registerForEvent("rawDataReceived", $this, "receiveData");
			return true;
		}
	}
?>