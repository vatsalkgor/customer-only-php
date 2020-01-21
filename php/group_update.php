<?php 
session_start();
	include "../database/Database.php";
	$db = new Database();
	$conn = $db->connect();
	$sql = "update groups set g_name='".$_POST['g_name']."',g_customer_com='".$_POST['g_customer_com']."',g_customer_wage=".$_POST['g_customer_wage']." where g_id=".$_POST['g_id'];
	if($conn->query($sql) === TRUE){
		$_SESSION['group_update_success'] = "Group Successfully Updated";
		echo "1";
	}else{
		$_SESSION['group_update_unsuccess'] = "Something went wrong. Here is the error ".$conn->error;
		echo "0";
	}
?>