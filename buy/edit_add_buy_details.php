<?php 
include '../database/Database.php';
$db = new Database();
$conn = $db->connect();
$bill = $_POST['b_no'];
$res = "";
for($i = 0;$i<sizeof($_POST['table'])-$_POST['buy_count'];$i++){
	// echo "1";
	// UPDATE QUERY
	$sql = "update purchase set pu_i_qty=".$_POST['table'][$i][6].", pu_i_pending=".$_POST['table'][$i][6]." where pu_i_id=".$_POST['table'][$i][5]." and pu_f_id=".$_POST['table'][$i][2]." and pu_b_no=$bill";
	if($conn->query($sql) === TRUE){
		$res .= "1";
	}else{
		$res .= "0";
		echo $conn->error;
	}
}
for($i=sizeof($_POST['table'])-$_POST['buy_count'];$i<sizeof($_POST['table']);$i++){
	// INSERT QUERY
	// echo "2";
	// $sql = "insert into purchase (pu_b_no,pu_b_date,pu_f_id,pu_i_id,pu_i_qty,pu_i_sold,pu_i_pending,pu_remarks,pu_biled) values($bill,'".$_POST['b_date']."',$value[2],$value[5],$value[6],0,$value[6],'".$_POST['remarks']."',0)";
	// print_r($_POST);
$date =date('Y.m.d',strtotime(str_replace('.', '-', $_POST['b_date'])));

	$sql = "insert into purchase(pu_b_no,pu_b_date,pu_f_id,pu_i_id,pu_i_qty,pu_i_sold,pu_i_pending,pu_remarks,pu_biled) values($bill,'$date',".$_POST['table'][$i][2].",".$_POST['table'][$i][5].",".$_POST['table'][$i][6].",0,".$_POST['table'][$i][6].",'".$_POST['remarks']."',0)";
	if($conn->query($sql) === TRUE){
		$res .= "1";
	}else{
		$res .= "0";
		echo $conn->error;
	}
}
echo $res;
?>