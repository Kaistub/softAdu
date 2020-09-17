<?php 
require '../../assets/js/vendor/autoload.php';
//include connection
  //Include connection file 
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
   
      
      $sql_products = "SELECT * FROM saldos";
      $result_products = $conn->query($sql_products);
      $prodCheck = "";
      $rdw_cnt =  mysqli_num_rows($result_products);
      //
      //.----------------------Generate PDF----------------------.
$datenow = date("Y-m-d", strtotime('now'));
$pdf_name = 'Saldos_'.$datenow.'.pdf';
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
        <td style="text-align:center; border: 1px solid #000;">&nbsp; <h2>Reporte de saldos</h2> '.$rzCompany.' <br> '.$adCompany.' <br> RFC: '.$rfcCompany.'
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
<table class="table table-sm table-dark table-hover"  width = "100%">
<thead>
  <tr>
    <th scope="col">Material</th>
    <th scope="col">Fraccion</th>
    <th scope="col">Unidad de medida</th>
    <th scope="col">Valor</th>
    <th scope="col">Valor Original</th>
    <th scope="col">Valor Usado</th>
    <th scope="col">Cantidad</th>
    <th scope="col">Cantidad Original</th>
    <th scope="col">Cantidad Usada</th>
  </tr>
</thead>
<tbody>';
        $sheet++;
                    $rdw_cnt =  mysqli_num_rows($result_products);
                    $cont2 = 28;
                    $contC = 0;
                    (double) $valueC = 0;
                    (double) $valueT = 0;
                    (double) $qtyC = 0;
                    $counterThis = 1;
              
                  while ($row = mysqli_fetch_array($result_products)){
                    $pednum = $row['tariff_product'];
                    $voriginal = $row['tariff_voriginal'];
                    $qoriginal = $row['tariff_qoriginal'];
                    $tvalue = $row['tariff_value'];
                    $qvalue = $row['tariff_qty'];
                    if ($contC == 0) {
                      
                    }else {
                      //Check Product
                      if ($prodCheck != $pednum) {
                        $html .= '<tr class=" bg-secondary" data-href="../inventory/product.php?prod_name='.$prodCheck.'" style="background-color:gray">';
                        $html .= '<td style="border-bottom: 1px solid black;"> <strong>' .'Total '.$prodCheck.'</strong></td>';
                        $html .= "<td style='border-bottom: 1px solid black;'>  </td>";
                        $html .= "<td style='border-bottom: 1px solid black;'>  </td>";
                        $html .= "<td style='border-bottom: 1px solid black;'> <strong>  </strong></td>";
                        $html .= "<td style='border-bottom: 1px solid black;'><strong> </strong> </td>";
                        $html .= "<td style='border-bottom: 1px solid black;'> <strong>  </strong></td>";
                        $html .= "<td style='border-bottom: 1px solid black;'><strong> </strong> </td>";
                        $html .= "<td style='border-bottom: 1px solid black;'> <strong> $qtyC </strong></td>";
                        $html .= "<td style='border-bottom: 1px solid black;'><strong> $valueC</strong> </td>";
                        
                        $html .= '</tr>';
                        $contC = 0;
                        $valueC = 0;
                        $qtyC = 0;
                      }else {
                        //Do nothing
                      }
                    }
                    $html .= '<tr class="clicProduct" data-href="../inventory/product.php?prod_name='.$pednum.'">';
                      $html .= '<td style="border-bottom: 1px solid black;"> ' .''.$pednum.' - '.$row['product_desc'].'</td>';
                      $html .= '<td style="border-bottom: 1px solid black;"> ' .''.$row['tariff_num'].'</td>';
                      $html .= '<td style="border-bottom: 1px solid black;"> ' .''.$row['measure_desc'].'</td>';
                      $html .= '<td style="border-bottom: 1px solid black;"> ' .''.$row['tariff_value'].'</td>';
                      $html .= '<td style="border-bottom: 1px solid black;"> <strong>'.$row['tariff_voriginal'].'</strong></td>';
                      $html .= '<td style="border-bottom: 1px solid black;"> <strong>'.(floatval($voriginal)-floatval($tvalue)).'</strong></td>';
                      $html .= '<td style="border-bottom: 1px solid black;"> ' .''.$row['tariff_qty'].'</td>';
                      $html .= '<td style="border-bottom: 1px solid black;"> <strong>'.$row['tariff_qoriginal'].'</strong></td>';
                      $html .= '<td style="border-bottom: 1px solid black;"> <strong>'.(floatval($qoriginal)-floatval($qvalue)).'</strong></td>';
                      
                      $html .= '</tr>';
                      $valueT = $valueT + $row['tariff_value'];
                      $qtyC = $qtyC + $row['tariff_qty'];
                      $qtyT = $qtyT + $qtyC;
                      $valueC = $valueC + $row['tariff_value'];
                      $prodCheck = $row['tariff_product'];
                      
                     
                      $contC++;  
                      if ($rdw_cnt == $counterThis) {
                        $html .= '<tr class="clicProduct bg-secondary" data-href="../inventory/product.php?prod_name='.$prodCheck.'" style="background-color:gray">';
                        $html .= '<td style="border-bottom: 1px solid black;" >' .'<strong>Total '.$prodCheck.'</strong></td>';
                        $html .= "<td style='border-bottom: 1px solid black;'>  </td>";
                        $html .= "<td style='border-bottom: 1px solid black;'>  </td>";
                        $html .= "<td style='border-bottom: 1px solid black;'> <strong>  </strong></td>";
                        $html .= "<td style='border-bottom: 1px solid black;'><strong> </strong> </td>";
                        $html .= "<td style='border-bottom: 1px solid black;'> <strong>  </strong></td>";
                        $html .= "<td style='border-bottom: 1px solid black;'><strong> </strong> </td>";
                        $html .= "<td style='border-bottom: 1px solid black;'><strong> $qtyC</strong> </td>";
                        $html .= "<td style='border-bottom: 1px solid black;'> <strong>$valueC </strong></td>";
                        $html .= '</tr>';

                        //Finish Him
                        $html .= '<tr class=" bg-info" >';
                        $html .= '<td> <strong>Total General</strong></td>';
                        $html .= "<td>  </td>";
                        $html .= "<td>  </td>";
                        $html .= "<td style=''> <strong>$valueT  </strong></td>";
                        $html .= "<td style=''><strong> </strong> </td>";
                        $html .= "<td style=''> <strong>  </strong></td>";
                        $html .= "<td style=''><strong>$qtyT </strong> </td>";
                        $html .= "<td><strong> </strong> </td>";
                        $html .= "<td > <strong></strong> </td>";
                        $html .= '</tr>';
                        $html .= '</tbody>';
                        $html .= '</table>';
                        $html .= '</div>';
                      }
                      if ($counterThis == $cont2) {
                        $html .= '</tbody>';
                        $html .= '</table>';
                        $html .= '</div>';
                        $cont2 = ($counterThis + 28) ;
                        $mpdf->WriteHTML($html);
                        $mpdf->AddPage('L'); 
                        $html = '
                        <div style="padding-left: 10px; padding-right: 10px; border: 1px solid #000;">
                        <table id="companyData" width="100%" >
                                <tbody>
                                <tr>
                                <td style="text-align:center; border: 1px solid #000;">&nbsp; <h2>Reporte de saldos</h2> '.$rzCompany.' <br> '.$adCompany.' <br> RFC: '.$rfcCompany.'
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
                        <table class="table table-sm table-dark table-hover"  width = "100%">
                        <thead>
                        <tr>
                            <th scope="col">Material</th>
                            <th scope="col">Fraccion</th>
                            <th scope="col">Unidad de medida</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Valor Original</th>
                            <th scope="col">Valor Usado</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Cantidad Original</th>
                            <th scope="col">Cantidad Usada</th>
                        </tr>
                        </thead>
                        <tbody>';
                        $sheet++;
                      }
                      $counterThis++;
                  } 
  
$mpdf->WriteHTML($html);

//Save file
$mpdf->Output($pdf_name, 'D' );  
//.----------------------Generate PDF----------------------
      //close Session
      mysqli_close($conn);
 ?>
            <table class="table table-sm table-dark table-hover">
              <thead>
                <tr>
                  <th scope="col">Material</th>
                  <th scope="col">Fraccion</th>
                  <th scope="col">Unidad de medida</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col">Valor</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              $contC = 0;
              (double) $valueC = 0;
              (double) $valueT = 0;
              (double) $qtyC = 0;
              $counterThis = 1;
              
                  while ($row = mysqli_fetch_array($result_products)){
                    $pednum = $row['tariff_product'];
                    if ($contC == 0) {
                      
                    }else {
                      //Check Product
                      if ($prodCheck != $pednum) {
                        echo '<tr class=" bg-secondary" data-href="../inventory/product.php?prod_name='.$prodCheck.'">';
                        echo '<td>' .'Total '.$prodCheck.'</td>';
                        echo "<td> </td>";
                        echo "<td> </td>";
                        echo "<td> $qtyC </td>";
                        echo "<td> $valueC </td>";
                        echo '</tr>';
                        $contC = 0;
                        $valueC = 0;
                        $qtyC = 0;
                      }else {
                        //Do nothing
                      }
                    }
                    echo '<tr class="clicProduct" data-href="../inventory/product.php?prod_name='.$pednum.'">';
                      echo '<td>' .''.$pednum.' - '.$row['product_desc'].'</td>';
                      echo '<td>' .''.$row['tariff_num'].'</td>';
                      echo '<td>' .''.$row['measure_desc'].'</td>';
                      echo '<td>' .''.$row['tariff_qty'].'</td>';
                      echo '<td>' .''.$row['tariff_value'].'</td>';
                      echo '</tr>';
                      $valueT = $valueT + $row['tariff_value'];
                      $qtyC = $qtyC + $row['tariff_qty'];
                      $qtyT = $qtyT + $qtyC;
                      $valueC = $valueC + $row['tariff_value'];
                      $prodCheck = $row['tariff_product'];
                      
                     
                      $contC++;  
                      if ($rdw_cnt == $counterThis) {
                        echo '<tr class="clicProduct bg-secondary" data-href="../inventory/product.php?prod_name='.$prodCheck.'">';
                        echo '<td>' .'Total '.$prodCheck.'</td>';
                        echo "<td>  </td>";
                        echo "<td>  </td>";
                        echo "<td> $qtyC </td>";
                        echo "<td> $valueC </td>";
                        echo '</tr>';

                        //Finish Him
                        echo '<tr class=" bg-info">';
                        echo '<td>' .'Total General</td>';
                        echo "<td>  </td>";
                        echo "<td>  </td>";
                        echo "<td> $qtyT </td>";
                        echo "<td> $valueT </td>";
                        echo '</tr>';
                      }
                      $counterThis++;
                  }  ?>
              </tbody>
            </table>
            