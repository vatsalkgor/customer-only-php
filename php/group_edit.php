<?php 
include "../database/Database.php";
$db = new Database();
$conn = $db->connect();
$sql = "select * from groups where g_id = ".$_POST['g_id'];
$res = $conn->query($sql);
$row = $res->fetch_array();
echo json_encode($row);
?>