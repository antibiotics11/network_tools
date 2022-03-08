<?php
	
	@error_reporting(E_ALL);
	
	//ini_set("display_errors", 1);

	if (empty(exec("pgrep tor;"))) {
		echo "Tor Service is not currently running on this server.";
		exit();
	}
	
	if (!isset($_GET["url"]) || empty($_GET["url"])) {
		echo "Please enter the URL.";
		exit();
	}
	
	$localhost = "127.0.0.1";
	$port = "9050";
	
	$onion_url = (string)$_GET["url"];
	$proxy_url = "http://".$localhost.":".$port;
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $onion_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300); 
	
	//curl_setopt($ch, CURLOPT_HEADER, true);
	//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	
	curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
	curl_setopt($ch, CURLOPT_PROXY, $proxy_url);
	curl_setopt($ch, CURLOPT_PROXYTYPE, 7);

	$contents = curl_exec($ch);
	print_r($contents);
	
	//$error = curl_error($ch);
	//print_r($error);

	curl_close($ch);
