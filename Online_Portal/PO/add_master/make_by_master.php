<?php 
session_start();
if (!isset($_SESSION['user_type'])) {
    $_SESSION['utype'] = "You Are Not Authorized!!";
            header("location:..\..\dashboard.php");
  }
  else {
  include('..\..\..\dbcon.php');

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    	
</head>
<body>
	<div class="container-fluid mt-3 p-0">
		<div class="row bg-info text-white" align="center"><h4>Make By (Master)</h4></div><br/>

		<div class="row"><div class="col-md-6 mx-2"><a href="../../dashboard.php" class="btn btn-warning mx-2">Back</a><a href="make_by_master.php" class="btn btn-secondary">Add New</a></div></div>
        <?php if(isset($_GET['id'])) 
        { 
            $sql1 = "SELECT MakebyIDP, Make_by from  rm_makeby_master where  MakebyIDP = '".$_GET['id']."'";
            $res1 = sqlsrv_query($con, $sql1);
            $row1 = sqlsrv_fetch_array($res1, SQLSRV_FETCH_ASSOC);
        ?>
        <form id="makebyupdatemaster">
            <div class="p-3">
            	<div class="container">
	                <div class="row border p-2">
	                    <h4 class="text-info">Update Make by</h4>
	                    <div class="col-md-4">
	                        <label class="form-label">Make By</label>
	                      <input type="text" name="makebyu" id="makebyu" class="form-control" placeholder="Make by Name" value="<?php echo $row1['Make_by']; ?>" required>
	                    </div>
	                    <div class="col-md-3" align="left">
	                        <label class="form-label"><br/>
	                            <input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>"> 
	                        <button type="button" class="btn btn-secondary mt-2 update">Update</button>
	                        </label>
	                    </div>
	                </div>
	             </div>
            </div>
        </form> 
    <?php } else { ?>

        <form id="makebyaddmaster">
            <div class="p-3">
            	<div class="container">
	                <div class="row border p-2">
	                    <h4 class="text-info">Add Make by</h4><br/>
	                    <div class="col-md-6">
	                        <label class="form-label">Make By</label>
	                      <input type="text" name="makeby"  id="makeby" class="form-control" placeholder="Make by Name" required>
	                    </div>
	                    <div class="col-md-2">
	                        <label class="form-label"><br/>
	                        <button type="button" class="btn btn-secondary mt-2 add">Add</button>
	                        </label>
	                    </div>
	                </div>
	            </div>
            </div>
        </form> 
    <?php } ?>

        <br/>
        <div align="center" class="col-md-6 d-flex" id="response_message" style="font-size: 20px;color:red;"></div>
        <div class="container-fluid" align="left">
        	<table  class="table table-bordered table-striped" width="100%"  id="tableaa">
                <thead>
                    <tr class="bg-info text-white font-weight-bold">
                        <td width="60px" align="center">
                            Sr No
                        </td>
                        <td width="200px" align="center">
                        	Make By
                        </td>
                        <td width="200px" align="center">
                            Action
                        </td>
                    </tr>
                 </thead>
                 <tbody>
                    <?php 
                    $count = 0;
                    $sql = "SELECT * from  rm_makeby_master where Status = '1'";
                    $res = sqlsrv_query($con, $sql);
                    while($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC))
                    {
                    	$count++;
                    ?>
					<tr>
                        <td align="center">
                            <?php echo $count; ?>
                        </td>
                        <td align="center">
                            <?php echo $row['Make_by']; ?>
                        </td>
                        <td align="center">
                            <a href="make_by_master.php?id=<?php echo $row['MakebyIDP']; ?>"><button class="btn btn-secondary">Edit</button></a>
                            <i class="fa fa-close btn btn-danger remove" data-id="<?php echo $row['MakebyIDP']; ?>"></i>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
    var table = $('#tableaa').DataTable({
      "processing": true, 
     ordering: true,
     destroy: true,
     dom: 'Bfrtip',
        
  lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
   buttons: [
    'pageLength','copy', 'excel',
    // Customize button datatable
      ]
  });
});


$(document).on('click','.add',function()
{
    var m = $("#makeby").val();
    if(m == "")
    {
        alert("Please Add Make by.");
    }
    else
    {
        if(confirm("Are you sure you want to Save this?"))
        {
           $.ajax({
                url: "make_by_master_db.php?status=0",
                type: 'post',
                data : $('#makebyaddmaster').serialize(),
                success: function(data) 
                {
                    alert(data);
                    window.location.href = 'make_by_master.php';
                }
            });
        }
    }        
});

$(document).on('click','.update',function()
{
    var m = $("#makebyu").val();
    if(m == "")
    {
        alert("Please Add Make by.");
    }
    else
    {
        if(confirm("Are you sure you want to Update this?"))
        {
           $.ajax({
                url: "make_by_master_db.php?status=1",
                type: 'post',
                //data : $('#tableaa').serialize(),
                data : $('#makebyupdatemaster').serialize(),
                success: function(data) 
                {
                    alert(data);
                    window.location.href = 'make_by_master.php';
                }
            });
        }
    
    }
});

$(document).on('click','.remove',function()
{
	var id = $(this).data('id');
   	if(confirm("Are you sure you want to Remove this?"))
    {
       $.ajax({
            url: "make_by_master_db.php?status=2",
            type: 'post',
            data : {id:id},
            success: function(data) 
            {
                alert(data);
                window.location.href = 'make_by_master.php';
            }
        });
    }
    
   
});

</script>

<?php } ?>