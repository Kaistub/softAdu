<?php

	//Include connection file
	include 'conn.php';

	//Start session
	session_start();

	//$sql_data = "TRUNCATE Sales_Product_Temp";
	//$result_data = $conn->query($sql_data);
	
	//Destroy session
	session_destroy();
	header('Location: /');
?>