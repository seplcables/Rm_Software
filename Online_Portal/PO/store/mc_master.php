<?php
session_start();
	if(isset($_POST['mc_master']))
	{
		include('..\..\..\dbcon.php');
		
		$Mc_name= $_POST['Mc_name'];
		$dpnt= $_POST['dpnt'];
		$superwizer= $_POST['superwizer'];
		$plant= $_POST['plant'];
		$created_by= $_SESSION['oid'];

		$query = "INSERT INTO mc_master(mc,dpnt,superwizer,plant,created_by) VALUES ('$Mc_name','$dpnt','$superwizer','$plant','$created_by')";
		$run = sqlsrv_query($con,$query);
		if($run == true)
		{
			?>
		<script>
		alert('Mc Added Successfully!!');
		window.open('rm_issue.php','_self');
		</script>
		<?php
		}
		else{
			echo "Errorrr!!!";
			
		}
	}
	else{
		
	}
	
?>