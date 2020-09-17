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
$totalOutgoing=0;
$totalQty=0;
$currentOutgoing=false;
$pednumChk="";
$cont=0;


$sql_outgoing = 'SELECT DISTINCT * FROM outgoing INNER JOIN tariff ON outgoing.outgoing_tariff = tariff.tariff_id INNER JOIN measure ON measure.measure_id = outgoing.outgoing_measure INNER JOIN pednum ON pednum.pednum_id = outgoing.outgoing_pednum WHERE outgoing_peddate >= "'.$date.'" AND outgoing_peddate <= "'.$date2.'"  ORDER BY pednum.pednum_desc ' ;
$result_outgoing =  $conn->query($sql_outgoing);
mysqli_close($conn);
?>

<div class="col-md-12">
    <div class="card">
        <div class="col-md-10 pdtop-0 text-left">
            <h3>Reporte de Salidas</h3> 
            <div class="col-md-12">
            <form action="../queries/outgoingReportPDF.php" method="POST">
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
                    $rdw_cnt =  mysqli_num_rows($result_outgoing);
                    while ($row = mysqli_fetch_array($result_outgoing)){                      
                      $pednum = $row['outgoing_product'];
                        if($pednumChk==""){                                                   
                          $currentOutgoing=true;

                        }elseif($pednum!=$pednumChk){                          
                          $currentOutgoing=false;

                        }elseif($pednum==$pednumChk){                          
                          $currentOutgoing=true;

                        }else{                          
                          $currentOutgoing=false;

                        }
                        $pednumChk=$row['outgoing_product'];

                        if($currentOutgoing){

                          $totalOutgoing= $totalOutgoing+$row['outgoing_value'];
                          $totalQty=$totalQty+$row['outgoing_qty'];
                          
                            $pednum = $row['outgoing_pednum'];
                            echo '<tr class="clicProduct" data-href="entryoutgoing.php?outgoing_name='.$pednum.'">';
                            echo '<td>' .''.$row['pednum_desc'].'</td>';
                            echo '<td>' .''.$row['outgoing_pedkey'].'</td>';
                            echo '<td>' .''.$row['outgoing_peddate'].'</td>';
                            echo '<td>' .''.$row['outgoing_product'].'</td>';
                            echo '<td>' .''.$qty = $row['outgoing_qty'].'</td>';
                            echo '<td>' .''.$row['tariff_num'].'</td>';
                            echo '<td>' .''.$row['measure_desc'].'</td>';
                            echo '<td>' .''.$row['outgoing_value'].'</td>';
                            echo '</tr>';

                          if(($cont+1)==$rdw_cnt){
                            echo '<tr class="">';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';                            
                            echo '<td>Cantida total</td>';
                            echo '<td>' .''.$totalQty.'</td>';
                            echo '<td></td>';
                            echo '<td>Total de Salidas</td>';
                            echo '<td>' .''.$totalOutgoing.'</td>';
                            echo '</tr>';
                            $totalOutgoing=0;
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
                          echo '<td>Total de Salidas</td>';
                          echo '<td>' .''.$totalOutgoing.'</td>';
                          echo '</tr>';
                          $totalOutgoing=0;
                          $totalQty=0;            
                          $totalOutgoing= $totalOutgoing+$row['outgoing_value'];
                          $totalQty=$totalQty+$row['outgoing_qty'];
                          
                            echo '<tr class="clicProduct" data-href="entryoutgoing.php?outgoing_name='.$pednum.'">';
                            echo '<td>' .''.$row['pednum_desc'].'</td>';
                            echo '<td>' .''.$row['outgoing_pedkey'].'</td>';
                            echo '<td>' .''.$row['outgoing_peddate'].'</td>';
                            echo '<td>' .''.$row['outgoing_product'].'</td>';
                            echo '<td>' .''.$qty = $row['outgoing_qty'].'</td>';
                            echo '<td>' .''.$row['tariff_num'].'</td>';
                            echo '<td>' .''.$row['measure_desc'].'</td>';
                            echo '<td>' .''.$row['outgoing_value'].'</td>';
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