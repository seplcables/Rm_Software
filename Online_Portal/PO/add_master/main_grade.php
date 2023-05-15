<?php
session_start();
if (!isset($_SESSION['user_type'])) {
    $_SESSION['utype'] = "You Are Not Authorized!!";
            header("location:..\..\dashboard.php");
  }
  
  else {
  	if (isset($_GET['c_code'])) {
  		$_SESSION['c_code']=$_GET['c_code'];
  	}
  	$c_code = $_SESSION['c_code'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>show_data</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


		<!-------------------------- CSS only ------------------>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		
		<!---------------------- JavaScript Bundle with Popper ------------------------------->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

		<!------------------------ BT-5 CSS -------------------------------------->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

		<!------------------------ BT-5 JS ---------------------------->
		<script src="https://momentjs.com/downloads/moment.min.js"></script>
		<script src="https://cdn.datatables.net/plug-ins/1.10.13/sorting/datetime-moment.js"></script>

	 <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

		<style type="text/css" media="screen">
			@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
			td{
				background-color: #e0f6f97a;
			}
			th{
				background-color: #607d8bab;
				font-size: 18px;
			}
			::-webkit-input-placeholder { /* Edge */
  					color: grey;
				}
			#cat{
					color: #003300;
      				font: italic small-caps bold 20px Georgia, serif;
			}	
			table{
				box-shadow: 0 7px 25px rgba(0, 0, 0, 0.2);
			}
			table tr th,tr td{
				border: 1px solid black;
			}
			.modal-footer,.modal-header{
				background-color:#00968833;
			}
		</style>
	</head>
<body>
	<div class="mt-2">
		<a href="category.php" class="btn btn-warning btn-lg font-weight-bold m-1 ml-5 px-5">Back</a>
		<!-- Trigger the modal with a button -->
		<button type="button" class="btn btn-info btn-lg font-weight-bold m-1" data-toggle="modal" data-target="#myModal">Add Main Grade</button>
		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
  			<div class="modal-dialog">
				<!-- Modal content-->
    			<div class="modal-content">
      				<div class="modal-header">
	      				<h4 class="modal-title font-weight-bold font-italic">Add Main Grade</h4>
	        			<button type="button" class="close" data-dismiss="modal">&times;</button>
      				</div>
      				<div class="modal-body text-white">
      					<form action="addmg_to_db.php" method="post" id="form">
	        				<input type="text" name="main_grade" class="form-control" id="main_grade" required>
	        				<input type="hidden" name="c_code" class="form-control" value="<?php echo $c_code ?>">
	    				</form>
      				</div>
      				<div class="modal-footer">
        				<input type="submit" name="submit" value="Submit" id="submit" class="btn btn-danger font-weight-bold w-25" form="form">
    				</div>
      			</div>
  			</div>
		</div>
	</div><br>
<?php if(isset($_SESSION['mess'])): ?>
	<div class="alert alert-primary font-weight-bold font-italic">
			<?php echo $_SESSION['mess']; ?>
	</div>
<?php unset($_SESSION['mess']); ?>
	<?php endif; ?>
	<div id="table-container">		
		<table id="mytable" align="center" border="1" class="border-danger border-bottom-0" style="width:95%; margin-top:10px;" >
			<tr class="bg-primary text-white text-center">
				<th>Sr No.</th>
				<th>Main Grade</th>
				<th>Add</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
					<?php
					include('..\..\..\dbcon.php');
					$sql="SELECT * from rm_m_grade where c_code='$c_code'";
					$run=sqlsrv_query($con,$sql);
					$sr = 0;
					while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
					$sr++;
					?>
			<tr class="text-center font-italic font-weight-bold trbody">
				<td style="width:3%"><?php echo $sr; ?></td>
				<td style="width:50%" class="main_grade"><?php echo $row['main_grade'];  ?></td>
				<td style="width:5%"><a href="sub_grade.php?m_code=<?php echo $row['m_code']; ?>" class="btn btn-info px-3 py-1 m-1"><i class="fa fa-plus"></i></a></td>
				<td style="width:5%"><!-- <a href="mgrade_edit.php?m_code=" class="btn btn-success px-3 py-1 m-1"><i class="fa fa-edit"></i></a> --><button type="button" id="<?php echo $row['m_code']; ?>" class="btn btn-success px-3 py-1 m-1 button"><i class="fa fa-edit"></button></td>
				<td style="width:5%"><a  onClick="return confirm('Please confirm deletion');" href="main_grade.php?m_code=<?php echo $row['m_code']; ?>" class="btn btn-danger px-3 py-1 m-1"><i class="fa fa-trash"></i></a></td>
			</tr>
				<?php } ?>
		</table>
	</div>
	<!-----------------------------------------  delivery Modal ----------------------------------------->
	   <div class="modal fade small" id="edit_modal" aria-labelledby="edit_modal" aria-hidden="true" tabindex="-1">
	            
	      <!----------------- Scrollable modal --------------------------->
	       <div class="modal-dialog modal-md modal-dialog-scrollable">
	          <div class="modal-content">
	              <div class="modal-header font-weight-bold">
	                <h4>Edit</h4>
	              	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
	              </div>
	              <div class="modal-body" id="edit_modal">
	                <div id="edit">
						<div class="form-group">
						<form action="main_grade.php" method="post" id="main">
	                      <label for="test" class="text-info">Main Grade Type:</label><br>
	                      <input type="text" name="mgrade" id="mgrade" class="form-control">
	                      <input type="text" name="m_code" id="m_code" class="form-control" readonly>
	                    </form>
                     </div>
					</div>
	              </div>
		         	    <div class="modal-footer">
		         	    	<input type="submit" name="submit" class="btn btn-info btn-md" value="Update" form="main">
		                  <!--  <button type="button" name="save" class="btn btn-primary btn-md px-4" id="send_delivery" >ADD</button> -->
		                </div>
	            	</div>
	        		</div>
	    		</div>
</body>
</html>
<script type="text/javascript">
	$(document).on('click','.button',function(){
			var m_code = $(this).attr('id');
			var magrade = $(this).closest('tr').find('.main_grade').text();
			$('#mgrade').val(magrade);
			$('#m_code').val(m_code);
			$('#edit_modal').modal('show');
		});
</script>


<?php
if (isset($_GET['m_code'])) {

	include('..\..\..\dbcon.php');
		$m_code = $_GET['m_code'];
		$query = "DELETE FROM rm_m_grade WHERE m_code='$m_code'";
		$run = sqlsrv_query($con,$query);
		if($run == true)
		{
			?>
				<script>
					alert("Data Deleted Successfully");
					window.open('main_grade.php','_self');
				</script>
			<?php			
		}
		else{
			?>
				<script>
					alert("Category's ID is Used In Foreign Key");
					window.open('main_grade.php','_self');
				</script>
			<?php
			
		  }
	}

	if(isset($_POST['submit']))
    {
        include('..\..\..\dbcon.php');
        $id= $_POST['m_code'];
        $mgrade= $_POST['mgrade'];
        
        $query = "UPDATE rm_m_grade SET main_grade = '$mgrade' WHERE m_code = '$id'";
        $run1 = sqlsrv_query($con,$query);
        if($run1 == true)
        {
          ?>
        <script>
			alert("Data Updated Successfully");
			window.open('main_grade.php','_self');
		</script>
		<?php
        }
        else{
            	print_r(sqlsrv_errors());
        }
    }

	}
?>