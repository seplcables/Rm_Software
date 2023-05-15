<?php
session_start();
if ($_SESSION['oid'] =='snehal' || true) {
    ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Bill_Approve</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />


        <script src="https://momentjs.com/downloads/moment.min.js"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.10.13/sorting/datetime-moment.js"></script>

        <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />

		<style type="text/css" media="screen">
			input.largerCheckbox {
		transform : scale(2);
		}
		#trow th{
		background-color: yellow;
		text-align: center;
		}
		.processrow{
        font-weight: bold;
        background-color: #bfc7c1;
        border-color: red;
        text-align: center;
    }

		.HOME{
        background-color: #ffcc00 !important;
    }
     .job_work{
        background-color: #00ff80 !important;
    }
     .approve_bill{
        background-color: #0066ff !important;
        color: white !important;
    }
    .approved_bill{
        background-color: #b82b2b !important;
        color: white !important;
    }
    .view{
    		background-color: #5cb85c !important;
        color: white !important;
    }
    .upload
    {
    	width:190px;
		font-size: 13px;
		color: black;
    }
    .showbtn{
    	width:30px;
		font-size: 12px;
    }
    td{
    	white-space: nowrap;
    }
    input[type=file] {
    	display: inline;
	}
    </style>
    
 </head>
	<body>
		<br>
		<div class="table-responsive m-1">
			<form id="form">
			<table class="table table-bordered table-striped" id="employee_data">
				<thead>
				<tr id="trow">
					<th>Receive Date</th>
					<th>Rmta</th>
					<th>Party</th>
					<th>Bill No.</th>
					<th>Bill Date</th>
					<th>mat_ord_by</th>
					<th>Bill amt</th>
					<th>Upload</th>
					<th>Ctrl</th>
				</tr>
			</thead>
				<?php
                include('..\..\..\dbcon.php');
    $mat_ord_by = $_SESSION['oid'];
    $sql="SELECT * from inward_com where bill_send = 1 AND bill_receive= 1 AND bill_approve = 0 AND mat_ord_by like '%".$mat_ord_by."%' ORDER BY receive_time desc";
    $run=sqlsrv_query($con, $sql);
    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $run1=sqlsrv_query($con, $sql, $params, $options);
    $row1=sqlsrv_num_rows($run1);
    if ($row1 > 0) {
        ?>
				<?php
                while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
                    $sql2="SELECT * from rm_party_master where pid='".$row['mat_from_party']."'";
                    $run2=sqlsrv_query($con, $sql2);
                    $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC); ?>
				<tr class="text-center font-italic" id="<?php echo $row["sr_no"].$row['receive_at']; ?>">
					<td><?php echo $row['receive_date']->format('d.M.Y'); ?></td>
					<td><?php echo $row['sr_no']."_(".$row['receive_at'].")"; ?></td>
					<td><?php echo $row2['party_name']; ?></td>
					<td><?php echo $row['invoice_no']; ?></td>
					<td><?php echo $row['invoice_date']->format('d.M.Y'); ?></td>
					<td><?php echo $row['mat_ord_by']; ?></td>
					<td><?php echo (float)$row['total_bill_amt']; ?></td>
				    <td class="text-left" style="width:15%;"><input type="file" name="upload[]" accept=".pdf" id="upload" class="upload mx-2">
					<?php
                        if ($row['invoice_aprove'] != null) {
                            ?>
						<button type="button" class="btn btn-primary mx-2" class="showbtn" onclick="return popitup('Invoice/<?php echo $row['invoice_aprove']; ?>')"><i class="fa fa-eye"></i></button>
						<?php
                        } ?>
					</td>
					<td><input type="checkbox" name="" class="largerCheckbox" value="<?php echo $row["sr_no"].$row['receive_at']; ?>" /><input type="hidden" name="value[]" class="value"></td>
				</tr>
				<?php
                } ?>
				<?php
    } else {
    } ?>
			</table>
			</form>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#employee_data').DataTable({
					dom: 'Bfrtip',
					ordering:false,
					lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
   buttons: [
    'pageLength', 'excel',

            {
                text: 'HOME',"className": 'HOME',

                action: function () { 
                  window.open("../../dashboard.php","_self");  
               }
             },

                          {
                text: 'APPROVE BILL',"className": 'approve_bill',
                action: function () { 
                   		if(confirm("Are you sure you want to Approve this?"))
												{
												var form = document.getElementById('form');
												var formData = new FormData(form);
												var id = [];

												$(':checkbox:checked').each(function(i){
												id[i] = $(this).val();
												});
												if(id.length === 0) //tell you if the array is empty
												{
												alert("Please Select atleast one checkbox");
												}
												else
												{
												$.ajax({
												url:'approve_to_db.php',
												method:'POST',
												data: formData,
												processData: false,
												contentType: false,
												success:function(data)
												{
													console.log(data);
												for(var i=0; i<id.length; i++)
												{
													$('tr#'+id[i]+'').css('background-color', '#ccc');
													$('tr#'+id[i]+'').fadeOut('slow');
												}
											},
										 complete:function()
										 {
											 location.reload(true);
										 }

												});
												}

												}
												else
												{
												return false;
										}
               }
             },

                      {
                text: 'VIEW ALL',"className": 'view',
                action: function () { 
                     window.open("uploadInvoice.php","_self");
                 }
               },
               {
                text: 'APPROVED BILL',"className": 'approved_bill',
                action: function () { 
                     window.open("approved_bill.php","_self");
                 }
               }

   ],
   
				});

		});

			
				$(document).on('click','.largerCheckbox',function(){
					var x = $(this).val();
		            if($(this).prop("checked")){
		                $(this).closest('tr').find('.value').val(x);
		                 //$(this).closest('tr').find('.upload').attr('required',true);
		            }
		            else{
		                $(this).closest('tr').find('.value').val('');
		            }
		        });

		        function popitup(url) {
					newwindow=window.open(url,'_blank','height=500,width=500,left=300,top=50');
					if (window.focus) {newwindow.focus()}
					return false;
					}

		</script>
	</body>
</html>
<?php
} else {
        $_SESSION['utype'] = "You Are Not Authorized!!";
        header("location:..\..\dashboard.php");
    }
?>

