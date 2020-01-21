<?php 
	include '../database/Database.php';
	$db = new Database();
	$conn = $db->connect();
	$sql = "select IFNULL(SUM(caret),0) as caret from caret where party=".$_POST['id'];
	$res = $conn->query($sql)->fetch_array()[0];
	echo $res;
?>