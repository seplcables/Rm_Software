<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Store Rep</title>
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
        <style type="text/css">
        #trow{
        background-color: #ffb3ff;
        text-align: center;
        }
        </style>
    </head>
    <body>
        <div class="row">
            <a href="..\..\dashboard.php" class="btn btn-warning"><<< Back</a>
        </div>
        <br />
        <div class="table-responsive ml-1">
            <table class="table table-bordered table-striped table-sm" id="example" style="width:100%">
                <thead>
                    <tr id="trow">   
                        <th id="trow" width="8%">Category</th>
                        <th id="trow" width="10%">main_grae</th>
                        <th id="trow" width="12%">sub_grade</th>
                        <th id="trow" width="25%">Item_name</th>
                        <th id="trow" width="6%">Opening</th>
						<th id="trow" width="6%">Total_Inw</th>
                        <th id="trow" width="6%">Total_Issue</th>
                        <th id="trow" width="6%">live_stk</th>
                        <th id="trow" width="6%">Diff</th>
						<th id="trow" width="15%">View</th>
                        
                    </tr>
                </thead>
				<?php
        include('..\..\..\dbcon.php');
        $sqla="SELECT MAX(opening_date) as last_date FROM store_opening_date";
        $runa=sqlsrv_query($con,$sqla);
        $rowa = sqlsrv_fetch_array($runa, SQLSRV_FETCH_ASSOC);
        $dd = $rowa['last_date']->format('d-M-y');
        
			$sql = "SELECT DISTINCT a.item as icode,e.category,d.main_grade,c.sub_grade,b.item FROM inward_store a
			LEFT OUTER JOIN rm_item b on a.item = b.i_code
			LEFT OUTER JOIN rm_s_grade c on b.s_code = c.s_code
			LEFT OUTER JOIN rm_m_grade d on c.m_code = d.m_code
			LEFT OUTER JOIN rm_category e on d.c_code = e.c_code";
$run = sqlsrv_query($con,$sql);
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
	$item = $row['icode'];
	    $query1="SELECT SUM(qnty) as opening FROM inward_store where item='$item' and come_from = 'opening' and receive_dte >= '2021-03-31' and receive_dte <= '2021-04-24'";
        $result1=sqlsrv_query($con,$query1);
        $row1=sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC);
		
	    $query2="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='$item' and come_from = 'inward' and receive_dte >='2021-03-31'";
        $result2=sqlsrv_query($con,$query2);
        $row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);	
		
        $query3="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='$item' and issue_from = 'store' and issue_date >='2021-03-31'";
        $result3=sqlsrv_query($con,$query3);
        $row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
        
        $query4="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='$item' and receive_dte >='$dd'";
        $result4=sqlsrv_query($con,$query4);
        $row4=sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC); 
                
        $query5="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='$item' and issue_from = 'store' and issue_date >='$dd'";
        $result5=sqlsrv_query($con,$query5);
        $row5=sqlsrv_fetch_array($result5, SQLSRV_FETCH_ASSOC);
        
        $qnty= $row4["inw_qnty"]-$row5['qnty_value'];
        $diff = $row1['opening'] + $row2["inw_qnty"]-$row3['qnty_value'] - $qnty;
		
		if ($row['item'] == '') {
            continue;
        }
		
        ?>
		<tr class="text-center font-italic">
          
          <td><?php echo $row['category'];  ?></td>
          <td><?php echo $row['main_grade'];  ?></td>
          <td><?php echo $row['sub_grade'];  ?></td>
          <td><?php echo $row['item'];  ?></td>
		  <td><?php echo $row1['opening'];  ?></td>
		  
		  <td><?php echo $row2['inw_qnty'];  ?></td>
		  <td><?php echo $row3['qnty_value'];  ?></td>
		  <td><?php echo $qnty;  ?></td>
		  <td><?php echo $diff;  ?></td>
          <td><a href="inwd_view.php?id=<?php echo $item; ?>" onclick="return popitup('inwd_view.php?id=<?php echo $item; ?>')" class="btn btn-primary btn-xs view_data">Inwd</a>
		  <a href="issue_view.php?id=<?php echo $item; ?>" onclick="return popitup1('issue_view.php?id=<?php echo $item; ?>')" class="btn btn-success btn-xs view_data">Issue</a></td>
          
          
        </tr>
        <?php
        }
        ?>
            </table>
        </div>
        <script type="text/javascript">
		function popitup(url) {
    newwindow=window.open(url,'_blank','height=500,width=600,left=300,top=50');
    if (window.focus) {newwindow.focus()}
    return false;
}
function popitup1(url) {
    newwindow=window.open(url,'_blank','height=500,width=500,left=300,top=50');
    if (window.focus) {newwindow.focus()}
    return false;
}
            $(document).ready(function() {
        $('#example').DataTable( {
            "processing": true,
            "dom": 'Bfrtip',
       
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength', 'excel', 'print'
        ]
        } );
        });
        </script>
    </body>
</html>