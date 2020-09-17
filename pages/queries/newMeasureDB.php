<?php

include '../conn/conn.php';
if(session_id() == '') {
 session_start();}
 if (!$_SESSION['user']) {
   header("Location: /");
}

$measure_name = $_POST['measure_name'];
$measure_desc =$_POST['measure_desc'];
$exist=false;
$sql_measureExiste='SELECT * FROM measure WHERE measure_name="'.$measure_name.'";';
$sql_measure='INSERT INTO measure VALUE(null,"'.$measure_name.'","'.$measure_desc.'");';

$result_exist =  $conn->query($sql_measureExiste);
$rdw_cnt =  mysqli_num_rows($result_exist);
if ($rdw_cnt == 0) {
    $exist=true;
    $result_insert =  $conn->query($sql_measure);
}
mysqli_close($conn);
?>