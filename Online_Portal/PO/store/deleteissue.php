<?php
	session_start();
	$uname = $_SESSION['oid'];
	$sid = $_GET['sid'];
	if ($uname == 'Rajnish' || $uname == 'suresh') {
		include('..\..\..\dbcon.php');
		$query = "DELETE FROM rm_issue WHERE id='$sid'";
		$run = sqlsrv_query($con,$query);
		if($run == true)
		{
		?>
           <script>
              alert('Data Deleted Successfully!!');
              window.open('issue_rep.php','_self');
           </script>
        <?php
			
		}
	
	}
	else{
		?>
           <script>
              alert("You Can't Delete this!!");
              window.open('issue_rep.php','_self');
           </script>
         <?php
			
		}
		
	
?>