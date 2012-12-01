<?php
	class Channel {
		private $channame;
		private $members;
		private $modes;
		
		public function __construct($client, $channame) {
			$this->channame = $channame;
			$this->joinChannel($client);
		}
		
		public function joinChannel($client) {
			$this->members[] = $client;
			EventHandling::triggerEvent('clientJoinedChannel', array($client, $this->channame));
		}
		
		public function partChannel($client) {
			foreach ($this->members as $id => $member) {
				if ($client->getNick() == $member->getNick()) {
					unset($this->members[$id]);
					EventHandling::triggerEvent('clientPartedChannel', array($client, $this->channame));
				}
			}
		}
		
		public function broadcastMessage($params) {
			foreach ($this->members as $member) {
				if ($member->getNick() != $params[]])
			}
		}
	}
?>