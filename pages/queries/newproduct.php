<?php 
	//Include connection file
	include '../conn/conn.php';

  $sql_product = 'SELECT  * FROM measure';
  $result_product = $conn->query($sql_product);
  $sql_type = 'SELECT  * FROM product_type';
  $result_type = $conn->query($sql_type);
  $sql_tariff = 'SELECT DISTINCT  tariff_num FROM tariff';
  $result_tariff = $conn->query($sql_tariff);

	mysqli_close($conn);
?> 
          <div class="col-md-12" id="product">
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
                      <h2>Nuevo producto</h2>
                    </div> 
                    <div class="col-md-12 pdtop-1">
                      <table style="height: 100%; width:100%;" class="table table-sm">
                        <tbody>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Id del producto</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                               <input type="text" name="idprod" id="idprod" class="form-control f50" aria-label="Default" >
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Fracci&oacute;n Arancelaria</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                               <select class="form-control f50" name="fracArancel" id="fracArancel">
                                <?php while ($row = mysqli_fetch_array($result_tariff)){ 
                                 $arancel = $row['tariff_num'];
                                 if($arancel == $tariff){$sel = 'selected';} else{$sel = '';}
                                 echo '<option value="'.$row['tariff_num'].'"'.$sel.'>'.$arancel.'</option>';
                                } ?>
                                </select>
                                <input type="checkbox" class="f50" id="isNewCheck" name="isNewCheck">
                                <label>Otra Fraccion Aranvelaria</label>
                                <input type="text" class="form-control f50" onclick="" name="newFracc" id="newFracc" placeholder="Fraccion Arancelaria">

                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Descripcion</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="desc" id="desc" class="form-control f50" aria-label="Default" >  
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
                              <input type="text" name="cactual" id="cactual" class="form-control f50" aria-label="Default" >  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Unidad de medida</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <div class="form-group">
                                <div class="form-group">
                                <select class="form-control f50" name="measure" id="measure">
                                <?php while ($row = mysqli_fetch_array($result_product)){ 
                                 $descs = $row['measure_desc'];
                                 if($descs == $measure){$sel = 'selected';} else{$sel = '';}
                                 echo '<option value="'.$row['measure_id'].'"'.$sel.'>'.$descs.'</option>';
                                } ?>
                                </select>
                              </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Imagen</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="file" name="images" id="images" class="form-control f50" aria-label="Default" accept="image/png, image/jpeg">  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Valor</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="valor" id="valor" class="form-control f50" aria-label="Default" >  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Fecha Declarada</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                            <input class="form-control" type="datetime-local" name="fdate" id="fdate" class="form-control f50" aria-label="Default" 
                                 >  
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
               
              </div>
            </div>
             <button type="button" type="submit" class="btn btn-success" onclick="InsertProd()"><i class="fas fa-edit"></i> &nbsp;Guardar</button>
            </form>
          </div>