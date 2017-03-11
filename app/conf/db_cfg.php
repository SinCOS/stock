<?php 
	return [
	'database_type' => 'mysql',
	'database_name' => 'stock',
	'server' => '127.0.0.1',
	'username' => 'root',
	'password' => '123456',
	'charset' => 'utf8',
 
	// [optional]
	'port' => 3306,
 
	// [optional] Table prefix
	'prefix' => 'cc_',
 
	// [optional] driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
	'option' => [
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	]
	];
?>