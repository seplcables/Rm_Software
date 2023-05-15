<?php

include('C:\xampp\htdocs\rm_software\dbcon.php');
include('C:\xampp\htdocs\rm_software\package\pdf.php');
require 'C:\xampp\htdocs\rm_software\package\phpmailer\class.phpmailer.php';
    $sql1 = "SELECT distinct po_gen_by,email_add from po_entry_details a
	left outer join po_entry_head b on a.iid = b.id
	left outer join online_portal_user c on b.po_gen_by = c.email
	where a.id not in(select iid from inward_ind) and b.po_date > '2021-06-01' and DATEDIFF(day, b.mat_req_date,GETDATE()) > 0 and isCancle is NULL and email_add is not NULL
	order by po_gen_by desc";
	$run1 = sqlsrv_query($con,$sql1);
	while($row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC))
	{	
	$sql = "SELECT top 15 a.iid,format(b.po_date,'dd-MMM-yy') as poDate,e.party_name,b.po_gen_by,
    c.item,d.main_grade,a.unit,a.qnty,format(b.mat_req_date,'dd-MMM-yy') as reqDate,DATEDIFF(day, b.mat_req_date,GETDATE()) AS DateDiff from po_entry_details a
			left outer join po_entry_head b on a.iid = b.id
			left outer join rm_item c on a.item_code = c.i_code
			left outer join rm_m_grade d on c.m_code = d.m_code
			left outer join rm_party_master e on b.party = e.pid
			where a.id not in(select iid from inward_ind) and b.po_date > '2021-06-01' and DATEDIFF(day, b.mat_req_date,GETDATE()) > 0 and isCancle is NULL and b.po_gen_by = '".$row1['po_gen_by']."'
            order by b.po_gen_by asc";
    $run = sqlsrv_query($con,$sql);
      
	$output = '
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  padding:10px;
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

<table style="width: 100%; padding:10px;">
<tr>
<th style="text-align:left;font-size:18px;">Pending PO (Material Not Received) </th>
<th style="text-align:right;font-size:18px;">'. date("d-M-y") .'</th>
</tr>

		<table id="customers">
			<tr>
				        <th style="width:20px;">PO_No</th>
                        <th style="width:60px;">PO_DATE</th>
                        <th>PARTY NAME</th>
                        <th style="width:70px;">PO_GEN_BY</th>
                        <th>ITEM</th>
                        <th style="width:60px;">UNIT</th>
                        <th style="width:70px;">QNTY</th>
                        <th style="width:70px;">REQ_DATE</th>
                        <th style="width:20px;">OVER_DUE</th>
			</tr>
	';
	while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
	{
		$output .= '
			<tr>
				<td>'.$row["iid"].'</td>
				<td>'.$row["poDate"].'</td>
				<td>'.$row["party_name"].'</td>
				<td>'.$row["po_gen_by"].'</td>
				<td>'.$row["item"].'</td>
				<td>'.$row["unit"].'</td>
				<td>'.$row["qnty"].'</td>
				<td>'.$row["reqDate"].'</td>
				<td>'.$row["DateDiff"].'</td>
				
			</tr>
		';
	}
	$output .= '
		</table>
	';

	// mail part
	
	$file_name = 'pendingPoList.pdf';
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
	$mail->AddAddress($row1['email_add']);  //Adds a "To" address
	$mail->AddCC('rm.update@seplcables.com');  //Adds a "CC" address
	$mail->WordWrap = 52;							  //Sets word wrapping on the body of the message to a given number of characters
	$mail->IsHTML(true);							  //Sets message type to HTML
	$mail->CharSet = 'UTF-8';											
	$mail->AddAttachment($file_name);     			  //Adds an attachment from a path on the filesystem
	$mail->Subject = 'Po Pending Mail';			  //Sets the Subject of the message
	$mail->Body = 'Note : Kindly follow up with the party and delivered the material as soon as possible else cancel the PO from RM software if the material is not required now.';	//An HTML or plain text message body
	if($mail->Send())								 //Send an Email. Return true on success or false on error
	{
		echo '<label class="text-success">pendingPo Details has been send successfully...</label>';
	}
	unlink($file_name);                              //Delete pdf file after send mail

}	

?>
