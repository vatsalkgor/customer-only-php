<?php 
	session_start();
	include "../database/Database.php";
	$db = new Database();
	$conn = $db->connect();
	// $sql = "insert into party(p_name,p_type,p_contact,p_address,p_pending_amount,p_credit_limit) values('$_POST['p_id']',$_POST['p_type'],'$_POST['p_contact']','$_POST['p_address'])";
	$sql = "insert into groups(g_name,g_customer_com,g_customer_wage) 
	values('".$_POST['g_g_name']."',".$_POST['g_customer_com'].",".$_POST['g_customer_wage'].")";
	if($conn->query($sql) === TRUE){
		$_SESSION['new_group_added'] = "New Group Successfully Added";
		header('location:../new_group.php');
	}else{
		$_SESSION['new_group_not_added'] = "Something Went wrong.Here is the error".$conn->error;;
		header('location:../new_group.php');
	}
?>