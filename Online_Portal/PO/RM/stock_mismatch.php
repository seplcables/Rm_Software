<?php
session_start();
if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='amey' || $_SESSION['oid'] =='harikishan' || $_SESSION['oid'] =='Nishant') {
    ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>stock_mismatch</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<style type="text/css" media="screen">
			
		</style>
	</head>
	<body>
	<div class="row m-1">
      <div class="col-md-3">
          <select class="form-control" name="ope_date" id="ope_date" form="opening_form" onChange="GetClosing(this.value)">
                <option disabled="true" selected="true" value="" class="bg-dark">select opening date</option>
                <?php
                include('..\..\..\dbcon.php');
    $sql="SELECT * FROM store_opening_date WHERE rm_opening_date != (SELECT MAX(rm_opening_date) FROM store_opening_date)";
    $run=sqlsrv_query($con, $sql);
    while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
        ?>
                <option value="<?php echo $row['rm_opening_date']->format('d-M-y'); ?>"><?php echo $row['rm_opening_date']->format('d-M-y'); ?></option>
                <?php
    } ?>
            </select>  
      </div>
      <div class="col-md-3">
          <input type="text" id="closing_date" value="" name="closing_date" class="form-control" readonly>  
      </div>
      <div class="col-md-3">
          <button type="button" name="btn_filter" id="btn_filter" class="btn btn-info">Filter</button>  
      </div>
        <div class="col-md-3">
          <a href="../../dashboard.php" class="btn btn-warning w-25">Back</a>  
      </div>
    </div>
		<?php if (isset($_SESSION['mess'])): ?>
		<div class="alert alert-primary font-weight-bold font-italic">
			<?php echo $_SESSION['mess']; ?>
		</div>
		<?php unset($_SESSION['mess']); ?>
		<?php endif; ?>
		<div class="table-responsive m-1"  id="order_table">
			<table class="table table-bordered table-striped table-sm" id="employee_data">
				<tr class="bg-dark text-white text-center font-italic">
					<th width="16%">Sub_Grade</th>
					<th width="24%">Grade</th>
					<th width="12%">Store</th>
					<th width="8%">Rmta</th>
					<th width="8%">ope(A)</th>
					<th width="8%">Inw(B)</th>
					<th width="8%">Iss(C)</th>
					<th width="8%">Clo(D)</th>
					<th width="8%">D-(A+B-C)</th>
				</tr>
				
				<tr class="text-center font-italic">
					
					
				</tr>
				
			</table>
			
		</div>
		<script type="text/javascript">
			function GetClosing(str){						
								var xmlhttp = new XMLHttpRequest();
								xmlhttp.onreadystatechange = function() {
									if (this.readyState == 4 && this.status == 200) {
										var myObj = JSON.parse(this.responseText);
										document.getElementById("closing_date").value = myObj[0];
										
									}
								};
								xmlhttp.open("GET", "getClosingDate.php?ope_date="+str, true);
								xmlhttp.send();
							}

	$(document).ready(function(){
		$('#btn_filter').click(function(){
			var ope_date = $('#ope_date').val();
			var closing_date = $('#closing_date').val();
			if(ope_date != '' || closing_date != '')
			{
			$.ajax({
			url:"getStockMismatch.php",
			method:"POST",
			data:{ope_date:ope_date, closing_date:closing_date},
			success:function(data)
			{
			$('#order_table').html(data);
			}
			});
			}
			else
			{
			alert("Please Select Opening Date");
			}
			});
				$('#employee_data').DataTable();
		
		});
		
		</script>
	</body>
</html>
<?php
} else {
        $_SESSION['utype'] = "You Are Not Authorized!!";
        header("location:..\..\dashboard.php");
    }
?>