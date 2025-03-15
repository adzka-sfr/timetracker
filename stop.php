<?php
include 'config.php';

// get data post
$id = $_POST['id'];
$stop_time = $_POST['stop_time'];
$stop_time = date('Y-m-d H:i:s', strtotime($stop_time));

// stop data
$sql = "UPDATE t_data SET c_event_end = :stop_time WHERE id = :id";
$query = $connect->prepare($sql);
$query->bindParam(':id', $id);
$query->bindParam(':stop_time', $stop_time);
$query->execute();

echo json_encode(['status' => 'success']);
