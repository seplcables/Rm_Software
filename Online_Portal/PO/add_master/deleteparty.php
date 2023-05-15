<?php
	session_start();
	$uname = $_SESSION['oid'];
	$sid = $_GET['sid'];
	if ($uname == 'Rajnish') {
		include('..\..\..\dbcon.php');
		$query = "DELETE FROM rm_party_master WHERE pid='$sid'";
		$run = sqlsrv_query($con,$query);
		if($run == true)
		{
		?>
           <script>
              alert('Data Deleted Successfully!!');
              window.open('showparty.php','_self');
           </script>
        <?php
			
		}
	
	}
	else{
		?>
           <script>
              alert("You Can't Delete this!!");
              window.open('showparty.php','_self');
           </script>
         <?php
			
		}
		
	
?>