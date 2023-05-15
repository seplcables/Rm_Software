<?php

include('C:\xampp\htdocs\rm_software\dbcon.php');
include('C:\xampp\htdocs\rm_software\package\pdf.php');
require 'C:\xampp\htdocs\rm_software\package\phpmailer\class.phpmailer.php';
     $sql1 = "SELECT distinct b.name,email_add from inward_com a
							left outer join online_portal_user b on a.mat_ord_by = b.email or a.mat_ord_by = b.Emp_Name
							where receive_date > '2022-01-01' and DATEDIFF(day, payment_due,GETDATE()) > 0";
	$run1 = sqlsrv_query($con,$sql1);
	while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
	{	
		  $x = 0;
	    $sql = "SELECT format(receive_date,'dd-MMM-yy') as Purchase_Date,sr_no as Rmta,receive_at,party_name,invoice_no,format(invoice_date,'dd-MMM-yy') as invoice_date,mat_ord_by,total_bill_amt,approve_by,format(payment_due,'dd-MMM-yy') as Payment_Due,DATEDIFF(day, payment_due,GETDATE()) AS PaymentDelay from inward_com a
				left outer join rm_party_master b on a.mat_from_party = b.pid
				where receive_date > '2022-01-01' and DATEDIFF(day, payment_due,GETDATE()) > 0 and mat_ord_by like '%".$row1["name"]."%'
				order by PaymentDelay desc";
    $run = sqlsrv_query($con,$sql);
      
	$output = '
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  padding:5px;
  font-size:10px;	

}

#customers td, #customers th {
  border: 2px solid #efc1c9;
  padding: 6px;
  text-align: center;
  font-size:12px;
}


#customers tr:nth-child(even){background-color: #D6EEEE;}


tr:hover {background-color: #04aaaa;}
#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: #04aaaa;
  color: white;
}

</style>

<table style="width: 100%; padding:5px;">
<tr>
<th style="text-align:left;font-size:18px;">Over Payment Due Date (Payment Not Done) </th>
<th style="text-align:right;font-size:18px;">'. date("d-M-y") .'</th>
</tr>

		<table id="customers">
			<tr>
				                <th style="width:60px;">Pur-Date</th>
                        <th style="width:50px;">Rmta</th>
                        <th style="width:60px;">Plant</th>
                        <th style="width:160px;">PARTY NAME</th>
                        <th style="width:70px;">Inv_No</th>
                        <th style="width:60px;">Inv_Date</th>
                        <th style="width:80px;">mat_ord_by</th>
                        <th style="width:80px;">Bill_Amt</th>
                        <th style="width:70px;">Bal_amt</th>
                        <th style="width:70px;">Approve_by</th>
                        <th style="width:60px;">Payment_Due</th>
                        <th style="width:35px;">Diff</th>
			</tr>
	';
	while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
	{
		$sql2 = "SELECT sum(payment_amt) as pay_amt from payment_table where sr_no = '".$row["Rmta"]."' and receive_at = '".$row["receive_at"]."'";
		$run2 = sqlsrv_query($con,$sql2);
		$row2 = sqlsrv_fetch_array($run2, SQLSRV_FETCH_ASSOC);
		$amt = $row["total_bill_amt"] - $row2["pay_amt"];
		if ($amt < 1) {
			continue;
		}
		$x = 1;
		$output .= '
			<tr>
				<td>'.$row["Purchase_Date"].'</td>
				<td>'.$row["Rmta"].'</td>
				<td>'.$row["receive_at"].'</td>
				<td style="font-size:10px;">'.$row["party_name"].'</td>
				<td>'.$row["invoice_no"].'</td>
				<td>'.$row["invoice_date"].'</td>
				<td>'.$row["mat_ord_by"].'</td>
				<td>'.$row["total_bill_amt"].'</td>
				<td>'.$amt.'</td>
				<td>'.$row["approve_by"].'</td>
				<td>'.$row["Payment_Due"].'</td>
				<td>'.$row["PaymentDelay"].'</td>
				
			</tr>
		';
	}
	$output .= '
		</table>
	';

	// mail part
if ($x) {
	$file_name = 'pendingPayment.pdf';
	$html_code = $output;
	$pdf = new Pdf();
	$pdf->set_paper('A4', 'landscape');
	$pdf->load_html($html_code);
	$pdf->render();
	$file = $pdf->output();
	file_put_contents($file_name, $file);

	$mail = new PHPMailer;
	$mail->IsSMTP();								   //Sets Mailer to send message using SMTP
	$mail->Host = 'nifty.interactivedns.com';		               //Sets the SMTP hosts of your Email hosting, this for Godaddy
	$mail->Port = 465;							      //Sets the default SMTP server port
	$mail->SMTPAuth = true;						      //Sets SMTP authentication. Utilizes the Username and Password variables
	$mail->Username = 'rm.update@seplcables.com';      //Sets SMTP username
	$mail->Password = 'Jw[Aim8&c}6A';	              //Sets SMTP Password
	$mail->SMTPSecure = 'ssl';					      //Sets connection prefix. Options are "", "ssl" or "tls"
	$mail->From = 'rm.update@seplcables.com';	      //Sets the From email address for the message
	$mail->FromName = 'Rm Software Update';			      //Sets the From name of the message
	$mail->AddAddress('accounts4@seplcables.com');  //Himanshu Gandhi
	$mail->AddAddress('accounts5@seplcables.com');  //Dipen
	$mail->addCC($row1['email_add']);
	$mail->WordWrap = 52;							  //Sets word wrapping on the body of the message to a given number of characters
	$mail->IsHTML(true);							  //Sets message type to HTML
	$mail->CharSet = 'UTF-8';											
	$mail->AddAttachment($file_name);     			  //Adds an attachment from a path on the filesystem
	$mail->Subject = 'Pending Bill Payment';			  //Sets the Subject of the message
	$mail->Body = 'Note : If the following invoices have been paid, then you will get it entered in the Rm_Software';	//An HTML or plain text message body
	if($mail->Send())								 //Send an Email. Return true on success or false on error
	{
		echo '<label class="text-success">pendingPayment Details has been send successfully...</label>';
	}
	unlink($file_name);

	}
	
		
                          
}	

?>
