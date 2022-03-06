<?php

	include_once "scanner.php";
	
	use scanner\{ip, scan};
	
	$target = "127.0.0.1";
	
	if (isset($_SERVER["argv"][1])) {
		
		$target = $_SERVER["argv"][1];
		$target = gethostbyname($target);
	
	}
	
	if (ip::is_ipv4($target)) {
		
		echo $target." is ipv4".PHP_EOL;
		
	} else if (ip::is_ipv6($target)) {
		
		echo $target." is ipv6".PHP_EOL;
		
	} else {
		
		echo "Unknown host ".$target.PHP_EOL;
		echo "Aborting..".PHP_EOL;
		exit(0);
		
	}
	
	$scan = new scan($target);
	
	if ($scan->target_alive()) {
		
		echo "Target host is alive".PHP_EOL;
		
	} else {
		
		echo "Target host may not be alive".PHP_EOL;
		
	}
	
	echo "Scanning host ".$target."..".PHP_EOL;
	$result = $scan->tcp_scan();
	
	if (count($result) <= 0) {
		
		echo "No open ports detected".PHP_EOL;
		echo "Aborting..".PHP_EOL;
		exit(0);
		
	}
	
	foreach ($result as $port => $alive) {
		
		echo $port." is open".PHP_EOL;
		
	}
	