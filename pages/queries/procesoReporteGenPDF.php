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

$startDate = $_POST['date'];
$endDate = $_POST['date2'];
$date = ''.date("Y-m-d", strtotime($startDate)).'';
$date2 = ''.date("Y-m-d", strtotime($endDate)).'';
$datenow = date("Y-m-d", strtotime('now'));
$totalProceso=0;
$currentProcess=false;
$pednumChk="";
$cont=0;

$sql_company = "SELECT * FROM company WHERE company_id = 1";
$result_company = $conn->query($sql_company);
$riw = mysqli_fetch_assoc($result_company);
$rfcCompany = $riw['company_rfc'];
$rzCompany = $riw['company_rz'];
$adCompany = $riw['company_address'];

$sql_process = 'SELECT * FROM process_report WHERE  process_inv_date >= "'.$date.'" AND process_inv_date <= "'.$date2.'" ORDER BY process_id;';
$result_process =  $conn->query($sql_process);

/*if(isset($_POST['generatePDF'])){*/
//.----------------------Generate PDF----------------------.
$date_now = date("F j, Y");
$pdf_name = 'Process'.$date.'_'.$date2.'.pdf';
$sheet = 1;


  mysqli_close($conn);

$mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'default_font_size' => 7,
'default_font' => 'DejaVuSerif']);
$mpdf->shrink_tables_to_fit = 0;

$html = '
        <div style="padding-left: 10px; padding-right: 10px; border: 1px solid #000;">
        <table id="companyData" width="100%" >
        <tbody>
        <tr>
        <td style="text-align:center; border: 1px solid #000;">&nbsp; <h2>Reporte de procesos</h2> '.$rzCompany.' <br> '.$adCompany.' <br> RFC: '.$rfcCompany.'
        </td>
        </tr>
        </tbody>
        </table>
        <table width="100%">
        <tbody>
        <tr>
        <td>&nbsp;<strong>Por rangos</strong></td>
        <td>&nbsp;<strong>Rango: del '.$date.' a '.$date2.'</strong></td>
        <td>&nbsp;<strong>Fecha actual: '.$datenow.' - Hoja '.$sheet.' </strong></td>
        </tr>
        </tbody>
        </table>
        <table id="Data" width="100%">
        <tbody>
        <tr style="background-color: white; color: black;">
        <td><em><strong>&nbsp;Producto</strong></em></td>
        <td><em><strong>&nbsp;</strong></em></td>
        <td><em><strong>Proceso</strong></em></td>
        <td><em><strong>Fraccion</strong></em></td>
        <td><em><strong>Materia</strong></em></td>
        <td><em><strong>Fecha de proceso</strong></em></td>
        <td><em><strong>Cantidad Usada</strong></em></td>
        <td><em><strong>Tipo de cantidad</strong></em></td>
        <td><em><strong>Costo</strong></em></td>
        <td><em><strong>Cantidad de producto</strong></em></td>
        <td><em><strong>Costo Total</strong></em></td>
        <td><em><strong></strong></em></td>
        </tr> ';
        $sheet++;
                    $rdw_cnt =  mysqli_num_rows($result_process);
                    $cont2 = 22;
                    while ($row = mysqli_fetch_array($result_process)){                      
                      $pednum = $row['process_id'];
                        if($pednumChk==""){                                                   
                          $currentProcess=true;
                          $html .= '<tr class="">';
                          $html .= '<td>Producto Creado</td>';
                          $html .= '<td>' .''. $row['process_product_id'].'</td>';
                          $html .= '<td></td>';                            
                          $html .= '<td></td>';
                          $html .= '<td></td>';
                          $html .= '<td></td>';
                          $html .= '<td></td>';
                          $html .= '<td></td>';
                          $html .= '<td></td>';
                          $html .= '<td></td>';
                          $html .= '<td></td>';
                          $html .= '<td></td>';
                            
                          $html .= '</tr>' ;
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
                          
                          $html .= '<tr class="">';
                          $html .= '<td></td>';
                          $html .= '<td></td>';
                          $html .= '<td>' .''. $row['process_id'].'</td>';
                          $html .= '<td>' .''. $row['tariff_num'].'</td>';
                          $html .= '<td>' .''.$row['processinv_material'].'</td>';
                          $html .= '<td>' .''.$row['process_inv_date'].'</td>';
                          $html .= '<td>' .''.$row['process_product_qty'].'</td>';
                          $html .= '<td>' .''.$row['measure_desc'].'</td>';
                          $html .= '<td>' .''.$row['processinv_dw_total'].'</td>';
                          $html .= '<td>' .''.$row['processinv_export_qty'].'</td>';
                          $html .= '<td></td>';
                          $html .= '<td></td>';
                          $html .= '</tr>';
                          if(($cont+1)==$rdw_cnt){
                            $html .= '<tr class="" style="border-bottom: 1px solid black;">';
                            $html .= '<td style="border-bottom: 1px solid black;"></td>';
                            $html .= '<td style="border-bottom: 1px solid black;"></td>';
                            $html .= '<td style="border-bottom: 1px solid black;"></td>';
                            $html .= '<td style="border-bottom: 1px solid black;"></td>';
                            $html .= '<td style="border-bottom: 1px solid black;"></td>';
                            $html .= '<td style="border-bottom: 1px solid black;"></td>';
                            $html .= '<td style="border-bottom: 1px solid black;"></td>';
                            $html .= '<td style="border-bottom: 1px solid black;"></td>';
                            $html .= '<td style="border-bottom: 1px solid black;"></td>';
                            $html .= '<td style="border-bottom: 1px solid black;"></td>';
                            $html .= '<td style="border-bottom: 1px solid black;">Total del proceso</td>';
                            $html .= '<td style="border-bottom: 1px solid black;">' .''.$totalProceso.'</td>';
                            $html .= '<td ></td>';
                            
                            $html .= '</tr>';
                            $totalProceso=0;
                            $html .= '</tbody>
                                </table></div>';
                          }
                        }else{
                          $html .= '<tr class="">';
                          $html .= '<td style="border-bottom: 1px solid black;"></td>';
                          $html .= '<td style="border-bottom: 1px solid black;"></td>';
                          $html .= '<td style="border-bottom: 1px solid black;"></td>';
                          $html .= '<td style="border-bottom: 1px solid black;"></td>';
                          $html .= '<td style="border-bottom: 1px solid black;"></td>';
                          $html .= '<td style="border-bottom: 1px solid black;"></td>';
                          $html .= '<td style="border-bottom: 1px solid black;"></td>';
                          $html .= '<td style="border-bottom: 1px solid black;"></td>';
                          $html .= '<td style="border-bottom: 1px solid black;"></td>';
                          $html .= '<td style="border-bottom: 1px solid black;"></td>';
                          $html .= '<td style="border-bottom: 1px solid black;">Total del proceso</td>';
                          $html .= '<td style="border-bottom: 1px solid black;">' .''.$totalProceso.'</td>';
                          $html .= '</tr>';
                          $totalProceso=0;
                          $totalProceso= $totalProceso+$row['processinv_dw_total'];
                            $html .= '<tr class="">';
                            $html .= '<td>Producto Creado</td>';
                            $html .= '<td>' .''. $row['process_product_id'].'</td>';
                            $html .= '<td></td>';                            
                            $html .= '<td></td>';
                            $html .= '<td></td>';
                            $html .= '<td></td>';
                            $html .= '<td></td>';
                            $html .= '<td></td>';
                            $html .= '<td></td>';
                            $html .= '<td></td>';
                            $html .= '<td></td>';
                            $html .= '<td></td>';                            
                            $html .= '</tr>';
                            $html .= '<tr class="">';
                            $html .= '<td></td>';
                            $html .= '<td></td>';
                          $html .= '<td>' .''. $row['process_id'].'</td>';
                          $html .= '<td>' .''. $row['tariff_num'].'</td>';
                          $html .= '<td>' .''.$row['processinv_material'].'</td>';
                          $html .= '<td>' .''.$row['process_inv_date'].'</td>';
                          $html .= '<td>' .''.$row['process_product_qty'].'</td>';
                          $html .= '<td>' .''.$row['measure_desc'].'</td>';
                          $html .= '<td>' .''.$row['processinv_dw_total'].'</td>';
                          $html .= '<td>' .''.$row['processinv_export_qty'].'</td>';
                          $html .= '<td></td>';
                          $html .= '<td></td>';
                          $html .= '</tr>';
                        }
                        if ($cont == $cont2 ) {
                          $html .= '</tbody>
                          </table>';
                          $cont2 = ($cont + 22) ;
                          $mpdf->WriteHTML($html);
                          $mpdf->AddPage('L'); 
                          $html = '
                          <table id="companyData" width="100%" >
                          <tbody>
                          <tr>
                          <td style="text-align:center; border: 1px solid #000;">&nbsp; <h2>Reporte de procesos</h2> '.$rzCompany.' <br> '.$adCompany.' <br> RFC: '.$rfcCompany.'
                          </td>
                          </tr>
                          </tbody>
                          </table>
                          <table width="100%">
                          <tbody>
                          <tr>
                          <td>&nbsp;<strong>Por rangos</strong></td>
                          <td>&nbsp;<strong>Rango: del '.$date.' a '.$date2.'</strong></td>
                          <td>&nbsp;<strong>Fecha actual: '.$datenow.' - Hoja '.$sheet.' </strong></td>
                          </tr>
                          </tbody>
                          </table>
                          <table id="Data" width="100%">
                          <tbody>
                          <tr style="background-color: white; color: black;">
                          <td><em><strong>&nbsp;Producto</strong></em></td>
                          <td><em><strong>&nbsp;</strong></em></td>
                          <td><em><strong>Proceso</strong></em></td>
                          <td><em><strong>Fraccion</strong></em></td>
                          <td><em><strong>Materia</strong></em></td>
                          <td><em><strong>Fecha de proceso</strong></em></td>
                          <td><em><strong>Cantidad Usada</strong></em></td>
                          <td><em><strong>Tipo de cantidad</strong></em></td>
                          <td><em><strong>Costo</strong></em></td>
                          <td><em><strong>Cantidad de producto</strong></em></td>
                          <td><em><strong>Costo Total</strong></em></td>
                          <td><em><strong></strong></em></td>
                          </tr> ';
                          $sheet++;
                        }
                        $cont++;
                    } 
  
$mpdf->WriteHTML($html);

//Save file
$mpdf->Output($pdf_name, 'D' );  
//.----------------------Generate PDF----------------------.
/*}*/
mysqli_close($conn);
?>