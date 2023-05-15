<?php
session_start();
if ($_SESSION['oid'] =='jignesh' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='amey')
{
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Store-Bill_Receive</title>
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
		#trow{
		background-color: yellow;
		text-align: center;
		}
		 .HOME{
        background-color: #ffcc00 !important;
    }
     .job_work{
        background-color: #00ff80 !important;
    }
     .receive_bill{
        background-color: #0066ff !important;
        color: white !important;
    }
    .view{
    		background-color: #5cb85c !important;
        color: white !important;
    }
		</style>
 </head>
	<body>
		<h3 class="bg-primary" align="center">BILL IN - Store</h3><br/>
		<div class="table-responsive m-1">
			<table class="table table-bordered table-striped table-sm" id="employee_data">
				<thead>
				<tr class="bg-dark text-white text-center font-italic" id="trow">
					<th>Send_Date</th>
					<th>Rmta</th>
					<th>Party</th>
					<th>Bill_No</th>
					<th>Bill_Date</th>
					<th>mat_ord_by</th>
					<th>Bill_amt</th>
					<th>memo_no</th>
					<!-- <th>Ctrl</th> -->
				</tr>
			</thead>
				<?php
				include('..\..\..\dbcon.php');
				$sql = " SELECT b.sr_no, b.receive_at, b.invoice_date, b.invoice_no, b.mat_from_party, b.mat_ord_by, b.total_bill_amt,   b.send_time, b.bill_out_store_memono from inward_ind a, inward_com b, po_entry_head c, po_entry_details d where a.sr_no = b.sr_no  and a.receive_at = b.receive_at and c.id = d.iid and a.iid = d.id and d.category <> '30'  and d.category <> '37' and b.receive_at = 'halol' and b.receive_date >= '2021-02-01' AND  b.bill_out_store = 1  group by b.sr_no, b.receive_at, b.invoice_date, b.invoice_no, b.mat_from_party, b.mat_ord_by, b.total_bill_amt,   b.send_time, b.bill_out_store_memono ORDER BY b.send_time desc";

				//$sql="SELECT * from inward_com where bill_send = 1 AND bill_receive = 0 ORDER BY send_time desc";
				$run=sqlsrv_query($con,$sql);
				$params = array();
				$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
				$run1=sqlsrv_query($con,$sql,$params,$options);
				$row1=sqlsrv_num_rows($run1);
				if ($row1 > 0) {
				?>
				<?php
				while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
				$sql2="SELECT * from rm_party_master where pid='".$row['mat_from_party']."'";
				$run2=sqlsrv_query($con,$sql2);
				$row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
				?>
				<tr class="text-center font-italic" id="<?php echo $row["sr_no"].$row['receive_at']; ?>">
					<td><?php echo $row['send_time']->format('d.M.Y');  ?></td>
					<td><?php echo $row['sr_no']."_(".$row['receive_at'].")";  ?></td>
					<td><?php echo $row2['party_name'];  ?></td>
					<td><?php echo $row['invoice_no'];  ?></td>
					<td><?php echo $row['invoice_date']->format('d.M.Y');  ?></td>
					<td><?php echo $row['mat_ord_by'];  ?></td>
					<td><?php echo (float)$row['total_bill_amt'];  ?></td>
					<td><?php echo $row['bill_out_store_memono'];  ?></td>
					<!-- <td><input type="checkbox" name="sr_no[]" class="largerCheckbox" value="<?php echo $row["sr_no"].$row['receive_at']; ?>" /></td> -->
				</tr>
				<?php
				}
				?>
				<?php
				}
				else{}
				?>
			</table>

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
             // {
             //    text: 'JOB WORK',"className": 'job_work',
             //    action: function () { 
             //      window.open('JW/bill_in.php','_self');  
             //   }
             // },
             // {
             //    text: 'VIEW',"className": 'view',
             //    action: function () { 
             //      window.open('view_bill_in.php','_self');  
             //   }
             // },
          //    {
          //       text: 'RECEIVE BILL',"className": 'receive_bill',
          //       action: function () { 
          //          		if(confirm("Are you sure you want to Receive this?"))
										// 		{
										// 		var id = [];

										// 		$(':checkbox:checked').each(function(i){
										// 		id[i] = $(this).val();
										// 		});
										// 		if(id.length === 0) //tell you if the array is empty
										// 		{
										// 		alert("Please Select atleast one checkbox");
										// 		}
										// 		else
										// 		{
										// 		$.ajax({
										// 		url:'bill_in_to_db.php',
										// 		method:'POST',
										// 		data:{id:id},
										// 		success:function()
										// 		{
										// 		for(var i=0; i<id.length; i++)
										// 		{
										// 			$('tr#'+id[i]+'').css('background-color', '#ccc');
										// 			$('tr#'+id[i]+'').fadeOut('slow');
										// 		}
										// 	},
										//  complete:function()
										//  {
										// 	 location.reload(true);
										//  }

										// 		});
										// 		}

										// 		}
										// 		else
										// 		{
										// 		return false;
										// }
          //      }
          //    },


   ],
				});


		});

		</script>
	</body>
</html>
<?php
	}
	else{
		$_SESSION['utype'] = "You Are Not Authorized!!";
            header("location:..\..\dashboard.php");
	}
?>
