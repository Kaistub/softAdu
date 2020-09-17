<?php
include '../conn/conn.php';
if(session_id() == '') {
 session_start();}
 if (!$_SESSION['user']) {
   header("Location: /");
}


$user = $_POST['userid'];



$sql_user = 'DELETE FROM user WHERE user_id='.$user.'; ';
$result_user =  $conn->query($sql_user);

?>