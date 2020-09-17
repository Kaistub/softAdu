<?php
include '../conn/conn.php';
if(session_id() == '') {
 session_start();}
 if (!$_SESSION['user']) {
   header("Location: /");
}


$userid = $_POST['user_id'];
$name = $_POST['user_rname'];
$lastName = $_POST['user_lname'];
$userName = $_POST['user_name'];
$userPsw = $_POST['user_psw'];
$userlvl = $_POST['user_lvl'];


$sql_user = 'UPDATE user SET user_name="'.$name.'", user_lastname="'.$lastName.'" ,user_username="'.$userName.'" ,user_psw="'.$userPsw.'" ,user_level='.$userlvl.' WHERE user_id='.$userid.';';
$result_user =  $conn->query($sql_user);

?>