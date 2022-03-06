<?php

	namespace scanner;
	
	
	class ip {
		
		/**  Returns true if the target address format is ipv4, otherwise false. */
		public static function is_ipv4(string $address): bool {
			
			$address = explode(".", $address);
			
			if (count($address) != 4) {
				return false;
			}
			foreach ($address as $part) {
				if (!is_numeric($part) || (int)$part > 255 || (int)$part < 0) {
					return false;
				}
			}
			
			return true;
			
		}
		
		/**  Returns true if the input address format is ipv6, otherwise false. */
		public static function is_ipv6(string $address): bool {
			
			$address = explode(":", $address);
			
			if (count($address) > 8 || count($address) < 2) {
				return false;
			}
			foreach ($address as $part) {
				if (empty($part)) {
					$part = "0";
				}
				if (!ctype_xdigit($part) || (int)hexdec($part) > 65535 || (int)hexdec($part) < 0) {
					return false;
				}
			}
			
			return true;
			
		}
		
	};
	
	
	class scan {
		
		private $target_address;
		
		private $tcp_ports_list = array();
		
		private $common_tcp_ports_list = array(
			"ftp" => "21",
			"ssh" => "22",
			"talnet" => "23",
			"smtp" => "25",
			"dns" => "53",
			"http" => "80",
			"pop3" => "110",
			"imap" => "143",
			"https" => "443",
			"oracle" => "1521",
			"mysql" => "3306"
		);
		
		public function __construct(string $target_address) {
			
			$this->target_address = $target_address;
			$this->tcp_ports_list = range(1, 65535);
			
		}
		
		/**  Returns true if target host is reachable, false if target is unreachable or target address is empty. */ 
		public function target_alive(): bool {
			
			if (empty($this->target_address)) {
				
				return false;
				
			}
			
			foreach ($this->common_tcp_ports_list as $port) {
				
				if ($socket = @fsockopen("tcp://".$this->target_address, $port, $errno, $errstr, 5)) {
					fclose($socket);
					return true;
				}
				
			}
			
			return false;
			
		}
		
		/**  Runs tcp port scan. Returns scan results as an array. */
		public function tcp_scan(int $type = 1): array {
			
			$ports_list = $this->tcp_ports_list;
			if ($type == 1) {
				$ports_list = $this->common_tcp_ports_list;
			} 
			
			foreach ($ports_list as $port) {
				
				$socket_result = @fsockopen("tcp://".$this->target_address, $port, $errno, $errstr, 2);
				$port_index = array_search($port, $ports_list);
				
				if (is_resource($socket_result)) {
					fclose($socket_result);
					$scan_result[$port_index] = true;
				} 
				
			}
			
			return $scan_result;
			
		}

	};
