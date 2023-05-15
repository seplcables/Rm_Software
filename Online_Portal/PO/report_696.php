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
    a
    {
        font-size: 20px;
        cursor: none;
        text-decoration: none !important;
    } 
   
        </style>
        <script type="text/javascript">
        $(document).on('click', '.yeardata', function()
        {
            var id = $(this).attr('id');
            window.location.href = "report_696.php?year="+id;
            // $.ajax({
            //     url:"viewStoreItem.php",
            //     method:"POST",
            //     data:{id:id},
            //     success:function(data)
            //     {
            //         $('#createstoreitem').modal('show');
            //         $('#t_body_createstoreitem').html(data);
                    
            //     }
            //     });
        });

        </script>
    </head>
    <body>
        <h3 class="bg-primary" align="center">PURCHASE REPORT - 696</h3>
        <div class="row">
            <a href="..\dashboard.php" class="btn btn-warning"><<< Back</a>
            <a href="#" class="btn btn-info" onclick="editRemarks1();">Save Remarks</a>
            <a href="report_696.php" class="btn btn-success">View All</a>
            <b><a href="#" class="link-primary"><?php if(isset($_GET['year'])) { echo "Year : ".$_GET['year']; } ?></a></b>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-12">
                <table colspan="0" rowspan="0" border="0">
                     <tr>
                        <?php
                            $srno = 1;
                            $sql1 = "SELECT DISTINCT format(b.invoice_date,'yyyy') as inv_date  FROM inward_ind a
LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_item d on d.i_code= a.p_item LEFT OUTER JOIN rm_s_grade e on e.s_code= d.s_code
LEFT OUTER JOIN rm_m_grade f on f.m_code= d.m_code LEFT OUTER JOIN rm_category g on g.c_code= d.c_code where a.receive_at = '696_plant'   order by inv_date desc";
                            $run1 = sqlsrv_query($con,$sql1);
                            while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
                            {
                                $sql2 = "SELECT  sum(a.rec_qnty*a.pur_rate) as rate  FROM inward_ind a
                                    LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
                                    LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
                                    LEFT OUTER JOIN rm_item d on d.i_code= a.p_item
                                    LEFT OUTER JOIN rm_s_grade e on e.s_code= d.s_code
                                    LEFT OUTER JOIN rm_m_grade f on f.m_code= d.m_code
                                    LEFT OUTER JOIN rm_category g on g.c_code= d.c_code where a.receive_at = '696_plant' and format(b.invoice_date,'yyyy') = '".$row1['inv_date']."'";
                                $run2 = sqlsrv_query($con,$sql2);
                                $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);

                        ?>
                        <td width="100px">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td width="25%" align="center"><button type="button" class="btn btn-primary text-white yeardata" id="<?php echo $row1['inv_date']; ?>"><?php echo $row1['inv_date']; ?></button></td>
                                </tr>
                                <tr>
                                    <td width="25%" class="text-info"><b>&#x20B9;&nbsp;&nbsp;<?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", round($row2['rate'],2)); ?></b></td>
                                </tr>
                            </table>
                        </td>
                    <?php } ?>
                        
                    </tr>
                </table>
            </div>
        </div>
       
        <div class="table-responsive ml-1">
            <table class="table table-bordered table-striped table-sm" id="example" style="width:200%">
                <thead id="t_head">
                    <tr id="trow">
                        <th>Sr.No</th>
                        <th>Receive_at</th>
                        <th>Remarks1</th>
                        <th>Remarks2</th>
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
                    $srno = 1;
                    $sql = "SELECT b.sr_no,b.receive_at, a.id, a.p_po_no,format(b.receive_date,'dd-MMM-yyyy') as rec_date,b.invoice_no,format(b.invoice_date,'dd-MMM-yyyy') as inv_date,c.party_name,g.category,f.main_grade,e.sub_grade,d.item,
                        b.mat_ord_by,a.p_project,a.plant,a.p_job,a.p_remark,a.p_pkg,a.p_unit,a.rec_qnty,a.pur_rate,(a.rec_qnty*a.pur_rate) as basic_rate,a.gst_amt,a.total_amt,b.total_bill_amt FROM inward_ind a
                        LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
                        LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
                        LEFT OUTER JOIN rm_item d on d.i_code= a.p_item
                        LEFT OUTER JOIN rm_s_grade e on e.s_code= d.s_code
                        LEFT OUTER JOIN rm_m_grade f on f.m_code= d.m_code
                        LEFT OUTER JOIN rm_category g on g.c_code= d.c_code where a.receive_at = '696_plant' ";
                        if(isset($_GET['year']))
                        {
                            $sql .= " and  format(b.invoice_date,'yyyy') = '".$_GET['year']."'";
                        }
                        $sql .= "  order by b.invoice_date desc";

                        $run = sqlsrv_query($con,$sql);
                        while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
                        {

                            $sql1 = "SELECT Remarks696ID ,PlantName  ,Remarks1  ,Remarks2  ,Inwrd_ind_IDP  ,Status ,TimeStamp FROM rm_remarks_696 where Inwrd_ind_IDP = '".$row['id']."' ";
                            $run1 = sqlsrv_query($con,$sql1);
                            $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
                    ?>
                    <tr>
                        <td><?php echo $row['sr_no']; ?><input type="hidden" name="idd" class="idd" value="<?php echo $row['id']; ?>"/></td>
                        <td><?php echo $row['receive_at']; ?></td>
                        <td><input type="text" name="Remarks1[]" class="form-control Remarks1" id="Remarks1<?php echo $row['id']; ?>" value="<?php echo $row1['Remarks1']; ?>"/></td>
                        <td><input type="text" name="Remarks2[]" class="form-control Remarks2" id="Remarks2<?php echo $row['id']; ?>" value="<?php echo $row1['Remarks2']; ?>"/></td>
                        <td><?php echo $row['p_po_no']; ?></td>
                        <td><?php echo $row['rec_date']; ?></td>
                        <td><?php echo $row['invoice_no']; ?></td>
                        <td><?php echo $row['inv_date']; ?></td>
                        <td><?php echo $row['party_name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['main_grade']; ?></td>
                        <td><?php echo $row['sub_grade']; ?></td>
                        <td><?php echo $row['item']; ?></td>
                        <td><?php echo $row['mat_ord_by']; ?></td>
    					<td><?php echo $row['p_project']; ?></td>
                        <td><?php echo $row['plant']; ?></td>
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
                <?php } ?>
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
            
            // function getRemark1(data, type, full)
            // {
            //     var Remarks1 ='';
            //     Remarks1 ="<div class=\"temp\">"; 
            //     //optionLink = "<a class=\"btn btn-sm btn-danger\" href=\"pdfdata.php?sid=" + data.id + "\">pdf</a> " ;
            //     Remarks1 +=  "<input type=\"text\" id=\"remarks1"+data.id+"\"  class=\"form-control remarks1\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Enter Remarks1\" value=\""+data.id+"\"\>"; 
            //     Remarks1 += "<span class=\"btn btn-sm btn-danger\" onclick=\"editRemarks1("+data.id+",'1')\">+</span> ";
            //     Remarks1 +="</div>"; 
            //     return Remarks1;
            // }

            // function getRemark2(data, type, full)
            // {
            //     var Remarks2 ='';
            //     Remarks2 ="<div class=\"temp\">"; 
            //     //optionLink = "<a class=\"btn btn-sm btn-danger\" href=\"pdfdata.php?sid=" + data.id + "\">pdf</a> " ;
            //     Remarks2 +=  "<input type=\"text\" id=\"remarks2"+data.id+"\" class=\"form-control\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Enter Remarks1\" value=\""+data.id+"\"\>"; 
            //     Remarks2 += "<span class=\"btn btn-sm btn-danger\" onclick=\"editRemarks2("+data.id+",'2')\">+</span> ";
            //     Remarks2 +="</div>"; 
            //     return Remarks2;
            // }

            function editRemarks1()
            {   
                var id1 = [];
                var id2 = [];
                var id3 = []; //id of inward

                $('.Remarks1').each(function(i)
                {
                    id1[i] = $(this).val();

                });
                $('.Remarks2').each(function(i)
                {
                    id2[i] = $(this).val();

                });

                $('.idd').each(function(i)
                {
                    id3[i] = $(this).val();

                });

                $.ajax({
                    url: "saveRemark_696.php",
                    type: 'post',
                    data: {inwardid:id3,remark1:id1,remark2:id2},
                    success: function( data ) 
                    {
                        alert(data);
                    }
                });
            }
            
            // function editRemarks2(id,val)
            // {   
            //     txtid = "remarks"+val+id;
            //     txtvalue = $("#"+id).val();
            //     r = 2;
            //     // $.ajax({
            //     //     url: "saveRemark_696.php",
            //     //     type: 'post',
            //     //     data:{inwardid:id,val:txtvalue,r:r}
            //     //     success: function( data ) {
            //     //         alert('updated success')
            //     //     }
            //     // });
            // }

            $(document).ready(function() 
            {
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
                buttons: 
                [
                    'pageLength', 'excel', 'print'
                ],
                
                 
        });



});
        </script>
    </body>
</html>