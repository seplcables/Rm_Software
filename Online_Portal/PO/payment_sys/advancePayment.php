<?php
session_start();
if ($_SESSION['oid'] =='snehal' || true)
{
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Advance Payment</title>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <!------------------------ BT-5 CSS -------------------------------------->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <!------------------------ BT-5 JS -------------------------------------->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
        
        <script src="https://momentjs.com/downloads/moment.min.js"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.10.13/sorting/datetime-moment.js"></script>
        
        
        <!----------------------------------- jQuery UI ---------------------------->
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
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
    .ui-autocomplete {
        max-height: 180px;
        overflow: auto;
        max-width: 400px;
        overflow-y: auto;
        font-size: 12px;
        text-overflow: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
        background-color: #9ed8fa;
        
        z-index: 2150000000 !important;
        
        }
    </style>
    
 </head>
	<body>
		<div class="modal fade" id="create" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen modal-dialog-scrollable ">
                    <div class="modal-content">
                        <div class="modal-header text-center bg-dark bg-gradient text-white">
                            
                            
                            <h3 class="h4 text-center">REQUISITION SLIP</h3>
                            
                            <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="compare_data">
                            <div class="container-fluid">
                                <form action="Requisition_slip_db.php" method="POST" id="submit_form">
                                    <div class="card bg-faded mt-3" id="t_body"> 
                                    
                                    </div>
                                
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="save" class="btn btn-primary save" form="submit_form">Save</button>
                    </div>
                </div>
            </div>
        </div>
		<h4 class="bg-info text-white" align="center">ADVANCE PAYMENT</h4>
		<br/>
		<div class="table-responsive m-1">
			<form action="advance_payment_db.php?status=0" id="form_submit_save" method="post">
			<table class="table table-bordered table-striped" id="employee_data">
				<thead>
				<tr id="trow">
					<th>Po Date</th>
					<th>Po Number</th>
					<th>Party</th>
					<th>Po Gen by</th>
					<th>Mat Req Date</th>
					<th>Department</th>
					<th>Mat_req_by</th>
					<th>PO Amt</th>
					<th>Advance Amt</th>							
					<th>Percentage</th>
					<th>Ctrl</th>
					
				</tr>
			</thead>
				<?php
				include('..\..\..\dbcon.php');
				$mat_ord_by = $_SESSION['oid'];
				//$sql="SELECT * from po_entry_head  order by id desc";
				$sql="SELECT * from po_entry_head where adv_type = 'Yes' and adv_amt IS NOT NULL and adv_amt <> 0 and (advance_status IS NULL or advance_status = 0)  ORDER BY party, po_date DESC";
				$run=sqlsrv_query($con,$sql);
				$params = array();
				$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
				$run1=sqlsrv_query($con,$sql,$params,$options);
				$row1=sqlsrv_num_rows($run1);
				if ($row1 > 0) 
				{
				?>
				<?php
				while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
				$sql2="SELECT * from rm_party_master where pid='".$row['party']."'";
				$run2=sqlsrv_query($con,$sql2);
				$row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
				?>
				<!-- <tr class="text-center font-italic" id="<?php //echo $row["sr_no"].$row['receive_at']; ?>"> -->
				<tr class="text-center font-italic">
					<td><?php echo $row['po_date']->format('d.M.Y');  ?></td>
					<td><?php echo $row['po_no'];  ?></td>
					<td><?php echo $row2['party_name'];  ?></td>
					<td><?php echo $row['po_gen_by'];  ?></td>
					<td><?php echo $row['mat_req_date']->format('d.M.Y');  ?></td>
					<td><?php echo $row['depart_ment'];  ?></td>
					<td><?php echo $row['mat_req_by']; ?></td>
					<td><?php echo (float)$row['po_value'];  ?></td>
					<td><?php echo $row['adv_amt']; ?></td>
					<!-- <td width="5%">
						<?php
							// $sql3="SELECT a.sr_no as inward_srno,a.receive_at, b.iid as poentryidp  FROM inward_com  a LEFT OUTER JOIN inward_ind b on a.sr_no = b.sr_no and a.receive_at = b.receive_at  where  a.bill_approve = 0 and a.sr_no = '".$row['sr_no']."'";
							// $run3=sqlsrv_query($con,$sql3);
							// $row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

							// //echo $row3['inward_srno']."<br/>";

							// $sql4 = "SELECT id, requisition_id, req_iid from po_entry_details where id = '".$row3['poentryidp']."'";
							// $run4=sqlsrv_query($con,$sql4);
							// $row4 = sqlsrv_fetch_array($run4, SQLSRV_FETCH_ASSOC);
							// if(($row4['requisition_id'] != "") || ($row4['requisition_id'] != NULL))
							// {
							// 	echo "MRS Done";
							// } 
							// else
							// {
                                //echo $row4['id'];
						?>
						<button type="button" class="btn  bg-gradient btn-warning btn-sm createbtn" data-id="<?php //echo $row3['inward_srno']; ?>"  data-bs-toggle="modal" data-bs-target="#create"><i class="fa fa-plus float-sm"></i> Create New</button>
						<?php
							//}
							
							
						?>
					</td>
				    <td class="text-left" style="width:15%;"><input type="file" name="upload[]" accept=".pdf" id="upload" class="upload mx-2">
					<?php
						//if ($row['invoice_aprove'] != NULL) {
						?>
						<button type="button" class="btn btn-primary mx-2" class="showbtn" onclick="return popitup('Invoice/<?php //echo row['invoice_aprove']; ?>')"><i class="fa fa-eye"></i></button>
						<?php
							//}
						 ?>
					</td> -->
					<td><?php echo round($row['adv_amt']/$row['po_value'],2);  ?></td>
					<td>
						<?php if(($row['advance_status'] == "") || ($row['advance_status'] == NULL)) { ?>
						<input type="checkbox" name="" class="largerCheckbox" value="<?php echo $row['id']; ?>" />
						<input type="hidden" name="value[]" class="value">
					<?php }
					else
					{
						echo "Advance <br/>Payment<br/>done";
					} ?>
					</td>
				</tr>
				<?php
				}
				?>
				<?php
				}
				else{}

				?>
			</table>
			</form>
		</div>
		<script type="text/javascript">
			$(document).ready(function()
            {
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
								    action: function () 
								   	{ 
					                	window.open("../../dashboard.php","_self");  
					               	}
					            },
		               {
		                	text: 'SAVE',"name":'savee',"className": 'view',"id": 'savee',
		                	action: function () { 
		                    	savePaymentStatus();
		                 }
		               }
	   				],
	   
				});

			});


			//$('#savee').click(function()
			function savePaymentStatus()
			{

				if(confirm("Are you sure you want to Send this?"))
				{
					var id = [];
					$(':checkbox:checked').each(function(i)
					{
						id[i] = $(this).val();
					});
					if(id.length === 0) //tell you if the array is empty
					{
						alert("Please Select atleast one checkbox");
						return false;
					}
					else
					{
						$("#form_submit_save").submit();
					}
				}
				else
				{
					return false;
				}


			}



			
		$(document).on('click','.largerCheckbox',function()
		{
			var x = $(this).val();
            if($(this).prop("checked"))
            {
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


function SearchIndentor(txtBoxRef) 
{  

    console.log('function call');
    var f = true; //check if enter is detected
    $(txtBoxRef).keypress(function (e) {
    if (e.keyCode == '13' || e.which == '13')
    {
    f = false;
    }
    });
    $(txtBoxRef).autocomplete({
    source: function( request, response ) {
    // Fetch data
    $.ajax({
    url: "getindentor.php",
    type: 'post',
    dataType: "json",
    data: {
    indentor: request.term
    },
    success: function( data ) {
    response( data );
    console.log(data);
    }
    });
    },
    select: function (event, ui) {
    // Set selection
    $(this).closest('div').find('.indentor').val(ui.item.label);
    $(this).closest('div').find('.dpnt').val(ui.item.dpnt);
    //$('.dpnt').val(ui.item.dpnt);
    return false;
    },
    change: function (event, ui)  //if not selected from Suggestion
    {
    if (f)
    {
    if (ui.item == null)
    {
    $(this).val('');
    $(this).focus();
    }
    /*else{
    $(this).closest('tr').find('.qty').focus();
    }*/
    }
    }
    });
}
$(document).on('click','.createbtn',function()
{
    var x = $(this).attr('data-id');
    
    $.ajax({
    url: "mrsmodaldata.php?status=0",
    type: 'post',
    data: {sr_no:x},
    success: function( data ) 
    {
        $("#t_body").html(data);
    }
});
});

$(document).on('change','#type',function()
{
    var a = $(this).val();
    if (a == 'Replace') {
    $(this).closest('tr').find(".hideit").show();
    //$(this).closest('tr').find("#upload3,#upload4").attr('required', true);
    }
    else {
    $(this).closest('tr').find(".hideit").hide();
    //$(this).closest('tr').find(".select_hide").val('-- Select --');
    //$(this).closest('tr').find("#upload3,#upload4").attr('required', false);
    }
});


$("#submit_form").submit(function()
{
    val = $(".selecttype").val();
    if(val == "Replace")
    {
        alert("Please select old part status");
        $(".select_hide").focus();
        return false;
    }
    
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