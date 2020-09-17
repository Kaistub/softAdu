<?php
 include '../conn/conn.php';

 $measure_id = $_POST['measure_id'];
 $sql_measure='DELETE FROM measure WHERE measure_id="'.$measure_id.'";';
 
 $result_measure =  $conn->query($sql_measure);




?>