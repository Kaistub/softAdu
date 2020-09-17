<?php
  //Include connection file
   include '../conn/conn.php';
   if(session_id() == '') {
    session_start();}
    if (!$_SESSION['user']) {
      header("Location: /");
   }

      //Load Values
      $sql_product = 'SELECT DISTINCT product.product_id, product.product_desc FROM product INNER JOIN bom_inventory ON product.product_id = bom_inventory.bominv_product_id WHERE product.product_type=2';
      $result_product = $conn->query($sql_product);

      $sql_process = "SELECT DISTINCT * FROM process ";
      $result_process = $conn->query($sql_process);
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
    Proceso - SoftAdu
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

<body>
  <div class="wrapper " id="fetchall" name ="fetchall">
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
          <li class="active">
            <a href="../process/process.php">
              <i class="fas fa-project-diagram"></i>
              <p>Proceso</p>
            </a>
          </li>
          <li>
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
          <li >
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
              <p class="navbar-brand" >Proceso de producto</p>
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
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
              <button type="button" type="submit" class="btn btn-reddark" onclick="toCsv()"><i class="fas fa-edit"></i> &nbsp;Importar Procesos</button>
            <!-- <button type="button" class="btn btn-reddark" onclick="newEntry()"><i class="fas fa-plus"></i> &nbsp;Nuevo Proceso</button>-->
            </div> 
          </div>
          </div>
          <!-- Modal -->
        </div>
      <div class="content">
        <div class="row" id="product_updated">
        <div class="col-md-12">
            <form>
            <div class="card">
               <div class="col-md-10 pdtop-0 text-left">
                      <h2>Proceso de productos</h2>
                    </div>
                    <div class="col-md-12 pdtop-1">
                      <table style="height: 100%; width:100%;" class="table table-sm">
                        <tbody>
                          <tr >
                            <td style="width: 5px;"><em><strong>&nbsp;Seleccionar producto</strong></em></td>
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
            <div>
              <h3>Reporte por fecha</h3>
              <form action="">
                  <div class="row">
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
            <form>
              <div class="card">
                <table class="table table-sm table-hover table-dark ">
                  <thead>
                    <tr>
                      <th>Fecha de creacion</th>
                      <th>Producto Procesado</th>
                      <th>Cantidad de producto</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    while ($row = mysqli_fetch_array($result_process )){
                        $pednum = $row['process_id'];
                        echo "<tr class='' >";
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
            &copy;2018, Designed by
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
   //POST TO UPDATE PHP FILE
   
   function sendRequestOrder(){
     if (!$('#qty').val()) {
       alert('La cantidad a procesarse no puede ir vacia');
     }else{
      $.ajax({
        type: "POST",
        url: "../queries/checkStock.php",
        data: {
           product_id:$('#productCheck').val(),
           product_qty:$('#qty').val(),
           user:'<?php echo ''.$_SESSION['user'].''; ?>'

        },

        success: function (data) {
           $('#product_updated').html(data);
           document.location.href='../process/process.php';
        }
     });
     }
     
   }
   function toCsv() {
    document.location.href='procesbm.php';
   }
   function report(pid){
     alert("wea");
   }
   


   function reportDate(){
     if(!$('#startDate').val() || !$('#endDate').val()){
      alert("Seleccione los rangos de fecha para generar el reporte");
     }else{
       
       $.ajax({
          type: "POST",
          url: "../queries/procesoReporteGen.php",
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
