<?php 
session_start();
	include "../database/Database.php";
	$db = new Database();
	$conn = $db->connect();
	$sql = "update items set i_name='".$_POST['i_name']."',i_group_id=".$_POST['i_group_id']." where i_id=".$_POST['i_id'];
	if($conn->query($sql) === TRUE){
		$_SESSION['item_update_success'] = "Group Successfully Updated";
		echo "1";
	}else{
		$_SESSION['item_update_unsuccess'] = "Something went wrong. Here is the error ".$conn->error;
		echo "0";
	}
?>