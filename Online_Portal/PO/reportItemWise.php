<?php
include('..\..\dbcon.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
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
   #close1,#close2,#close3,#close4
   {
        font-weight: bold;
        color: red;
        font-size: 16px;
   } 
   #close1:hover
   {
        border: 1px solid black;
        cursor: pointer;
   }
   #close2:hover
   {
        border: 1px solid black;
        cursor: pointer;
   }
   #close3:hover
   {
        border: 1px solid black;
        cursor: pointer;
   }
   #close4:hover
   {
        border: 1px solid black;
        cursor: pointer;
   }
   
        </style>
        <script type="text/javascript">
            $(function()
            {
               
               $("#getitem").select2();
               $("#getparty").select2();
               $("#getmaingrade").select2();
               $("#getsubgrade").select2();

                $('#getitem').val(localStorage.selectVal1);
                $('#getitem').select2().trigger('change');

                $('#getparty').val(localStorage.selectVal2);
                $('#getparty').select2().trigger('change');


                $('#getmaingrade').val(localStorage.selectVal3);
                $('#getmaingrade').select2().trigger('change');


                $('#getsubgrade').val(localStorage.selectVal4);
                $('#getsubgrade').select2().trigger('change');

                //localStorage.removeItem('selectVal');
               //var $select = $("#getitem").select2({});
               //$('#getitem').append(new Option(localStorage.selectVal, localStorage.selectVal)).selected();
               //$("#getitem").val(localStorage.selectVal).trigger("chosen:updated");

               //alert(localStorage.selectVal);
               //$("#test").val(localStorage.selectVal);    
               //$("#getitem option[value='"+localStorage.selectVal+"']").attr('selected', true);
                    
            }); 

            $(document).on('click',".reset",function(){
                 localStorage.selectVal1 = '';
                localStorage.selectVal2 = '';
                localStorage.selectVal3 = '';
                localStorage.selectVal4 = '';
            });
        </script>
    </head>
    <body>
        <h3 class="bg-primary" align="center">ITEM HISTORY</h3>
        <form action="reportItemWise.php?getdata=1" method="post" id="myForm">
        <div class="row">
            <div class="container-fluid">
                <div class="col-md-12"><a href="..\dashboard.php" class="btn btn-warning"><<< Back</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="reportItemWise.php" class="btn btn-info reset">Reset All</a>
                </div>

                <div class="col-md-3">
                    <label id="getitemtest"><h4>Select Item</h4></label>
                    <select class="form-control" name="getitem" id="getitem">
                        <option value="">--Select Item--</option>
                        <?php
                        $sql = "SELECT distinct d.item, a.id FROM inward_ind a LEFT OUTER JOIN rm_item d on d.i_code= a.p_item order by a.id desc";
                            $run = sqlsrv_query($con,$sql);
                            while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
                            {
                        ?>
                        <option value="<?php echo $row['item']; ?>"><?php echo $row['item']; ?></option>    
                        <?php } ?>                
                    </select>
                </div>
                <div class="col-md-3">
                   <label><h4>Select Party</h4></label>
                    <select class="form-control" name="getparty" id="getparty">
                        <option value="">--Select Party--</option>
                        <?php
                        $sql = "SELECT distinct c.party_name FROM inward_com b LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party order by  c.party_name desc";
                            $run = sqlsrv_query($con,$sql);
                            while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
                            {
                        ?>
                        <option value="<?php echo $row['party_name']; ?>"><?php echo $row['party_name']; ?></option>    
                        <?php } ?>                
                    </select>
                </div>
                <div class="col-md-3">
                    <label><h4>Select Main Grade</h4></label>
                    <select class="form-control" name="getmaingrade" id="getmaingrade">
                        <option value="">--Select Main Grade--</option>
                        <?php
                        $sql = "SELECT distinct f.main_grade FROM rm_item d  LEFT OUTER JOIN rm_m_grade f on f.m_code= d.m_code
                        order by f.main_grade desc";
                            $run = sqlsrv_query($con,$sql);
                            while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
                            {
                        ?>
                        <option value="<?php echo $row['main_grade']; ?>"><?php echo $row['main_grade']; ?></option>    
                        <?php } ?>                
                    </select>
                </div>        
                <div class="col-md-3">
                    <label><h4>Select Sub Grade</h4></label>
                    <select class="form-control" name="getsubgrade" id="getsubgrade">
                        <option value="">--Select Sub Grade--</option>
                        <?php
                        $sql = "SELECT distinct e.sub_grade FROM rm_item d LEFT OUTER JOIN rm_s_grade e on e.s_code= d.s_code
                        order by e.sub_grade desc";
                            $run = sqlsrv_query($con,$sql);
                            while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
                            {
                        ?>
                        <option value="<?php echo $row['sub_grade']; ?>"><?php echo $row['sub_grade']; ?></option>    
                        <?php } ?>                
                    </select>
                </div>
                <div class="col-md-12">
                    <!-- <input type="hidden" name="getdata" value="1"> -->
                    <br/><input type="submit" class="btn btn-info" name="item" id="item" value="Get Report">
                </div>
            </div>    
        </div>
        </form><hr/>
        <div class="row d-flex">
            <div class="col-md-3">
                <label>Item</label><br/>
                <?php if(isset($_GET['getdata'])){ if($_POST['getitem'] != ""){ ?><span><?php echo $_POST['getitem']; ?>&nbsp;&nbsp;&nbsp;<span id="close1">X</span></span><?php } } ?>
            </div>
            <div class="col-md-3">
                <label>Party</label><br/>
                <?php if(isset($_GET['getdata'])){ if($_POST['getparty'] != ""){ ?><span><?php echo $_POST['getparty'] ?>&nbsp;&nbsp;&nbsp;<span id="close2">X</span></span><?php } } ?>
            </div>
            <div class="col-md-3">
                <label>Main Grade</label><br/>
                <?php if(isset($_GET['getdata'])){ if($_POST['getmaingrade'] != ""){ ?><span><?php echo $_POST['getmaingrade'] ?>&nbsp;&nbsp;&nbsp;<span id="close3">X</span></span><?php } } ?>
            </div>
            <div class="col-md-3">
                <label>Sub Grade</label><br/>
                <?php if(isset($_GET['getdata'])){ if($_POST['getsubgrade'] != ""){ ?><span><?php echo $_POST['getsubgrade'] ?>&nbsp;&nbsp;&nbsp;<span id="close4">X</span></span><?php } } ?>
            </div>
        </div><hr/>
        <div class="table-responsive ml-1">
            <table class="table table-bordered table-striped table-sm" id="example" style="width:200%">
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
                        <th>Job No</th>
                         <th>Remarks</th>
                         <th>PKG</th>
                         <th>Unit</th>
                        <th>Qnty</th>
                        <th>Rate</th>
                        <th>Basic_amt</th>
                         <th>GST</th>
                        <th>Total_bill_amt</th>
                        <th>Payable_Amt</th>
                    </tr>
                </thead>
                <tbody>
                   
                    <?php
                    if(isset($_GET['getdata']))
                    {
                        $srno = 1;
                        $sql = "SELECT b.sr_no,b.receive_at, a.id, a.p_po_no,format(b.receive_date,'dd-MMM-yyyy') as rec_date,b.invoice_no,format(b.invoice_date,'dd-MMM-yyyy') as inv_date,c.party_name,g.category,f.main_grade,e.sub_grade,d.item,
                            b.mat_ord_by,a.p_project,a.plant,a.p_job,a.p_remark,a.p_pkg,a.p_unit,a.rec_qnty,a.pur_rate,(a.rec_qnty*a.pur_rate) as basic_rate,a.gst_amt,a.total_amt,b.total_bill_amt FROM inward_ind a
                            LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
                            LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
                            LEFT OUTER JOIN rm_item d on d.i_code= a.p_item
                            LEFT OUTER JOIN rm_s_grade e on e.s_code= d.s_code
                            LEFT OUTER JOIN rm_m_grade f on f.m_code= d.m_code
                            LEFT OUTER JOIN rm_category g on g.c_code= d.c_code where a.id > 0 ";

                        if($_POST['getitem'] != "")
                        {
                            $sql .= "AND d.item = '".$_POST['getitem']."' ";    
                        }
                        if($_POST['getparty'] != "")
                        {
                            $sql .= "AND c.party_name = '".$_POST['getparty']."' ";    
                        }
                        if($_POST['getmaingrade'] != "")
                        {
                            $sql .= "AND f.main_grade = '".$_POST['getmaingrade']."' ";    
                        }
                        if($_POST['getsubgrade'] != "")
                        {
                            $sql .= "AND e.sub_grade = '".$_POST['getsubgrade']."' ";    
                        }   
                        
                        $sql .= " order by b.sr_no ASC";

                        //echo $sql;
                        $run = sqlsrv_query($con,$sql);
                        while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
                        {
                                
                    ?>
                    <tr>
                        <td><?php echo $row['sr_no']; ?><input type="hidden" name="idd" class="idd" value="<?php echo $row['id']; ?>"/></td>
                        <td><?php echo $row['receive_at']; ?></td>
                        <td><?php echo $row['p_po_no']; ?></td>
                        <td><?php echo $row['rec_date']; ?></td>
                        <td><?php echo $row['invoice_no']; ?></td>
                        <td><?php echo $row['inv_date']; ?></td>
                        <td><?php echo $row['party_name']; ?></td>
                        <td><?php echo $row['mat_ord_by']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['main_grade']; ?></td>
                        <td><?php echo $row['sub_grade']; ?></td>
                        <td><?php echo $row['item']; ?></td>
                        <td><?php echo $row['plant']; ?></td>
                        <td><?php echo $row['p_project']; ?></td>
                        <td><?php echo $row['p_job']; ?></td>
                        <td><?php echo $row['p_remark']; ?></td>
                        <td><?php echo $row['p_pkg']; ?></td>
                        <td><?php echo $row['p_unit']; ?></td>
                        <td><?php echo $row['rec_qnty']; ?></td>
                        <td><?php echo $row['pur_rate']; ?></td>
                        <td><?php echo $row['basic_rate']; ?></td>
                        <td><?php echo $row['gst_amt']; ?></td>
                        <td><?php echo $row['total_amt']; ?></td>
                        <td><?php echo $row['total_bill_amt']; ?></td>
                    </tr>
                <?php 
                 } }  ?> 
                </tbody>
            </table>
        </div>
        <style type="text/css">
            .temp
            {
                display: flex;
                //border:  1px solid red;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function() 
            {
                
                //$("select#getitem option[value="+localStorage.selectVal+"]").attr('selected', true);
                // Setup - add a text input to each footer cell
                // $('#example thead th').each( function () 
                // {
                //         var title = $(this).text();
                //         $(this).html( '<input type="text" name="remark1" class="" placeholder="'+title+'" />' );
                // });
                
                // $('#example tfoot th').each( function () 
                // {
                //     var title = $(this).text();
                //     $(this).html( '<input type="text" class="" placeholder="'+title+'" />' );
                // });
                //    
                var table = $('#example').DataTable({  
                    

                    "processing": true,
                    "order": [[ 0, "desc" ]],
                    "dom": 'Bfrtip',
                     lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
                buttons: [
                    'pageLength', 'excel', 'print'
                ],
            });


    //             if (localStorage.selectVal) {
    //         // Select the value stored
    //     $('select').val( localStorage.selectVal );
    // }
        });

            $('#getitem').on('change', function(){
                var currentVal1 = $(this).val();
                localStorage.setItem('selectVal1', currentVal1 );
            });
            $('#getparty').on('change', function(){
                var currentVal2 = $(this).val();
                localStorage.setItem('selectVal2', currentVal2 );
            });
            $('#getmaingrade').on('change', function(){
                var currentVal3 = $(this).val();
                localStorage.setItem('selectVal3', currentVal3 );
            });
            $('#getsubgrade').on('change', function(){
                var currentVal4 = $(this).val();
                localStorage.setItem('selectVal4', currentVal4 );
            });

            $(document).on('click','#close1', function(){
                $('#getitem').val('');
                 localStorage.selectVal1 = '';
                document.getElementById("myForm").submit();
            });
            $(document).on('click','#close2', function(){
                $('#getparty').val('');
                 localStorage.selectVal2 = '';
                document.getElementById("myForm").submit();
            });
            $(document).on('click','#close3', function(){
                $('#getmaingrade').val('');
                 localStorage.selectVal3 = '';
                document.getElementById("myForm").submit();
            });
            $(document).on('click','#close4', function(){
                $('#getsubgrade').val('');
                 localStorage.selectVal4 = '';
                document.getElementById("myForm").submit();
            });

            // ...

            
                
            
        </script>
        <link href='jquery/select2/css/select2.min.css' rel='stylesheet' type='text/css'>
            }
    <!-- jQuery UI -->
    <script src='jquery/select2/js/select2.full.min.js' type='text/javascript'></script>
    </body>
</html>