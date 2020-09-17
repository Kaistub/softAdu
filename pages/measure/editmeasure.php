<?php 
  //Include connection file 
   include '../conn/conn.php';
   if(session_id() == '') {
    session_start();}
    if (!$_SESSION['user']) {
      header("Location: /");
   }
   if ($_SESSION['LevelAccess'] != 3) {
    header("Location: /");
  }


      
      //Check Values Values
      $url = $_SERVER["QUERY_STRING"];
      $separatedURL = explode("=", $url);
      $measureCheck = $separatedURL[1];

      //Load Values
      $sql_measure = 'SELECT * FROM measure WHERE measure_id="'.$measureCheck.'";';
       $result_measure = $conn->query($sql_measure);



      while ($row = mysqli_fetch_array($result_measure)){ 
          $id=$row['measure_id'];
          $name=$row['measure_name'];
          $desc=$row['measure_desc'];
        
      break;
       }
       $sql_measureexist= 'SELECT * FROM product WHERE product_unitmeasure="'.$id.'";';
       $result_measureExist = $conn->query($sql_measureexist);

       $rdw_cnt =  mysqli_num_rows($result_measureExist);

       if($rdw_cnt>0){
        $approval=1;
       }else{
        $approval=0; 
       }


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
    Measure - SoftAdu
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
            echo '<li class="active">
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
              <p class="navbar-brand" >Descripc&iacute;on de la medida</p>
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
            <button type="button" class="btn btn-delete" data-toggle="modal" data-target="#confirmdelete"><i class="fas fa-times" ></i> &nbsp;Eliminar Medida</button>
            </div> 
          </div>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="confirmdelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Atencion!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>¿Esta seguro de eliminar esta medida <?php echo $id; ?> ?</p>
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
                  <?php
                   
                    if (!$row) {
                      echo '<h2 class="pdleft-1 pdtop-1">Error. La medida&nbsp;'.$measureCheck.'&nbsp;no fue encontrado encontrado <i class="far fa-sad-tear"></i><br> Por favor intente de nuevo. </h2>.
                      ';
                    }else{
                    ?>
                    <div class="col-md-2 text-left">
                      <img src="../../assets/img/<?php 
                      //Load image
                      if (file_exists('../../assets/img/product/'.$id.'.jpg')) {
                        echo 'medida/'.$id;
                      }else{
                        echo 'nophoto';
                      } ?>.jpg" alt="..." class="img-prod">
                    </div>
                    <div class="col-md-10 pdtop-0 text-left">
                      <h2><?php echo $id.' - '.$desc ?></h2>
                    </div> 
                    <div class="col-md-12 pdtop-1">
                      <table style="height: 100%; width:100%;" class="table table-sm">
                        <tbody>
                          <tr >
                            <td style="width: 5px;"><em><strong>&nbsp;Nombre de la medida</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                            <input type="text" name="measuName" id="measuName" class="form-control f50" aria-label="Default" 
                               value="<?php echo $name; ?>">
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Descripcion</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="descr" id="descr" class="form-control f50" aria-label="Default" 
                               value="<?php echo $desc; ?>"  >
                              </td>
                          </tr>
                          
                          <tr>
                            <td style="width: 172px;">&nbsp;
                               <button type="button " onclick="loadNew()" class="btn btn-reddark btn-sm">Actualizar</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                 <?php  }  ?>
                
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

        function deleteprod(){
            <?php 
            if ($approval==0) {
                echo"
                $.ajax({
                    type: 'POST',
                    url: '../queries/delmeasure.php',
                    data: {
                       measure_id:'$id'
                    },
                    success: function (data) {
                       alert('Borrado Exitosamente');
                       $('#product_updated').html(data); 
                       document.location.href='../measure/measure.php';                      
                       
                    } 
                    
                 });
                ";
            }else{
                echo "alert('Algunos productos dependen de esta medida y no puede ser borrada');";
            }
            
            ?>
            
        }

        function loadNew(){
            $.ajax({
               type: "POST",
               url: "../queries/editarmeasurec.php",
               data: {
                  measure_desc:$('#descr').val(),
                  measure_name:$('#measuName').val(),
                  measure_id:"<?php echo $id ?>"

               },
               success: function (data) {
                    alert("Editado Exitosamente");
                    $('#product_updated').html(data); 
                    document.location.href='../measure/measure.php';

               }
            });
        }
        function newMeasure(){
          $.ajax({
               type: "POST",
               url: "../queries/newMeasure.php",
               data: {
                  measure_desc:$('#descr').val(),
                  measure_name:$('#measuName').val(),
                  measure_id:"<?php echo $id ?>"

               },
               success: function (data) {
                    alert("Editado Exitosamente");
                    $('#product_updated').html(data); 

               }
            });
        }

    </script>



  