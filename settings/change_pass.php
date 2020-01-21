<?php 
session_start();
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$sql = "select opassword from login where id=".$_SESSION['u_id'];
$oldPass = $conn->query($sql)->fetch_array()[0];
if(strcmp($oldPass,$_POST['old']) == 0){
	$sql="update login set opassword='".$_POST['new']."', password='".md5($_POST['new'])."' where id=".$_SESSION['u_id'];
	if($conn->query($sql) === TRUE){
		echo "Password Successfully Changed";
	}
	else{
		echo "Something Went Wrong. ".$conn->error;
	}
}else{
	echo "Old Password does not match";
}
?> 