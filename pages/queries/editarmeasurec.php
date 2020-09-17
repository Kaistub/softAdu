<?php
include '../conn/conn.php';

$measure_id = $_POST['measure_id'];
$measure_name = $_POST['measure_name'];
$measure_desc = $_POST['measure_desc'];


$sql_measure='UPDATE measure SET measure_name="'.$measure_name.'", measure_desc="'.$measure_desc.'" WHERE measure_id='.$measure_id.';';

$result_measure =  $conn->query($sql_measure);


?>

<div>
    <?php echo "".$measure_name.""?>
</div>