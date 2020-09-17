<?php 
	//Include connection file
	include '../conn/conn.php';

	//Get product to update
	$prodid = $_POST['prodid'];

	//Set all data
	$sql_del = "UPDATE `product` SET `product_on` = '0' WHERE `product`.`product_id` = '$prodid';";
	$result_del = $conn->query($sql_del);

	mysqli_close($conn);
?> 