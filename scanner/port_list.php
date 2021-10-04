<?php	
	
	//Custom list of TCP and UDP port numbers you can add as
	
	/*
	 * Here's an example.
	 *
	 * Do not change the variable name !
	
	$custom_tcp_port_list == array(
		"my_port_1" => "1000",
		"my_port_2" => "2000",
		"my_port_3" => "3000"
	)
	
	 */
	
	$custom_tcp_port_list = array(
	);
	
	$custom_udp_port_list = array(
	);
	
	// Default list of TCP and UDP port numbers used by protocols for operation of network applications. 
	
	$default_tcp_port_list = array(
		"ftp" => "21",
		"ssh" => "22",
		"telnet" => "23",
		"smtp" => "25",
		"dns" => "53",
		"http" => "80",
		"pop3" => "110",
		"imap" => "143",
		"https" => "443",
		"oracle" => "1521",
		"mysql" => "3306"
	);
	
	$default_udp_port_list = array(
		"dns" => "53",
		"ntp" => "123"
	);
	
	for ($i = 1; $i <= 65535; $i++) {
		$full_tcp_port_list[$i] = $i;
		$full_udp_port_list[$i] = $i;
	}