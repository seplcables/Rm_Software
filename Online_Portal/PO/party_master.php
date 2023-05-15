<?php
session_start();
	if(isset($_POST['p_master']))
	{
		include('..\..\dbcon.php');
		
		$party_name= $_POST['party_name'];
		$place= $_POST['place'];
		$party_address= $_POST['party_address'];
		$p_code= $_POST['p_code'];
		$GSTIN= $_POST['GSTIN'];
		$con_no= $_POST['con_no'];
		$con_per= $_POST['con_per'];
		$created_by= $_SESSION['oid'];

		$query = "INSERT INTO rm_party_master(party_name,place,party_address,p_code,GSTIN,created_by,Contact_No,Contact_Person) VALUES ('$party_name','$place','$party_address','$p_code','$GSTIN','$created_by','$con_no','$con_per')";
		$run = sqlsrv_query($con,$query);
		if($run == true)
		{
			?>
		<script>
		alert('Party Added Successfully!!');
		window.open('adddata.php','_self');
		</script>
		<?php
		}
		else{
			print_r(sqlsrv_errors());
			echo "Errorrr!!!";
			
		}
	}
	else{
		
	}
	
?>