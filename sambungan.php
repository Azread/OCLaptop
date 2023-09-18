<?php

$servername = "localhost:3307";
$username = "root";
$password = ""; 
$database = "kedai"; 

$sambungan = new mysqli($servername, $username, $password, $database);

if ($sambungan->connect_error) {
    die("Connection failed: " . $sambungan->connect_error);
} 
?>
