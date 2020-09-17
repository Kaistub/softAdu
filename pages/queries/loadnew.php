<?php
  //Include connection file 
  include '../conn/conn.php';
  if(session_id() == '') {
  session_start();}

  $tariff = $_POST['product_tariff'];
  $dates = $_POST['product_date'];
  $productCheck = $_POST['product_id'];

  //Load Values
  $sql_product = 'SELECT * FROM tariff INNER JOIN product ON tariff.tariff_product = 
  product.product_id INNER JOIN measure ON product.product_unitmeasure = measure.measure_id INNER JOIN product_type ON product.product_type =
    product_type.protype_id WHERE tariff.tariff_product="'.$productCheck.'" AND tariff.tariff_state != 0';
    $sql_product2 = 'SELECT * FROM tariff INNER JOIN product ON tariff.tariff_product = 
    product.product_id INNER JOIN measure ON product.product_unitmeasure = measure.measure_id INNER JOIN product_type ON product.product_type =
      product_type.protype_id WHERE tariff.tariff_product="'.$productCheck.'" AND tariff.tariff_state != 0 ORDER BY tariff.tariff_date';
  //$sql_product2 = $sql_product.'AND tariff.tariff_date ='.$date;
  $result_product2 = $conn->query($sql_product2);
  $queryconn = $conn->query($sql_product);

  while ($row = mysqli_fetch_array($queryconn)){ 
    $id = $row['product_id']; 
    $desc = $row['product_desc'];
    $measure = $row['measure_desc'];
    $prodtype = $row['protype_desc'];
    $qty = $row['tariff_qty'];
    $value = $row['tariff_value'];
    $date = $row['tariff_date'];
    
    if($tariff == $row['tariff_num'] && $dates == $row['tariff_id']){
      break;
    }
    }

  $queryconn2 = $conn->query($sql_product);


  
  //close Session
  mysqli_close($conn);
?>
          <div class="col-md-12"  id="product_updated">
            <div class="card">
              <div class="row pdtop-1 pdleft-1">
                    <div class="col-md-2 text-left">
                      <img src="../../assets/img/<?php 
                      //Load image
                      if (file_exists('../../assets/img/product/'.$id.'.jpg')) {
                        echo 'product/'.$id;
                      }else{
                        echo 'nophoto';
                      } ?>.jpg" alt="..." class="img-prod">
                    </div>
                    <div class="col-md-10 pdtop-0 text-left">
                      <h2><?php echo $id.' - '.$desc ?></h2>
                    </div> 
                    <div class="col-md-12 pdtop-1">
                      <table style="height: 100%; width:100%;" class="table table-sm">
                        <tbody>
                          <tr >
                            <td style="width: 5px;"><em><strong>&nbsp;Fracci&oacute;n Arancelaria</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                            <input type="text" name="fracArancel" id="fracArancel" class="form-control f50" aria-label="Default" 
                               value="<?php echo $tariff; ?>"  disabled>
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Tipo de producto</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="tipop" id="tipop" class="form-control f50" aria-label="Default" 
                               value="<?php echo $prodtype; ?>"  disabled>
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Cantidad disponible</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="cactual" id="cactual" class="form-control f50" aria-label="Default" 
                               value="<?php echo $qty; ?>"  disabled>  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Unidad de medida</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="measure" id="measure" class="form-control f50" aria-label="Default" 
                               value="<?php echo $measure; ?>"  disabled>  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Valor</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="valor" id="valor" class="form-control f50" aria-label="Default" 
                               value="<?php echo $value; ?>"  disabled>  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Fecha de registro</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                               <select class="form-control f50" name="dates" id="dates">
                               <?php while ($row2 = mysqli_fetch_array($result_product2)){ 
                                 $num = $row2['tariff_date'];
                                 if($row2['tariff_id'] == $dates){$sel = 'selected';} else{$sel = '';}
                                 echo '<option value="'.$row2['tariff_id'].'"'.$sel.'>'.$num.'</option>';
                                } ?>
                               </select>
                               <button type="button " onclick="loadNew()" class="btn btn-reddark btn-sm">Actualizar</button>

                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
              </div>
            </div>
          </div>