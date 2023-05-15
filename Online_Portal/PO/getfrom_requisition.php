<?php
//filter.php
include('../../dbcon.php');
if(isset($_POST["p"]))
{
$output = '';

        $sql = "SELECT b.id,b.item_code,d.item,d.s_code,d.m_code,d.c_code,b.qnty,b.unit,e.rate,b.qnty*e.rate as basic_value,b.mc,b.department,b.plant,b.type,b.old_part_status,c.remarks,c.indentor,c.mat_require_dte from Requisition_details b 
			left outer join Requisition_head c on c.id = b.iid
			left outer join rm_item d on d.i_code = b.item_code
			left outer join requisition_rate e on e.iid=b.id
			 where party_id = '".$_POST["p"]."' and b.id not in(SELECT req_iid from po_entry_details where req_iid > 0)";
  $run = sqlsrv_query($con,$sql);
  $srno = 0;
  $total = 0;
  while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
  {
    $sql1 = "SELECT sum(qnty) as qunty from po_entry_details where requisition_id = '".$row['id']."'";
    $run1 = sqlsrv_query($con,$sql1);
    $row1 = sqlsrv_fetch_array($run1, SQLSRV_FETCH_ASSOC);
    $rest_qnty = $row['qnty'] - $row1['qunty'];

  $srno++;
  $output .= '
   <tr>
     <td><input type="text" class="form-control" id="srno" value="'.$srno.'" readonly style="width:50px"><input type="hidden" class="req_id" name="req_id[]" value="'.$row['id'].'"><input type="hidden" class="req_id2" name="requisition_id[]" value="'.$row['id'].'" readonly></td>

     <td><input type="text" class="form-control item" value="'.$row['item'].'" name="item_desc[]" id="item_desc" readonly style="width:400px"><input type="hidden" id="i_code" name="i_code[]" value="'.$row['item_code'].'"><input type="hidden" id="s_code" name="s_code[]" value="'.$row['s_code'].'"><input type="hidden" id="m_code" name="m_code[]" value="'.$row['m_code'].'"><input type="hidden" id="c_code" name="c_code[]" value="'.$row['c_code'].'"></td>

     <td><input type="hidden" class="form-control text-center r_qnty" value="'.$rest_qnty.'" name="r_qnty[]" id="r_qnty" readonly style="width:100px">
     <input type="text" class="form-control text-center po_qnty" value="'.$rest_qnty.'" name="qnty[]" id="po_qnty" style="width:100px" required></td>

     <td> <select name="unit[]" class="form-control text-center" id="unit" style="width: 120px;" required> 
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

     <td><input type="text" class="form-control text-center po_rate" value="'.$row['rate'].'" name="rate[]" id="rate" readonly style="width:120px"></td>

     <td><input type="text" class="form-control text-center basic_rate" value="'.$row['rate']*$rest_qnty.'" name="basic_rate[]" id="basic_rate" readonly style="width:120px"></td>

     <td><input type="text" class="form-control text-center" value=" " name="hsn_code[]" id="hsn_code" readonly style="width:80px"></td>

     <td><input type="text" class="form-control text-center" value=" " name="project[]" id="project"style="width:150px"></td>

     <td><input type="text" class="form-control text-center" value=" " name="job[]" id="job" style="width:120px"></td>

     <td><input type="text" class="form-control text-center" value="'.$row['remarks'].'" name="remark[]" id="remark" style="width:160px"></td>

	 <td><input type="text" class="form-control" name="use_by[]" value="'.$row['indentor'].'" id="use_by" readonly style="width:160px"></td>

     <td><input type="text" class="form-control text-center" value="'.$row['mc'].'" name="mcno[]" id="mcno" readonly style="width:120px"></td>

     <td><input type="text" class="form-control person" value=" " name="person[]" id="person" readonly style="width:160px"></td>

     <td><input type="text" class="form-control dpnt" value="'.$row['department'].'" name="dpnt[]" id="dpnt" readonly style="width:160px"></td>

     <td><input type="text" class="form-control plant" value="'.$row['plant'].'" name="plant[]" id="plant" readonly style="width:120px"></td>

     <td><input type="text" class="form-control text-center" value="'.$row['type'].'" name="type[]" id="type" readonly style="width:140px"></td>

     <td><input type="text" class="form-control text-center" value="'.$row['old_part_status'].'" name="old_part[]" id="old_part" readonly style="width:130px"></td>
    
   <td style="width:2%"><button type="button" id="edit" class="btn btn-info font-weight-bold text-danger">X</button></td>
    </tr>
';
	}
  
echo $output;
}

?>
