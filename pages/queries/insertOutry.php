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
    $isExist = false;
    $date = ''.date("Y-m-d", strtotime("now")).'';

    $qtyIni= $qty;

    //Verify If pednum Exist
    $sql_pednum = "SELECT * FROM pednum WHERE `pednum_desc` = '$pednum'";
    $result_ped = $conn->query($sql_pednum);
    $rdw_cnt =  mysqli_num_rows($result_ped);

    if ($rdw_cnt > 0) {
        $isExist = true;
        echo "<script>alert('El numero de pedimento ingresado ya existe, Verifique sus datos'); </script>";
       
    }else {
        
         //Verify Product
         $sql_select = "SELECT * FROM product WHERE `product_id` = '$prod_name'";
         $result_query = $conn->query($sql_select);
         $raw = mysqli_fetch_assoc($result_query);
         $measure = $raw['product_unitmeasure'];
         $lessqty = $raw['product_qty'];
         $lessvalue = $raw['product_value'];
         //$row_cnt =  mysqli_num_rows($result_query);

        if ($lessqty >= $qty) {
            //Convert Values to index form
           // echo "<script>alert('Hay mas producto que pedido')</script>;";
        $sql_pednum2 = "INSERT INTO `pednum` (`pednum_desc`) VALUES ('$pednum')";
        $result_ped2 = $conn->query($sql_pednum2);
        $sql_ped = "SELECT pednum_id FROM `pednum` WHERE `pednum_desc` = '$pednum'";
        $result_ped2 = $conn->query($sql_ped);
        $rvw = mysqli_fetch_assoc($result_ped2);
        $newPednum = $rvw['pednum_id'];

        //Verify Tariff and load data
        $sql_tariff = "SELECT * FROM tariff WHERE `tariff_product` = '$prod_name' AND `tariff_state` != 0  ORDER BY `tariff_date`";
        $result_tariff = $conn->query($sql_tariff);
        $result_tariff2 = $conn->query($sql_tariff);
        $rtt = mysqli_fetch_assoc($result_tariff2);
        
        $newTariff = $rtt['tariff_id'];
        //Data to be loaded in product
        $updateBT = ($lessqty - $qty);
        
        $total = 0;
        while ($row = mysqli_fetch_array($result_tariff)){ 
            //Check and save data from query
            $newTariff = $row['tariff_id'];
            $lessqty2 = $row['tariff_qty'];
            $lessvalue2 = $row['tariff_value'];
            $dste = $row['tariff_date'];
            $updateValue = ($lessqty2 - $qty);
            
            //Check 
            //Set data to be loaded
            
            if ($updateValue <= 0) {
                $qty = ($qty - $lessqty2);
                echo "<script>alert('Lo que queda es: $qty')</script>;";
                //Update the select Product to no one
                $sql_updateT = "UPDATE tariff SET `tariff_qty` = '0', `tariff_state` = '0', `tariff_state` = 0 WHERE `tariff_product` = '$prod_name' AND `tariff_date` = '$dste'";
                $updatedFVAL3 = $updatedFVAL3 + $lessvalue2;
                //$sql_updatet2 = "UPDATE `product` SET `product`.`product_qty` = '$TU2', `product`.`product_value` = '$TU1' WHERE `product`.`product_id` = '$prod_name' AND `product`.`product_date` = '$dste'";
                $result_updateT = $conn->query($sql_updateT);
                //$result_updateT2 = $conn->query($sql_updatet2);
            }else {
                if ($qty == 0) {
                    break;
                }else {
                $UpdatedFQTY = ($lessqty2 - $qty);
                $updatedFVAL = ($lessvalue2 / $lessqty2);
                $updatedFVAL2 = ($updatedFVAL * $qty);

                //fval para restar al valor total de la tarifa
                $updatedFVALTariff=($lessvalue2-$updatedFVAL2);
                $updatedFVAL3 = ($updatedFVAL3 + $updatedFVAL2);
                $sql_updateT2 = "UPDATE tariff SET `tariff_qty` = '$UpdatedFQTY', `tariff_value` = '$updatedFVALTariff' WHERE `tariff_product` = '$prod_name' AND `tariff_date` = '$dste'"; 
                $result_updateT2 = $conn->query($sql_updateT2);
                break;
                }
            }
            
        }
        $updateBT2 = ($lessvalue - $updatedFVAL3);
        //Set all data
        $sql_update1 = "UPDATE `product` SET `product`.`product_qty` = '$updateBT', `product`.`product_value` = '$updateBT2' WHERE `product`.`product_id` = '$prod_name'";
        $sql_new3 = "INSERT INTO `outgoing` (`outgoing_id`, `outgoing_pednum`, `outgoing_peddate`, `outgoing_pedkey`, `outgoing_qty`, `outgoing_product`, `outgoing_tariff`, `outgoing_measure`, `outgoing_value`)
            VALUES (NULL, '$newPednum', '$peddate', '$pedkey', '$qtyIni', '$prod_name', '$newTariff', '$measure', '$updatedFVAL3')";
        $result_update = $conn->query($sql_update1);
        $result_insert = $conn->query($sql_new3);
        echo "<script>document.location.href='../outgoing/outgoing.php'</script>";
        }else {
            echo "<script>alert('No existe suficiente producto en stock, verifique e intente de nuevo'); document.location.href='../outgoing/outgoing.php'</script>";
        }
        
    }

    //close Session
    mysqli_close($conn);
?>
