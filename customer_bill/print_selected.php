<?php

session_start();

include '../database/Database.php';

$db = new Database();

$conn = $db->connect();

$finalData = array();

$sms = array();

$i = 0;

$f_date = date('Y.m.d',strtotime($_POST['f_date']));

$t_date = date('Y.m.d',strtotime($_POST['t_date']));

$bnos = '';

foreach ($_POST['a'] as $key => $value) {

	$bnos .= $value.',';

}

$bnos = rtrim($bnos,',');



$sql = "select s_date, party.p_name,party.p_id,ROUND(sum(s_com)) as s_com,ROUND(sum(s_wage)) as s_wage,ROUND(sum(s_o_e)) as s_o_e from sell_bill join party where party.p_id = s_c_id and s_date between '$f_date' and '$t_date' and s_b_no in($bnos) group by s_c_id,s_date order by party.p_name";

echo $sql;

$res = $conn->query($sql);



while ($row = $res->fetch_assoc()) {

	$finalData[$i] = array();

	$sms[$i] = array();

	$finalData[$i]['date'] = date('d.m.Y',strtotime($row['s_date']));

	$sms[$i]['date'] = $finalData[$i]['date'];

	$sms[$i]['contact'] = $row['p_contact'];

	$finalData[$i]['name'] = $row['p_name'];

	$finalData[$i]['id'] = $row['p_id'];

	$finalData[$i]['com'] = $row['s_com'];

	$finalData[$i]['wage'] = $row['s_wage'];

	$finalData[$i]['o_e'] = $row['s_o_e'];

	$i++;

}

for ($j=0; $j < $i; $j++) { 

	$total = 0;

	$sql = "select items.i_name, sum(s_qty) as qty,sum(s_weight) as weight,s_rate,ROUND(sum(s_total)) as total from sell_bill join items where items.i_id=s_i_id and s_date between '$f_date' and '$t_date' and s_c_id=".$finalData[$j]['id']." group by s_rate,items.i_name";

	$res = $conn->query($sql);

	$finalData[$j]['items'] = array();

	$finalData[$j]['items']['i_name'] = array();

	$finalData[$j]['items']['qty'] = array();

	$finalData[$j]['items']['weight'] = array();

	$finalData[$j]['items']['rate'] = array();

	$finalData[$j]['items']['total'] = array();

	while($row = $res->fetch_assoc()){

		array_push($finalData[$j]['items']['i_name'], $row['i_name']);

		array_push($finalData[$j]['items']['qty'], $row['qty']);

		array_push($finalData[$j]['items']['weight'], $row['weight']);

		array_push($finalData[$j]['items']['rate'], $row['s_rate']);

		array_push($finalData[$j]['items']['total'], $row['total']);

		$total += $row['total'];

	}

	

	$sql = "select (ROUND((select IFNULL(sum(s_total),0) from sell_bill WHERE s_c_id=".$finalData[$j]['id']." and s_date<'".$f_date."') + (select IFNULL(p_pending_amount,0) from party where p_id=".$finalData[$j]['id'].") - (select IFNULL(sum(a_amount),0) from account where account.p_id=".$finalData[$j]['id']."))) as pending";

	$finalData[$j]['pending'] = empty($conn->query($sql)->fetch_array()[0])? 0 : $conn->query($sql)->fetch_array()[0];

	$sql = "select ROUND(a_amount),a_date from account where p_id=".$finalData[$j]['id']." and a_date<='".$f_date."' order by a_date desc limit 1";

	$finalData[$j]['last_paid_amount'] = empty($conn->query($sql)->fetch_array()[0])?0:$conn->query($sql)->fetch_array()[0];

	$finalData[$j]['last_paid_date'] = empty(strtotime($conn->query($sql)->fetch_array()[1]))? "": date('d.m.Y',strtotime($conn->query($sql)->fetch_array()[1]));

	$sql = "select IFNULL(SUM(caret),0),IFNULL((SUM(caret)*settings.value),0) as caret from caret join settings where settings.type='rs' and party=".$finalData[$j]['id'];
	$temp = $conn->query($sql)->fetch_array();
	$finalData[$j]['caret'] = $temp[0];
	$finalData[$j]['caret_total'] = $temp[1];
}

$_SESSION['data'] = $finalData;	

$_SESSION['msg_response']= json_encode($msgResponse);

// print_r($_SESSION);

?>

