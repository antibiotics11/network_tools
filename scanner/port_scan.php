<?php
	
	class host {
		public $localhost_address;
		public $target_address;
		
		public function is_ipv4($address) {
			$address = explode(".", $address);
			for ($i = 0; $i < 4; $i++) {
				if (!is_numeric($address[$i]) || $address[$i] > 255) {
					return false;
				}
			}
			return true;
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
		
		public function tcp_port_scan(array $port_list) {
			foreach ($port_list as $port) {
				$socket_result = @fsockopen("tcp://".$this->target_address, $port, $errno, $errstr, 2);
				$port_index = array_search($port, $port_list);
				
				if (is_resource($socket_result)) {
					fclose($socket_result);
					$scan_result[$port_index] = true;
				} 
			}
			
			return $scan_result;
		}
		
		public function udp_port_scan(array $port_list) {
			
		}
		
		public function print_scan_result(array $scan_result) {
			foreach ($scan_result as $port) {
				$port_index = array_search($port, $scan_result);
				
			}
			
			return;
		}
	}