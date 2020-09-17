<?php 
  //Include connection file 
   include '../conn/conn.php';
   if(session_id() == '') {
    session_start();}
    if (!$_SESSION['user']) {
      header("Location: /");
   }

      $_SESSION['LevelAccess'];
      $sql_products = "SELECT * FROM saldos";
      $result_products = $conn->query($sql_products);
      $prodCheck = "";
      $rdw_cnt =  mysqli_num_rows($result_products);
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
    Inventario - SoftADU
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
  <!-- CSS Files -->
  <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../../assets/css/now-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
  <link href="../../assets/css/adu.min.css" rel="stylesheet" />
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
          <li class="active">
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
            <p class="navbar-brand" id="DescPage">Saldos</p>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <!--<form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" id="sProduct" name="sProduct" placeholder="Buscar...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="fas fa-search"></i>
                  </div>
                </div>
              </div>
            </form>-->
            <ul class="navbar-nav">
              
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Bienvenido, <?php echo $_SESSION['user'] ?>
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
            <form action="../queries/balanceReport.php" method="POST">
              <button type="submit" class="btn btn-primary">Generar Reporte</button>
            </form>
            
          </div>
          </div>
        </div>
        <div class="content">
        <div class="row" id="product">
          <div class="col-md-12">
            <div class="card">
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
            </div>
          </div>
        </div>
      </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          
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
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script type="text/javascript">
    function newprod() {
      $.ajax({
               type: "POST",
               url: "../queries/newproduct.php",
               data: {
                  

               },
               success: function (data) {
                 $('#product').html(data);
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
                  func: "document.location.href='../inventory/inventory.php'"
               },

               success: function (data) {
                  $('#ConfButton').html(data);
               }
            });
    }
    function InsertProd(data) {
      if ($('#isNewCheck').is(':checked')) {
        $.ajax({
               type: "POST",
               url: "../queries/InsertProd.php",
               data: {
                  prodid:$('#idprod').val(),
                  tariff:$('#newFracc').val(),
                  desc:$('#desc').val(),
                  measure:$('#measure').val(),
                  type:$('#tipop').val(),
                  qty:$('#cactual').val(),
                  img:$('#img').val(),
                  valor:$('#valor').val(),
                  date:$('#fdate').val()
               },
               success: function (data) {
                alert('El producto fue agregado exitosamente.');
                document.location.href='../inventory/product.php?prod_name='+$('#idprod').val();
               }
            });
      }else {
        $.ajax({
               type: "POST",
               url: "../queries/InsertProd.php",
               data: {
                  prodid:$('#idprod').val(),
                  tariff:$('#fracArancel').val(),
                  desc:$('#desc').val(),
                  measure:$('#measure').val(),
                  type:$('#tipop').val(),
                  qty:$('#cactual').val(),
                  img:$('#img').val(),
                  valor:$('#valor').val(),
                  date:$('#fdate').val()
               },
               success: function (data) {
                alert('El producto fue agregado exitosamente.2');
                document.location.href='../inventory/product.php?prod_name='+$('#idprod').val();
               }
            });
      }
    }
    function toCsv(argument) {
      document.location.href='../inventory/productbm.php';
    }
    function test(argument) {
      if ($('#isNewCheck').is(':checked')) {
        alert($('#idprod').val());
      alert($('#newFracc').val());
      alert($('#desc').val());
      alert($('#measure').val());
      alert($('#tipop').val());
      alert($('#cactual').val());
      alert($('#valor').val());
      }
      else{
      alert($('#idprod').val());
      alert($('#fracArancel').val());
      alert($('#desc').val());
      alert($('#measure').val());
      alert($('#tipop').val());
      alert($('#cactual').val());
      alert($('#valor').val());
      }
      
    }
  </script>
  


</body>

</html>