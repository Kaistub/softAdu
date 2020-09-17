<?php
include '../conn/conn.php';
if(session_id() == '') {
 session_start();}
 if (!$_SESSION['user']) {
   header("Location: /");
}


$name = $_POST['user_rname'];
$lastName = $_POST['user_lname'];
$userName = $_POST['user_name'];
$userPsw = $_POST['user_psw'];
$userPsw = $_POST['user_lvl'];




$sql_user = 'INSERT INTO user(user_id,user_name,user_lastname,user_username,user_psw,user_level)VALUE(0,"'.$name.'","'.$lastName.'","'.$userName.'","'.$userPsw.'",'.$userPsw.');';
$result_user =  $conn->query($sql_user);
mysqli_close($conn);
?>