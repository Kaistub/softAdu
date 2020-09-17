<?php 
  //Include connection file
  include '../conn/conn.php';

  //Get product to update
      $pednum = $_POST['pednum']; 
      $pedkey = $_POST['pedkey'];
      $peddate =  $_POST['peddate'];
      $qty = $_POST['qty'];
      $id = $_POST['id'];
      $tariff = $_POST['tariff'];
      $measure = $_POST['measure'];
      $prod_name = $_POST['prod_name']; 
      $measureUnit = $_POST['measureUnit'];
      $value =  $_POST['value'];

      $sql_product = 'SELECT  * FROM measure';
      $result_product = $conn->query($sql_product);
      $sql_type = 'SELECT  * FROM product_type';
      $result_type = $conn->query($sql_type);
      $sql_tariff = 'SELECT DISTINCT  tariff_num FROM tariff WHERE tariff_product != "'.$prodid.'" OR tariff_num ='.$tariff.'';
      $result_tariff = $conn->query($sql_tariff);
      $sql_pednum = 'SELECT DISTINCT pednum_desc FROM pednum WHERE pednum_id="'.$pednum.'"';
      $result_pednum = $conn->query($sql_pednum);
      $rew = mysqli_fetch_assoc($result_pednum);

  mysqli_close($conn);
?> 
 <div class="col-md-12" id="product_updated">
            <form action="" method="POST">
            <div class="card">
              <div class="row pdtop-1 pdleft-1">
                    <div class="col-md-12 pdtop-0 text-center">
                      <h2><?php echo 'Pedimento &nbsp#'.$rew['pednum_desc'].' - &nbsp;'.$prod_name.''; ?></h2>
                    </div> 
                    <div class="col-md-12 pdtop-1">
                      <table style="height: 100%; width:100%;" class="table table-sm">
                        <tbody>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Clave de pedimento</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" class="form-control f50" aria-label="Default" 
                               value="<?php echo $pedkey; ?>" disabled>
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Fecha de pedimento</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" class="form-control f50" aria-label="Default" 
                               value="<?php echo $peddate; ?>" disabled>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Producto</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" class="form-control f50" aria-label="Default" 
                               value="<?php echo $id; ?>" >  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Cantidad</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" class="form-control f50" aria-label="Default" 
                               value="<?php echo $qty; ?>" >  
                            </td>
                          </tr>
                          <tr >
                            <td style="width: 5px;"><em><strong>&nbsp;Fracci&oacute;n Arancelaria</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                               <select class="form-control f50" name="fracArancel" id="fracArancel">
                                <?php while ($row = mysqli_fetch_array($result_tariff)){ 
                                 $arancel = $row['tariff_num'];
                                 if($arancel == $tariff){$sel = 'selected';} else{$sel = '';}
                                 echo '<option value="'.$row['tariff_num'].'"'.$sel.'>'.$arancel.'</option>';
                                } ?>
                                </select>
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Unidad de medida</strong></em></td>
                            <td style="width: 172px;">&nbsp; 
                               <div class="form-group">
                                <select class="form-control f50" name="measure" id="measure">
                                <?php while ($row = mysqli_fetch_array($result_product)){ 
                                 $descs = $row['measure_desc'];
                                 if($descs == $measure){$sel = 'selected';} else{$sel = '';}
                                 echo '<option value="'.$row['measure_id'].'"'.$sel.'>'.$descs.'</option>';
                                } ?>
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Valor</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" class="form-control f50" aria-label="Default" 
                               value="<?php echo $value ; ?>" >  
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

              </div>
            </div>
             <button type="button" type="submit" class="btn btn-info" onclick="Updatentry()"><i class="fas fa-edit"></i> &nbsp;<?php echo 'Actualizar'; ?></button>
            </form>
          </div>