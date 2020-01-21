<?php 


class LogInterface{
	function getTime(){
		date_default_timezone_set('Asia/Kolkata');
		$this->str=date('d-m-Y At h:i:s');
		return $this->str;
	}
	function addPaymentLog($user,$customer,$amt,$conn){
		$query = "insert into logs(user,type,amt,customer) VALUES('".$user."','payment',".$amt.",'".$customer."')";
		if($conn->query($query) === FALSE){
			echo "exception";
			echo $query;
			exit;
			throw new Exception("Error Processing Request", 1);
		}
	}
}
?>