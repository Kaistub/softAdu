<?php 
    include '../conn/conn.php';
    if(session_id() == '') {
        session_start();}
        if (!$_SESSION['user']) {
        header("Location: /");
    }
    $pednum = $_POST['pednum'];
    $pedkey = $_POST['pedkey'];
    $peddate = $_POST['peddate'];
    $prod_name = $_POST['prod_name'];
    $qty = $_POST['qty'];
    
    $value = $_POST['value'];
    $isExist = false;
    $date = ''.date("Y-m-d", strtotime("now")).'';

    $sql_checkdata = "SELECT * FROM tariff WHERE tariff_product = '$prod_name'";
    $result_checkdata = $conn->query($sql_checkdata);
    $rxs = mysqli_fetch_assoc($result_checkdata);
    $tariff = $rxs['tariff_num'];
    

    //Verify If pednum Exist
    $sql_pednum = "SELECT * FROM pednum WHERE `pednum_desc` = '$pednum'";
    $result_ped = $conn->query($sql_pednum);
    $rdw_cnt =  mysqli_num_rows($result_ped);

    /*if ($rdw_cnt > 0) {
        $isExist = true;
        echo "<script>alert('El numero de pedimento ingresado ya existe, Verifique sus datos'); document.location.href='../ingoing/ingoing.php'</script>";
       
    }else {*/
        //Convert Values to index form
        $sql_pednum2 = "INSERT INTO `pednum` (`pednum_desc`) VALUES ('$pednum')";
        $result_ped2 = $conn->query($sql_pednum2);
        $sql_ped = "SELECT pednum_id FROM `pednum` WHERE `pednum_desc` = '$pednum'";
        $result_ped2 = $conn->query($sql_ped);
        $rvw = mysqli_fetch_assoc($result_ped2);
        $newPednum = $rvw['pednum_id'];
        
        $sql_tari2 = "SELECT tariff_id FROM `tariff` WHERE `tariff_num` = '$tariff'";
        $result_tari2 = $conn->query($sql_tari2);
        $rzw = mysqli_fetch_assoc($result_tari2);
        $newTariff = $rzw['tariff_id'];

        $isExist = false;
        //Verify Data Not finished
        $sql_select = "SELECT * FROM product WHERE `product_id` = '$prod_name'";
        $result_query = $conn->query($sql_select);
        $raw = mysqli_fetch_assoc($result_query);
        $lessqty = $raw['product_qty'];
        $lessvalue = $raw['product_value'];
        $measure = $raw['product_unitmeasure'];
        $row_cnt =  mysqli_num_rows($result_query);

        $sql_tariff = "SELECT * FROM tariff WHERE `tariff_product` = '$prod_name' AND `tariff_num`= '$tariff' ";
        $result_tariff = $conn->query($sql_tariff);
        $riw = mysqli_fetch_assoc($result_tariff);
        $lessqty2 = $riw['tariff_qty'];
        $lessvalue2 = $riw['tariff_value'];

        //Set data
        $updateBT = ($lessqty + $qty);
        $updateBT2 = ($lessvalue + $value);
        $updateTF = ($lessqty2 + $qty);
        $updateTF2 = ($lessvalue2 + $value);

        //Set all data
        if ($riw['tariff_product'] == $prod_name &&  $riw['tariff_num'] == $tariff) {
            $sql_new2 = "INSERT INTO `tariff` (`tariff_num`, `tariff_product`,`tariff_value`,`tariff_qty`,`tariff_date`,`tariff_state`,`tariff_voriginal`,`tariff_qoriginal`) 
            VALUES ('$tariff', '$prod_name', '$value', '$qty','$peddate','1','$value','$qty')";
            $sql_update1 = "UPDATE `product` SET `product`.`product_qty` = '$updateBT', `product`.`product_value` = '$updateBT2' WHERE `product`.`product_id` = '$prod_name'";
            $sql_new3 = "INSERT INTO `ingoing` (`ingoing_id`, `ingoing_pednum`, `ingoing_peddate`, `ingoing_pedkey`, `ingoing_qty`, `ingoing_product`, `ingoing_tariff`, `ingoing_measure`, `ingoing_value`)
             VALUES (NULL, '$newPednum', '$peddate', '$pedkey', '$qty', '$prod_name', '$newTariff', '$measure', '$value')";
            $result_update2 = $conn->query($sql_new2);
            $result_update = $conn->query($sql_update1);
            $result_insert = $conn->query($sql_new3);
        }else{
            $sql_new2 = "INSERT INTO `tariff` (`tariff_num`, `tariff_product`,`tariff_value`,`tariff_qty`,`tariff_date`,`tariff_state`,`tariff_voriginal`,`tariff_qoriginal`) 
            VALUES ('$tariff', '$prod_name', '$value', '$qty','$peddate','1','$value','$qty')";
            $sql_update1 = "UPDATE `product` SET `product`.`product_qty` = '$updateBT', `product`.`product_value` = '$updateBT2' WHERE `product`.`product_id` = '$prod_name'";
            $sql_new3 = "INSERT INTO `ingoing` (`ingoing_id`, `ingoing_pednum`, `ingoing_peddate`, `ingoing_pedkey`, `ingoing_qty`, `ingoing_product`, `ingoing_tariff`, `ingoing_measure`, `ingoing_value`)
             VALUES (NULL, '$newPednum', '$peddate', '$pedkey', '$qty', '$prod_name', '$newTariff', '$measure', '$value')";
            $result_update2 = $conn->query($sql_new2);
            $result_update = $conn->query($sql_update1);
            $result_insert = $conn->query($sql_new3);
            
        }
    /*}*/

    //close Session
    mysqli_close($conn);
?>