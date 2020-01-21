<?php 
	session_start();
	$_SESSION['e_b_no'] = $_GET['id'];
	echo $_SESSION['e_b_no'];
	header('location:../update_buy_details.php');
 ?>