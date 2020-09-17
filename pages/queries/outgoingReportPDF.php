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
$totalOutgoing=0;
$totalQty=0;
$currentOutgoing=false;
$pednumChk="";
$cont=0;


$sql_outgoing = 'SELECT DISTINCT * FROM outgoing INNER JOIN tariff ON outgoing.outgoing_tariff = tariff.tariff_id INNER JOIN measure ON measure.measure_id = outgoing.outgoing_measure INNER JOIN pednum ON pednum.pednum_id = outgoing.outgoing_pednum WHERE outgoing_peddate >= "'.$date.'" AND outgoing_peddate <= "'.$date2.'"  ORDER BY pednum.pednum_desc ' ;
$result_outgoing =  $conn->query($sql_outgoing);

//.----------------------Generate PDF----------------------.
$datenow = date("Y-m-d", strtotime('now'));
$pdf_name = 'Salidas_'.$date.'_'.$date2.'.pdf';
$sheet = 1;


$mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'default_font_size' => 7,
'default_font' => 'DejaVuSerif']);
$mpdf->shrink_tables_to_fit = 0;

$html = '
<div style="padding-left: 10px; padding-right: 10px; border: 1px solid #000;">
<table id="companyData" width="100%" >
        <tbody>
        <tr>
        <td style="text-align:center; border: 1px solid #000;">&nbsp; <h2>Reporte de salidas de productos</h2> '.$rzCompany.' <br> '.$adCompany.' <br> RFC: '.$rfcCompany.'
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
                    
                    $cont2 = 35;
                    $cont = 0;
                    (double) $valueC = 0;
                    (double) $valueT = 0;
                    (double) $qtyC = 0;
                    $counterThis = 1;
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
                            $html .= '<tr class="clicProduct" data-href="entryoutgoing.php?outgoing_name='.$pednum.'">';
                            $html .= '<td>' .''.$row['pednum_desc'].'</td>';
                            $html .= '<td>' .''.$row['outgoing_pedkey'].'</td>';
                            $html .= '<td>' .''.$row['outgoing_peddate'].'</td>';
                            $html .= '<td>' .''.$row['outgoing_product'].'</td>';
                            $html .= '<td>' .''.$qty = $row['outgoing_qty'].'</td>';
                            $html .= '<td>' .''.$row['tariff_num'].'</td>';
                            $html .= '<td>' .''.$row['measure_desc'].'</td>';
                            $html .= '<td>' .''.$row['outgoing_value'].'</td>';
                            $html .= '</tr>';

                          if(($cont+1)==$rdw_cnt){
                            $html .= '<tr class="">';
                            $html .= '<td></td>';
                            $html .= '<td></td>';
                            $html .= '<td></td>';                            
                            $html .= '<td>Cantida total</td>';
                            $html .= '<td>' .''.$totalQty.'</td>';
                            $html .= '<td></td>';
                            $html .= '<td>Total de Salidas</td>';
                            $html .= '<td>' .''.$totalOutgoing.'</td>';
                            $html .= '</tr>';
                            $html .= "</tbody>
                            </table>
                          </div>";
                            $totalOutgoing=0;
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
                          $html .= '<td>Total de Salidas</td>';
                          $html .= '<td>' .''.$totalOutgoing.'</td>';
                          $html .= '</tr>';
                          $totalOutgoing=0;
                          $totalQty=0;            
                          $totalOutgoing= $totalOutgoing+$row['outgoing_value'];
                          $totalQty=$totalQty+$row['outgoing_qty'];
                          
                            $html .= '<tr class="clicProduct" data-href="entryoutgoing.php?outgoing_name='.$pednum.'">';
                            $html .= '<td>' .''.$row['pednum_desc'].'</td>';
                            $html .= '<td>' .''.$row['outgoing_pedkey'].'</td>';
                            $html .= '<td>' .''.$row['outgoing_peddate'].'</td>';
                            $html .= '<td>' .''.$row['outgoing_product'].'</td>';
                            $html .= '<td>' .''.$qty = $row['outgoing_qty'].'</td>';
                            $html .= '<td>' .''.$row['tariff_num'].'</td>';
                            $html .= '<td>' .''.$row['measure_desc'].'</td>';
                            $html .= '<td>' .''.$row['outgoing_value'].'</td>';
                            $html .= '</tr>';
                        }
                        if ($cont == $cont2) {
                            if ($cont == ($rdw_cnt-1)) {
                                # code...
                            }else {
                                $cont2 = ($cont + 35);
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
                                        <td style="text-align:center; border: 1px solid #000;">&nbsp; <h2>Reporte de salidas de productos</h2> '.$rzCompany.' <br> '.$adCompany.' <br> RFC: '.$rfcCompany.'
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