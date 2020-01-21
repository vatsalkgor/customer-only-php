<?php

session_start(); 

include '../database/Database.php';

$db = new Database();

$conn = $db->connect();



function gettoday($id,$conn){

	$date = date('Y-m-d',strtotime($_POST['d']));

	$todaysql = "select sum(s_total) from sell_bill where s_date='$date' and s_c_id=$id";

	return $conn->query($todaysql)->fetch_array()[0];

}

function getprevious($id,$conn){

	$previous = "select a_amount,DATEDIFF(DATE('".date('Y-m-d',strtotime($_POST['d']))."'),a_date) as days from account where p_id=$id order by a_date desc limit 1";

	return $conn->query($previous)->fetch_array();

}

function getcaret($id,$conn){
    $date = date('Y-m-d',strtotime($_POST['d']));
    $sql = "select IFNULL(SUM(caret),0) as caret,IFNULL((SUM(caret)*settings.value),0) from caret join settings where settings.type='rs' and party=".$id;
	return $conn->query($sql)->fetch_array();
}


function getpending($id,$conn){

	$date = date('Y-m-d',strtotime($_POST['d']));

	$pending = "select ((select IFNULL(sum(s_total),0) from sell_bill WHERE s_c_id=$id and s_date<'".$date."') + (select p_pending_amount from party where p_id=$id) - (select IFNULL(sum(a_amount),0) from account where account.p_id=$id and a_date<='".$date."')) as pending";

	return $conn->query($pending)->fetch_array()[0];

}



$finalData = array();

$sql = "select p_id,p_name from party where p_name<>'raokDo' order by p_name";

$res = $conn->query($sql);

$i=0;

$finalData['d'] = $_POST['d'];

$finalData['table'] = array();

while ($row = $res->fetch_assoc()) {

	if(getpending($row['p_id'],$conn) + gettoday($row['p_id'],$conn) > 10 ){

		$finalData['table'][$i] = array();

		$finalData['table'][$i]['name'] = $row['p_name']; 

		$finalData['table'][$i]['today'] = empty(gettoday($row['p_id'],$conn))?0:gettoday($row['p_id'],$conn);

		$temp = getprevious($row['p_id'],$conn);

		$finalData['table'][$i]['previous'] = empty($temp[0])?0:$temp[0];

		$finalData['table'][$i]['days'] = empty($temp[1])?'.':$temp[1];

		$finalData['table'][$i]['pending'] = getpending($row['p_id'],$conn);
		
		$temp = getcaret($row['p_id'],$conn);

		$finalData['table'][$i]['caret'] = $temp[0];

		$finalData['table'][$i]['caret_total'] = $temp[1];

		$finalData['table'][$i]['total'] = $finalData['table'][$i]['pending'] + $finalData['table'][$i]['today'] + $finalData['table'][$i]['caret_total'];

	$i++;

	}

}

$_SESSION['dailyReport'] = $finalData;