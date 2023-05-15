<?php
include('..\..\dbcon.php');
$sql = "SELECT d.item,d.m_code,b.receive_date,c.pid,c.p_code,a.rec_qnty,a.p_pkg,a.sr_no from inward_ind a
LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_item d on d.i_code= a.p_item where a.id='".$_GET['id']."'";
$run = sqlsrv_query($con,$sql);
$row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
$pcode = substr($row['p_code'],0,8);
$visible_code = $row['receive_date']->format('M.y').'/'.$pcode.'/'.$row['sr_no'];
$item = $row['item'];
$pkg = $row['p_pkg'];
if ($row['m_code'] == 135) {
          if ($row['pid'] == 4242 || $row['pid'] == 4243 || $row['pid'] == 4244) {
          $code = 'A';
          }
          elseif($row['pid'] == 4846)
          {
          $code = 'B';
          }
          else
          {
          $code = 'D';
          }
}
else{
$code = 'K';
}
?>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>BARCODE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <style type="text/css">
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }
    #star_req{
    color: red;
    }
    ul {
    cursor: pointer;
    padding: unset;
    max-height: 250px;
    overflow: auto;
    }
    li {
    padding: 5px;
    background-color: #3399ff;
    }

    </style>
  </head>
  <body class="bg-info">
    <div class="container mt-5 bg-light" style="border-radius: 30px;
      box-shadow: 15px 15px 15px 15px;">
      <div>
        <br>
        <h4 class="bg-info shadow" style="color: white" align="center">COIL NO & WEIGHT</h4>
        <br>
        <form action="cuAlu_to_db.php" id="setform" method="post">
          
          <div class="form-row">
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label class="font-italic">VISIBLE CODE<span id="star_req"> </span></label>
              <input type="text" name="vis_code" value="<?php echo $visible_code; ?>" id="vis_code" class="form-control bg-light" readonly>
              <input type="hidden" value="<?php echo $_GET['id']; ?>" name="iid">
              
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label class="font-italic">ITEM NAME<span id="star_req"> </span></label>
              <input type="text" value="<?php echo $item; ?>" name="item" class="form-control bg-light" readonly>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <label class="font-italic">QNTY<span id="star_req"></span></label>
              <input type="text" name="qnty" value="<?php echo $row['rec_qnty']; ?>" id="qnty" class="form-control bg-light" readonly>
              
            </div>
          </div>
          <div class="form-row shadow bg-info text-white" style="height:25px;width:100%;margin-left: 1px;">
            <div class="form-group col-lg-3 col-md-3 col-sm-3 text-left">
              <label class="">SrNo</label>
              
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 text-left">
              <label class="">SEPL COIL No</label>
              
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-5 text-left">
              <label class="">COIL Wt<span id="star_req"> **</span></label>
            </div>
          </div>
          <?php
          $sql1 = "SELECT * FROM inwardCuAlu where ind_id = '".$_GET['id']."'";
          $params = array();
          $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
          $run1=sqlsrv_query($con,$sql1,$params,$options);
          $row1 = sqlsrv_num_rows($run1);
          if ($row1 > 0) {
            $sql2 = "SELECT min(cn) as coil FROM inwardCuAlu where ind_id = '".$_GET['id']."'";
            $run2 = sqlsrv_query($con,$sql2);
            $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
            $fromcoil = $row2['coil'];
          }
          else{
                $sql2 = "SELECT max(cn) as coil FROM inwardCuAlu where cl = '$code'";
                $run2 = sqlsrv_query($con,$sql2);
                $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
                $fromcoil = $row2['coil'] + 1;
          }

          $tocoil = $pkg + $fromcoil;
          $srno = 0;
          for ($i=$fromcoil; $i < $tocoil; $i++)
          {
          $srno++;
                $sql3 = "SELECT CoilWt FROM inwardCuAlu where cl = '$code' AND cn = '$i'";
                $run3 = sqlsrv_query($con,$sql3);
                $row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);
          ?>
          <!-- Repeat row -->
          <div class="form-row mt-2">
            <div class="form-group col-lg-3 col-md-3 col-sm-3">
              <input type="text" name="srno" value="<?php echo $srno; ?>" id="srno" class="form-control form-control-sm bg-light" readonly>
              <input type="hidden" name="cl[]" value="<?php echo $code; ?>">
              <input type="hidden" name="cn[]" value="<?php echo $i; ?>">

            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4">
              <input type="text" name="coilno[]" value="<?php echo $code.$i; ?>" id="coilno" class="form-control form-control-sm bg-light" readonly>

              
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-5">
              <input type="number" step="0.01" name="coilWt[]" value="<?php echo $row3['CoilWt']; ?>" id="coilWt" tabindex="<?php echo $srno; ?>" class="form-control form-control-sm font-weight-bold coilWt" placeholder="" required>
              <input type="hidden" name="cwt[]" value="<?php echo $row3['CoilWt']; ?>">
            </div>
          </div>
          <?php } ?>
          <div class="form-row mt-2">
            <div class="form-group col-lg-5 col-md-5 col-sm-5">
              <button id="submit" name="submit" class="button btn-info" style="width:350px;border-radius: 30px"><span>Print Barcode</span></button>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
 $("#setform").submit(function(){
    var sum = 0;
    var tqty = parseFloat($("#qnty").val());
        $(".coilWt"). each(function(){
        sum += parseFloat($(this).val());
        });
      
      if (sum > tqty + 1 || sum < tqty - 1) {
        alert("आपके द्वारा दर्ज किया गया कॉइल वजन खरीद वजन से मेल नहीं खाता है");
        return false
      }
    
 }); 



</script>