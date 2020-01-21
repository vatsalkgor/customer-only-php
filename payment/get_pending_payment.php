<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$sql = "select ((select IFNULL(sum(s_total),0) from sell_bill WHERE s_c_id=".$_POST['id'].") + (select IFNULL(p_pending_amount,0) from party where p_id=".$_POST['id'].") - (select IFNULL(sum(a_amount),0) from account where account.p_id=".$_POST['id'].")) as pending"; 
echo $conn->query($sql)->fetch_array()[0];
?>