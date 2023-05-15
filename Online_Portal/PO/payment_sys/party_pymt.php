<?php
session_start();
if ($_SESSION['oid'] =='snehal' || $_SESSION['oid'] =='Rajnish' || $_SESSION['oid'] =='dipen' || $_SESSION['oid'] =='himanshu' || $_SESSION['oid'] =='Pratik' || $_SESSION['oid'] =='rohan')
{
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Bill_Send</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"/>
    
<style>
h1{
  font-size: 30px;
  color: #fff;
  text-transform: uppercase;
  font-weight: 300;
  text-align: center;
  margin-bottom: 15px;
}
#file_upload{
  width:120px;
  font-size:13px;
}
h4 {
  color: white;
  text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;
  font-weight: 300;
  text-align: center;
  margin-top:15px;
  margin-bottom:15px;
}
table{
  width:100%;
    /* max-height:100%; */
  /* table-layout: fixed; */
  background: -webkit-linear-gradient(left, #2a88a4, #1a3234d6);
  background: linear-gradient(to right, #2a88a4, #14084c);
  border-radius:20px;
}
.tbl-header{
  width:100%;
  background-color: rgba(255,255,255,0.3);
 }
.tbl-content{
  /* width:100%;
  height:300px;
  overflow-x:auto;
  margin-top: 0px; */
  border: 1px solid rgba(255,255,255,0.3);
}
th{
  padding: 15px 15px;
  text-align: left;
  font-weight: 800px;
  font-size: 12px;
  color: black;
  text-transform: uppercase;
  /* background: -webkit-linear-gradient(left, yellow, #1a3234);
  background: linear-gradient(to right, yellow, #1a3234); */
  background-color:#20c3ac;
}
td{
  white-space: nowrap;
  padding: 15px;
  text-align: left;
  vertical-align:middle;
  /* font-weight: 200; */
  font-size: 14px;
  color: #fff;
  border-bottom: solid 1px rgb(28 0 170 / 10%);
}


/* demo styles */

@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);
body{
  /* background: -webkit-linear-gradient(left, #25c481, #25b7c4);
  background: linear-gradient(to right, #25c481, #25b7c4); */
  font-family: 'Roboto', sans-serif;
  /* background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab); */
  background: linear-gradient(-45deg,#dfff62, #c99b6bcc, #c1b6f9, #23d5ab);
	background-size: 400% 400%;
	animation: gradient 15s ease infinite;
	height: 100vh;
}
@keyframes gradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}

section{
  margin: 50px;
}

input.largerCheckbox {
    transform : scale(2);
    }

/* follow me template */
.made-with-love {
  margin-top: 40px;
  padding: 10px;
  clear: left;
  text-align: center;
  font-size: 10px;
  font-family: arial;
  color: #fff;
}
.made-with-love i {
  font-style: normal;
  color: #F50057;
  font-size: 14px;
  position: relative;
  top: 2px;
}
.made-with-love a {
  color: #fff;
  text-decoration: none;
}
.made-with-love a:hover {
  text-decoration: underline;
}


/* for custom scrollbar for webkit browser*/

::-webkit-scrollbar {
    width: 6px;
} 
::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
} 
::-webkit-scrollbar-thumb {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
}
input[type="date"] {
  display:block;
  position:relative;
  height:40px;
  /* width:200px; */
  padding:1rem 3.5rem 1rem 0.75rem;
  
  font-size:1rem;
  font-family:monospace;
  
  border:0px solid #8292a2;
  border-radius:0.25rem;
  background:
    white
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='22' viewBox='0 0 20 22'%3E%3Cg fill='none' fill-rule='evenodd' stroke='%23688EBB' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' transform='translate(1 1)'%3E%3Crect width='18' height='18' y='2' rx='2'/%3E%3Cpath d='M13 0L13 4M5 0L5 4M0 8L18 8'/%3E%3C/g%3E%3C/svg%3E")
    right 1rem
    center
    no-repeat;
  
  cursor:pointer;
}
input[type="date"]:focus {
  outline:none;
  border-color:#3acfff;
  box-shadow:0 0 0 0.25rem rgba(0, 120, 250, 0.1);
 
}

::-webkit-datetime-edit {}
::-webkit-datetime-edit-fields-wrapper {}
::-webkit-datetime-edit-month-field:hover,
::-webkit-datetime-edit-day-field:hover,
::-webkit-datetime-edit-year-field:hover {
  background:rgba(0, 120, 250, 0.1);
}
::-webkit-datetime-edit-text {
  opacity:0;
}
::-webkit-clear-button,
::-webkit-inner-spin-button {
  display:none;
}
::-webkit-calendar-picker-indicator {
  position:absolute;
  width:2.5rem;
  height:100%;
  top:0;
  right:0;
  bottom:0;
  
  opacity:0;
  cursor:pointer;
  
  color:rgba(0, 120, 250, 1);
  background:rgba(0, 120, 250, 1);
 
}

input[type="date"]:hover::-webkit-calendar-picker-indicator { opacity:0.05; }
input[type="date"]:hover::-webkit-calendar-picker-indicator:hover { opacity:0.15; }

</style>
</head>
<body>
    <h4 > Party Payment</h4>
<div class="row m-1" style="padding-left:30px;padding-right:30px;" >
      <!-- <div class="col-md-1">
          <input type="button" value="Back"  class="btn btn-success" onclick="closeCurrentTab()">
      </div> -->
      <br>
      <div class="col-lg-2 col-md-4 col-sm-4">
          <input type="text"  id="total" value="0" class="form-control">
      </div>
      <div class="col-lg-2 col-md-4 col-sm-4">
          <input type="text" id="trans_id"  class="form-control" placeholder="Trans_id">
      </div>
        <div class="col-lg-2 col-md-4 col-sm-4">
        <select class="form-control" id="payment_mode">
            <option  value="" disabled="true" selected="true">Payment Mode</option>    
            <option value="Check">Check</option>
            <option value="BOB_Next">BOB Next</option>
            <option value="ICICI"> ICICI </option>
            <option value="RTGS">RTGS</option>
            <option value="NEFT">NEFT</option>
            <option value="Credit_Card">Credit Card</option>
          </select>   
        </div>
        <div class="col-lg-2 col-md-4 col-sm-4">
        <input type="date" id="payment_date" value="<?php echo date('Y-m-d',time())?>" min="2021-01-01" max="2025-01-01">
      </div> 
      <div class="col-lg-4 col-md-4 col-sm-4" style="padding-right:35px;">
    <textarea class="form-control" id="remark" style="margin-left:20px;" placeholder="Enter Your Remark "rows="1"></textarea>
  </div>
    </div>
<br>
<br>
    <div class="row m-1" style="padding-left:30px;padding-right:30px;">
    <div class="col-md-6">
          <input type="button" value="Back"  class="btn btn-success" onclick="closeCurrentTab()">
      </div>
      <div class="col-md-6">
          <button type="button" style="margin-left:90%;"name="btn_save" id="btn_save" class="btn btn-info">Save</button>
      </div>
</div>
    <?php if(isset($_SESSION['mess'])): ?>
    <div class="alert alert-primary font-weight-bold font-italic">
      <?php echo $_SESSION['mess']; ?>
    </div>
    <?php unset($_SESSION['mess']); ?>
    <?php endif; ?>
<section>
<div class="table-responsive">
			<table class="table" id="example">
				<thead>
					<tr style="background-color: #00bcd4; color: white;">
          <th  style="width:250px;">Party</th>
          <th>Bill_No</th>
          <th>Bill_Date</th>
          <th>mat_ord_by</th>
          <th>Bill_Amt</th>
          <th>Bal_amt</th>
          <th>Paid_Amt</th>
          <th>Due_Date</th>
          <!-- <th>upload</th> -->
          <th>Ctrl</th>
					</tr>
				</thead>
				<tbody>
				<?php
        include('..\..\..\dbcon.php');
            $party= $_GET['party'];


        $sql="SELECT * from inward_com where bill_receive = 1 AND bill_send = 1 AND mat_from_party='$party' ORDER BY payment_due asc";
        $run=sqlsrv_query($con,$sql);
        $params = array();
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $run1=sqlsrv_query($con,$sql,$params,$options);
        $row1=sqlsrv_num_rows($run1);
        if ($row1 > 0) {

        while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
        $sql2="SELECT party_name from rm_party_master where pid='".$row['mat_from_party']."'";
        $run2=sqlsrv_query($con,$sql2);
        $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

        $sql3="SELECT SUM(payment_amt) as payment_value FROM payment_table where sr_no='".$row['sr_no']."' AND receive_at='".$row['receive_at']."'";
        $run3=sqlsrv_query($con,$sql3);
        $row3 = sqlsrv_fetch_array($run3, SQLSRV_FETCH_ASSOC);

        $bal_amt = floatval($row['total_bill_amt'])-floatval($row3['payment_value']);
          if ($bal_amt <= 0) {
                         continue;
                               }
        ?>
        <tr class="text-center font-italic" id="<?php echo $row["sr_no"].$row['receive_at']; ?>">
          <td><?php echo $row2['party_name'];  ?></td>
          <td><?php echo $row['invoice_no'];  ?></td>
          <td><?php echo $row['invoice_date']->format('d.M.Y');  ?></td>
          <td><?php echo $row['mat_ord_by'];  ?></td>
          <td><?php echo $row['total_bill_amt'];  ?></td>
          <td id="bill_amt_value" class="font-weight-bold"><?php echo $row['total_bill_amt']-$row3['payment_value'];  ?></td>
          <td><input type="number" step="0.01" name="paidAmt[]" style="width: 90px;" class="paidAmt"></td>
          <td><?php echo $row['payment_due']->format('d.M.Y');  ?></td>
         <!--  <td>
          <input type="file" data-max-size="500" name="file_upload[]"  id="file_upload" style="margin: 2px" required>
          </td> -->
          <td><input type="checkbox" name="sr_no[]" class="largerCheckbox" id="check_box" value="<?php echo $row["sr_no"].$row['receive_at']; ?>" /></td>
          
        </tr>
        <?php
        }
        ?>
        <?php
        }
        else{}

        ?>
			</table>
		</div>
  <br>
  <br>
 
</section>
  </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
$("i").click(function () {
  $("input[type='file']").trigger('click');
});

$('input[type="file"]').on('change', function() {
  var val = $(this).val();
  $(this).siblings('span').text(val);
})
    $(window).on("load resize ", function() {
  var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
  $('.tbl-header').css({'padding-right':scrollWidth});
}).resize();

      $(document).ready(function(){

    $('#btn_save').click(function(){
      var ti = $("#trans_id").val();
      var pm = $("#payment_mode").val();
      if (ti == '' || pm == null) {
          alert('Transaction ID and Payment Mode both are mandatory');
      }
      else{
    if(confirm("Are you sure you want to Pay this?"))
    {
    var id = [];
    
    var pa = $("#total").val();
    var pd = $("#payment_date").val();
    var re = $("#remark").val();
    $(':checkbox:checked').each(function(i){
    id[i] = $(this).val();
    

    });
    //remove blank value in array
    
    if(id.length == 0) //tell you if the array is empty
    {
    alert('Please Select at least one checkbox');
    }
    else
    {
    $.ajax({
    url:'payment_to_db.php',
    method:'POST',
    data:{id:id,pa:pa,ti:ti,re:re,pm:pm,pd:pd},
    success:function()
    {

    for(var i=0; i<id.length; i++)
    {
      $('tr#'+id[i]+'').css('background-color', '#ccc');
      $('tr#'+id[i]+'').fadeOut('slow');
    }
    },
    complete:function()
    {
      location.reload(true);
    }

    });
    }

    }
    else
    {
    return false;
    }
  }
    });
    // Add bill_amt value to textbox
    $(document).on('click', '#check_box', function(){
        var bill = $(this).closest('tr').find('#bill_amt_value').text();
        var tot = $("#total").val();
         if(this.checked)
      {
        var x = parseFloat(bill) + parseFloat(tot);
        $('#total').val((x).toFixed(2));
      }
      else{
        var x =  parseFloat(tot) - parseFloat(bill);
        $('#total').val((x).toFixed(2));
      }
      });
    });
    // ------End------
        function closeCurrentTab() {
        var conf = confirm("Are you sure, you want to close this tab?");
        if (conf == true) {
            close();
        }
    }
    </script>
<?php
  }
  else{
    $_SESSION['utype'] = "You Are Not Authorized!!";
            header("location:..\..\dashboard.php");
  }
?>
