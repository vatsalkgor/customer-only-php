<?php 
	session_start();
	include "../database/Database.php";
	$db = new Database();
	$conn = $db->connect();
	$sql = "delete from groups where g_id=".$_POST['g_id'];
	if($conn->query($sql) === TRUE){
		$_SESSION['group_delete'] = "Group Deleted.";
	}else{
		$_SESSION['group_delete'] = "Grpup not deleted. Here is the Error ".$conn->error;
	}
?>