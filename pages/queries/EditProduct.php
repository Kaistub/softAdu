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
  $date = $_POST['product_date'];

  $sql_product = 'SELECT  * FROM measure';
  $result_product = $conn->query($sql_product);
  $sql_type = 'SELECT  * FROM product_type';
  $result_type = $conn->query($sql_type);
  $sql_tariff = 'SELECT DISTINCT  tariff_num FROM tariff WHERE tariff_product != "'.$prodid.'" OR tariff_num ='.$tariff.'';
  $result_tariff = $conn->query($sql_tariff);

	mysqli_close($conn);
?> 
          <div class="col-md-12" id="product_updated">
            <form action="" method="POST">
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
                      <h2><?php echo $prodid .' - '.$desc  ?></h2>
                    </div> 
                    <div class="col-md-12 pdtop-1">
                      <table style="height: 100%; width:100%;" class="table table-sm">
                        <tbody>
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
                            <td style="width: 5px;"><em><strong>&nbsp;Descripcion</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="desc" id="desc" class="form-control f50" aria-label="Default" 
                               value="<?php echo $desc; ?>">  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Tipo de producto</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              
                               <div class="form-group">
                               <select class="form-control f50" name="tipop" id="tipop">
                                <?php while ($row = mysqli_fetch_array($result_type)){ 
                                 $typos = $row['protype_desc'];
                                 if($typos == $type){$sel = 'selected';} else{$sel = '';}
                                 echo '<option value="'.$row['protype_id'].'"'.$sel.'>'.$typos.'</option>';
                                } ?>
                                </select>
                              </div>
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Cantidad disponible</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="cactual" id="cactual" class="form-control f50" aria-label="Default" 
                               value="<?php echo $qty; ?>">  
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
                              <input type="text" name="valor" id="valor" class="form-control f50" aria-label="Default" 
                               value="<?php echo $value; ?>">  
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
               
              </div>
            </div>
             <button type="button" type="submit" class="btn btn-reddark" onclick="Updateprd()"><i class="fas fa-edit"></i> &nbsp;<?php echo 'Actualizar'; ?></button>
            </form>
          </div>