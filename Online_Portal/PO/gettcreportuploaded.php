<?php
include('..\..\dbcon.php');
// $sql = "SELECT b.sr_no,b.receive_at,a.p_po_no,format(b.receive_date,'dd-MMM-yyyy') as rec_date,b.invoice_no,format(b.invoice_date,'dd-MMM-yyyy') as inv_date,c.party_name,g.category,f.main_grade,e.sub_grade,d.item,
// b.mat_ord_by,a.p_project,a.plant,a.p_job,a.p_remark,a.p_pkg,a.p_unit,a.rec_qnty,a.pur_rate,(a.rec_qnty*a.pur_rate) as basic_rate,a.gst_per,a.gst_amt,a.total_amt,b.total_bill_amt FROM inward_ind a
// LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
// LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
// LEFT OUTER JOIN rm_item d on d.i_code= a.p_item
// LEFT OUTER JOIN rm_s_grade e on e.s_code= d.s_code
// LEFT OUTER JOIN rm_m_grade f on f.m_code= d.m_code
// LEFT OUTER JOIN rm_category g on g.c_code= d.c_code order by sr_no desc";
// $run = sqlsrv_query($con,$sql);
// $rows = array();
// while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
// {
//        $rows[] = $row;
// }

// echo json_encode($rows);

?>
<table class="table table-bordered table-striped" id="example" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 5%;">no</th>
                        <th style="width: 5%;">sr_no</th>
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
                        <th style="width: 10%;">Show</th>
                        <th style="width: 10%;">Reupload</th>
                    </tr>
                    
                </thead>
                <tbody>
                    <?php 

                        $srno = 1;
                        $sql = "
 SELECT a.sr_no,a.receive_at, format(a.receive_date,'dd-MMM-yyyy') as rec_date,c.party_name,format(a.invoice_date,'dd-MMM-yyyy') as inv_date,a.invoice_no,cast(a.total_bill_amt as float) as
                     total_bill_amt,a.bill_receive,a.bill_approve, a.Invoice_img_timestamp, e.c_code, e.category FROM inward_com a
LEFT OUTER JOIN rm_party_master c on c.pid= a.mat_from_party left outer join inward_ind b on b.sr_no = a.sr_no and b.receive_at = a.receive_at  
left outer join rm_item d on d.i_code = b.p_item left outer join rm_category e on e.c_code = d.c_code 
 WHERE   concat(b.sr_no,lower(b.receive_at))  IN (select concat(SrNo,lower(receive_at)) from rm_tcreceipt_pdf where Status = '1')
  GROUP BY a.sr_no,a.receive_at, a.receive_date,c.party_name,a.invoice_date,a.invoice_no,
 a.total_bill_amt,a.bill_receive,a.bill_approve, a.Invoice_img_timestamp, e.c_code, e.category  order by a.sr_no asc";                       
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
                        <td><?php echo $row['category']; ?></td>
                        <!-- <td width="200px"><?php //echo $row['main_grade']; ?></td>
                        <td width="200px"><?php //echo $row['sub_grade']; ?></td>
                        <td width="200px"><?php //echo $row['item']; ?> -->
                            <!-- <input type="hidden" name="itemcode" id="itemcode" value="<?php //echo $row['i_code']; ?>"> -->
                        </td>
                        <!-- <td width="200px"><?php //echo $row['p_unit']; ?></td>
                        <td width="200px"><?php //echo $row['rec_qnty']; ?></td>
                        <td width="200px"><?php //echo $row['pur_rate']; ?></td> -->
                        <td><?php echo $row['total_bill_amt']; ?></td>
                        <td>

                            <?php
                                $sql1 = "SELECT *  from rm_tcreceipt_pdf where Status = '1' and SrNo = '".$row['sr_no']."' and receive_at = '".$row['receive_at']."'";
                                
                                $run1 = sqlsrv_query($con,$sql1);
                                $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
                                if($row1['SrNo'] != "")
                                {
                                    if($row1['uploadurl'] == "tc")
                                    {
                                        $sql2 = "SELECT * from rm_tcreceipt_pdf where Status = '1' and SrNo = '".$row['sr_no']."' and receive_at = '".$row['receive_at']."'";
                                        $run2 = sqlsrv_query($con,$sql2);
                                        while($row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC)){
                            ?>
                                <a href="tcreceipt/<?Php echo $row2['Name']; ?>" target="_blank"><i class="fa fa-eye"></i><br/></a>   
                            <?php } }else if($row1['uploadurl'] == "invoice") { 
                                $sql2 = "SELECT invoice_img from inward_com where sr_no = '".$row['sr_no']."' and receive_at = '".$row['receive_at']."'";
                                $run2 = sqlsrv_query($con,$sql2);
                                $row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
                                if($row2['invoice_img'] != 0) {
                                ?>
                                <a href="invoice_img/<?Php echo $row2['invoice_img']; ?>" target="_blank"><i class="fa fa-eye"></i></a>
                            <?php } } } ?>
                        </td>
                        <td> 
                            <?php  if($row1['SrNo'] != "")
                                {
                            ?>
                            <a data-bs-toggle="modal" data-bs-target="#exampleModalUpdate2" data-content="toggle-text" href="#" class="btn btn-secondary reupload" style="text-decoration: none;" data-id="<?php echo $row['sr_no']."~".$row['receive_at']."~".$srno."~".$row1['TCReceiptIDP']; ?>">ReUpload</a>
                        <?php } else { ?>
                            <a data-bs-toggle="modal" data-bs-target="#exampleModalUpdate2" data-content="toggle-text" href="#" class="btn btn-secondary upload" style="text-decoration: none;" data-id="<?php echo $row['sr_no']."~".$row['receive_at']."~".$srno; ?>">Upload</a>                            
                       <?php }  ?>
                        </td>
                    </tr>
                <?php $srno++; } ?>
                </tbody>
            </table>


            <script type="text/javascript">
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
                'pageLength', 'excel',
                // Customize button datatable
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
            </script>