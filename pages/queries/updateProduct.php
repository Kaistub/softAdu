<?php 
	//Include connection file
	include '../conn/conn.php';
	//Get product to update
	$prodid = $_POST['product_id'];
	$tariff = $_POST['product_tariff'];
	$desc = $_POST['product_desc'];
	$measure = $_POST['product_unitmeasure'];
	$type = $_POST['product_type'];
	$qty = $_POST['product_qty'];
	$value = $_POST['product_value'];
	$date = $_POST['product_dates'];
	$oldtariff = $_POST['product_oldtariff'];
	$oldqty = $_POST['product_oldqty'];
	$tariffid = $_POST['tariff_id'];

	echo "<script>alert('$prodid, $tariff, $desc, $measure, $type, $qty, $value, $date, $oldtariff, $oldqty, $tariffid')</script>";
	

	//Verify Data
	$sql_select = "SELECT * FROM product WHERE `product`.`product_id` = '$prodid'";
	$result_query = $conn->query($sql_select);
	$raw = mysqli_fetch_assoc($result_query);
	$lessqty = $raw['product_qty'];
	$lessvalue = $raw['product_value'];

	//Verify Data 2
	$sql_select2 = "SELECT * FROM tariff WHERE `tariff`.`tariff_product` = '$prodid' AND `tariff`.`tariff_num` = '$tariff'";
	$result_query2 = $conn->query($sql_select2);
	$raw2 = mysqli_fetch_assoc($result_query2);
	$lessqty2 = $raw2['tariff_qty'];
	$lessvalue2 = $raw2['tariff_value'];

	//Set comparation
	$compareBT = $lessqty - $lessqty2;
	$compareBT2 = $lessvalue - $lessvalue2;
	$compareTW = $compareBT + $qty;
	$compareTW2 = $compareBT2 + $value;
	
	//Set all data
	$sql_update1 = "UPDATE `product` SET `product_value` = '$compareTW2', `product_qty` = '$compareTW',  `product_desc` = '$desc', `product_unitmeasure` = '$measure', `product_type` = '$type' WHERE `product`.`product_id` = '$prodid'";
	$sql_update2 = "UPDATE `tariff` SET  `tariff_num` = '$tariff', `tariff_qty` = '$qty', `tariff_value` = '$value'   WHERE `tariff`.`tariff_id` = '$tariffid'";
	$result_update = $conn->query($sql_update1);
	$result_update2 = $conn->query($sql_update2);


	mysqli_close($conn);
?> 