<?php
include '../conn/conn.php';
if(session_id() == '') {
 session_start();}
 if (!$_SESSION['user']) {
   header("Location: /");
}


$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];
$date = ''.date("Y-m-d", strtotime($startDate)).'';
$date2 = ''.date("Y-m-d", strtotime($endDate)).'';
$totalIngoing=0;
$totalQty=0;
$currentIngoing=false;
$pednumChk="";
$cont=0;


$sql_ingoing = 'SELECT DISTINCT * FROM ingoing INNER JOIN tariff ON ingoing.ingoing_tariff = tariff.tariff_id INNER JOIN measure ON measure.measure_id = ingoing.ingoing_measure INNER JOIN pednum ON pednum.pednum_id = ingoing.ingoing_pednum WHERE ingoing_peddate >= "'.$date.'" AND ingoing_peddate <= "'.$date2.'" ORDER BY ingoing_product, ingoing.ingoing_peddate ASC';
$result_ingoing =  $conn->query($sql_ingoing);

//close Session
mysqli_close($conn);

?>

<div class="col-md-12">
    <div class="card">
        <div class="col-md-10 pdtop-0 text-left">
            <h3>Reporte de Entradas</h3> 
            <div class="col-md-12">
            <form action="../queries/ingoingReportPDF.php" method="POST">
            <input type="text" id="date" name="date" value="<?php echo $date ?>" hidden>
            <input type="text" id="datea" name="datea" value="<?php echo $date2 ?>" hidden>
            <button type="submit" class="btn btn-reddark"><i class="fas fa-edit"></i> &nbsp;Generar Reporte</button>
            </form>
            
            <form>
              <div class="card">
                <table class="table table-sm table-hover table-dark ">
                  <thead>
                    <tr>
                        <th>Numero de pedimento</th>
                        <th>Clave de pedimento</th>
                        <th>Fecha de pedimento</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Tarifa Arancelaria</th>
                        <th>Tipo de producto</th>
                        <th>Valor</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $rdw_cnt =  mysqli_num_rows($result_ingoing);
                    while ($row = mysqli_fetch_array($result_ingoing)){                      
                      $pednum = $row['ingoing_product'];
                        if($pednumChk==""){                                                   
                          $currentIngoing=true;

                        }elseif($pednum!=$pednumChk){                          
                          $currentIngoing=false;

                        }elseif($pednum==$pednumChk){                          
                          $currentIngoing=true;

                        }else{                          
                          $currentIngoing=false;

                        }
                        $pednumChk=$row['ingoing_product'];

                        if($currentIngoing){

                          $totalIngoing= $totalIngoing+$row['ingoing_value'];
                          $totalQty=$totalQty+$row['ingoing_qty'];
                          
                            $pednum = $row['ingoing_product'];
                            echo '<tr class="clicProduct" data-href="entryingoing.php?ingoing_name='.$pednum.'">';
                            echo '<td>' .''.$row['pednum_desc'].'</td>';
                            echo '<td>' .''.$row['ingoing_pedkey'].'</td>';
                            echo '<td>' .''.$row['ingoing_peddate'].'</td>';
                            echo '<td>' .''.$row['ingoing_product'].'</td>';
                            echo '<td>' .''.$qty = $row['ingoing_qty'].'</td>';
                            echo '<td>' .''.$row['tariff_num'].'</td>';
                            echo '<td>' .''.$row['measure_desc'].'</td>';
                            echo '<td>' .''.$row['ingoing_value'].'</td>';
                            echo '</tr>';

                          if(($cont+1)==$rdw_cnt){
                            echo '<tr class="">';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';                            
                            echo '<td>Cantida total</td>';
                            echo '<td>' .''.$totalQty.'</td>';
                            echo '<td></td>';
                            echo '<td>Total de Entradas</td>';
                            echo '<td>' .''.$totalIngoing.'</td>';
                            echo '</tr>';
                            $totalIngoing=0;
                            $totalQty=0;
                          }
                        }else{
                          echo '<tr class="">';
                          echo '<td></td>';
                          echo '<td></td>';
                          echo '<td></td>';                          
                          echo '<td>Cantida total</td>';
                          echo '<td>' .''.$totalQty.'</td>';
                          echo '<td></td>';
                          echo '<td>Total de Entradas</td>';
                          echo '<td>' .''.$totalIngoing.'</td>';
                          echo '</tr>';
                          $totalIngoing=0;
                          $totalQty=0;            
                          $totalIngoing= $totalIngoing+$row['ingoing_value'];
                          $totalQty=$totalQty+$row['ingoing_qty'];
                            echo '<tr class="clicProduct" data-href="entryingoing.php?ingoing_name='.$pednum.'">';
                            echo '<td>' .''.$row['pednum_desc'].'</td>';
                            echo '<td>' .''.$row['ingoing_pedkey'].'</td>';
                            echo '<td>' .''.$row['ingoing_peddate'].'</td>';
                            echo '<td>' .''.$row['ingoing_product'].'</td>';
                            echo '<td>' .''.$qty = $row['ingoing_qty'].'</td>';
                            echo '<td>' .''.$row['tariff_num'].'</td>';
                            echo '<td>' .''.$row['measure_desc'].'</td>';
                            echo '<td>' .''.$row['ingoing_value'].'</td>';
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

<script>

function reporteGen(){
    <?php
        $htmlR;
        $htmlR='
        
        
        
        
        
        
        
        
        
        
        
        
        ';
    ?>
}

</script>