<?php 
include('..\..\dbcon.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Issue Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!----------------------- jQuery UI --------------------------->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style type="text/css">
        .table th{
            background-color: #607d8b7d !important;
            font-size: 17px;
        }
        #example td{
            padding: 3px 8px;
        }
        .HOME{
            background-color: #ffcc00 !important;
        }
        #table1{
            width: 100%;
        }
        /*#table1 th,#table1 td{
          border: 1px solid black;
          padding: 2px 8px;
      }*/
      #table1 th{
        font-size: 16px;
      }
      #table1 input{
          border: none;
          box-shadow: none;
          outline: none;
          text-align: center;
      }
      
    </style>
    <style type="text/css">
        .w2ui-col-header{
                font-weight: bold !important;
                background: #ffeb3b73 !important;
        }
        .warning,.primary, .primary1{
            border: 1px solid #ff9800e0;
            border-radius: 5px;
            background: #ff9800e0;
            color: white;
            padding: 8px;
            margin: 0 5px;
            text-decoration: none;
            font-weight: 500;
        }  
        .primary{
            background: #2196f3 !important;
            border: 1px solid #2196f3 !important;
        }
        .primary1{
            background: #ea0d0d !important;
            border: 1px solid #ea0d0d !important;
        }
    </style>
    <script type="text/javascript">
     $(document).on('click','.upload',function () 
    {   
        var str = $(this).attr('data-id');
        $('#uploaddoc').modal('show');   
        $('#id').val(str);
        $('#idr').val(str);
    });

     $(document).on('click','.reupload',function () 
    {   
         var str = $(this).attr('data-id');
        $('#reuploaddoc').modal('show');   
        $('#idu').val(str);
        $('#idur').val(str);
    });
     //upload
    $(document).on('change','#flexRadioDefault1',function() 
    {
        $('#tcupload').show();
        $('#tcremark').hide();
    });
    $(document).on('change','#flexRadioDefault2',function()
    {
       $('#tcremark').show(); 
       $('#tcupload').hide(); 
    });

    //re-upload
    $(document).on('change','#filereupload1',function() 
    {
        $('#tcuploadupdate').show();
        $('#tcremarkupdate').hide();
    });
    $(document).on('change','#filereupload2',function()
    {
       $('#tcremarkupdate').show(); 
       $('#tcuploadupdate').hide(); 
    });
    </script>
</head>
<body>
     <div class="modal" id="uploaddoc">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Upload Document</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <!-- Modal body -->
                <div class="modal-body">
                <div class="content-body">
                <!-- row -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="email-right-box">
                                        <div class="col-md-12 d-flex">
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                              <label class="form-check-label" for="flexRadioDefault1">
                                                TC Upload
                                              </label>
                                            </div>
                                            <div class="form-check mx-5">
                                              <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                              <label class="form-check-label" for="flexRadioDefault2">
                                                Remark
                                              </label>
                                            </div>
                                        </div>
                                        <br/>
                                        <div id="tcupload">
                                            <div class="col-md-12 d-flex">
                                                <form action="recreceipt_upload.php" id="interviewForm" method="POST" enctype="multipart/form-data">
                                                    <div class="col-md-12">
                                                         <input type="file" name="myfiledoc" id="myfiledoc" accept=".pdf" required>
                                                    </div>
                                                    <br/>
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="id" id="id">
                                                        <input type="hidden" name="reason" id="reason" value="0">
                                                        <button class="btn btn-primary m-b-30 m-t-15 f-s-14 p-l-20 p-r-20 m-r-10" name="test_btn" type="submit" >Submit</button>
                                                    </div>
                                                 </form>
                                            </div>
                                        </div>
                                        <br/>
                                        <div  id="tcremark" style="display:none;">
                                            <div class="col-md-12 d-flex">
                                                <form action="recreceipt_upload.php" id="interviewForm" method="POST" enctype="multipart/form-data">
                                                    <div class="col-md-12">
                                                         <textarea cols="90" placeholder="Why tc receipt not uploaded?" rows="5" name="tcremarks" id="tcremarks" required></textarea>
                                                    </div>
                                                    <br/>
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="idr" id="idr">
                                                        <input type="hidden" name="reason" id="reason" value="1">
                                                        <button class="btn btn-primary m-b-30 m-t-15 f-s-14 p-l-20 p-r-20 m-r-10" name="test_btn" type="submit" >Submit</button>
                                                    </div>
                                                 </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
                <!-- #/ container -->
            </div>
        </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>

    <div class="modal" id="reuploaddoc">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Re-Upload Document</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <!-- Modal body -->
                <div class="modal-body">
                    <div class="content-body">
                <!-- row -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="email-right-box">
                                        <div class="col-md-12 d-flex">
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="filereupload" id="filereupload1" checked>
                                              <label class="form-check-label" for="filereupload1">
                                                TC Upload
                                              </label>
                                            </div>
                                            <div class="form-check mx-5">
                                              <input class="form-check-input" type="radio" name="filereupload" id="filereupload2">
                                              <label class="form-check-label" for="filereupload2">
                                                Remark
                                              </label>
                                            </div>
                                        </div>
                                        <br/>
                                        <div id="tcuploadupdate">
                                            <div class="col-md-12 d-flex">
                                                <form action="recreceipt_upload_update.php" id="interviewForm" method="POST" enctype="multipart/form-data">
                                                    <div class="col-md-12">
                                                         <input type="file" name="myfiledocu" id="myfiledocu" accept=".pdf">
                                                    </div>
                                                    <br/>
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="idu" id="idu">
                                                        <input type="hidden" name="reasonu" id="reasonu" value="0">
                                                        <button class="btn btn-primary m-b-30 m-t-15 f-s-14 p-l-20 p-r-20 m-r-10" name="test_btn" type="submit" >Submit</button>
                                                    </div>
                                                 </form>
                                            </div>
                                        </div>
                                        <br/>
                                        <div  id="tcremarkupdate" style="display:none;">
                                            <div class="col-md-12 d-flex">
                                                <form action="recreceipt_upload_update.php" id="interviewForm" method="POST" enctype="multipart/form-data">
                                                    <div class="col-md-12">
                                                         <textarea cols="90" placeholder="Why tc receipt not uploaded?" rows="5" name="tcremarksu" id="tcremarksu" required></textarea>
                                                    </div>
                                                    <br/>
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="idur" id="idur">
                                                        <input type="hidden" name="reasonu" id="reasonu" value="1">
                                                        <button class="btn btn-primary m-b-30 m-t-15 f-s-14 p-l-20 p-r-20 m-r-10" name="test_btn" type="submit" >Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
                <!-- #/ container -->
            </div>
        </div>
          <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
         
        </div>
      </div>
    </div>


    <div class="font-weight-bold bg-secondary p-1 text-white" align="center" style="font-size: 22px;">
      TC RECEIPT
    </div>
<div class="container" style="margin: 5px;"> <br>
    <a href="..\dashboard.php" class="warning"><<< Back</a>
    <a href="tcreceipt_report.php" class="primary">Load All Data</a>
    <a href="#" class="primary1" id="viewPendingData">Pending Data</a>
    <a href="#" class="btn btn-success" id="viewUploadedData">Uploaded Data</a><!-- 
    <a href="#" class="btn btn-info" id="viewmailbutton">Send Mail</a> -->
</div> <br/> 

<div class="container-fluid my-4">
        <div class="table-responsive container-fluid chnagedata">
            <table class="table table-bordered table-striped" id="example" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 5%;">no</th>
                        <th style="width: 5%;">rmta</th>
                        <th style="width: 10%;">receive_at</th>
                        <!-- <th style="width: 30%;">p_po_no</th> -->
                        <th style="width: 15%;">rec_date</th>
                        <th style="width: 10%;">invoice_no</th>
                        <th style="width: 10%;">inv_date</th>
                        <th style="width: 10%;">party_name</th>
                        <th style="width: 10%;">category</th>
                        <!-- <th style="width: 10%;">main_grade</th>
                        <th style="width: 10%;">Sub_grade</th>
                        <th style="width: 10%;">Item</th>
                        <th style="width: 10%;">Unit</th>
                        <th style="width: 10%;">Qnty</th>
                        <th style="width: 10%;">Rate</th> -->
                        <th style="width: 10%;">total_bill_amt</th>
                        <th style="width: 10%;">Remarks</th>
                        <th style="width: 10%;">Show</th>
                        <th style="width: 10%;">Reupload</th>
                    </tr>
                    
                </thead>
                <tbody>
                    <?php 

                        $srno = 1;
                        /*$sql = "
                        SELECT  b.sr_no,b.receive_at,a.p_po_no,format(b.receive_date,'dd-MMM-yyyy') as rec_date,b.invoice_no,format(b.invoice_date,'dd-MMM-yyyy') as inv_date,
    c.party_name,g.category,f.main_grade, a.p_unit, a.rec_qnty,a.pur_rate,b.total_bill_amt ,e.sub_grade,d.i_code, d.item
    FROM inward_ind a
    LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
    LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
    LEFT OUTER JOIN rm_item d on d.i_code= a.p_item
    LEFT OUTER JOIN rm_s_grade e on e.s_code= d.s_code
    LEFT OUTER JOIN rm_m_grade f on f.m_code= d.m_code
    LEFT OUTER JOIN rm_category g on g.c_code= d.c_code where g.c_code = '30' group by b.sr_no,b.receive_at,a.p_po_no,format(b.receive_date,'dd-MMM-yyyy'),
    b.invoice_no,format(b.invoice_date,'dd-MMM-yyyy'),
    c.party_name,g.category,f.main_grade,a.p_unit, a.rec_qnty,a.pur_rate,b.total_bill_amt, e.sub_grade, d.i_code, d.item order by b.sr_no desc";*/
    $sql = "SELECT a.sr_no,a.receive_at, format(a.receive_date,'dd-MMM-yyyy') as rec_date,c.party_name,format(a.invoice_date,'dd-MMM-yyyy') as inv_date,a.invoice_no,cast(a.total_bill_amt as float) as
                     total_bill_amt,a.bill_receive,a.bill_approve, a.Invoice_img_timestamp, e.c_code, e.category FROM inward_com a
LEFT OUTER JOIN rm_party_master c on c.pid= a.mat_from_party left outer join inward_ind b on b.sr_no = a.sr_no and b.receive_at = a.receive_at  
left outer join rm_item d on d.i_code = b.p_item left outer join rm_category e on e.c_code = d.c_code 
 WHERE receive_date >= '2022-01-01' and e.c_code = '30' GROUP BY a.sr_no,a.receive_at, a.receive_date,c.party_name,a.invoice_date,a.invoice_no,
 a.total_bill_amt,a.bill_receive,a.bill_approve, a.Invoice_img_timestamp, e.c_code, e.category  order by a.sr_no DESC";
                    // $sql = "SELECT  b.sr_no,b.receive_at,format(b.receive_date,'dd-MMM-yyyy') as rec_date,b.invoice_no,format(b.invoice_date,'dd-MMM-yyyy') as inv_date,
                    // c.party_name,g.category, b.total_bill_amt, g.c_code , g.category    FROM inward_com b 
                    // LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
                    // , rm_category g  where g.c_code = '30' and b.receive_date > '2022-12-01' group by b.sr_no,b.receive_at,format(b.receive_date,'dd-MMM-yyyy'),
                    // b.invoice_no,format(b.invoice_date,'dd-MMM-yyyy'),
                    // c.party_name,g.category,b.total_bill_amt, g.c_code, g.category order by b.sr_no asc";
                        $run = sqlsrv_query($con,$sql);
                        while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)){ 
                    ?>
                    <tr>
                        <td width="10px"><?php echo $srno; ?></td>
                        <td width="10px"><?php echo $row['sr_no']; ?></td>
                        <td><?php echo $row['receive_at']; ?></td>
                        <!-- <td><?php //echo $row['p_po_no']; ?></td> -->
                        <td><?php echo $row['rec_date']; ?></td>
                        <td><?php echo $row['invoice_no']; ?></td>
                        <td><?php echo $row['inv_date']; ?></td>
                        <td><?php echo $row['party_name']; ?></td>
                        <td><?php echo $row['c_code']."-".$row['category']; ?></td>
                        <!-- <td width="200px"><?php //echo $row['main_grade']; ?></td>
                        <td width="200px"><?php // $row['sub_grade']; ?></td>
                        <td width="200px"><?php //echo $row['item']; ?> -->
                            <input type="hidden" name="itemcode" id="itemcode" value="<?php //echo $row['i_code']; ?>">
                        </td>
                        <!-- <td width="200px"><?php //echo $row['p_unit']; ?></td>
                        <td width="200px"><?php //echo $row['rec_qnty']; ?></td>
                        <td width="200px"><?php //echo $row['pur_rate']; ?></td> -->
                        <td><?php echo $row['total_bill_amt']; ?></td>
                        <td>
                        <?php 
                            //$sql1 = "SELECT *  from rm_tcreceipt_pdf where Status = '1' and item_code = '".$row['i_code']."' and SrNo = '".$row['sr_no']."'";
                            $sql1 = "SELECT *  from rm_tcreceipt_pdf where Status = '1' and SrNo = '".$row['sr_no']."' and receive_at = '".$row['receive_at']."'";
                            $run1 = sqlsrv_query($con,$sql1);
                            $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC); 
                            if($row1['Remarks'] != "")
                            {
                                echo $row1['Remarks'];
                            }
                        ?>
                        </td>
                        <td>
                            <?php
                                if($row1['SrNo'] != "")
                                {
                                    if($row1['uploadurl'] == "tc"){
                            ?>
                            <a href="tcreceipt/<?Php echo $row1['Name']; ?>" target="_blank"><i class="fa fa-eye"></i></a>
                            <?php }else if($row1['uploadurl'] == "invoice")  { 
                                $sql2 = "SELECT invoice_img from inward_com where sr_no = '".$row['sr_no']."' and receive_at = '".$row['receive_at']."'";
                                $run2 = sqlsrv_query($con,$sql2);
                                $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
                                if($row2['invoice_img'] != 0) {
                                ?>
                            <a href="invoice_img/<?Php echo $row2['invoice_img']; ?>" target="_blank"><i class="fa fa-eye"></i></a>
                            <?php } } } ?>
                        </td>
                        <td> 
                            <?php  
                                if($row1['SrNo'] != "")
                                {
                            ?>
                            <a data-bs-toggle="modal" data-bs-target="#exampleModalUpdate2" data-content="toggle-text" href="#" class="btn btn-secondary reupload" style="text-decoration: none;" data-id="<?php echo $row['sr_no']."~".$row['receive_at']."~".$srno."~".$row1['TCReceiptIDP']; ?>">Reupload</a>

                            <!-- <a data-bs-toggle="modal" data-bs-target="#exampleModalUpdate2" data-content="toggle-text" href="#" class="btn btn-secondary reupload" style="text-decoration: none;" data-id="<?php echo $row['sr_no']."~".$row['receive_at']."~".$srno."~".$row['i_code']."~".$row1['TCReceiptIDP']; ?>">Reupload</a> -->
                            <?php } else { ?>
                            <!-- <a data-bs-toggle="modal" data-bs-target="#exampleModalUpdate2" data-content="toggle-text" href="#" class="btn btn-secondary upload" style="text-decoration: none;" data-id="<?php echo $row['sr_no']."~".$row['receive_at']."~".$srno."~".$row['i_code']; ?>">Upload</a> -->
                            <a data-bs-toggle="modal" data-bs-target="#exampleModalUpdate2" data-content="toggle-text" href="#" class="btn btn-secondary upload" style="text-decoration: none;" data-id="<?php echo $row['sr_no']."~".$row['receive_at']."~".$srno; ?>">Upload</a>                            
                            <?php }  ?>
                        </td>
                    </tr>
                <?php $srno++; } ?>
                </tbody>
            </table>
        </div>
    </div>

<script type="module">

$(document).ready(function(){

    $('#example thead th').each( function () 
        {
            var title = $(this).text();
            $(this).html( '<input type="text" class="" placeholder="'+title+'" />' );
        });

              var table = $('#example').DataTable({
                "processing": true,
                 dom: 'Bfrtip',
                 ordering: false,
            
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
             buttons: [
                'pageLength',
                // Customize button datatable
                {
                    extend: 'excelHtml5',
                    title: 'TC-RECEIPT_PENDING_LIST',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 7, 11, 12, 13, 14, 15 ]
                    }
                },
                {
                text: 'HOME',"className": 'HOME',

                action: function () { 
                  window.open("../dashboard.php","_self");  
               }
             },
            ],
            initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.header() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

        }
        });

             

        
     });

$(document).on('click','#viewmailbutton',function () {
     $.ajax
            ({
                url: "gettcpendingreport_mail.php",
                type:"POST",
                success: function(data) 
                {
                   $(".chnagedata").html(data); 
                },
            });
});

        $(document).on('click','#viewPendingData',function ()
        {
            $.ajax
            ({
                url: "getreport_tcreceipt.php",
                type:"POST",
                success: function(data) 
                {
                   $(".chnagedata").html(data); 
                },
            });

            
            // $('#updateOfferLetter').modal('show');
            // $('#jobidpu').val(val[0]);
            // $('#candidatenameu').val(val[1]);
            // $('#positionu').val(val[2]);
        });

        $(document).on('click','#viewUploadedData',function ()
        {
            $.ajax
            ({
                url: "gettcreportuploaded.php",
                type:"POST",
                success: function(data) 
                {
                   $(".chnagedata").html(data); 
                },
            });

            
            // $('#updateOfferLetter').modal('show');
            // $('#jobidpu').val(val[0]);
            // $('#candidatenameu').val(val[1]);
            // $('#positionu').val(val[2]);
        });


</script>

</body>
</html>