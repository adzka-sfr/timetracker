<?php
include 'config.php';

// get data post
$id = $_POST['id'];

// delete data
$sql = "DELETE FROM t_data WHERE id = :id";
$query = $connect->prepare($sql);
$query->bindParam(':id', $id);
$query->execute();

echo json_encode(['status' => 'success']);
?>