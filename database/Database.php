<?php 
/**
 * 
 */
class Database
{
	function __construct()
	{

	}

	function connect(){
		return new mysqli('localhost','root','','customer-only');
	}
}

?>