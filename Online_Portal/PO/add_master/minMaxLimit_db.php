<?php
	session_start();
	if(isset($_POST['submit']))
	{
		include('..\..\..\dbcon.php');
		
		$item_name= $_POST['item_name'];
		$i_code= $_POST['i_code'];
		$is_lmt= $_POST['is_lmt'];
		$min_limit= $_POST['min_limit'];
		$max_limit= $_POST['max_limit'];

		$query = "UPDATE rm_item set item = '$item_name',min_limit = '$min_limit',max_limit = '$max_limit',is_limit = '$is_lmt' where i_code='$i_code'";
		$run = sqlsrv_query($con,$query);
		if($run == true)
		{
		 ?>
             <script>
                  alert('Limit Set Successfully');
                  window.open('minMax_limit.php','_self');
            </script>
         <?php

			
		}
		else{
			print_r(sqlsrv_errors());
			
		}
	}
	
	
?>