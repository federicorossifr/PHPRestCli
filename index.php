<?php
	require "./RestCli.php";

	$client = new RestCli("https://httpbin.org");
	$client->setDebugLevel(10);
	$resp = $client->GET("/get","",1);
	echo "<pre>" . var_export($resp,true) . "</pre>";

	echo "<hr>";

	$resp = $client->POST("/post","",array("field1"=>"hi"),1);
	echo "<pre>" . var_export($resp,true) . "</pre>";

	echo "<hr>";

	$resp = $client->PUT("/put","",array("field1"=>"hi"),1);
	echo "<pre>" . var_export($resp,true) . "</pre>";

	echo "<hr>";

	$resp = $client->PUT("/put","",array("field1"=>"hi"),1);
	echo "<pre>" . var_export($resp,true) . "</pre>";