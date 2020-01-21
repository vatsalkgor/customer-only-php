<?php 
	session_start();
	include "../database/Database.php";
	$db = new Database();
	$conn = $db->connect();
	// $sql = "insert into party(p_name,p_type,p_contact,p_address,p_pending_amount,p_credit_limit) values('$_POST['p_id']',$_POST['p_type'],'$_POST['p_contact']','$_POST['p_address'])";
	$sql = "insert into party(p_name,p_pending_amount) 
	values('".$_POST['p_name']."',".$_POST['p_pending_amount'].")";
	if($conn->query($sql) === TRUE){
		echo "Success";
		$_SESSION['new_party_added'] = "New Party Successfully Added";
		header('location:../new_party.php');
	}else{
		echo "not success";
		$_SESSION['new_party_not_added'] = "Something Went wrong.Here is the error".$conn->error.$sql;
		header('location:../new_party.php');
	}
?>