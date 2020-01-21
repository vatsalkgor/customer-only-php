<?php 
session_start();
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$date= date('Y.m.d',strtotime($_POST['date']));
$sql = "insert into account (a_v_no,p_id,a_date,a_amount) values(".$_POST['v_no'].",".$_POST['p_id'].",'$date',".$_POST['amt'].")";
$res = array();
if($conn->query($sql) === TRUE){
	function __autoload($class){
		include_once("../logs/$class.php");
	}
	$name = $conn->query("select p_name from party where p_id=".$_POST['p_id'])->fetch_array()[0];
	$logger = new LogInterface();
	$logger->addPaymentLog($_SESSION['u_name'],$name,$_POST['amt'],$conn);
	$res['success'] = 1;
	echo json_encode($res);
}
else{
	$res['success'] = "0".$conn->error;
	echo json_encode($res);
}