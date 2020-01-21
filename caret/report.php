<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$f_date = date('Y-m-d',strtotime($_POST['f_date']));
$t_date = date('Y-m-d',strtotime($_POST['t_date']));

$finalData = array();
$sql = "select IFNULL(SUM(caret),0) as caret, IFNULL((SUM(caret)*settings.value),0) from caret join settings where settings.type='rs' and party=".$_POST['f_name'];
$finalData['pending'] = $conn->query($sql)->fetch_array()[0];
$finalData['pending_total'] = $conn->query($sql)->fetch_array()[1];

$finalData['table'] = array();
$t_date = date('Y-m-d',strtotime($t_date." +1 day"));

while(strcmp($f_date,$t_date)!=0){
	$s_date = date('Y-m-d',strtotime($f_date));
	$date = date('d.m.Y',strtotime($s_date));
	$finalData['table'][$date] = array();
	$javak = "select IFNULL(caret,0), IFNULL((caret*settings.value),0) from caret join settings where settings.type='rs' and party=".$_POST['f_name']." and date='$s_date' and caret>0";
	$res = $conn->query($javak)->fetch_array();
	if($res!=null){
		array_push($finalData['table'][$date],$res[0]==null?0:$res[0]);
		array_push($finalData['table'][$date],$res[1]==null?0:$res[1]);
	}else{
		array_push($finalData['table'][$date],0);
		array_push($finalData['table'][$date],0);
	}
	$aavak = "select IFNULL(caret,0), IFNULL((caret*settings.value),0) from caret join settings where settings.type='rs' and party=".$_POST['f_name']." and date='$s_date' and caret<0";
	$res = $conn->query($aavak)->fetch_array();
	if($res!==null){
		array_push($finalData['table'][$date],$res[0]==null?0:$res[0]);
		array_push($finalData['table'][$date],$res[1]==null?0:$res[1]);
	}else{
		array_push($finalData['table'][$date],0);
		array_push($finalData['table'][$date],0);
	}
	$f_date = date('Y-m-d',strtotime($f_date." +1 day"));
}
$sql = "select p_name from party where party.p_id=".$_POST['f_name'];
$finalData['name'] = $conn->query($sql)->fetch_array()[0];
session_start();
$_SESSION['data'] = $finalData;
echo json_encode($finalData);
?>