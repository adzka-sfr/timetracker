<?php
date_default_timezone_set('Asia/Jakarta');
$now = date('Y-m-d H:i:s');

// Detect environment based on the host
if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
    // Local environment
    $host = 'localhost';
    $dbname = 'counter';
    $username = 'root';
    $password = '';
} else {
    // Hosting environment
    $host = 'localhost';
    $dbname = 'u266480338_counter';
    $username = 'u266480338_adzkaganteng';
    $password = 'Alfianwai1!';
}

$today = date('l', strtotime($now));
$keygen = $today . '-vicidior';
$keygen = strtolower($keygen);

try {
    $connect = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
