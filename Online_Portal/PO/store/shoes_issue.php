<?php 
include('dbcon.php');
$year = date('Y');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Shoes Issue</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	 <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

     <!----------------------- jQuery UI --------------------------->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style type="text/css">
    	body{
    		font-size: 14.5px !important;
    	}
    	table{
    		width: 100%;
    		border: 0.2px solid black;
    		text-align: center;
    	}
    	.heading{
    		font-size: 1.2rem;
    		text-align: center;
    		padding: 4px !important;
    		font-weight: 600;
    	}
    	table td{
    		padding: 4px 7px !important;
    	}
    	table th{
    		position: sticky;
    		background: #e3f1de !important;
    		text-align: center !important;
    		padding: 4px 7px !important;
    	}
    	table.dataTable{
            border-collapse: collapse;
        }
        .tableData th{
        	background-color: #ff000e57 !important;
        }
        .totalShow{
        	background-color: #ffa500cf;
        	font-weight: 600;
        }
        .col-lg-3{
        	width: 32% !important;
        	padding-right: 6px;
        }
        .col-lg-9{
        	width: 68% !important;
        }
    </style>
</head>
<body>
	<div class="container-fluid">
		<div class="row py-2" style="background-color:#ff9a07ab;">
			<div class="col-auto">
				<a href="../../dashboard.php" class="btn btn-info text-white btn-sm px-3">Back</a>
			</div>
			<div class="col text-center">
				<h4 class="m-0">Shoes Issue</h4>
			</div>
		</div><br>
		<div class="row">
			<div class="col-lg-3">
				<table class="table table-bordered">
					<tr>
						<td colspan="7" class="heading">Staff</td>
					</tr>
					<tr>
						<th>Size</th>
						<th>Qnty</th>
						<th>Unit</th>
						<th>Lot 1</th>
						<th>Lot 2</th>
						<th>Issue</th>
						<th>Available</th>
					</tr>
					<?php 
						$qnty = 0;
						$count = 0;
						$avil = 0;
						$lot1 = 0;
						$lot2 = 0;
						$sql = "SELECT * FROM Shoes_M_Staff where year = '$year'";
						$run = sqlsrv_query($conhr,$sql);
						while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)){
							$sqlb = "SELECT count(id) as count FROM Shoes_Issue where issueBy is not NULL AND cat = 'Staff' AND year = '$year' AND size = '".$row['size']."'";
							$runb = sqlsrv_query($conhr,$sqlb);
							$rowb = sqlsrv_fetch_array($runb, SQLSRV_FETCH_ASSOC);

							if ($year == '2022') {
								$available = ($row['lot1']+$row['lot2'])-$rowb['count'];
							}else{
								$available = $row['qnty']-$rowb['count'];
							}
							$qnty += $row['qnty'];
							$lot1 += $row['lot1'];
							$lot2 += $row['lot2'];
							$count += $rowb['count'];
							$avil += $available;
					?>
					<tr>
						<td><?php echo $row['size'] ?></td>
						<td><?php echo $row['qnty'] ?></td>
						<td><?php echo $row['unit'] ?></td>
						<td><?php echo $row['lot1'] ?></td>
						<td><?php echo $row['lot2'] ?></td>
						<td><?php echo $rowb['count'] ?></td>
						<td><?php echo $available ?></td>
					</tr>
					<?php } ?>
					<tr class="totalShow">
						<td>Total Pair</td>
						<td><?php echo $qnty ?></td>
						<td>Pairs</td>
						<td><?php echo $lot1 ?></td>
						<td><?php echo $lot2 ?></td>
						<td><?php echo $count ?></td>
						<td><?php echo $avil ?></td>
					</tr>
				</table>
			</div>
			<div class="col-lg-9">
				<table class="table table-bordered tableData">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Size</th>
							<th>Approve By</th>
							<th>Approve Date</th>
							<th>Issue By</th>
							<th>Issue Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php  
							$sqla = "SELECT id,empid,empname,modal,size,approveBy,format(approve_date,'dd-MM-yyyy') as approve_date,issueBy,format(issue_date,'dd-MM-yyyy') as issue_date FROM Shoes_Issue where cat = 'Staff' AND year = '$year' AND isDelete != '1' order by id desc";
							$runa = sqlsrv_query($conhr,$sqla);
							while($rowa = sqlsrv_fetch_array($runa, SQLSRV_FETCH_ASSOC)){
						?>
						<tr>
							<td><?php echo $rowa['empid'] ?></td>
							<td><?php echo $rowa['empname'] ?></td>
							<td><?php echo $rowa['size'] ?></td>
							<td><?php echo $rowa['approveBy'] ?></td>
							<td><?php echo $rowa['approve_date']?></td>
							<td><?php echo $rowa['issueBy'] ?></td>
							<td><?php echo $rowa['issue_date'] ?></td>
							<td style="padding:2px 7px !important;">
								<?php if($rowa['issueBy'] != NULL){ ?>
										<button type="button" class="btn btn-secondary btn-sm pb-1 pt-0">Issue</button>
								<?php }else{ ?>
										<button type="button" class="btn btn-success btn-sm pb-1 pt-0 issueShoes" id="<?php echo $rowa['id'] ?>">Issue</button>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div><hr>
		<div class="row">
			<div class="col-lg-3">
				<table class="table table-bordered">
					<tr>
						<td colspan="7" class="heading">Workers</td>
					</tr>
					<tr>
						<th>Size</th>
						<th>Qnty</th>
						<th>Unit</th>
						<th>Issue</th>
						<th>Available</th>
					</tr>
					<?php 
						$qnty1 = 0;
						$count1 = 0;
						$avil1 = 0;
						// $sql1 = "SELECT * FROM Shoes_M_Workers where year = '$year'";
						$sql1 = "SELECT year,size,sum(qnty) as qnty,unit FROM Shoes_M_Workers where year = '$year' group by year,size,unit";
						$run1 = sqlsrv_query($conhr,$sql1);
						while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)){
							$sqlb = "SELECT count(id) as count FROM Shoes_Issue where issueBy is not NULL AND cat = 'Worker' AND year = '$year' AND size = '".$row1['size']."'";
							$runb = sqlsrv_query($conhr,$sqlb);
							$rowb = sqlsrv_fetch_array($runb, SQLSRV_FETCH_ASSOC);

							$available1 = $row1['qnty']-$rowb['count'];
							$qnty1 += $row1['qnty'];
							$count1 += $rowb['count'];
							$avil1 += $available1;
					?>
					<tr>
						<td class="shoesWorker"><?php echo $row1['size'] ?></td>
						<td><?php echo $row1['qnty'] ?></td>
						<td><?php echo $row1['unit'] ?></td>
						<td><?php echo $rowb['count'] ?></td>
						<td class="availWork"><?php echo $available1 ?></td>
					</tr>
					<?php } ?>
					<tr class="totalShow">
						<td>Total Pair</td>
						<td><?php echo $qnty1 ?></td>
						<td>Pairs</td>
						<td><?php echo $count1 ?></td>
						<td><?php echo $avil1 ?></td>
					</tr>
				</table>
				<!-- <table class="table table-bordered">
					<tr>
						<td colspan="7" class="heading">Workers</td>
					</tr>
					<tr>
						<th>Size</th>
						<th>Qnty</th>
						<th>Unit</th>
						<th>Lot 1</th>
						<th>Lot 2</th>
						<th>Issue</th>
						<th>Available</th>
					</tr>
					<?php 
						$qnty1 = 0;
						$count1 = 0;
						$avil1 = 0;
						$lot11 = 0;
						$lot21 = 0;
						$sql1 = "SELECT * FROM Shoes_M_Workers where year = '$year'";
						$run1 = sqlsrv_query($conhr,$sql1);
						while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC)){
							$sqlb = "SELECT count(id) as count FROM Shoes_Issue where issueBy is not NULL AND cat = 'Worker' AND year = '$year' AND size = '".$row1['size']."'";
							$runb = sqlsrv_query($conhr,$sqlb);
							$rowb = sqlsrv_fetch_array($runb, SQLSRV_FETCH_ASSOC);

							if ($year == '2022') {
								$available1 = ($row1['lot1']+$row1['lot2'])-$rowb['count'];
							}else{
								$available1 = $row1['qnty']-$rowb['count'];
							}
							
							$qnty1 += $row1['qnty'];
							$lot11 += $row1['lot1'];
							$lot21 += $row1['lot2'];
							$count1 += $rowb['count'];
							$avil1 += $available1;
					?>
					<tr>
						<td><?php echo $row1['size'] ?></td>
						<td><?php echo $row1['qnty'] ?></td>
						<td><?php echo $row1['unit'] ?></td>
						<td><?php echo $row1['lot1'] ?></td>
						<td><?php echo $row1['lot2'] ?></td>
						<td><?php echo $rowb['count'] ?></td>
						<td><?php echo $available1 ?></td>
					</tr>
					<?php } ?>
					<tr class="totalShow">
						<td>Total Pair</td>
						<td><?php echo $qnty1 ?></td>
						<td>Pairs</td>
						<td><?php echo $lot11 ?></td>
						<td><?php echo $lot21 ?></td>
						<td><?php echo $count1 ?></td>
						<td><?php echo $avil1 ?></td>
					</tr>
				</table> -->
			</div>
			<div class="col-lg-9">
				<table class="table table-bordered tableData">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Size</th>
							<th>Approve By</th>
							<th>Approve Date</th>
							<th>Issue By</th>
							<th>Issue Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php  
							$sqla = "SELECT id,empid,empname,modal,size,approveBy,format(approve_date,'dd-MM-yyyy') as approve_date,issueBy,format(issue_date,'dd-MM-yyyy') as issue_date FROM Shoes_Issue where cat = 'Worker' AND year = '$year' AND isDelete != '1' order by id desc";
							$runa = sqlsrv_query($conhr,$sqla);
							while($rowa = sqlsrv_fetch_array($runa, SQLSRV_FETCH_ASSOC)){
						?>
						<tr>
							<td><?php echo $rowa['empid'] ?></td>
							<td><?php echo $rowa['empname'] ?></td>
							<td><?php echo $rowa['size'] ?></td>
							<td><?php echo $rowa['approveBy'] ?></td>
							<td><?php echo $rowa['approve_date'] ?></td>
							<td><?php echo $rowa['issueBy'] ?></td>
							<td><?php echo $rowa['issue_date'] ?></td>
							<td style="padding:3px !important;">
								<?php if($rowa['issueBy'] != NULL){ ?>
										<button type="button" class="btn btn-secondary btn-sm pb-1 pt-0">Issue</button>
								<?php }else{ ?>
										<button type="button" class="btn btn-success btn-sm pb-1 pt-0 issueShoes" id="<?php echo $rowa['id'] ?>">Issue</button></td>
								<?php } ?>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		var table = $('.tableData').DataTable({
		    "processing": true,
			dom: 'Bfrtip',
			ordering: false,
			destroy: true,
            
		 	lengthMenu: [
            	[ 10, 25, 50, -1 ],
            	[ '10 rows', '25 rows', '50 rows','Show all' ]
        	],
			 buttons: [
		 		'pageLength'
        	]
    	});
 	});

 	$(document).on('click','.issueShoes',function(){
 		var id = $(this).attr('id');
 		if (confirm('Are You Sure!!')){
 			$.ajax({
	 			url: 'shoes_db.php',
	 			type: 'post',
	 			data: {id:id},
	 			success:function(data){
	 				alert(data);
	 				location.reload();
	 			}
	 		});
 		}else{
 			return false;
 		}
 	});
</script>