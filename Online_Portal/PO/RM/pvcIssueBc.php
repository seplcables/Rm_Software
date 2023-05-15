<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>pvcIsuue</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Jquery cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- modal cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- data table cdn -->
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <style type="text/css">
        hr{
            margin: 0.3rem 0 1rem 0;
        }
        #Pvc_data td{
            padding: 0;
        }
        #Pvc_data input{
            outline: none;
            box-shadow: none;
            border: none;
            width: 100%;
            padding: 5px 6px;
        }
        /*----toggle switch css-----*/
        .switch 
        {
          position: relative;
          display: inline-block;
          width: 55px;
          height: 30px;
        }
        .switch input { 
          opacity: 0;
          width: 0;
          height: 0;
        }
        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }
        .slider:before {
          position: absolute;
          content: "";
          height: 22px;
          width: 22px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }
        input:checked + .slider {
          background-color: blue;
        }
        input:focus + .slider {
          box-shadow: 0 0 1px blue;
        }
        input:checked + .slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
        }
        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }
        .slider.round:before {
          border-radius: 50%;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-auto">
                <a href="../../dashboard.php" class="btn btn-danger">Back</a>
            </div>
            <div class="col-auto">
                <label class="switch float-end">
                    <input type="checkbox" id="toggle_checkbox" value="yes">
                    <span class="slider round"></span>
                </label>
                <input type="hidden" name="isreturn" id="isreturn" value="no">
            </div>   
            <div class="col text-center" style="margin-left: 50px;">
                <h3>Pvc Issue</h3>
            </div>
            <div class="col-auto mx-1">
                <input type="date" id="date_selec" class="form-control" value="<?php echo date('Y-m-d'); ?>"> 
            </div>
            <div class="col-auto p-0">
                <input type="text" id="mcno" class="form-control" placeholder="Enter Mc No">
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary" id="savebtn">Save Data</button>
            </div>
        </div><hr/>
        <div>
            <form id="formData">
                <table class="table table-bordered table-sm" id="Pvc_data" style="width: 100%;">
                    <thead>
                        <tr class="bg-secondary text-white text-center font-italic">
                            <th style="width:5%">SrNo</th>
                            <th style="width:25%">BARCODE ID *</th>
                            <th style="width:12%">Rmta</th>
                            <th style="width:25%">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="srno text-center" value="1" readonly></td>
                            <td><input type="text" class="barcode_id" name="barcode_id[]" required autocomplete="off"></td>
                            <td><input type="text" class="rmta" name="rmta[]" readonly></td>
                            <td><input type="text" class="grade" name="grade[]" readonly></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <!-- Toast message -->
<div class="toast-container position-absolute bottom-0 end-0 p-3">
 <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body fw-bold">
      Duplicate Found!!!
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>
</div>

</body>
</html>

<script type="text/javascript">
	// scan barcode
    $(document).on('keydown', '.barcode_id', function(e) {
        var $this = $(this);
        if (e.keyCode == 13) {
            var bc = $(this).val();
            var arr = bc.split('/');
            // Function call
            if (barCode(bc)) {
            	$('.toast').toast({delay: 1000});
                $('.toast').toast('show');
            	$(this).val('');
            	$(this).focus();
            } else {
                $.ajax({
					url:"getBarcodeData.php",
					method:"POST",
					data:{iid:arr[0]},
					dataType:"json",
					success:function(data){
						$this.closest('tr').find('.rmta').val(data['sr_no']);
						$this.closest('tr').find('.grade').val(data['item']);
					},
					complete:function(){
        				var row = $('#Pvc_data').find('tbody tr:first');
        				var tr = row.clone();
        				tr.find('input').val('');
        				var sr = parseFloat($('#Pvc_data').find('tbody tr:last .srno').val())+parseFloat(1);
        				tr.find('.srno').val(sr);
        				$('#Pvc_data').find('tbody').append(tr);
        				$('#Pvc_data').find('tbody tr:last .barcode_id').focus();
        			}
				});
            }
        }
    });

    // function for input value
    function barCode(inputVal){
        // check database variable
        var bc;
        $.ajax({
            url:"getBarcodeData.php",
            method:"POST",
            data:{bc:inputVal},
            dataType:"json",
            async: false,
            success:function(data){
                bc = data['cnt'];
            }
        });
        // check on browser variable
        let barcodes = localStorage.getItem('barcode');
        if (barcodes == null) {
            barcodeObj = [];
        } else {
            barcodeObj = JSON.parse(barcodes);
        }

        if (barcodeObj.includes(inputVal) || bc == '1') {
    		return true;
        } else {
            barcodeObj.push(inputVal);
            localStorage.setItem("barcode", JSON.stringify(barcodeObj));
            return false;
        }
    }

    // save data to database
    $(document).on("click","#savebtn",function()
    {
	    var mc = $("#mcno").val();
        var date = $('#date_selec').val();
        var isreturn = $('#isreturn').val();
        if(date == "")
        {
            $('#date_selec').focus();
            alert('Select Issue Date');
            return false;
        }
        if(mc == "")
        {
            $('#mcno').focus();
            alert('Enter Machine Number');
            return false;
        }

        $.ajax({
			type: "POST",
			url: "pvcIssueBc_db.php?mc="+mc+"&dt="+date+"&isreturn="+isreturn,
			// dataType:'json',
			data:$('#formData').serialize(),
			success: function (msg) {
				alert(msg);
			},
			complete:function(){
				localStorage.removeItem("barcode");
				location.reload(true);
			}
	    });
    });

    $(document).on('click','#toggle_checkbox', function(){
        var yes = $(this).val();
        if(this.checked){
            $('#isreturn').val('yes');
        }
        else{
            $('#isreturn').val('no');
        }
    });
</script>