<?php
include 'config.php';

// get data
$sql = "SELECT * FROM t_data ORDER BY c_event_time DESC";
$query = $connect->prepare($sql);
$query->execute();
$data = $query->fetchAll();

echo json_encode($data);
