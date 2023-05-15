<?php
session_start();
include('..\..\..\dbcon.php');

if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='amey' || $_SESSION['oid'] =='harikishan' || $_SESSION['oid'] =='Nishant')
{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Grade Wise Report</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <style type="text/css" media="screen">
      input.largerCheckbox {
    transform : scale(2);
    }
    </style>
  </head>
  <body>
      <div class="font-weight-bold bg-primary p-1 text-white" align="center" style="font-size: 22px;">
        Grade Wise Report

      </div><br/>
      <div class="row" style="padding-left:2%;">
        <div class="col-md-12">
            <a href="../../dashboard.php" class="btn btn-warning">HOME</a>  
        </div>
    </div>

      <br/>
    <div class="table-responsive" style="padding:1%;">
      <table class="table table-bordered table-striped table-sm" id="employee_data">
        <thead>
        <tr class="bg-dark text-white text-center font-italic">
              <th>Subgrade</th>
              <th>Item</th>
              <th>inward_ind qnty</th>
              <th>issue qnty</th>
              <th>diff</th>
        </tr>
        </thead>
        <?php
              $i=0;
              $sql="SELECT a.p_item, sum(a.rec_qnty) as recqty from inward_ind a , inward_com b where a.sr_no = b.sr_no and b.receive_date >= '2022-12-30'  group by a.p_item order by a.p_item ASC";
              $run=sqlsrv_query($con,$sql);
              while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) 
              {
                $sql1="SELECT grade_code,sum(issue_qnty) as issueqty from pvc_issue where grade_code = '".$row["p_item"]."' and  issue_date >= '2022-12-30' group by grade_code order by grade_code asc";
                $run1=sqlsrv_query($con,$sql1);
                $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);

                $query4="SELECT * FROM rm_item where i_code='".$row["p_item"]."'";
                $result4=sqlsrv_query($con,$query4);
                $row4=sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);
                $s_grade = $row4["s_code"];
                
                $query5="SELECT sub_grade FROM rm_s_grade where s_code='$s_grade'";
                $result5=sqlsrv_query($con,$query5);
                $row5=sqlsrv_fetch_array($result5, SQLSRV_FETCH_ASSOC);

                if($row['p_item'] == $row1['grade_code'])  
                { 
                  $diff = $row["recqty"] - $row1['issueqty']; 
                } 
                else 
                { 
                  $diff = $row["recqty"];
                }

            
        ?>
        <tr>
            <td><?php echo $row5["sub_grade"];  ?></td>
            <td><?php echo $row4["item"];  ?></td>
            <td><?php echo $row["recqty"];  ?></td>
            <td><?php $retVal = ($row1['issueqty'] == "") ? 0 : $row1['issueqty']; echo $retVal;  ?></td>
            <td><?php  echo $diff; ?></td>            
        </tr>
        <?php
              $i++; }
        ?>
      </table>

    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#employee_data').DataTable();

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
