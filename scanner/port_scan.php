<?php
	
	class host {
		public $localhost_address;
		public $target_address;
		
		public function return_localhost() {
			return $this->localhost_address;
		}
		
		public function return_target() {
			return $this->target_address;
		}
		
		public function check_target_alive() {
			$socket_result = @fsockopen("udp://".$this->target_address, 13, $errno, $errstr, 5);
			if ($socket_result) { 
				fclose($socket_result);
				return true; 
			} else { 
				fclose($socket_result);
				return false; 
			}
		}
	}
	
	class scan {
		public $localhost_address;
		public $target_address;
		
		private function get_protocol($protocol) {
			if (strtolower($protocol) == "tcp" || $protocol == 1) {
				return "tcp";
			} else {
				return "udp";
			}
		}
		
		public function port_scan(array $port_list, $protocol) {
			foreach ($port_list as $port) {
				$socket_result = @fsockopen($this->get_protocol($protocol)."://".$this->target_address, $port, $errno, $errstr, 2);
				$port_index = array_search($port, $port_list);
				
				if (is_resource($socket_result)) {
					fclose($socket_result);
					$scan_result[$port_index] = true;
				} else {
					fclose($socket_result);
					$scan_result[$port_index] = false;
				}
			}
			
			return $scan_result;
		}
		
		public function full_scan($priority) {
			$protocol = $priority;
			for ($i = 0; $i <= 65535; $i++) {
				
			}
		}
	}