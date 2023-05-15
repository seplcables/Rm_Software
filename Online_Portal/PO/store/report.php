<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Stock_live_rep.</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  


    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <style type="text/css">
    #trow{
    background-color: #ffb3ff;
    text-align: center;
    }
    </style>
  </head>
  <body>
    <div class="row ml-2">
      <a href="../../dashboard.php" class="btn btn-warning"><<< Back</a>
    </div>
    <br />
    <div class="table-responsive ml-1">
      <table class="table table-bordered table-striped table-sm" id="employee_data">
        <thead>
          <tr class="bg-dark text-white text-center font-italic">
            
            <th id="trow">Item_name</th>
            <th id="trow">sub_grade</th>
            <th id="trow">main_grae</th>
            <th id="trow">Category</th>
            <th id="trow">Qnty</th>
            <th id="trow">Show</th>
          </tr>
        </thead>
        <?php
        include('..\..\..\dbcon.php');
        $sql="SELECT MAX(opening_date) as last_date FROM store_opening_date";
        $run=sqlsrv_query($con,$sql);
        $rowa = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
        $dd = $rowa['last_date']->format('d-M-y');
        
        $query = "SELECT DISTINCT item FROM inward_store where receive_dte >='$dd'";
        $result = sqlsrv_query($con,$query);
        while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
        {
        $item = $row["item"];
       
        
        
        $query2="SELECT SUM(qnty) as inw_qnty FROM inward_store where item='$item' and receive_dte >='$dd'";
        $result2=sqlsrv_query($con,$query2);
        $row2=sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);
        
        
        $query3="SELECT SUM(qnty) as qnty_value FROM rm_issue where item_name='$item' and issue_from = 'store' and issue_date >='$dd'";
        $result3=sqlsrv_query($con,$query3);
        $row3=sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
        $qnty= $row2["inw_qnty"]-$row3['qnty_value'];
        
        
        $query4="SELECT * FROM rm_item where i_code='$item'";
        $result4=sqlsrv_query($con,$query4);
        $row4=sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);
        $s_grade = $row4['s_code'];
        $m_grade = $row4['m_code'];
        $cat = $row4['c_code'];
        $query5="SELECT sub_grade FROM rm_s_grade where s_code='$s_grade'";
        $result5=sqlsrv_query($con,$query5);
        $row5=sqlsrv_fetch_array($result5, SQLSRV_FETCH_ASSOC);
        $query6="SELECT main_grade FROM rm_m_grade where m_code='$m_grade'";
        $result6=sqlsrv_query($con,$query6);
        $row6=sqlsrv_fetch_array($result6, SQLSRV_FETCH_ASSOC);
        $query7="SELECT category FROM rm_category where c_code='$cat'";
        $result7=sqlsrv_query($con,$query7);
        $row7=sqlsrv_fetch_array($result7, SQLSRV_FETCH_ASSOC);
        if ($qnty == 0) {
            continue;
        }
        ?>
        <tr class="text-center font-italic">
          
          <td><?php echo $row4['item'];  ?></td>
          <td><?php echo $row5['sub_grade'];  ?></td>
          <td><?php echo $row6['main_grade'];  ?></td>
          <td><?php echo $row7['category'];  ?></td>
          <td><?php echo $qnty;  ?></td>
          <td><a href="select.php?id=<?php echo $item; ?>" onclick="return popitup('select.php?id=<?php echo $item; ?>')" class="btn btn-primary btn-xs view_data">View</a></td>
          
          
        </tr>
        <?php
        }
        ?>
        
      </table>
      
    </div>
    
    <script type="text/javascript">
    function popitup(url) {
    newwindow=window.open(url,'_blank','height=500,width=500,left=300,top=50');
    if (window.focus) {newwindow.focus()}
    return false;
}
      
      $(document).ready(function(){
    $('#employee_data').DataTable({
    "createdRow": function(row, data, dataIndex) {
    if (data["4"] < 0) {
    $(row).css("background-color", "Orange");
    }
    },
    });
  });
    
    </script>
  </body>
</html>