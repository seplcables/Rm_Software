<?php
session_start();
$user = $_SESSION['oid'];
$output = '
<div class="card">
  <div class="card-header border-5 border-warning"></div>

    
  
<table align="center" class="table table-bordered table-striped table-sm" id="receive" style="text-align: center;">
  <thead class="bg-primary text-white">
    <tr>
      <th>
        SR.
      </th>
      <th>Item Description</th>
      <th>Qnty</th>
      <th>Approx Cost</th>
      <th>M\C No.</th>
      <th>Department</th>
      <th>Plant</th>
      <th>Category</th>
      <th>State</th>
      <th>Type</th>
      <th>Old_Part_Status</th>
      <th>Price?</th>
    </tr>
  </thead>
  <tbody id="receive">
    ';
    
    include('../../../dbcon.php');
    $sql1 = "SELECT a.req_aprv,a.id,a.iid,a.item_code,d.category,b.item,a.qnty,a.rate,a.mc,a.department,a.state,a.plant,a.type,a.old_part_status from Requisition_details a
    LEFT OUTER JOIN rm_item b on a.item_code = b.i_code
    LEFT OUTER JOIN rm_category d on d.c_code = b.c_code
    where a.iid = '".$_POST['id']."' AND reject is NULL";
    $run1 = sqlsrv_query($con,$sql1);
    $count = 0;
    while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
    {
      $sql = "SELECT * FROM requisition_rate where iid = '".$row1['id']."'";
      $params = array();
      $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
      $run=sqlsrv_query($con,$sql,$params,$options);
      $row=sqlsrv_num_rows($run);

    $count++;
    
    $output .= '
    <tr>
      <td name="sr" id="sr">'.$count.'</td>
      <td>'.$row1['item'].'</td>
      <td>'.$row1['qnty'].'</td>
      <td>'.$row1['rate'].'</td>
      <td>'.$row1['mc'].'</td>
      <td>'.$row1['department'].'</td>
      <td>'.$row1['plant'].'</td>
      <td>'.$row1['category'].'</td>
      <td>'.$row1['state'].'</td>
      <td>'.$row1['type'].'</td>
      <td>'.$row1['old_part_status'].'</td>
      <td  style="width:100px">';
        
        if ($row1["req_aprv"] == 1 && true) {//$row < 1
          $output .= '<button type="Button" class="btn btn-warning btn-outline-danger text-white border-0 btn-sm button1 font-weight-bold" name="com" id="'.$row1['id'].'">Add Rate</button>';
        }
        /*elseif ($row > 1 && $user != 'Rajnish'){
          $output .= '<i class="fa fa-check-square checked_check" onclick="rateGiven();" aria-hidden="true"></i>';
        }
        elseif ($user == 'Rajnish'){
          $output .= '<button type="Button" class="btn btn-warning btn-outline-danger text-white border-0 btn-sm button1 font-weight-bold" name="com" id="'.$row1['id'].'">Add Rate</button>';
        }*/
        else
        { 
        $output .= '<i class="fa fa-window-close not_approve" onclick="not_approve();"></i>';
        }
        
      $output .= '</td>
      
    </tr>
    ';
    }
    
    $output .= '
  </tbody>
</table>

</div>
';
echo $output;
?>