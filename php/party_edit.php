<?php 
include "../database/Database.php";
$db = new Database();
$conn = $db->connect();
$sql = "select * from party where p_id = ".$_POST['p_id'];
$res = $conn->query($sql);
$row = $res->fetch_array();
echo json_encode($row);
?>