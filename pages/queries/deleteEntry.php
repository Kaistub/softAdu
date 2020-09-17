<?php 
	//Include connection file
	include '../conn/conn.php';

	//Get product to update
	$prodid = $_POST['prodid'];

	//Set all data
	$sql_del = "DELETE FROM ingoing WHERE ingoing.ingoing_pednum = ''";
	$result_del = $conn->query($sql_del);

	mysqli_close($conn);
?> 