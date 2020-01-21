<?php 
	include '../database/Database.php';
	$db = new Database();
	$conn = $db->connect();
	$date = date('Y-m-d',strtotime($_POST['date']));
	$sql = "insert into caret(party,date,caret) values(".$_POST['id'].",'$date',".$_POST['caret'].")";
	if($conn->query($sql) === TRUE){
		echo "1";
	}else{
		echo "0";
	}
?>