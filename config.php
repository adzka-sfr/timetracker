<?php
date_default_timezone_set('Asia/Jakarta');
$now = date('Y-m-d H:i:s');

// $host = 'localhost';  // local
// $dbname = 'counter'; // local
// $username = 'root';  // local
// $password = '';  // local

$today = date('l', strtotime($now));
$keygen = $today . '-vicidior';
$keygen = strtolower($keygen);

$host = 'localhost';  // hosting
$dbname = 'u266480338_counter'; // hosting
$username = 'u266480338_adzkaganteng';  // hosting
$password = 'Alfianwai1!';  // hosting

try {
    $connect = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
