<?php
//require files
require '../../assets/js/vendor/autoload.php';
//include connection
include '../conn/conn.php';
//check user
if(session_id() == '') {
 session_start();}
 if (!$_SESSION['user']) {
   header("Location: /");
}
//code start

$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];
$date = ''.date("Y-m-d", strtotime($startDate)).'';
$date2 = ''.date("Y-m-d", strtotime($endDate)).'';
$totalProceso=0;
$currentProcess=false;
$pednumChk="";
$cont=0;


$sql_process = 'SELECT * FROM process_report WHERE  process_inv_date >= "'.$date.'" AND process_inv_date <= "'.$date2.'" ORDER BY process_id;';
$result_process =  $conn->query($sql_process);
$result_process3 =  $conn->query($sql_process);


mysqli_close($conn);
?>

<div class="col-md-12">
    <div class="card">
        <div class="col-md-10 pdtop-0 text-left">
            <h3>Reporte de procesos</h3> 
            <div class="col-md-12">
            <form action="../queries/procesoReporteGenPDF.php" method="POST">
            <input type="text" id="date" name="date" value="<?php echo $date ?>" hidden>
            <input type="text" id="datea" name="date2" value="<?php echo $date2 ?>" hidden>
            <button type="submit" class="btn btn-reddark"><i class="fas fa-edit"></i> &nbsp;Generar Reporte</button>
            </form>
            
            <form>
              <div class="card">
                <table class="table table-sm table-hover table-dark ">
                  <thead>
                    <tr>
                      <th>produto</th>
                      <th></th>
                      <th>Proceso</th>
                      <th>Fraccion</th>
                      <th>Materia</th>
                      <th>fecha de proceso</th>                      
                      <th>Cantidad Usada</th>
                      <th>Tipo de Cantidad</th>
                      <th>Costo</th>
                      <th>Cantidad de producto</th>
                      <th>Costo total</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $rdw_cnt =  mysqli_num_rows($result_process);
                    while ($row = mysqli_fetch_array($result_process)){                      
                      $pednum = $row['process_id'];
                        if($pednumChk==""){                                                   
                          $currentProcess=true;
                          echo '<tr class="">';
                            echo '<td>Producto Creado</td>';
                            echo '<td>' .''. $row['process_product_id'].'</td>';
                            echo '<td></td>';                            
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            
                            echo '</tr>';
                        }elseif($pednum!=$pednumChk){                          
                          $currentProcess=false;

                        }elseif($pednum==$pednumChk){                          
                          $currentProcess=true;

                        }else{                          
                          $currentProcess=false;

                        }
                        $pednumChk=$row['process_id'];

                        if($currentProcess){

                          $totalProceso= $totalProceso+$row['processinv_dw_total'];
                          
                          echo '<tr class="">';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td>' .''. $row['process_id'].'</td>';
                          echo '<td>' .''. $row['tariff_num'].'</td>';
                          echo '<td>' .''.$row['processinv_material'].'</td>';
                          echo '<td>' .''.$row['process_inv_date'].'</td>';
                          echo '<td>' .''.$row['process_product_qty'].'</td>';
                          echo '<td>' .''.$row['measure_desc'].'</td>';
                          echo '<td>' .''.$row['processinv_dw_total'].'</td>';
                          echo '<td>' .''.$row['processinv_export_qty'].'</td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '</tr>';
                          if(($cont+1)==$rdw_cnt){
                            echo '<tr class="">';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td>Total del proceso</td>';
                            echo '<td>' .''.$totalProceso.'</td>';
                            echo '<td></td>';
                            
                            echo '</tr>';
                            $totalProceso=0;
                          }
                        }else{
                          echo '<tr class="">';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td>Total del proceso</td>';
                          echo '<td>' .''.$totalProceso.'</td>';
                          echo '</tr>';
                          $totalProceso=0;
                          $totalProceso= $totalProceso+$row['processinv_dw_total'];
                            echo '<tr class="">';
                            echo '<td>Producto Creado</td>';
                            echo '<td>' .''. $row['process_product_id'].'</td>';
                            echo '<td></td>';                            
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';                            
                            echo '</tr>';
                            echo '<tr class="">';
                            echo '<td></td>';
                            echo '<td></td>';
                          echo '<td>' .''. $row['process_id'].'</td>';
                          echo '<td>' .''. $row['tariff_num'].'</td>';
                          echo '<td>' .''.$row['processinv_material'].'</td>';
                          echo '<td>' .''.$row['process_inv_date'].'</td>';
                          echo '<td>' .''.$row['process_product_qty'].'</td>';
                          echo '<td>' .''.$row['measure_desc'].'</td>';
                          echo '<td>' .''.$row['processinv_dw_total'].'</td>';
                          echo '<td>' .''.$row['processinv_export_qty'].'</td>';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '</tr>';
                        }
                        $cont++;
                    }  ?>
                  </tbody>
                </table>
              </div>
            </form>
            </div>
        </div>
    </div>
</div>
