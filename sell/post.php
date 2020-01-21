<?php 
	session_start();
	$_SESSION['s_id'] = $_GET['id'];
	// echo $_SESSION['e_b_no'];
	header('location:update_sell_details.php');
 ?>