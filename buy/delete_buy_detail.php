<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$sql = 'delete from purchase where pu_id='.$_POST['id'];
if($conn->query($sql) === TRUE){
	echo "1";
}else{
	echo "0";
}
?>
