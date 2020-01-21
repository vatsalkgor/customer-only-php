<?php 
session_start();
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$sql = "update settings set value=".$_POST['rs']." where type='rs'";
if($conn->query($sql) === TRUE){
    echo "RS Successfully Changed";
}
else{
    echo "Something Went Wrong. ".$conn->error."alsdfjalsdfj".$sql;
}
?> 