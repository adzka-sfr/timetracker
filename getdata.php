<?php
include 'config.php';

// get data
$sql = "SELECT * FROM t_data ORDER BY id DESC";
$query = $connect->prepare($sql);
$query->execute();
$data = $query->fetchAll();

echo json_encode($data);
