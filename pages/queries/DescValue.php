<?php 
	//Include connection file
	include '../conn/conn.php';

	//Get page Desc
	$desc = $_POST['desc'];

	mysqli_close($conn);
?>        
          <div id="DescPage">
              <p class="navbar-brand" ><?php echo $desc; ?></p>
          </div>