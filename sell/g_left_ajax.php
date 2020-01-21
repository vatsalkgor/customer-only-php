<?php 
session_start();
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$sql = "select DISTINCT g_customer_com,g_customer_wage from groups join items where g_id = (SELECT i_group_id from items where i_id=".$_POST['i_id'].")";
$row = $conn->query($sql)->fetch_array();
$response[0] = $row[0];
$response[1] = $row[1];
echo json_encode($response);
?>