<?php
$database_config = include __DIR__ . '/../config/database.php';

$host = $database_config['host'];
$dbname = $database_config['dbname'];
$user = $database_config['user'];
$password = $database_config['password'];
$api_key = $database_config['api_key'];

$db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
