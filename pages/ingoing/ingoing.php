<?php 
  //Include connection file 
   include '../conn/conn.php';
   if(session_id() == '') {
    session_start();}
    if (!$_SESSION['user']) {
      header("Location: /");
   }
      //Check Values Values
      $url = $_SERVER["QUERY_STRING"];
      $separatedURL = explode("=", $url);
      $productCheck = $separatedURL[1];

      $sql_login = 'SELECT DISTINCT * FROM ingoing INNER JOIN tariff ON ingoing.ingoing_tariff = tariff.tariff_id INNER JOIN measure ON measure.measure_id = ingoing.ingoing_measure INNER JOIN pednum ON pednum.pednum_id = ingoing.ingoing_pednum ORDER BY pednum.pednum_desc ' ;
      $result_login = $conn->query($sql_login);

      //close Session
      mysqli_close($conn);

 ?>

<!DOCTYPE html>
<html lang="es-mx">

<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="../../assets/img/logo.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Entradas - SoftAdu
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
              <p class="navbar-brand" >Entradas</p>
            </div>
            
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" id="sProduct" name="sProduct" placeholder="Buscar...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="fas fa-search"></i>
                  </div>
                </div>
              </div>
            </form>
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
              <button type="button" type="submit" class="btn btn-reddark" onclick="toCsv()"><i class="fas fa-edit"></i> &nbsp;Importar entradas</button>
            <button type="button" class="btn btn-reddark" onclick="newEntry()"><i class="fas fa-plus"></i> &nbsp;Nueva Entrada</button>
            </div> 
          </div>
          </div>
          <!-- Modal -->
        </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12" id="product_updated">
            <div class="card">
              <h3>Reporte por fecha</h3>
                  <form action="">
                      <div class="row justify-content-md-center">
                        <div class="form-group">
                          <h5>Desde</h5>
                          <input class="form-control mb-2 mr-sm-2" type="date" name="startDate" id="startDate">
                        </div>
                        <div class="form-group">
                          <h5>Hasta</h5>
                          <input class="form-control mb-2 mr-sm-2" type="date" name="endDate" id="endDate">
                        </div>
                        <div class="form-group">
                          <button type="button" class="btn btn-primary" onclick="reportDate()">Generar Reporte</button>
                        </div>
                      </div>
                </div>
                </form>
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
                <tbody id="sTProduct">
                  <?php 
                  while ($row = mysqli_fetch_array($result_login )){
                      $pednum = $row['ingoing_pednum'];
                      echo '<tr class="" data-href="entryingoing.php?ingoing_name='.$pednum.'">';
                      echo '<td>' .''.$row['pednum_desc'].'</td>';
                      echo '<td>' .''.$row['ingoing_pedkey'].'</td>';
                      echo '<td>' .''.$row['ingoing_peddate'].'</td>';
                      echo '<td>' .''.$row['ingoing_product'].'</td>';
                      echo '<td>' .''.$qty = $row['ingoing_qty'].'</td>';
                      echo '<td>' .''.$row['tariff_num'].'</td>';
                      echo '<td>' .''.$row['measure_desc'].'</td>';
                      echo '<td>' .''.$row['ingoing_value'].'</td>';
                      echo '</tr>';

                  }  ?>
                </tbody>
              </table>
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
              document.write(new Date())
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
    function toCsv() {

      document.location.href='../ingoing/ingoingbm.php';
    }
    function newEntry() {
      $.ajax({
               type: "POST",
               url: "../queries/newEntry.php",
               data: {
                  

               },
               success: function (data) {
                 $('#product_updated').html(data);
               }
            }
            );
    $.ajax({
               type: "POST",
               url: "../queries/DescValue.php",
               data: {
                  desc: 'Nuevo Producto'
               },

               success: function (data) {
                  $('#DescPage').html(data);
               }
            });
    $.ajax({
               type: "POST",
               url: "../queries/ChangeButtons.php",
               data: {
                  btn2: 'Cancelar',
                  func: "document.location.href='../ingoing/ingoing.php'"
               },

               success: function (data) {
                  $('#ConfButton').html(data);
               }
            });
    }
    function insertEntry(){
     
             $.ajax({
               type: "POST",
               url: "../queries/insertEntry.php",
               data: {
                  pednum:$('#npedi').val(),
                  pedkey:'IN',
                  peddate:$('#date').val(),
                  prod_name:$('#pdt').val(), 
                  qty:$('#qtyy').val(),
                  tariff:$('#fracArancel').val(),
                  measure:$('#measures').val(),
                  value:$('#value2').val()

               },
               success: function (data) {
                $('#product_updated').html(data);
                document.location.href='../ingoing/ingoing.php';
               }
            });
    }

    function reportDate(){
      if(!$('#startDate').val() || !$('#endDate').val()){
        alert("Seleccione los rangos de fecha para generar el reporte");
      }else{
       
       $.ajax({
          type: "POST",
          url: "../queries/ingoingReport.php",
          data: {
            start_date:$('#startDate').val(),
            end_date:$('#endDate').val()

          },

          success: function (data) {
            $('#product_updated').html(data);
          }
      });
     }
    }


  </script>

</body>

</html>