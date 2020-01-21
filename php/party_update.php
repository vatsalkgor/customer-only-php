<?php 
session_start();
	include "../database/Database.php";
	$db = new Database();
	$conn = $db->connect();
	$sql = "update party set p_name='".$_POST['p_name']."',p_pending_amount=".$_POST['p_pending_amount']." where p_id=".$_POST['p_id'];
	if($conn->query($sql) === TRUE){
		$_SESSION['party_update_success'] = "Party Successfully Updated";
		echo "1";
	}else{
		$_SESSION['party_update_unsuccess'] = "Something went wrong. Here is the error ".$conn->error;
		echo "0";
	}
?>