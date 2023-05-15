<html lang="en">
<head>
<meta charset="UTF-8">
<title>Set Min/Max Qnty Limit</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
 	<h3 class="bg-info" style="color: white" align="center">SET MIN/MAX QNTY LIMIT</h3> 
 	<br>
 	   <form action="minMaxLimit_db.php" method="post">
 	   	

 	   	<div class="form-row mt-2">

         <div class="form-group col-12">
         <label class="font-italic">Item Name<span id="star_req"> **</span></label>
         <input type="text"  name="item_name" id="item_name" class="form-control" onFocus="SearchItem(this)" required>
         <input type="hidden" name="i_code" id="i_code" class="form-control">
         </div>  
       </div>
       <div class="form-row mt-2">

         <div class="form-group col-lg-5 col-md-5 col-sm-5">
         <label class="font-italic">Is Limit Set??<span id="star_req"> **</span></label>
         <select name="is_lmt" id="is_lmt" class="ml-2" required>
         	<option>Yes</option>
         	<option>No</option>
         </select>
         </div>   
       </div>

       <div class="form-row mt-2">

         <div class="form-group col-lg-5 col-md-5 col-sm-5">
         <label class="font-italic">Min Limit<span id="star_req"> **</span></label>
            <input type="number" step="0.01" name="min_limit" id="min_limit" class="form-control" required>
       
         </div>
         <div class="col-2"></div>
         <div class="form-group col-lg-5 col-md-5 col-sm-5">
         <label class="font-italic">Max Limit<span id="star_req"> **</span></label>
            <input type="number" step="0.01" name="max_limit" id="max_limit" class="form-control">
         </div>
       </div>
			 
			
			 
			<div class="form-row mt-2">
			 	<div class="form-group col-lg-5 col-md-5 col-sm-5">
			 		 <button id="submit" name="submit" class="button btn-info" style="width:350px;border-radius: 30px"><span>Sumbit</span></button>
			 			
			 		</button>
			 	</div>
			 </div>
		</form>
	</div>
</div>
<script type="text/javascript">
	      //ITEM seach
      function SearchItem(txtBoxRef) {
      console.log('function call');
        var f = true; //check if enter is detected
        $(txtBoxRef).keypress(function (e) {
            if (e.keyCode == '13' || e.which == '13')
            {
                f = false;
            }
        });
        $(txtBoxRef).autocomplete({
            
   source: function( request, response ) {
   // Fetch data
   $.ajax({
    url: "getitem.php",
    type: 'post',
    dataType: "json",
    data: {
     item: request.term
    },
    success: function( data ) {
     response( data );
    }
   });
  },
  select: function (event, ui) {
   // Set selection
   var self = this;
   $('#item_name').val(ui.item.label);
   $('#i_code').val(ui.item.i_code);
   $('#min_limit').val(ui.item.min);
   $('#max_limit').val(ui.item.max);
   

   return false;
  },
  change: function (event, ui)  //if not selected from Suggestion
      {
        if (f)
        {
          if (ui.item == null)
          {
            $(this).val('');
            $(this).focus();
          }
          /*else{
                  $(this).closest('tr').find('.qty').focus();
          }*/
        }

      }

         });
      
}
</script>
</body>
</html>

