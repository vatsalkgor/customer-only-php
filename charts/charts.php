<?php 
	include '../database/Database.php';
	$d = new Database();
	$conn = $d->connect();

	$labels_commission = array();

	$customer_com = array();
	$sql = "select MONTHNAME(s_date), sum(s_com) from (select s_date, s_com from sell_bill group by s_b_no) A group by YEAR(s_date),MONTH(s_date) ORDER BY s_date DESC LIMIT 0,6";
	$res = $conn->query($sql);
	while($row = $res->fetch_assoc()){
		array_push($labels_commission,$row['MONTHNAME(s_date)']);
		array_push($customer_com,$row['sum(s_com)']);
	}
	$commission = array();
	$commission['labels'] = $labels_commission;
	$commission['c_c'] = $customer_com;

	$income = array();
	$labels_income = array();
	$amount = array();
	$sql = "SELECT MONTHNAME(a_date), SUM(ROUND(a_amount)) FROM account GROUP BY YEAR(a_date), MONTH(A_DATE) ORDER BY a_date DESC LIMIT 0,6";
	$res = $conn->query($sql);
	while($row = $res->fetch_assoc()){
		array_push($labels_income,$row['MONTHNAME(a_date)']);
		array_push($amount,$row['SUM(ROUND(a_amount))']);
	}
	$income['labels'] = $labels_income;
	$income['amount'] = $amount;

	$data['com'] = $commission;
	$data['income'] = $income;
	echo json_encode($data);
 ?>