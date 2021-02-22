<?php 
ob_start(); //Turns on output buffering
session_start();

date_default_timezone_set("Asia/Kolkata");

try {
		$con = new PDO("mysql:dbname=decentube;host=localhost;charset=utf8mb4;","root","");
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$ipfsNodeArray = array(
			"1" => "https://314744871d1c.ngrok.io/ipfs/",
			"2" => "https://9ffdb14478b7.ngrok.io/ipfs/",
			"3" => "https://ipfs.io/ipfs/"
			// "4" => "https://43016f9a4524.ngrok.io/ipfs/"
			
			// "2" => "https://gateway.temporal.cloud/ipfs/"
			//https://gateway.pinata.cloud/ipfs/
			);
		// https://ipfs.github.io/public-gateway-checker/ USE PINATA OR IPFS.io
}
catch (PDOException $e) {
		echo "Connection Failed: ".$e->getMessage();
}
?>