<?php
	
	echo "<head><title>PHP Port Scanner v1.0</title><meta charset = \"UTF-8\"></head>";
	echo "PHP Port Scanner v1.0 <br><br><br>";
	
	include "port_list.php";
	include "port_scan.php";
	
	$option_list = array(
		"dt" => "default_tcp_port_list",
		"du" => "default_udp_port_list",
		"ft" => "full_tcp_port_list",
		"fu" => "full_udp_port_list",
		"ct" => "custom_tcp_port_list",
		"cu" => "custom_udp_port_list"
	);
	
	$host = new host();
	$scan = new scan();
	
	if (isset($_GET["addr"])) {
		$host->localhost_address = (string)$_SERVER["SERVER_ADDR"];
		$host->target_address = (string)$_GET["addr"];
		$scan->localhost_address = $host->localhost_address;
		$scan->target_address = $host->target_address;
		
		echo "Sending \"ping\" request to ".$host->target_address."(".gethostbyname($host->target_address).")... <br><br>";
		
		if (!isset($_GET["o"]) || empty($_GET["o"])) {
			echo "Failed to scan: At least one option is required <br><br>";
			exit();
		}
		
		if ($host->check_target_alive($host->target_address)) {
			$input_options = explode(",", $_GET["o"]);
			
			for ($i = 0; $i < count($input_options); $i++) {
				$input_options[$i] = trim($input_options[$i]);
				
				if (!array_key_exists($input_options[$i], $option_list)) {
					echo "Failed to scan: Unknown option \"".$input_options[$i]."\"<br><br>";
					exit();
				}
				
				$port_list = ${$option_list[$input_options[$i]]};
				
				if (strpos($input_options[$i], "t")) {
					$result = $scan->tcp_port_scan($port_list);
					print_r($result);
				} else if (strpos($input_options[$i], "u")) {
					$scan->udp_port_scan($port_list);
				}
			}
		} else {
			echo "Failed to scan: Request timed out <br><br>";
		}
	} else {
		echo "Please refer to User Manual: &nbsp; https://github.com/antibiotics/Port_Scanner";
	}