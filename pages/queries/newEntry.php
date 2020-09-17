<?php 
  //Include connection file 
   include '../conn/conn.php';
   if(session_id() == '') {
    session_start();}
    if (!$_SESSION['user']) {
      header("Location: /");
   }

      //Load Variables
      
      //Load Values
      $sql_product = 'SELECT * FROM product WHERE product_type = 1 AND product_on != 0';
      $result_product = $conn->query($sql_product);

      $sql_tariff = 'SELECT DISTINCT  tariff_num FROM tariff';
      $result_tariff = $conn->query($sql_tariff);

      $sql_measure = 'SELECT  * FROM measure';
      $result_measure = $conn->query($sql_measure);
      
      //echo "<script>alert('".$tariff."')</script>";
      $sql_pednum = 'SELECT DISTINCT pednum_desc FROM pednum WHERE pednum_id="'.$pednum.'"';
      $result_pednum = $conn->query($sql_pednum);
      $rew = mysqli_fetch_assoc($result_pednum);

      

      //close Session
      mysqli_close($conn);
 ?>
        <form action="">
          <div class="col-md-12" >
            <div class="card">
              <div class="row pdtop-1 pdleft-1">
                    <div class="col-md-12 pdtop-0 text-center">
                      <h2>Nueva entrada</h2>
                    </div> 
                    <div class="col-md-12 ">
                      <table style="height: 100%; width:100%;" class="table table-sm">
                        <tbody>
                        <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Numero de pedimento</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="number" name="npedi" id="npedi" class="form-control f50" aria-label="Default" 
                               value="<?php echo $pedkey; ?>"  >
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Producto</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <select name="pdt" id="pdt" class='form-control f50'>
                                <?php 
                                  while ($row = mysqli_fetch_array($result_product )){
                                    $prod_id = $row['product_id'];
                                    echo '<option value="'.$prod_id.'">'.$prod_id.' - '.$row['product_desc'].'</option>';
                                } 
                                ?>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Cantidad</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="number" name="qtyy" id="qtyy"  class="form-control f50" aria-label="Default" 
                               value="<?php echo $qty; ?>"  >  
                            </td>
                          </tr>
                          <!--<tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Tarifa Arancelaria</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                            <select class="form-control f50" name="fracArancel" id="fracArancel">
                                <?php while ($raw = mysqli_fetch_array($result_tariff)){ 
                                 $arancel = $raw['tariff_num'];
                                 echo '<option value="'.$raw['tariff_num'].'">'.$arancel.'</option>';
                                } ?>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Unidad de medida</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                            <select name="measures" id="measures" class="form-control f50">
                            <?php 
                                  while ($ruw = mysqli_fetch_array($result_measure)){
                                    $measure = $ruw['measure_desc'];
                                    echo '<option value="'.$ruw['measure_id'].'">'.$measure.'</option>';
                                } 
                                ?> 
                            </select>
                            </td>
                          </tr>-->
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Valor</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="number" name="value2" id="value2" class="form-control f50" aria-label="Default" 
                                 >  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Fecha Declarada</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input class="form-control" type="date" name="date" id="date" class="form-control f50" aria-label="Default" 
                                 >  
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                   
              </div>
              
            </div>
            <button type="button" class="btn btn-info" onclick="insertEntry()">Aceptar</button>
          </div>
          
          </form>