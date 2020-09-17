<?php 
include '../conn/conn.php';
if(session_id() == '') {
  session_start();}
  if (!$_SESSION['user']) {
    header("Location: /");
 }
  $products = "El/Los Numero de importacion ya existe: ";
  $products2 = "El/Los Siguientes Productos no existen y no han sido agregados: ";
  if (isset($_POST['import'])) {
    //Read data from document
    $file = $_FILES['file']['tmp_name'];
    $handle = fopen($file, "r");
    $msgerror = "";
    $c = 0;
    $the_big_array = [];
    while (($csvdata = fgetcsv($handle, 1000, ",") ) !== FALSE) {
      
      if ($c==0) {
        $c = $c+1; continue;
      }
      //Set data from document
      $pednum = $csvdata[0];
      $pedkey = "IN";
      $peddate = $csvdata[1];
      $qty = $csvdata[2];
      $prod_name = $csvdata[3];
      $value = $csvdata[4];
      $date = ''.date("Y-m-d H:i:s", strtotime($peddate)).'';

      $sql_checkdata = "SELECT * FROM tariff WHERE tariff_product = '$prod_name'";
      $result_checkdata = $conn->query($sql_checkdata);
      $rxs = mysqli_fetch_assoc($result_checkdata);
      $tariff = $rxs['tariff_num'];

      //Verify data
      $sql_select = "SELECT * FROM ingoing WHERE `ingoing`.`ingoing_pednum` = '$pednum'";
      $result_query = $conn->query($sql_select);
      $row_cnt =  mysqli_num_rows($result_query);
      
      if ($row_cnt != 0) {
        $products .= "$pednum ";
        }else{
        $sql_product2 = "SELECT * FROM product WHERE product_id = '$prod_name' AND product_type = '1'";
        $result_products = $conn->query($sql_product2);
        $row12_cnt =  mysqli_num_rows($result_products);
        if ($row12_cnt == 0) {
          $products2 .= "$prod_name ";
          }else {
          //Convert Values to index form
        $sql_pednum2 = "INSERT INTO `pednum` (`pednum_desc`) VALUES ('$pednum')";
        $result_ped2 = $conn->query($sql_pednum2);
        $sql_ped = "SELECT pednum_id FROM `pednum` WHERE `pednum_desc` = '$pednum'";
        $result_ped2 = $conn->query($sql_ped);
        $rvw = mysqli_fetch_assoc($result_ped2);
        $newPednum = $rvw['pednum_id'];
        

        $sql_tari2 = "SELECT tariff_id FROM `tariff` WHERE `tariff_num` = '$tariff'";
        $result_tari2 = $conn->query($sql_tari2);
        $rzw = mysqli_fetch_assoc($result_tari2);
        $newTariff = $rzw['tariff_id'];

        //Verify Data Not finished
        $sql_select = "SELECT * FROM product WHERE `product_id` = '$prod_name'";
        $result_query = $conn->query($sql_select);
        $raw = mysqli_fetch_assoc($result_query);
        $lessqty = $raw['product_qty'];
        $lessvalue = $raw['product_value'];
        $measure = $raw['product_unitmeasure'];
        $row_cnt =  mysqli_num_rows($result_query);

        $sql_tariff = "SELECT * FROM tariff WHERE `tariff_product` = '$prod_name' AND `tariff_num`= '$tariff' ";
        $result_tariff = $conn->query($sql_tariff);
        $riw = mysqli_fetch_assoc($result_tariff);
        $lessqty2 = $riw['tariff_qty'];
        $lessvalue2 = $riw['tariff_value'];

        //Set data
        $updateBT = ($lessqty + $qty);
        $updateBT2 = ($lessvalue + $value);
        $updateTF = ($lessqty2 + $qty);
        $updateTF2 = ($lessvalue2 + $value);

        //Set all data
        if ($riw['tariff_product'] == $prod_name &&  $riw['tariff_num'] == $tariff) {
          $sql_new2 = "INSERT INTO `tariff` (`tariff_num`, `tariff_product`,`tariff_value`,`tariff_qty`,`tariff_date`,`tariff_state`,`tariff_voriginal`,`tariff_qoriginal`) 
          VALUES ('$tariff', '$prod_name', '$value', '$qty','$date','1','$value','$qty')";
          $sql_update1 = "UPDATE `product` SET `product`.`product_qty` = '$updateBT', `product`.`product_value` = '$updateBT2' WHERE `product`.`product_id` = '$prod_name'";
          $sql_new3 = "INSERT INTO `ingoing` (`ingoing_id`, `ingoing_pednum`, `ingoing_peddate`, `ingoing_pedkey`, `ingoing_qty`, `ingoing_product`, `ingoing_tariff`, `ingoing_measure`, `ingoing_value`)
           VALUES (NULL, '$newPednum', '$date', '$pedkey', '$qty', '$prod_name', '$newTariff', '$measure', '$value')";
          $result_update2 = $conn->query($sql_new2);
          $result_update = $conn->query($sql_update1);
          $result_insert = $conn->query($sql_new3);
        }else{
          $sql_new2 = "INSERT INTO `tariff` (`tariff_num`, `tariff_product`,`tariff_value`,`tariff_qty`,`tariff_date`,`tariff_state`,`tariff_voriginal`,`tariff_qoriginal`) 
          VALUES ('$tariff', '$prod_name', '$value', '$qty','$date','1','$value','$date')";
          $sql_update1 = "UPDATE `product` SET `product`.`product_qty` = '$updateBT', `product`.`product_value` = '$updateBT2' WHERE `product`.`product_id` = '$prod_name'";
          $sql_new3 = "INSERT INTO `ingoing` (`ingoing_id`, `ingoing_pednum`, `ingoing_peddate`, `ingoing_pedkey`, `ingoing_qty`, `ingoing_product`, `ingoing_tariff`, `ingoing_measure`, `ingoing_value`)
           VALUES (NULL, '$newPednum', '$date', '$pedkey', '$qty', '$prod_name', '$newTariff', '$measure', '$value')";
          $result_update2 = $conn->query($sql_new2);
          $result_update = $conn->query($sql_update1);
          $result_insert = $conn->query($sql_new3);
          
          }
        }
        
      }
    //close Session
    }
  }
  if ($products != "El/Los Numero de importacion ya existe: ") {
    echo "<script> alert('$products')</script>";
  }
  if ($products2 != "El/Los Siguientes Productos no existen y no han sido agregados: ") {
    echo "<script> alert('$products2')</script>";
  }

  mysqli_close($conn);
 ?>

<!DOCTYPE html>
<html lang="es-mx">

<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="../../assets/img/logo.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Producto - SoftAdu
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
  <!-- CSS Files -->
  <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../../assets/css/now-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
  <link href="../../assets/css/adu.min.css" rel="stylesheet" />
  <div id="#charge"></div>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="black">
      <div class="logo">
        <a href="../config/config.php" class="simple-text logo-mini">
         SA
        </a>
        <a href="#" class="simple-text logo-normal">
          SoftAdu
        </a>
      </div>
      <div class="sidebar-wrapper">
      <ul class="nav">
          <li >
            <a href="../dashboard/dashboard.php">
              <i class="fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li >
            <a href="../inventory/inventory.php">
              <i class="fas fa-table"></i>
              <p>inventario</p>
            </a>
          </li>
          <li >
            <a href="../process/process.php">
              <i class="fas fa-project-diagram"></i>
              <p>Proceso</p>
            </a>
          </li>
          <li class="active">
            <a href="../ingoing/ingoing.php">
              <i class="fas fa-file-alt"></i>
              <p>Entradas</p>
            </a>
          </li>
          <li >
            <a href="../outgoing/outgoing.php">
              <i class="fas fa-file-invoice-dollar"></i>
              <p>Salidas</p>
            </a>
          </li>
          <li>
            <a href="../balance/balance.php">
              <i class="fas fa-money-bill"></i>
              <p>Saldos</p>
            </a>
          </li>
         <!-- <li>
            <a href="../bill/bill.php">
              <i class="fas fa-money-check-alt"></i>
              <p>Facturas</p>
            </a>
          </li>-->
          <?php if ($_SESSION['LevelAccess'] == 3) {
            echo '<li >
            <a href="../measure/measure.php">
              <i class="fas fa-balance-scale"></i>
              <p>Medidas</p>
            </a>
          </li>
          <li>
            <a href="../config/config.php">
              <i class="fas fa-cogs"></i>
              <p>Configuraciones</p>
            </a>
          </li>';
          } ?>
          
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <div id="DescPage">
              <p class="navbar-brand" >Importar Entradas</p>
            </div>
            
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <!--<form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Buscar...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                  </div>
                </div>
              </div>
            </form>-->
            <ul class="navbar-nav">
              
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Bienvenido, <?php echo $_SESSION['user']; ?>
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">User</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="../dashboard/dashboard.php">Mi perfil</a>
                  <hr>
                  <a class="dropdown-item" href="../conn/logout.php">Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content-header content-header-lg">
        <div class="row">
          <div class="col-md-12 text-right" id="ConfButton">
            <div >
              
            
            </div> 
          </div>
          </div>
        </div>
      <div class="content">
        <div class="row justify-content-md-center" id="product_updated">
          <div class="col-md-12">
            <div class="card"> 
            <form enctype ="multipart/form-data" class="form text-center" method="POST" role="form">
              <div class="group">
                
                <h4>Ejemplo de importacion</h3>
                <p>Es necesario que la primera linea este vacia o contenga los campos a los que va dirigida la informacion, la informacion tiene que estar 
                como el siguiente formato</p>
                <table width="100%" class="table">
                <thead class="thead-dark">
                    <tr>
                      <th scope="col">Numero de pedimento</th>
                      <th scope="col">Fecha declarada</th>
                      <th scope="col">Cantidad</th>
                      <th scope="col">Producto</th>
                      <th scope="col">Valor</th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr>
                  <td>894324564</td>
                  <td>9/1/2018 2:45</td>
                  <td>52</td>
                  <td>TUX.17</td>
                  <td>1500</td>
                  </tr>
                  </tbody>
                </table>
                <p>Descargar Formato: <a href="../downloads/csv_ingoing.csv">csv_ingoing.csv</a></p>
                <h4>Ingrese el Csv a importar</h4>
                <input type="file" name="file" id="file" value size="150" accept=".csv"> 
                <button class="btn btn-sm btn-info" type="submit" name="import" value="import" ><i class="fas fa-edit"></i> &nbsp;Importar Csv</button>  
                <?php echo $msg; ?>
              </div>
              
            </form>     
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav>
            <ul>
              <li>
                <a href="https://www.spaceshift.com">
                  Space Shift
                </a>
              </li>
              <li>
                <a href="#">
                  Acerca de nosotros
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, Designed by
            <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by
            <a href="https://www.spaceshift.com" target="_blank">Space Shift</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../../assets/js/core/jquery.min.js"></script>
  <script src="../../assets/js/core/popper.min.js"></script>
  <script src="../../assets/js/core/bootstrap.min.js"></script>
  <script src="../../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Adu JS -->
  <script src="../../assets/js/adu.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Custom Script -->
  <script type="text/javascript">
  </script>
</body>

</html>