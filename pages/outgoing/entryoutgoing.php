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
      
      //Load Values
      $sql_product = 'SELECT * FROM product INNER JOIN outgoing ON product.product_id = outgoing.outgoing_product INNER JOIN measure ON outgoing.outgoing_measure = measure.measure_id WHERE outgoing_pednum="'.$productCheck.'"';
      $result_product = $conn->query($sql_product);
      $row = mysqli_fetch_assoc($result_product);


      $pednum = $row['outgoing_pednum']; 
      $pedkey = $row['outgoing_pedkey'];
      $peddate =  $row['outgoing_peddate'];
      $qty = $row['outgoing_qty'];
      $id = $row['outgoing_product'];
      $tariff = $row['outgoing_tariff'];
      $measure = $row['outgoing_measure'];
      $prod_name = $row['product_desc']; 
      $measureUnit = $row['measure_name'];
      $value = $row['outgoing_value']; 
      //echo "<script>alert('".$tariff."')</script>";
      $sql_pednum = 'SELECT DISTINCT pednum_desc FROM pednum WHERE pednum_id="'.$pednum.'"';
      $result_pednum = $conn->query($sql_pednum);
      $rew = mysqli_fetch_assoc($result_pednum);

      $sql_tar = 'SELECT DISTINCT tariff_num FROM tariff WHERE tariff_id ="'.$tariff.'"';
      $result_tar = $conn->query($sql_tar);
      $raw = mysqli_fetch_assoc($result_tar);

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
          <li>
            <a href="../ingoing/ingoing.php">
              <i class="fas fa-file-alt"></i>
              <p>Entradas</p>
            </a>
          </li>
          <li class="active">
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
              <p class="navbar-brand" >Entradas</p>
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
              <button type="button" type="submit" class="btn btn-info" onclick="Updateprd()"><i class="fas fa-edit"></i> &nbsp;Editar</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmdelete"><i class="fas fa-times" ></i> &nbsp;Eliminar</button>
            </div> 
          </div>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="confirmdelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Atencion!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>¿Esta seguro de eliminar el registro con numero de pedimento #<?php echo $rew['pednum_desc']; ?> ?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="button" onclick="deleteprod()" class="btn btn-primary">Eliminar</button>
                </div>
              </div>
            </div>
          </div>
                  </div>
      <div class="content">
        <div class="row" id="product_updated">
          <div class="col-md-12">
            <div class="card">
              <div class="row pdtop-1 pdleft-1">
                    <div class="col-md-12 pdtop-0 text-center">
                      <h2><?php echo 'Pedimento &nbsp#'.$rew['pednum_desc'].' - &nbsp;'.$prod_name.''; ?></h2>
                    </div> 
                    <div class="col-md-12 pdtop-1">
                      <table style="height: 100%; width:100%;" class="table table-sm">
                        <tbody>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Clave de pedimento</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" class="form-control f50" aria-label="Default" 
                               value="<?php echo $pedkey; ?>"  disabled>
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Fecha de pedimento</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" class="form-control f50" aria-label="Default" 
                               value="<?php echo $peddate; ?>"  disabled>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Producto</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" class="form-control f50" aria-label="Default" 
                               value="<?php echo $id; ?>"  disabled>  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Cantidad</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" class="form-control f50" aria-label="Default" 
                               value="<?php echo $qty; ?>"  disabled>  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Tarifa Arancelaria</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" class="form-control f50" aria-label="Default" 
                               value="<?php echo $raw['tariff_num']; ?>"  disabled>  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Unidad de medida</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" class="form-control f50" aria-label="Default" 
                               value="<?php echo $measureUnit ; ?>"  disabled>  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Valor</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" class="form-control f50" aria-label="Default" 
                               value="<?php echo $value ; ?>"  disabled>  
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

              </div>
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
   //POST TO UPDATE PHP FILE 
       
    function Updateprd(data) {
      $.ajax({
               type: "POST",
               url: "../queries/editOutry.php",
               data: {
                  pednum:'<?php echo $pednum ?>',
                  pedkey:'<?php echo $pedkey ?>',
                  peddate:'<?php echo $peddate ?>',
                  qty:'<?php echo $qty ?>',
                  id:'<?php echo $id ?>',
                  tariff:'<?php echo $tariff ?>',
                  measure:'<?php echo $measure ?>',
                  prod_name:'<?php echo $prod_name ?>', 
                  measureUnit:'<?php echo $measureUnit ?>',
                  value: '<?php echo $value ?>'

               },
               success: function (data) {
                $('#product_updated').html(data);
               }
            });
      $.ajax({
               type: "POST",
               url: "../queries/DescValue.php",
               data: {
                  desc: 'Editar entrada'
               },

               success: function (data) {
                  $('#DescPage').html(data);
               }
            });
            $.ajax({
               type: "POST",
               url: "../queries/ChangeButtons.php",
               data: {
                  btn1: 'Aceptar Cambios',
                  btn2: 'Cancelar',
                  func: "document.location.href='../outgoing/entryoutgoing.php?outgoing_name=<?php echo $pednum ?>'"
               },

               success: function (data) {
                  $('#ConfButton').html(data);
               }
            });
    }
    function deleteprod(argument) {
        $.ajax({
               type: "POST",
               url: "../queries/deleteOutry.php",
               data: {
                 prodid: ('#numped').val()
               },
               success: function (data) {
                alert('Producto Eliminado.');
                document.location.href='../inventory/inventory.php';
               }
            });
        function toCsv(argument) {
      document.location.href='../outgoing/outgoingbm.php';
    }
      }
    
  </script>
</body>

</html>