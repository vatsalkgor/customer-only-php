<?php 
	session_start();
	include "../database/Database.php";
	$db = new Database();
	$conn = $db->connect();
	$sql = "delete from items where i_id=".$_POST['i_id'];
	if($conn->query($sql) === TRUE){
		$_SESSION['item_delete'] = "Group Deleted.";
	}else{
		$_SESSION['item_delete'] = "Grpup not deleted. Here is the Error ".$conn->error;
	}
?>