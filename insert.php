<?php
include 'config.php';

// get data 
$c_title = $_POST['c_title'];
$c_desc = $_POST['c_desc'];
$c_event = $_POST['c_event'];
$c_event = date('Y-m-d H:i:s', strtotime($c_event));
$c_keygen = $_POST['c_keygen'];

$c_timestamp = $now;

// check keygen
if ($c_keygen == $keygen) {
    // insert data
    $sql = "INSERT INTO t_data (c_title, c_desc, c_event_time, c_timestamp) VALUES ('$c_title', '$c_desc', '$c_event', '$c_timestamp')";
    $query = $connect->prepare($sql);
    $query->execute();
    echo "success";
} else {
    echo "wrong-keygen";
}
