<?php 
	session_start();
	include "../database/Database.php";
	$db = new Database();
	$conn = $db->connect();
	$sql = "delete from party where p_id=".$_POST['p_id'];
	if($conn->query($sql) === TRUE){
		$_SESSION['party_delete'] = "Party Deleted.";
	}else{
		$_SESSION['party_delete'] = "Party not deleted. Here is the Error ".$conn->error;
	}
?>