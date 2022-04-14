<?php

	namespace Scanner;
	
	
	class Scan {
		
		private $target;
		
		private $tcp_ports = array();
		
		private $common_tcp_ports = array(

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
		
		public function __construct(string $target) {
			
			$this->target = $target;
			$this->tcp_ports = range(1, 65535);
			
		}
		
		/**  Returns true if target host is reachable, false if target is unreachable or target address is empty. */ 
		public function target_alive(): bool {
			
			if (empty($this->target)) throw new Exception("Target is not defined.");
			
			foreach ($this->common_tcp_ports as $number) {
				
				if ($fp = @fsockopen("tcp://".$this->target, $number, $errno, $errstr, 5)) {

					fclose($fp);
					return true;

				}
				
			}
			
			return false;
			
		}
		
		/**  Runs tcp port scan. Returns scan results as an array. */
		public function tcp_scan(bool $run_full_scan = false): array {
			
			$ports = ($run_full_scan) ? $this->tcp_ports : $this->common_tcp_ports;
			$result = array();			

			foreach ($ports as $service => $number) {
				
				if (is_resource($fp = @fsockopen("tcp://".$this->target, $number, $errno, $errstr, 2))) {

					fclose($fp);
					$service = (((int)$number - 1) == (int)$service) ? "unknown" : $service;
					$result[$service] = $number;

				} 
				
			}
			
			return $result;
			
		}

	};

