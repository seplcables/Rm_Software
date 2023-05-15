<?php
session_start();
include('..\..\..\dbcon.php');
	if ($_POST['from_date'] == '' || $_POST['to_date'] == '') {
		$sql = "SELECT party_name,concat(sr_no,'-',receive_at) as sr,party,invoice_no,invoice_date,total_amt,bill_amt,a.pay_date,payment_amt,trans_id,remark FROM payment_table a left outer join rm_party_master b on b.pid = a.party";
	}else{
		$sql = "SELECT party_name,concat(sr_no,'-',receive_at) as sr,party,invoice_no,invoice_date,total_amt,bill_amt,a.pay_date,payment_amt,trans_id,remark FROM payment_table a left outer join rm_party_master b on b.pid = a.party
		where a.pay_date >= '".$_POST['from_date']."' AND a.pay_date <= '".$_POST['to_date']."'";
	}

    $run=sqlsrv_query($con,$sql);
    $output = '';
    $output .= '
    
			<thead id="thead">
				<tr class="head_part">
	              <th style="width:50px;">Rmta</th>
	              <th style="width:120px;">Party</th>
	              <th style="width:50px;">Bill no</th>
	              <th style="width:50px;">Bill date</th>
	              <th style="width:50px;">Total pay amt</th>
	              <th style="width:50px;">Bill amt</th>
	              <th style="width:50px;">Pymt Date</th>
	              <th style="width:50px;">Pymt amt</th> 
	              <th style="width:50px;">Trans id</th>
	              <th style="width:100px;">Remark</th>
	            </tr>
			</thead>
			<tbody>
        ';
        while($row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
        {
        $output .= '

        <tr>
            <td>'.$row["sr"].'</td>
            <td>'.$row["party_name"].'</td>
            <td>'.$row["invoice_no"].'</td>
            <td>'.$row["invoice_date"]->format('d-M-y').'</td>
            <td>'.$row["total_amt"].'</td>
            <td>'.$row["bill_amt"].'</td>
            <td>'.$row["pay_date"]->format('d-M-y').'</td>
            <td>'.$row["payment_amt"].'</td>
            <td>'.$row["trans_id"].'</td>
            <td>'.$row["remark"].'</td>
          </tr>

        ';
        }
    $output .= '</tbody>
            
    ';
    echo $output;
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
               
            var table = $('#exampleone').DataTable({
                "processing": true,
                ordering:false,
                destroy: true,
                 dom: 'Bfrtip',
         lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength', 'excel', 'print'
        ],

    });


     });   
    </script>
    <!--  -->