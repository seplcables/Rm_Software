<?php
include('..\..\dbcon.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purchase_Report</title>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />

    <style type="text/css">
        ::-webkit-input-placeholder { /* Edge */
                color: #b3b3cc;
                font-style: italic;
                /*font-size: 12px;*/
                font-family: "Times New Roman", Times, serif;
            }
    #trow{
    border-style: double;
 border-color: red;   
 background-color: #f0d6a3;    
color: black;
font-size: 12px;
font-family:Sitka Text;
text-align: center;
    }
    thead input {
    width: 100%;
    padding: 2px;
    box-sizing: border-box;
}
 #close1,#close2,#close3
   {
        font-weight: bold;
        color: red;
        font-size: 16px;
        cursor: pointer;
   } 
   
        </style>
        <script type="text/javascript">
            $(function()
            {
               
               $("#getitem").select2();
                    
            }); 

            
        </script>
</head>
<body>
        
        <form action="report-old.php" method="get" id="myForm">
            <div class="row">
                <div class="container-fluid">
                    <a href="..\dashboard.php" class="btn btn-warning"><<< Back</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="report-old.php?getcat=&fromdate=&todate=" class="btn btn-info reset">Reset All</a>
                </div>
                <div class="col-md-3">
                    <label id="getitemtest"><h4>From Date</h4></label>
                    <input type="date" name="fromdate" id="fromdate" class="form-control" style="height:45px;">
                </div>
                <div class="col-md-3">
                    <label id="getitemtest"><h4>To Date</h4></label>
                    <input type="date" name="todate" id="todate" class="form-control" style="height:45px;">
                </div>
                <div class="col-md-3">
                    <label id="getitemtest"><h4>Select Category</h4></label>
                    <select class="form-control" name="getcat" id="getitem">
                        <option value="">--Select Category--</option>
                        <?php
                        $sql = "SELECT distinct a.c_code, a.category FROM rm_category a order by a.c_code ASC";
                            $run = sqlsrv_query($con,$sql);
                            while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
                            {
                        ?>
                        <option value="<?php echo $row['c_code']; ?>"><?php echo $row['category']; ?></option>    
                        <?php } ?>                
                    </select>
                </div>
                <div class="col-md-12">
                    <!-- <input type="hidden" name="getdata" value="1"> -->
                    <br/><input type="submit" class="btn btn-info" name="item" id="item">
                </div>
            </div>   
        </form>
        <hr/>
        <div class="row d-flex" style="padding-left:10px;">
            <div class="col-md-3">
                <label><h4><b>From Date</b></h4></label><br/>
                <?php if($_GET['fromdate'] != ""){ ?><span><?php echo date('d-M-Y',strtotime($_GET['fromdate'])); ?>&nbsp;&nbsp;&nbsp;<span id="close1">X</span></span><?php } ?>
            </div>
            <div class="col-md-3">
                <label><h4><b>To Date</b></h4></label><br/>
                <?php if($_GET['todate'] != ""){ ?><span>
                    <?php echo date('d-M-Y',strtotime($_GET['todate'])); ?>&nbsp;&nbsp;&nbsp;<span id="close2">X</span></span><?php } ?>
            </div>
            <div class="col-md-3">
                <label><h4><b>Category</b></h4></label><br/>
                <?php if($_GET['getcat'] != "") {
                    $sql1 = "SELECT distinct a.c_code, a.category FROM rm_category a where a.c_code = '".$_GET['getcat']."'";
                    $run1 = sqlsrv_query($con,$sql1);
                    $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
                ?>
                <span><?php echo $row1['category']; ?>&nbsp;&nbsp;&nbsp;<span id="close3">X</span></span><?php } ?>
            </div>
        </div><hr/>
        <div class="table-responsive ml-1">
            <table class="table table-bordered table-striped table-sm display nowrap" id="example" style="width:200%">
                <thead id="t_head">
                    <tr id="trow">
                        <th>Sr.No</th>
                        <th>Receive_at</th>
                        <th>Po_No</th>
                        <th>Receive_dte</th>
                        <th>I_no</th>
                        <th>I_date</th>
                        <th>Party</th>
                        <th>Ord_By</th>
                        <th>Category</th>
                        <th>Main_grade</th>
                        <th>Sub_Grdae</th>
                        <th>Item Description</th>
                        <th>plant</th>
                        <th>Project</th>
                        <th>Sub_Project</th>
                        <th>Job No</th>
                        <th>Remarks</th>
                        <th>PKG</th>
                        <th>Unit</th>
                        <th>Qnty</th>
                        <th>Rate</th>
                        <th>Basic_amt</th>
                        <th>GST Type</th>
                        <th>GST Amt</th>
                        <th>Total_bill_amt</th>
                        <th>Payable_Amt</th>
                        <th>Mat Used by</th>
                        <th>MachineNo</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Plant</th>
                        <th>PO_project</th>
                        <th>PO_Sub_project</th>
                        <th>Type</th>
                        <th>OLD Part Status</th>
                    </tr>
                </thead>

                <tfoot>
                    <tr id="trow">
                        <th>Sr.No</th>
                        <th>Receive_at</th>
                        <th>Po_No</th>
                        <th>Receive_dte</th>
                        <th>I_no</th>
                        <th>I_date</th>
                        <th>Party</th>
                        <th>Ord_By</th>
                        <th>Category</th>
                        <th>Main_grade</th>
                        <th>Sub_Grdae</th>
                        <th>Item Description</th>
                        <th>plant</th>
                        <th>Project</th>
                        <th>Sub_Project</th>
                        <th>Job No</th>
                        <th>Remarks</th>
                        <th>PKG</th>
                        <th>Unit</th>
                        <th>Qnty</th>
                        <th>Rate</th>
                        <th>Basic_amt</th>
                        <th>GST Type</th>
                        <th>GST Amt</th>
                        <th>Total_bill_amt</th>
                        <th>Payable_Amt</th>
                        <th>Mat Used by</th>
                        <th>MachineNo</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Plant</th>
                        <th>PO_project</th>
                        <th>PO_Sub_project</th>
                        <th>Type</th>
                        <th>OLD Part Status</th>
                    </tr>
                </tfoot>
               
            </table>
        </div>
<script type="text/javascript">
    $(document).ready(function() 
    {
        var cat = '<?php echo $_GET['getcat']; ?>';
        if(cat == "")
        {
            var catg = "";
        }
        else
        {
            var catg = cat;
        }

        var fromdt = '<?php echo $_GET['fromdate']; ?>';
        if(fromdt == "")
        {
            var fdt = "";
        }
        else
        {
            var fdt = fromdt;
        }
        
        var todt = '<?php echo $_GET['todate']; ?>';
        if(todt == "")
        {
            var todtt = "";
        }
        else
        {
            var todtt = todt;
        }
            $('#example tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" class="" placeholder="'+title+'" />' );
            });
            
            var table = $('#example').DataTable({  
                    
                    "processing": true,
                    "order": [[ 0, "desc" ]],
                    "dom": 'Bfrtip',
                     
                    "columns": [
                { data: "sr_no" },
                { data: "receive_at" },
                { data: "p_po_no" },
                { data: "rec_date" },
                { data: "invoice_no" },
                { data: "inv_date" },
                { data: "party_name" },
                { data: "mat_ord_by" },
                { data: "category" },
                { data: "main_grade" },
                { data: "sub_grade" },
                { data: "item" },
                { data: "plant" },
                { data: "p_project" },
                { data: "sub_project" },
                { data: "p_job" },
                { data: "p_remark" },
                { data: "p_pkg" },
                { data: "p_unit" },
                { data: "rec_qnty" },
                { data: "pur_rate" },
                { data: "basic_rate" },
                { data: "gst_per" },
                { data: "gst_amt" },
                { data: "total_amt" },
                { data: "total_bill_amt" },
                { data: "matUsedBy" },
                { data: "mcno" },
                { data: "superviser" },
                { data: "department" },
                { data: "plant" },
                { data: "po_project" },
                { data: "sub_project" },
                { data: "type" },
                { data: "old_status" },
        
            ],
            "ajax": {

                url: 'getreport-old.php',
                type:"get",
                data:{getcat:catg,fromdate:fdt,todate:todtt},
                "dataSrc" : ""
            },

              
             lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength', 'excel', 'print',
         ],
            initComplete: function () {
            // Apply the search
                this.api().columns().every( function () {
                    var that = this;
     
                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    } );
                });
            }


        });

            function newexportaction(e, dt, button, config) {
             var self = this;
             var oldStart = dt.settings()[0]._iDisplayStart;
             dt.one('preXhr', function (e, s, data) {
                 // Just this once, load all data from the server...
                 data.start = 0;
                 data.length = 2147483647;
                 dt.one('preDraw', function (e, settings) 
                 {
                     // Call the original action function
                    if (button[0].className.indexOf('buttons-excel') >= 0) 
                     {
                            $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                    } 
                     dt.one('preXhr', function (e, s, data) {
                         settings._iDisplayStart = oldStart;
                         data.start = oldStart;
                     });
                     // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                     setTimeout(dt.ajax.reload, 0);
                     // Prevent rendering of the full data to the DOM
                     return false;
                 });
             });
             // Requery the server with the new one-time export settings
             dt.ajax.reload();
         }
});
//end ready fn.

            $('#getitem').on('change', function(){
                var currentVal1 = $(this).val();
                localStorage.setItem('selectVal1', currentVal1 );
            });
            
            $(document).on('click','#close1', function(){
                $('#getitem').val('');
                 localStorage.selectVal1 = '';
                document.getElementById("myForm").submit();
            });

            $(document).on('click','#close2', function(){
                $('#fromdate').val('');
                 localStorage.selectVal1 = '';
                document.getElementById("myForm").submit();
            });
            $(document).on('click','#close3', function(){
                $('#todate').val('');
                 localStorage.selectVal2 = '';
                document.getElementById("myForm").submit();
            });
            
            
</script>
<link href='jquery/select2/css/select2.min.css' rel='stylesheet' type='text/css'>
            }
    <!-- jQuery UI -->
    <script src='jquery/select2/js/select2.full.min.js' type='text/javascript'></script>
</body>
</html>