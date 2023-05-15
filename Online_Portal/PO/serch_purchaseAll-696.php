
<?php
session_start();
include('..\..\dbcon.php');

    $sql = "SELECT a.receive_date,a.sr_no,a.receive_at,c.party_name,a.invoice_date,a.invoice_no,a.total_bill_amt,a.bill_receive,a.invoice_img,format(a.Invoice_img_timestamp, 'dd-MM-yyyy') as Invoice_img_timestamp FROM inward_com a
LEFT OUTER JOIN rm_party_master c on c.pid= a.mat_from_party where (a.receive_at = '696_plant' or a.receive_at = 'D_696_plant')";
    $run=sqlsrv_query($con,$sql);
    $output = '';
    $output .= '
    
    <thead id="t_head">
        <tr id="trow">
            <th>Receive_date</th>
            <th>Rmta</th>
             <th>plant</th>
             <th>Party</th>
             <th>Invoice_Date</th>
             <th>Invoice_No</th>
            <th>Total_Bill_Amt</th>
            <th>Invoice PDF TimeStamp</th>
            <th>Cntrl</th>
        </tr>
    </thead>
    <tbody id="t_bdy1">
        ';
        while($row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
        {
        $output .= '
        	<tr>
        	<td>'.$row['receive_date']->format('d-M-Y').'</td>
        	<td>'.$row['sr_no'].'</td>
        	<td>'.$row['receive_at'].'</td>
        	<td>'.$row['party_name'].'</td>
        	<td>'.$row['invoice_date']->format('d-M-Y').'</td>
        	<td>'.$row['invoice_no'].'</td>
            <td>'.$row['total_bill_amt'].'</td>
            <td>'.$row['Invoice_img_timestamp'].'</td>
        	<td><input type="button" class="btn btn-sm btn-warning show_data" name="show" value="Show" id="'.$row['sr_no'].$row['receive_at'].'" >
            <input type="button" class="btn btn-sm btn-success show_inv" name="inv" value="See Invoice" id="'.$row['invoice_img'].'" >
            </td>
        	</tr>
               ';
         }
         $output .= '</tbody>';  
    echo $output;
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
                 
           var table = $('#example').DataTable({  
            

            "processing": true,
            "ordering": true,
            "destroy": true,
            "dom" : 'Bfrtip',
             
            "columns": [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null
            ],
            "order": [[1, 'desc']],
            lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],  

        buttons: [
            'pageLength', 'excel',
                         {
                text: 'HOME',"className": 'HOME',
                action: function () { 
                  window.open("../dashboard.php","_self");  
               }
             },
             {
                text: 'PURCHASE ENTRY',"className": 'purchase_entry',
                action: function () { 
                  window.open("inward_field-696.php","_self");  
               }
             }

           ],



        });


     });   
    </script>
    <!--  -->