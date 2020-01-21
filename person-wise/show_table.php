<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$f_date = date('Y-m-d',strtotime($_POST['f_date']));
$t_date = date('Y-m-d',strtotime($_POST['t_date']));

$finalData = array();
$pendingsql = "select ROUND(((select IFNULL(sum(s_total),0) from sell_bill WHERE s_c_id=".$_POST['f_name']." and s_date < '$f_date') + (select IFNULL(p_pending_amount,0) from party where p_id=".$_POST['f_name'].") - (select IFNULL(sum(a_amount),0) from account where account.p_id=".$_POST['f_name']." and a_date < '$f_date'))) as pending";
$finalData['pending'] = $conn->query($pendingsql)->fetch_array()[0];
$finalData['table']=array();
$t_date = date('Y-m-d',strtotime($t_date." +1 day"));
// $finalData['table']['date']=array();
// $finalData['table']['debit']=array();
// $finalData['table']['credit']=array();
while(strcmp($f_date,$t_date) !=0){
	$s_date = date('d.m.Y',strtotime($f_date));
	$finalData['table'][$s_date] = array();
	$debitsql = "select IFNULL(ROUND(SUM(s_total)),0) as total from sell_bill where s_c_id=".$_POST['f_name']." and s_date='$f_date'";
	array_push($finalData['table'][$s_date], $conn->query($debitsql)->fetch_array()[0]);
	$creditsql = "select IFNULL(round(sum(a_amount)),0) as total from account where p_id=".$_POST['f_name']." and a_date ='$f_date'";
	array_push($finalData['table'][$s_date], $conn->query($creditsql)->fetch_array()[0]);
	$f_date = date('Y-m-d',strtotime($f_date." +1 day"));
	
}

$sql="select p_name from party where p_id=".$_POST['f_name'];
$finalData['name'] = $conn->query($sql)->fetch_array()[0];
session_start();
$_SESSION['data'] = $finalData;
echo json_encode($finalData);
?>