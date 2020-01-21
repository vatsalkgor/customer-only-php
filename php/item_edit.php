<?php 
include "../database/Database.php";
$db = new Database();
$conn = $db->connect();
$sql = "select * from items where i_id = ".$_POST['i_id'];
$res = $conn->query($sql);
$row = $res->fetch_array();
echo json_encode($row);
?>