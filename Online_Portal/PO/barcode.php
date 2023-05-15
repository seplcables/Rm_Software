<?php
include('..\..\dbcon.php');
$sql = "SELECT d.item,b.receive_date,c.p_code,a.rec_qnty,a.p_pkg,a.sr_no,a.BC_printno from inward_ind a
LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_item d on d.i_code= a.p_item where a.id='".$_GET['id']."'";
$run = sqlsrv_query($con,$sql);
$row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);
$pcode = substr($row['p_code'],0,8);
$visible_code = $row['receive_date']->format('M.y').'/'.$pcode.'/'.$row['sr_no'];
$item = $row['item'];
$from = $row['BC_printno'] + 1;
$to = $row['p_pkg'];
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
        <h3 class="bg-info" style="color: white" align="center">SET BARCODE QNTY</h3>
        <br>
        <form action="barcode_to_db.php" method="post">
          
          <div class="form-row mt-2">
            <div class="form-group col-lg-5 col-md-5 col-sm-5">
              <label class="font-italic">VISIBLE CODE<span id="star_req"> **</span></label>
              <input type="text" name="vis_code" value="<?php echo $visible_code; ?>" id="vis_code" class="form-control bg-light">
              <input type="hidden" value="<?php echo $_GET['id']; ?>" name="iid">
            </div>
            <div class="col-1"></div>
            <div class="form-group col-lg-5 col-md-5 col-sm-5">
              <label class="font-italic">ITEM NAME<span id="star_req"> **</span></label>
              <input type="text" value="<?php echo $item; ?>" name="item" class="form-control bg-light">
            </div>
          </div>
          <div class="form-row mt-2">
            <div class="form-group col-lg-5 col-md-5 col-sm-5">
              <label class="font-italic">QNTY<span id="star_req"></span></label>
              <input type="text" name="qnty" value="<?php echo $row['rec_qnty']; ?>" id="qnty" class="form-control bg-light">
              <input type="hidden" value="<?=$row['BC_printno']==NULL ? 0 : $row['BC_printno']; ?>" name="BC_printno">   
            </div>
            <div class="col-1"></div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3">
              <label class="font-italic">PRINTS FROM<span id="star_req"> **</span></label>
              <input type="number" name="printFrom" id="printFrom" value="<?php echo $from; ?>" class="form-control font-weight-bold noOfPrints" required>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3">
              <label class="font-italic">PRINTS TO<span id="star_req"> **</span></label>
              <input type="number" name="printTo" id="printTo" value="<?php echo $to; ?>" class="form-control font-weight-bold noOfPrints" required>
            </div>
          </div>
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
$(document).ready(function(){
$('.noOfPrints').on('change',function(){
var x = parseFloat($(this).val());
var y = parseFloat($('#xyz').val());
if (x < 1 || x > y) {
$(this).val('');
$(this).focus();
alert('WRONG PRINT NO');
}
});
});
</script>