<?php 
	//Include connection file
	include '../conn/conn.php';

	//Get page Buttons
	$edit = $_POST['btn1'];
	$cancel = $_POST['btn2'];
	$func = $_POST['func'];

	mysqli_close($conn);
?>        
          
  <div id="ConfButton">
      
    <button type="button" class="btn btn-delete" onclick="<?php echo $func ?>"><i class="fas fa-times"></i> &nbsp;<?php echo $cancel; ?></button>
  </div> 