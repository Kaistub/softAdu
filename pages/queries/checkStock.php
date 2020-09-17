<?php
include '../conn/conn.php';
if(session_id() == '') {
  session_start();}
  if (!$_SESSION['user']) {
    header("Location: /");
 }

$prodid = $_POST['product_id'];
$qty =$_POST['product_qty'];
$user = $_SESSION['id'];
$cleanqty = $qty;



$approval = true;
$productId='';
$invQty='';
$newQtyChanges='';
$aprovalChanges='';
$newQty='';
$process = [];
$date=date("Y-m-d");
$dateId=date("Y-m-d H:i");
$dateToday = ''.date("Y-m-d H:i:s", strtotime("now")).'';
$cont = 0;
$wea ="NO";

$newQtyTariff;
$processId='';

//creando el id del nuevo proceso
$arrLet = str_split($prodid, 5);
$processId="$dateId-$arrLet[0]-$qty";

$costomaterial=0;
$costomatactual=0;

$sql_bom2 = 'SELECT * FROM bom_inventory WHERE bominv_product_id="'.$prodid.'";';
$sql_inventory2 = 'SELECT * FROM product;';

$result_bom2 =  $conn->query($sql_bom2);
$result_inventory2 =  $conn->query($sql_inventory2);


while ($rowbom = mysqli_fetch_array($result_bom2)){
  while($rowinv = mysqli_fetch_array($result_inventory2)){
    if($rowbom["bominv_material_id"]==$rowinv['product_id']){
      if($rowinv['product_qty']<($rowbom["bominv_material_qty"]*$qty)){
        $approval=false;
        echo '<script type="text/javascript">alert("No puede hacerse esta operacion");</script>';
      }
    }
  }
  mysqli_data_seek($result_inventory2, 0);
}

if($approval){


$sql_bom = 'SELECT * FROM bom_inventory WHERE bominv_product_id="'.$prodid.'";';
$sql_inventory = 'SELECT * FROM product;';
$sql_newprocess = "INSERT INTO process VALUE('$processId','$date','$user','$prodid','$qty')";

$sql_giveTarr = "SELECT * FROM tariff WHERE tariff_product = '$prodid'";

$result_bom =  $conn->query($sql_bom);
$result_inventory =  $conn->query($sql_inventory);
$result_newprocess =  $conn->query($sql_newprocess);
$result_giveTarr = $conn->query($sql_giveTarr);
$rxq = mysqli_fetch_assoc($result_giveTarr);
$rTariff = $rxq['tariff_num'];
$testeVar = 0;
$ValX = 0;


  while ($rowbom = mysqli_fetch_array($result_bom)){
    while($rowinv = mysqli_fetch_array($result_inventory)){
      if ($rowbom['bominv_material_id']==$rowinv['product_id']) {
        if($rowinv['product_qty']>=($qty*$rowbom['bominv_material_qty'])){
            $newQty=$rowinv['product_qty']-($qty*$rowbom['bominv_material_qty']);

            array_push($process,$rowinv['product_id'],$rowinv['product_qty'],$rowinv['product_qty'],$newQty,true);
            
            $newQtyTariff=$qty*$rowbom['bominv_material_qty'];
            $newQtyTariffCheck=$qty*$rowbom['bominv_material_qty'];

            $sql_tarrif = 'SELECT * FROM tariff WHERE tariff_product="'.$rowinv['product_id'].'" AND tariff_state=1 ORDER BY tariff_date ;';
            $result_tariff=  $conn->query($sql_tarrif);
           while ($rowtariff = mysqli_fetch_array($result_tariff)){
            $tariff = $rowtariff['tariff_num'];
                  if($newQtyTariffCheck>=$rowtariff['tariff_qty']){
                    $sql_updatetariff='UPDATE tariff SET tariff_qty=0, tariff_state=0, tariff_value = 0 WHERE tariff_id="'.$rowtariff['tariff_id'].'";';
                    $result_tariffupd=  $conn->query($sql_updatetariff);
                    //calcular costo
                    $qtyF0 = $rowtariff['tariff_qty'];
                    
                    $newQtyTariffCheck=$newQtyTariffCheck-$qtyF0;
                    $tarValue = $rowtariff['tariff_value'];
                    $valueP1 = $tarValue / $qtyF0;
                    $valueP2 = $valueP1 * $qtyF0;
                    $costomaterial= $valueP2; 
                    $testeVar = $testeVar + $costomaterial;

                    $qtyProd = $rowinv['product_qty'] -  $newQtyTariffCheck ;
                    $prodProd = $rowtariff['tariff_product'];
                    $valProd = ($rowinv['product_value'] ); 
                    $ValX = $tarValue;
                    $valProd = $valProd + ($rowinv['product_value'] -  $costomaterial);
                    $sql_updateProd = "UPDATE product SET product_value = '$ValX', product_qty = '$qtyProd' WHERE product_id = '$prodProd'";
                    
                    $result_tupd = $conn->query($sql_updateProd);

                    $costomatactual=$costomatactual+$costomaterial;  
                               
                    
                  }else{
                  //calcular costo
                   $valueP1 = $rowtariff['tariff_value'] / $rowtariff['tariff_qty'];
                   $valueP2 = $valueP1 * $newQtyTariffCheck;
                   $costomaterial= $valueP2; 
                   $testeVar = $testeVar + $costomaterial;
                    $sql_updatetariff='UPDATE tariff SET tariff_qty='.($rowtariff['tariff_qty'] - $newQtyTariffCheck).', tariff_state=1, tariff_value = '.($rowtariff['tariff_value'] - $costomaterial).' WHERE tariff_id='.$rowtariff['tariff_id'].';';
                    $result_tariffupd = $conn->query($sql_updatetariff);
                    $qtyProd = $rowinv['product_qty'] -  $newQtyTariffCheck ;
                    $prodProd = $rowtariff['tariff_product'];
                    $valProd = $rowinv['product_value'] -  $costomaterial;

                    
                    $ValX = $rowinv['product_value'] - $costomaterial - $ValX ;
                    
                    $sql_updateProd = "UPDATE product SET product_qty = '$qtyProd', product_value = '$ValX' WHERE product_id = '$prodProd'";
                    $result_tupd = $conn->query($sql_updateProd);

                    $costomatactual=$costomatactual+$costomaterial;   
                    $ValX = 0;              
                    break;
                  }
              
            }
            $quantity = $rowinv['product_qty'];
            $idlal = $rowinv['product_id'];
            $totales = $quantity-$newQtyTariff;
            $sql_updateinv="UPDATE product SET product_qty='$totales' WHERE product_id='$idlal'";
            
                $result_updtariff =  $conn->query($sql_updateinv);

                $sql_processinv='INSERT INTO process_inventory VALUE(null,
                "'.$rowbom['bominv_material_id'].'",
                '.($qty*$rowbom['bominv_material_qty']).',
                '.$costomatactual.',
                "'.$processId.'");';
                $result_processinv =  $conn->query($sql_processinv);
                
                $costomatactual=0;

        }else{
            array_push($process,$rowinv['product_id'],$rowinv['product_qty'],$newQty,false);
            $approval=false;
        }
      }
    }
    $wea ="YES";
    mysqli_data_seek($result_inventory, 0);
  }
  
  if ($wea = "YES") {
  $sql_inventory = 'SELECT * FROM product WHERE product_id="'.$prodid.'";';
    $result = $conn->query($sql_inventory);
    $rwx = mysqli_fetch_assoc($result );
    $newqtyprod= $rwx['product_qty']+ $cleanqty;
    $tvalue = $rwx['product_value'] + $testeVar;
    $sqlupdateproduct="UPDATE product SET product_qty = '$newqtyprod', product_value = '$tvalue' WHERE product_id = '$prodid'";
    
    $result = $conn->query($sqlupdateproduct);

  $sql_upTariff = "INSERT INTO tariff VALUES (NULL,'$rTariff','$prodid','$testeVar','$cleanqty','$dateToday','1','$testeVar','$cleanqty');";
  $resault = $conn->query($sql_upTariff);
  echo '<script type="text/javascript">alert("Hecho");</script>';
}
}else {
  echo '<script type="text/javascript">alert("No existe cantidad de Material suficiente para crear el producto");</script>';
}

mysqli_close($conn);
?>
