<?php 

	session_start();

	$uname = $_POST['username'];

	$pass = $_POST['password'];

	$pass = md5($pass);

	include "../database/Database.php";

	$db = new Database();

	$conn = $db->connect();

	$sql = 'select * from login where username = '."'$uname'".' and password = '."'$pass'";

	$res = $conn->query($sql);

	if($res->num_rows == 1){

		$temp = $res->fetch_array();

		$_SESSION['u_id'] = $temp['id'];

		$_SESSION['u_name'] = $temp['username'];

		$_SESSION['u_type'] = $temp['type'];

		header('location:../dashboard.php');

	}else{

		$_SESSION['wrong_id_pass'] = "You have entered wrong username or password. Please Try Again.".$conn->error;

		header('location:../index.php');



	}

?>