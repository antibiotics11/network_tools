<?php

	include_once "IP.class.php";
	include_once "Scan.class.php";
	
	use \Scanner\{IP, Scan};
	
	$target = readline("Target Host >> ");
	$target = gethostbyname($target);

	$fullscan = readline("Run full scan? (y, n) >> ");
	$fullscan = ($fullscan == "y") ? true : false;

	echo PHP_EOL;
	
	if (ip::is_ipv4($target)) {
		
		echo $target." is ipv4".PHP_EOL;
		
	} else if (ip::is_ipv6($target)) {
		
		echo $target." is ipv6".PHP_EOL;
		
	} else {
		
		echo "Unknown Host ".$target.PHP_EOL;
		echo "Aborting..".PHP_EOL;
		exit(0);
		
	}
	
	$scanner = new scan($target);	

	if ($scanner->target_alive()) {
		
		echo $target." is alive.".PHP_EOL;
		
	} else {
		
		echo $target." may not be alive.".PHP_EOL;
		
	}
	
	echo "Scanning...".PHP_EOL;

	$result = $scanner->tcp_scan($fullscan);
	
	if (count($result) <= 0) {
		
		echo "No open ports detected.".PHP_EOL;
		exit(0);
		
	}

	echo count($result)." open ports detected.".PHP_EOL;
	
	foreach ($result as $service => $number) {
		
		echo $number." (".$service.")".PHP_EOL;
		
	}
	
