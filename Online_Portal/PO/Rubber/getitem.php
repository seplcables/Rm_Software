<?php
include('..\..\..\dbcon.php');

/*---------For autocomplete item-------*/
if (isset($_POST['rmta'])) {

    $query = "SELECT distinct sr_no FROM inward_ind WHERE sr_no LIKE '%".$_POST["rmta"]."%'";
    $result = sqlsrv_query($con,$query);
    while($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ){

        $response[] = array("label"=>$row['sr_no']);
    }
    echo json_encode($response);
}

/*------------------ get select for item ----------------*/
if(isset($_POST['rmta1'])){
  
    $output = '';

    $output .= '
        <select class="form-control item" name="item[]">
            <option>- Select -</option>
            ';
            $sql = "SELECT a.p_item,b.item as name FROM inward_ind a left outer join rm_item b on a.p_item = b.i_code WHERE a.sr_no = '".$_POST['rmta1']."'";
            $run = sqlsrv_query($con,$sql);
            while($row1 = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)){
            $output .= '
                <option value="'.$row1['p_item'].'">'.$row1['name'].'</option>
            '; } $output .= '
        </select> 
    ';   
    echo $output;
}


/*------------------ get rate on change item ----------------*/
if(isset($_POST['item'])){
  
  $item = $_POST['item'];
  $rmt = $_POST['rmt'];

   $sql2 = "SELECT * FROM inward_ind WHERE p_item = '$item' AND sr_no = '$rmt'";
   $run2 = sqlsrv_query($con,$sql2);
   $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
    echo $row2['pur_rate'];
}
?>
