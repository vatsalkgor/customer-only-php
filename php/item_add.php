<?php 
	session_start();
	include "../database/Database.php";
	$db = new Database();
	$conn = $db->connect();
	// $sql = "insert into party(p_name,p_type,p_contact,p_address,p_pending_amount,p_credit_limit) values('$_POST['p_id']',$_POST['p_type'],'$_POST['p_contact']','$_POST['p_address'])";
	$sql = "insert into items(i_name,i_group_id) 
	values('".$_POST['i_item_name']."',".$_POST['i_item_group'].")";

	if($conn->query($sql) === TRUE){
		$_SESSION['new_item_added'] = "New Item Successfully Added";
		header('location:../new_item.php');
	}else{
		$_SESSION['new_item_not_added'] = "Something Went wrong.Here is the error".$conn->error;;
		header('location:../new_item.php');
	}
?>