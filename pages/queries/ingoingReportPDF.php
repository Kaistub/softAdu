<?php
require '../../assets/js/vendor/autoload.php';
include '../conn/conn.php';
if(session_id() == '') {
 session_start();}
 if (!$_SESSION['user']) {
   header("Location: /");
}

$sql_company = "SELECT * FROM company WHERE company_id = 1";
$result_company = $conn->query($sql_company);
$riw = mysqli_fetch_assoc($result_company);
$rfcCompany = $riw['company_rfc'];
$rzCompany = $riw['company_rz'];
$adCompany = $riw['company_address'];

$startDate = $_POST['date'];
$endDate = $_POST['datea'];
$date = ''.date("Y-m-d", strtotime($startDate)).'';
$date2 = ''.date("Y-m-d", strtotime($endDate)).'';
$totalIngoing=0;
$totalQty=0;
$currentIngoing=false;
$pednumChk="";
$cont=0;


$sql_ingoing = 'SELECT DISTINCT * FROM ingoing INNER JOIN tariff ON ingoing.ingoing_tariff = tariff.tariff_id INNER JOIN measure ON measure.measure_id = ingoing.ingoing_measure INNER JOIN pednum ON pednum.pednum_id = ingoing.ingoing_pednum WHERE ingoing_peddate >= "'.$date.'" AND ingoing_peddate <= "'.$date2.'" ORDER BY ingoing_product, ingoing.ingoing_peddate ASC';
$result_ingoing =  $conn->query($sql_ingoing);

  //.----------------------Generate PDF----------------------.
  $datenow = date("Y-m-d", strtotime('now'));
  $pdf_name = 'Entradas_'.$date.'_'.$date2.'.pdf';
  $sheet = 1;
  
  
  $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'default_font_size' => 7,
  'default_font' => 'DejaVuSerif']);
  $mpdf->shrink_tables_to_fit = 0;
  
  $html = '
  <div style="padding-left: 10px; padding-right: 10px; border: 1px solid #000;">
  <table id="companyData" width="100%" >
          <tbody>
          <tr>
          <td style="text-align:center; border: 1px solid #000;">&nbsp; <h2>Reporte de entradas de importacion</h2> '.$rzCompany.' <br> '.$adCompany.' <br> RFC: '.$rfcCompany.'
          </td>
          </tr>
          </tbody>
          </table>
          <table width="100%">
          <tbody>
          <tr>
          <td>&nbsp;<strong></strong></td>
          <td>&nbsp;<strong></strong></td>
          <td style="text-align:right;">&nbsp;<strong>Fecha actual: '.$datenow.' - Hoja '.$sheet.' </strong></td>
          </tr>
          </tbody>
          </table>
  <table width = "100%">
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
  <tbody>';
          $sheet++;
                      
                      $cont2 = 30;
                      $cont = 0;
                      (double) $valueC = 0;
                      (double) $valueT = 0;
                      (double) $qtyC = 0;
                      $counterThis = 1;
                
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
                              $html .= '<tr class="clicProduct" data-href="entryingoing.php?ingoing_name='.$pednum.'">';
                              $html .= '<td>' .''.$row['pednum_desc'].'</td>';
                              $html .= '<td>' .''.$row['ingoing_pedkey'].'</td>';
                              $html .= '<td>' .''.$row['ingoing_peddate'].'</td>';
                              $html .= '<td>' .''.$row['ingoing_product'].'</td>';
                              $html .= '<td>' .''.$qty = $row['ingoing_qty'].'</td>';
                              $html .= '<td>' .''.$row['tariff_num'].'</td>';
                              $html .= '<td>' .''.$row['measure_desc'].'</td>';
                              $html .= '<td>' .''.$row['ingoing_value'].'</td>';
                              $html .= '</tr>';
  
                            if(($cont+1)==$rdw_cnt){
                              $html .= '<tr class="">';
                              $html .= '<td></td>';
                              $html .= '<td></td>';
                              $html .= '<td></td>';                            
                              $html .= '<td>Cantida total</td>';
                              $html .= '<td>' .''.$totalQty.'</td>';
                              $html .= '<td></td>';
                              $html .= '<td>Total de Entradas</td>';
                              $html .= '<td>' .''.$totalIngoing.'</td>';
                              $html .= '</tr>';
                              $html .= "</tbody>
                              </table>
                            </div>";
                              $totalIngoing=0;
                              $totalQty=0;
                            }
                          }else{
                            $html .= '<tr class="">';
                            $html .= '<td></td>';
                            $html .= '<td></td>';
                            $html .= '<td></td>';                          
                            $html .= '<td>Cantida total</td>';
                            $html .= '<td>' .''.$totalQty.'</td>';
                            $html .= '<td></td>';
                            $html .= '<td>Total de Entradas</td>';
                            $html .= '<td>' .''.$totalIngoing.'</td>';
                            $html .= '</tr>';
                            $totalIngoing=0;
                            $totalQty=0;            
                            $totalIngoing= $totalIngoing+$row['ingoing_value'];
                            $totalQty=$totalQty+$row['ingoing_qty'];
                              $html .= '<tr class="clicProduct" data-href="entryingoing.php?ingoing_name='.$pednum.'">';
                              $html .= '<td>' .''.$row['pednum_desc'].'</td>';
                              $html .= '<td>' .''.$row['ingoing_pedkey'].'</td>';
                              $html .= '<td>' .''.$row['ingoing_peddate'].'</td>';
                              $html .= '<td>' .''.$row['ingoing_product'].'</td>';
                              $html .= '<td>' .''.$qty = $row['ingoing_qty'].'</td>';
                              $html .= '<td>' .''.$row['tariff_num'].'</td>';
                              $html .= '<td>' .''.$row['measure_desc'].'</td>';
                              $html .= '<td>' .''.$row['ingoing_value'].'</td>';
                              $html .= '</tr>';
                              
                          }
                          if ($cont ==  $cont2) {
                              if ($cont == ($rdw_cnt-1)) {
                                  # code...
                              }else{
                                $cont2 = ($cont + 30);
                                $html .= "</tbody>
                                </table>
                              </div>";
                                $mpdf->WriteHTML($html);
                              $mpdf->AddPage('L'); 
                              $html = '
                                      <div style="padding-left: 10px; padding-right: 10px; border: 1px solid #000;">
                                      <table id="companyData" width="100%" >
                                              <tbody>
                                              <tr>
                                              <td style="text-align:center; border: 1px solid #000;">&nbsp; <h2>Reporte de entradas de importacion</h2> '.$rzCompany.' <br> '.$adCompany.' <br> RFC: '.$rfcCompany.'
                                              </td>
                                              </tr>
                                              </tbody>
                                              </table>
                                              <table width="100%">
                                              <tbody>
                                              <tr>
                                              <td>&nbsp;<strong></strong></td>
                                              <td>&nbsp;<strong></strong></td>
                                              <td style="text-align:right;">&nbsp;<strong>Fecha actual: '.$datenow.' - Hoja '.$sheet.' </strong></td>
                                              </tr>
                                              </tbody>
                                              </table>
                                      <table width = "100%">
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
                                      <tbody>';
                                      $sheet++;
                              }
                              
                          }
                          $cont++;
                      }
    
  $mpdf->WriteHTML($html);
  
  //Save file
  $mpdf->Output($pdf_name, 'D' );  
  //.----------------------Generate PDF----------------------
        //close Session
        mysqli_close($conn);

?>
