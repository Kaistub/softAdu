<?php
include '../conn/conn.php';
if(session_id() == '') {
 session_start();}
 if (!$_SESSION['user']) {
   header("Location: /");
}
$processid = $_POST['process_id'];
$sql_process = 'SELECT * FROM process_report WHERE process_id="'.$processid.'";';
$result_process =  $conn->query($sql_process);
mysqli_close($conn);
?>



<div class="col-md-12">
            <form>
            <div class="card">
               <div class="col-md-10 pdtop-0 text-left">
                      <h2>Reporte de proceso</h2>
                    </div>
                    <div class="col-md-12 pdtop-1">
                      <table style="height: 100%; width:100%;" class="table table-sm">
                        <tbody>
                          <tr >
                            <td style="width: 5px;"><em><strong>&nbsp;Visualizacion del proceso</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                               <select name="productCheck" id="productCheck" class="form-control f50">
                                 <?php while ($row2 = mysqli_fetch_array($result_product)){
                                  echo '<option value="'.$row2['product_id'].'">'.$row2['product_id'].' - '.$row2['product_desc'].'</option>';
                                 } ?>
                                </select>
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Cantidad de producto</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="number" name="qty" id="qty" class="form-control f50" placeholder="Cantidad" require>
                            </td>
                          </tr>

                        </tbody>

                      </table>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#confirmCreate">Generar Orden</button>
                      <!-- Modal -->
                    <div class="modal fade" id="confirmCreate" tabindex="-1" role="dialog" aria-labelledby="confirmCreate" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Verificacion</h5>
                            <button type="" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p>Usted esta a punto de crear una orden para el producto, ¿Desea continuar?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" onclick="sendRequestOrder()" class="btn btn-primary">Continuar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                    </div>
            <!-- Next Card -->
            <div class="col-md-12">
            <form>
              <div class="card">
                <table class="table table-sm table-hover table-dark ">
                  <thead>
                    <tr>
                      <th>Fraccion</th>
                      <th>Materia</th>
                      <th>fecha de proceso</th>                      
                      <th>peso original</th>
                      <th>valor original</th>
                      <th>Cantidad Usada</th>
                      <th>Costo</th>
                      <th>Cantidad de producto</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    while ($row = mysqli_fetch_array($result_process )){
                        $pednum = $row['process_id'];
                        echo '<tr class="">';
                        echo '<td>' .''. $row['process_inv_date'].'</td>';
                        echo '<td>' .''.$row['process_product_id'].'</td>';
                        echo '<td>' .''.$row['process_product_qty'].'</td>';
                        echo '</tr>';
                    }  ?>
                  </tbody>
                </table>
              </div>
            </form>
            </div>
            
            
            
            </form>
            </div>