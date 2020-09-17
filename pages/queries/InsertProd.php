<?php 
	//Include connection file
	include '../conn/conn.php';

	//Get product to update
	$prodid = $_POST['prodid'];
	$tariff = $_POST['tariff'];
	$desc = $_POST['desc'];
	$measure = $_POST['measure'];
	$type = $_POST['type'];
	$qty = $_POST['qty'];
	$img = $_POST['img'];
	$valor = $_POST['valor'];
	//$date = ''.date("Y-m-d H:i:s", strtotime("now")).'';
	$date = $_POST['date'];
	

	//Verify Data
	$sql_select = "SELECT * FROM product WHERE `product`.`product_id` = '$prodid'";
	$result_query = $conn->query($sql_select);
	$raw = mysqli_fetch_assoc($result_query);
	$lessqty = $raw['product_qty'];
	$lessvalue = $raw['product_value'];
	$row_cnt =  mysqli_num_rows($result_query);

	//Set comparation
	$updateBT = ($lessqty + $qty);
	$updateBT2 = ($lessvalue + $valor);
	
	//Set all data
	if ($row_cnt == 0) {
		$sql_update1 = "INSERT INTO `product` (`product_id`, `product_desc`, `product_value`, `product_qty`, `product_unitmeasure`, `product_level`, `product_type`, `product_img`, `product_on`,`product_creationdate`) VALUES ('$prodid', '$desc','$valor','$qty', '$measure', '0', '$type', '$img','1', '$date')";	
		$sql_new2 = "INSERT INTO `tariff` (`tariff_num`, `tariff_product`,`tariff_value`,`tariff_qty`,`tariff_date`,`tariff_state`,`tariff_voriginal`,`tariff_qoriginal`) VALUES ('$tariff', '$prodid', '$valor', '$qty','$date','1','$valor','$qty')";
		$result_update = $conn->query($sql_update1);
		$result_update2 = $conn->query($sql_new2);
	}else {
		$sql_update1 = "UPDATE `product` SET `product`.`product_qty` = '$updateBT', `product`.`product_value` = '$updateBT2' WHERE `product`.`product_id` = '$prodid'";
		$sql_new2 = "INSERT INTO `tariff` (`tariff_num`, `tariff_product`,`tariff_value`,`tariff_qty`,`tariff_date`,`tariff_state`,`tariff_voriginal`,`tariff_qoriginal`) VALUES ('$tariff', '$prodid', '$valor', '$qty','$date','1','$valor','$qty')";
		$result_update = $conn->query($sql_update1);
		$result_update2 = $conn->query($sql_new2);
	};
	mysqli_close($conn);
?> 