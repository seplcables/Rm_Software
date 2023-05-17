<?php

//filter.php
include('../../dbcon.php');
if (isset($_POST["po"])) 
{
    $no = 1;
    $sql = "SELECT a.id,a.iid,a.item_code,a.project,a.job,a.remark,a.pkg,a.qnty,a.unit,a.plant,a.rate,b.item,b.c_code, a.make_by, a.model_no from po_entry_details a 
			left outer join rm_item b on a.item_code = b.i_code where a.iid = '".$_POST["po"]."' AND a.iid > 0";
    $run = sqlsrv_query($con, $sql);
    $output = '';
    while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) 
    {
        $sql12="SELECT SUM(rec_qnty) as qnty_value FROM inward_ind where iid='".$row['id']."'";
        $run12=sqlsrv_query($con, $sql12);
        $row12=sqlsrv_fetch_array($run12, SQLSRV_FETCH_ASSOC);
        $y = $row['qnty']-$row12['qnty_value'];
        $item= str_replace("'", "`", $row['item']);
        if ($y <= 0) {
            continue;
        }

        $output .= "
			<tr>
				<td>".$no."</td>
							<td>
							<input type='text' name='item_desc[]' id='item_desc' class='item_desc' value='".$item."' title='".$row['make_by'].' , '.$row['model_no']."'>
							";
        $output .= '
							<input type="hidden" name="i_code[]" id="i_code" class="i_code" value="'.$row['item_code'].'">
							<input type="hidden" id="c_code" class="c_code" value="'.$row['c_code'].'">
							<input type="hidden" name="iid[]" id="iid" class="iid" value="'.$row['id'].'"></td>
							
							<td><input type="text" name="pkg[]" id="pkg" value="'.$row['pkg'].'" class="pkg" required></td>
							<td><input type="text" name="qnty[]" id="qnty" class="qnty" value="'.$y.'"><input type="hidden" value="'.$y.'" class="balanceqnty"><input type="hidden" name="order_qnty[]" value="'.$row['qnty'].'"></td>
							<td>
								<select name="unit[]" id="unit" style="width: 80px;">
		                            <option value="'.$row['unit'].'">'.$row['unit'].'</option>
		                             <option>Box</option>
		                            <option>Mtr</option>
		                            <option>cylnr</option>
		                            <option>Feet</option>
		                            <option>Gram</option>
		                            <option>Kg</option>
		                            <option>Liter</option>
		                            <option>Nos</option>
		                            <option>Pair</option>
		                            <option>Pkt</option>
		                            <option>Roll</option>
		                            <option>Set</option>
		                            <option>Sq.Ft</option>
		                            <option>Sqmm</option>
		                            <option>Ton</option>
		                            <option>Uom</option>
		                            <option>Bag</option>
		                            <option>Book</option>
		                            <option>R.ft</option>
		                            <option>Sq.Mtr</option>
		                            <option>hours</option>
	                        	</select>
							</td>
							<td><input type="text" name="rate[]" id="rate" class="rate" value="'.$row['rate'].'"><input type="hidden" name="order_rate[]" value="'.$row['rate'].'"></td>
							<td><input type="text" name="basic[]" id="basic" class="basic" value="'.$row['rate']*$y.'"></td>
							<td>
								<select name="plant[]" id="plant" required class="plant" style="width: 90px;">
		                            <option value="'.$row['plant'].'">'.$row['plant'].'</option>
		                            <option value="1701">1701</option>
		                            <option value="2205">2205</option>
		                            <option value="696">696</option>
		                            <option value="jarod">jarod</option>
		                            <option value="baroda">baroda</option>
		                        </select>
							</td>
							<td>
								<select name="gst[]" id="gst" class="gst">
									<option selected="true" value="GST-0%">GST-0%</option>
		                            <option value="GST-3%">GST-3%</option>
		                            <option value="GST-5%">GST-5%</option>
		                            <option value="GST-12%">GST-12%</option>
		                            <option value="GST-18%">GST-18%</option>
		                            <option value="GST-28%">GST-28%</option>
		                            <option value="IGST-5%">IGST-5%</option>
		                            <option value="IGST-3%">IGST-3%</option>
		                            <option value="IGST-12%">IGST-12%</option>
		                            <option value="IGST-18%">IGST-18%</option>
		                            <option value="IGST-28%">IGST-28%</option>
								</select><input type="hidden" class="cgst" id="cgst" value="0">
								<input type="hidden" class="sgst" id="sgst" value="0">
								<input type="hidden" class="igst" id="igst" value="0">
								<input type="hidden" name="gst_amt[]" class="gst_amt" id="gst_amt" value="0">
							</td>
							<td><input type="text" name="tcs_amt[]" id="tcs_amt" class="tcs_amt"></td>
							<td><input type="text" name="project[]" id="project" value="'.$row['project'].'"></td>
							<td><input type="text" name="job[]" id="job" value="'.$row['job'].'"></td>
							<td><input type="text" name="remark1[]" id="remark1" value="'.$row['remark'].'"></td>
							<td><input type="text" name="total_amt[]" id="total_amt" value="'.$row['rate']*$y.'" class="total_amt" readonly></td>
						</tr>
		';
        $no++;
    }
    echo $output;
}
