<?php 
  //Include connection file 
   include 'pages/conn/conn.php';
   date_default_timezone_set('America/Los_Angeles');
   if(session_id() == '') {
    session_start();
    $message='';

    //Sign in
   if (isset($_POST['btnlogin'])){
      $username = $_POST['u-mail'];
      $password = $_POST['u-password'];
      
      $sql_login = "SELECT * FROM user WHERE user_username='$username' AND user_psw='$password'";
      $result_login = $conn->query($sql_login);
   
      $row_login = mysqli_fetch_assoc($result_login);
   
      if (!$row_login) {
         $message = '<div class=" alert alert-danger" style="padding-top: 10 px;">
                 <p> Usuario o contraseña incorrectos. Intente de nuevo </p>
               </div>';
      }else {
           $message = '';
         session_start();
         $date = date("Y-m-d", strtotime('now'));
         
         $_SESSION['username'] = $row_login['user_name'];
         $_SESSION['user']= $username;
         $_SESSION['company']= $row_login['user_company'];
         $_SESSION['id']= $row_login['user_id'];
         $_SESSION['LevelAccess'] = $row_login['user_level'];
         $userid =  $_SESSION['id'];
         $theip = $_SERVER['REMOTE_ADDR'];
         $sql_lastLogin = "UPDATE user set user_lastlogin = '$date', user_lastip = '$theip' WHERE `user_id` ='$userid'";
         $result_lastlogin = $conn->query($sql_lastLogin);
      }
   
   }
   if ($_SESSION['user']) {
    header("Location: pages/dashboard/dashboard.php");
 }
   }
 ?>
<html>
   <head>
    <meta charset="ISO-8859-1">
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Inicio - SoftADU
  </title>
      <link href="assets/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
      <link href="assets/css/adu.min.css" rel="stylesheet" id="bootstrap-css">
   </head>
   <body id="LoginForm">
      <div class="container">
         <h1 class="form-heading">Formulario de inicio</h1>
         <div class="login-form">
            <div class="main-div">
               <div class="panel">
                  <h2>Inicio</h2>
                  <p>Porfavor ingresa tu usuario y contrase&ntilde;a</p>
               </div>
               <form id="Login" method="POST">
                  <div class="form-group">
                     <input type="text" class="form-control" id="u-mail" name="u-mail" placeholder="Usuario">
                  </div>
                  <div class="form-group">
                     <input type="password" class="form-control" id="u-password" name="u-password" placeholder="Contrase&ntilde;a">
                  </div>
                  
                  <button type="submit" name="btnlogin" class="btn btn-primary">Entrar</button>
                  <?php echo $message?>
               </form>
            </div>
         </div>
      </div>
      </div>
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="http://www.cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   </body>
</html>