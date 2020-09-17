<?php
include '../conn/conn.php';

$bom = $_POST['bom'];
$approval =$_POST['approval'];

echo $bom;

mysqli_close($conn);

?>

<div class="col-md-12">
  <form>
    <div class="card">
       <div class="col-md-10 pdtop-0 text-left">
          <h2><?php echo $approval;?></h2>
        </div>
        <div class="col-md-12 pdtop-1">

        </div>
    </div>
  </form>
</div>
