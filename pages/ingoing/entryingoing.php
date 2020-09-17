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

      //Load Variables
      
      //Load Values
      $sql_product = 'SELECT * FROM product INNER JOIN ingoing ON product.product_id = ingoing.ingoing_product INNER JOIN measure ON ingoing.ingoing_measure = measure.measure_id WHERE ingoing_pednum="'.$productCheck.'"';
      $result_product = $conn->query($sql_product);
      $row = mysqli_fetch_assoc($result_product);


      $pednum = $row['ingoing_pednum']; 
      $pedkey = $row['ingoing_pedkey'];
      $peddate =  $row['ingoing_peddate'];
      $qty = $row['ingoing_qty'];
      $id = $row['ingoing_product'];
      $tariff = $row['ingoing_tariff'];
      $measure = $row['ingoing_measure'];
      $prod_name = $row['product_desc']; 
      $measureUnit = $row['measure_name'];
      $value = $row['ingoing_value']; 
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
               url: "../queries/editentry.php",
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
                  desc: 'Edotar entrada'
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
                  func: "document.location.href='../ingoing/entryingoing.php?ingoing_name=<?php echo $pednum ?>'"
               },

               success: function (data) {
                  $('#ConfButton').html(data);
               }
            });
    }
    function deleteprod(argument) {
        $.ajax({
               type: "POST",
               url: "../queries/deleteEntry.php",
               data: {
                 prodid: ('#numped').val()
               },
               success: function (data) {
                alert('Producto Eliminado.');
                document.location.href='../inventory/inventory.php';
               }
            });
        function toCsv(argument) {
      document.location.href='../ingoing/ingoingbm.php';
    }
      }
    
  </script>
</body>

</html>