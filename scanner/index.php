<?php
	include "port_list.php";
	include "port_scan.php";
	
	if (isset($_GET["target_address"])) {
		$host = new host();
		$scan = new scan();
		
		$host->localhost_address = "127.0.0.1";
		$host->target_address = (string)$_GET["target_address"];
		$scan->localhost_address = "127.0.0.1";
		$scan->target_address = (string)$_GET["target_address"];
		
		if ($host->check_target_alive($host->target_address)) {
			//$tcp_scan_result = $scan->port_scan($default_tcp_port_list, 1);
			//print_r($tcp_scan_result);
			
			$full_scan_result = $scan->full_scan();
			print_r($full_scan_result);
		} else {
			echo "호스트 응답 없음";
		}
	}