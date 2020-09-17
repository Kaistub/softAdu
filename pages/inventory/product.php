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
      $sql_product = 'SELECT DISTINCT  * FROM tariff INNER JOIN product ON tariff.tariff_product = 
      product.product_id INNER JOIN measure ON product.product_unitmeasure = measure.measure_id INNER JOIN product_type ON product.product_type =
       product_type.protype_id WHERE  tariff.tariff_product="'.$productCheck.'" AND tariff_state != 0 ' ;
       
       $sql_product2 = 'SELECT DISTINCT  * FROM tariff INNER JOIN product ON tariff.tariff_product = 
       product.product_id INNER JOIN measure ON product.product_unitmeasure = measure.measure_id INNER JOIN product_type ON product.product_type =
        product_type.protype_id WHERE  tariff.tariff_product="'.$productCheck.'" AND tariff_state != 0 ORDER BY tariff.tariff_date' ;
      $result_product = $conn->query($sql_product);
      $result_product2 = $conn->query($sql_product2);


      while ($row = mysqli_fetch_array($result_product)){ 
        $id = $row['product_id']; 
        $tariff = $row['tariff_num'];
        $desc = $row['product_desc'];
        $measure = $row['measure_desc'];
        $prodtype = $row['protype_desc'];
        $qty = $row['tariff_qty'];
        $value = $row['tariff_value'];
        $date = $row['tariff_date'];
        $tariffid = $row['tariff_id'];
      break;
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
          <li class="active">
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
              <p class="navbar-brand" >Descripc&iacute;on del producto</p>
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
              <button type="button" type="submit" class="btn btn-reddark" onclick="update_product()"><i class="fas fa-edit"></i> &nbsp;Editar Producto</button>
            <button type="button" class="btn btn-delete" data-toggle="modal" data-target="#confirmdelete"><i class="fas fa-times" ></i> &nbsp;Eliminar Producto</button>
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
                  <p>¿Esta seguro de eliminar el producto <?php echo $id; ?> ?</p>
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
                      echo '<h2 class="pdleft-1 pdtop-1">Error. El Producto&nbsp;'.$productCheck.'&nbsp;no fue encontrado o no existe material en existencia para este .<br> </h2>.
                      ';
                    }else{
                    ?>
                    <div class="col-md-2 text-left">
                      <img id="img" name= "img" src="../../assets/img/<?php 
                      //Load image
                      if (file_exists('../../assets/img/product/'.$id.'.jpg')) {
                        echo 'product/'.$id;
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
                            <td style="width: 5px;"><em><strong>&nbsp;Fracci&oacute;n Arancelaria</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                            <input type="text" name="fracArancel" id="fracArancel" class="form-control f50" aria-label="Default" 
                               value="<?php echo $tariff; ?>"  disabled>
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Tipo de producto</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="tipop" id="tipop" class="form-control f50" aria-label="Default" 
                               value="<?php echo $prodtype; ?>"  disabled>
                              </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Cantidad disponible</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="cactual" id="cactual" class="form-control f50" aria-label="Default" 
                               value="<?php echo $qty; ?>"  disabled>  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Unidad de medida</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="measure" id="measure" class="form-control f50" aria-label="Default" 
                               value="<?php echo $measure; ?>"  disabled >  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Valor</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="valor" id="valor" class="form-control f50" aria-label="Default" 
                               value="<?php echo $value; ?>"  disabled>  
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Fecha de registro</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                            <select class="form-control f50" name="dates" id="dates">
                               <?php 
                               
                               while ($row2 = mysqli_fetch_array($result_product2)){ 
                                $datex =$row2['tariff_id'];
                                if ($tariffid == $datex) {
                                  $varyues = 'selected';}else {$varyues = '';}
                                 echo '<option value="'.$row2['tariff_id'].'"'. $varyues.'>'.$row2['tariff_date'].'</option>';
                                } ?>
                               </select>
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
   //POST TO UPDATE PHP FILE 
   function loadNew(){
    $.ajax({
               type: "POST",
               url: "../queries/loadnew.php",
               data: {
                  product_tariff:$('#fracArancel').val(),
                  product_date:$('#dates').val(),
                  product_id:'<?php echo ''.$id.'' ?>'

               },
               success: function (data) {
                  $('#product_updated').html(data);

               }
            });
   }
         function update_product(){
            $.ajax({
               type: "POST",
               url: "../queries/EditProduct.php",
               data: {
                  product_id:'<?php echo ''.$id.''; ?>',
                  product_tariff:$('#fracArancel').val(),
                  product_desc:'<?php echo ''.$desc.''; ?>',
                  product_unitmeasure:$('#measure').val(),
                  product_type:$('#tipop').val(),
                  product_qty:$('#cactual').val(),
                  product_value:$('#valor').val(),
                  product_date:$('#dates').val()
                  
               },

               success: function (data) {
                  $('#product_updated').html(data);

               }
            });
            $.ajax({
               type: "POST",
               url: "../queries/DescValue.php",
               data: {
                  desc: 'Editar Producto'
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
                  func: "document.location.href='../inventory/product.php?prod_name=<?php echo $id ?>'"
               },

               success: function (data) {
                  $('#ConfButton').html(data);
               }
            });
         };
    function Updateprd(data) {
      $.ajax({
               type: "POST",
               url: "../queries/updateProduct.php",
               data: {
                  product_id:'<?php echo ''.$id.''; ?>',
                  product_tariff:$('#fracArancel').val(),
                  product_desc:'<?php echo ''.$desc.''; ?>',
                  product_unitmeasure:$('#measure').val(),
                  product_type:$('#tipop').val(),
                  product_qty:$('#cactual').val(),
                  product_value:$('#valor').val(),
                  product_date:$('#dates').val(),
                  product_oldtariff:'<?php echo ''.$tariff.''; ?>',
                  product_oldqty:'<?php echo ''.$qty.''; ?>',
                  tariff_id: "<?php echo $tariffid; ?>"

               },
               success: function (data) {
                alert('Producto Actualizado.');
                document.location.href='../inventory/product.php?prod_name=<?php echo $id ?>';
               }
            });
    }
    function deleteprod(argument) {
        $.ajax({
               type: "POST",
               url: "../queries/deleteProduct.php",
               data: {
                 prodid:'<?php echo $id ?>'
               },
               success: function (data) {
                alert('Producto Eliminado.');
                document.location.href='../inventory/inventory.php';
               }
            });
      }
      function check() {
          alert('<?php echo ''.$id.''; ?>');
           alert($('#fracArancel').val());
           alert('<?php echo ''.$desc.''; ?>');
           alert($('#measure').val());
           alert($('#tipop').val());
           alert($('#cactual').val());
           alert($('#valor').val());
           alert($('#dates').val());
      }
  </script>
</body>

</html>