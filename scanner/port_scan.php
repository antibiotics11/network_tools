<?php
	
	class host {
		public $localhost_address;
		public $target_address;
		
		public function is_ipv4($address) {
			$address = explode(".", $address);
			for ($i = 0; $i < count($address); $i++) {
				if (!is_numeric($address[$i]) || (int)$address[$i] > 255 || (int)$address[$i] < 0) {
					return false;
				}
				if ($i >= 4) {
					return false;
				}
			}
			return true;
		}
		
		public function is_private_ipv4($address) {
			if (!$this->is_ipv4($address)) {
				return false;
			}
			
			$address = explode(".", $address);
			// private address range 10.0.0.0/8
			if ((int)$address[0] == 10) {
				return true;
			// private address range 192.168.0.0/16
			} else if ((int)$address[0] == 192 && (int)$address[1] == 168) {
				return true;
			// private address range 172.16.0.0/12
			} else if ((int)$address[0] == 172 && (int)$address[1] >= 16 && (int)$address[1] <= 31) {
				return true;
			} else {
				return false;
			}
		}
		
		public function target_alive() {
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
