<?php

class Psummary
{
    //Psummary class
    public $con;
    private $server = '192.168.0.245';
    private $dbname = 'RM_software';
    private $user = 'sa';
    private $pass = 'suyog@123';
    public function __construct()
    {
        $this->database_connect();
    }
    public function database_connect()
    {
        try {
            $this->con = new PDO("sqlsrv:Server=$this->server;Database=$this->dbname", $this->user, $this->pass);
        } catch (PDOException $e) {
            echo 'Connection Failed:' . $e->getMessage();
        }
    }

    public function get_mGrade($mcode)
    {
        date_default_timezone_set('Asia/Kolkata');
        $current_month = date('Y-m-01', time());
        $cu_qnty = 0;
        $finalAmtSum = 0;
        $output = '';
        $sql = "SELECT distinct a.id,e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
b.total_bill_amt,h.isAprv,h.fi,h.deduction,h.aRate,i.rate,a.plant FROM inward_ind a
LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
LEFT OUTER JOIN psummary h on h.purchaseId = a.id
LEFT OUTER JOIN po_entry_details i on i.id = a.iid
LEFT OUTER JOIN rm_m_grade e on e.m_code= g.m_code
LEFT OUTER JOIN rm_s_grade f on f.s_code= g.s_code
where g.m_code='$mcode' and receive_date >= '$current_month'
order by receive_date asc";
        $run = $this->con->query($sql) or die(print_r($run->errorInfo(), true));
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            $finalRate = ($row['aRate'] == 0 || $row['aRate'] == null) ? $row['rate'] : $row['aRate'];
            $finalAmt = $finalRate*$row['rec_qnty'];
            if ($row['isAprv']) {
                $x =  '<i class="fa fa-check-square checked_check" onclick="approve();" aria-hidden="true"></i>';
                $y = 'readonly';
            } else {
                $x =  '<input type="checkbox" value="'.$row['id'].'" class="largerCheckbox tdCheckbox" name="checkId[]">';
                $y = '';
            }
            if ($finalRate == $row['pur_rate']) {
                $rowHighLigth = "";
            } else {
                $rowHighLigth = "rowHighLigth";
            }
            $output .= '
<tr class="text-center font-italic '.$rowHighLigth.'">
     <td>'.$row['main_grade'].'</td>
     <td>'.$row['plant'].'</td>
     <td>'.date('d-M-y', strtotime($row['receive_date'])).'</td>
     <td data-toggle="tooltip" title="'.$row['party_name'].'">'.substr($row['party_name'], 0, 15).'</td>
     <td>'.$row['sr_no'].'</td>
     <td>'.$row['invoice_no'].'</td>
     <td>'.date('d-M-y', strtotime($row['invoice_date'])).'</td>
     <td>'.date('d-M-y', strtotime($row['receive_date'])).'</td>
     <td>'.$row['sub_grade'].'</td>
     <td>'.$row['item'].'</td>
     
     <td class="setFont">'.round($row['pur_rate'], 3).'</td>
     <td class="setFont">'.round($row['taxable_amt'], 2).'</td>
     <td class="setFont">'.round($row['total_tax_amt'], 2).'</td>
     <td class="setFont">'.round($row['total_bill_amt'], 2).'
          <input type="hidden" value="'.$row['fi'].'" name="fi[]" class="inputInTable fi" '.$y.'>
          <input type="hidden" value="'.$row['deduction'].'" name="deduction[]" class="inputInTable deduction" '.$y.'>
     </td>
     <!-- <td></td>
     <td></td> -->
     <td><input type="number" value="'.round($finalRate, 3).'" step="0.01" name="aRate[]" class="inputInTable aRate" '.$y.'></td>
     <td class="setFont text-danger">'.round($row['rec_qnty'], 1).'</td>
     <td class="setFont text-danger">'.round($finalRate, 3).'</td>
     <td class="setFont text-danger">'.round($finalAmt, 2).'</td>
     <td>
          '.$x.'
     </td>
</tr>';

            $cu_qnty += $row['rec_qnty'];
            $finalAmtSum += (int)$finalAmt;
            $mGrade = $row['main_grade'];
        }
        if (isset($mGrade)) {
            $output .= '
<tr style="font-weight: bold; background-color: #ffff99;">
     <td align="center">'.$mGrade.'</td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <!-- <td></td>
     <td></td> -->
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td align="center">'.$cu_qnty.'</td>
     <td></td>
     <td align="center">'.$finalAmtSum.'</td>
     <td></td>
     
</tr>
';
        }
        return $output;
    }

    public function get_sGrade($mcode, $scode)
    {
        date_default_timezone_set('Asia/Kolkata');
        $current_month = date('Y-m-01', time());
        $cu_qnty = 0;
        $finalAmtSum = 0;
        $output = '';
        $sql = "SELECT distinct a.id,e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
b.total_bill_amt,h.isAprv,h.fi,h.deduction,h.aRate,i.rate,a.plant FROM inward_ind a
LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
LEFT OUTER JOIN psummary h on h.purchaseId = a.id
LEFT OUTER JOIN po_entry_details i on i.id = a.iid
LEFT OUTER JOIN rm_m_grade e on e.m_code= g.m_code
LEFT OUTER JOIN rm_s_grade f on f.s_code= g.s_code
where g.m_code='$mcode' and g.s_code='$scode' and receive_date >= '$current_month'
order by receive_date asc";
        $run = $this->con->query($sql) or die(print_r($run->errorInfo(), true));
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            $finalRate = ($row['aRate'] == 0 || $row['aRate'] == null) ? $row['rate'] : $row['aRate'];
            $finalAmt = $finalRate*$row['rec_qnty'];
            if ($row['isAprv']) {
                $x =  '<i class="fa fa-check-square checked_check" onclick="approve();" aria-hidden="true"></i>';
                $y = 'readonly';
            } else {
                $x =  '<input type="checkbox" value="'.$row['id'].'" class="largerCheckbox tdCheckbox" name="checkId[]">';
                $y = '';
            }
            if ($finalRate == $row['pur_rate']) {
                $rowHighLigth = "";
            } else {
                $rowHighLigth = "rowHighLigth";
            }
            $output .= '
 <tr class="text-center font-italic '.$rowHighLigth.'">
     <td>'.$row['main_grade'].'</td>
     <td>'.$row['plant'].'</td>
     <td>'.date('d-M-y', strtotime($row['receive_date'])).'</td>
     <td data-toggle="tooltip" title="'.$row['party_name'].'">'.substr($row['party_name'], 0, 15).'</td>
     <td>'.$row['sr_no'].'</td>
     <td>'.$row['invoice_no'].'</td>
     <td>'.date('d-M-y', strtotime($row['invoice_date'])).'</td>
     <td>'.date('d-M-y', strtotime($row['receive_date'])).'</td>
     <td>'.$row['sub_grade'].'</td>
     <td>'.$row['item'].'</td>
     
     <td class="setFont">'.round($row['pur_rate'], 3).'</td>
     <td class="setFont">'.round($row['taxable_amt'], 2).'</td>
     <td class="setFont">'.round($row['total_tax_amt'], 2).'</td>
     <td class="setFont">'.round($row['total_bill_amt'], 2).'
          <input type="hidden" value="'.$row['fi'].'" name="fi[]" class="inputInTable fi" '.$y.'>
          <input type="hidden" value="'.$row['deduction'].'" name="deduction[]" class="inputInTable deduction" '.$y.'>
     </td>
     <!-- <td></td>
     <td></td> -->
     <td><input type="number" value="'.round($finalRate, 3).'" step="0.01" name="aRate[]" class="inputInTable aRate" '.$y.'></td>
     <td class="setFont text-danger">'.round($row['rec_qnty'], 1).'</td>
     <td class="setFont text-danger">'.round($finalRate, 3).'</td>
     <td class="setFont text-danger">'.round($finalAmt, 2).'</td>
     <td>
          '.$x.'
     </td>
</tr>';

            $cu_qnty += $row['rec_qnty'];
            $finalAmtSum += (int)$finalAmt;
            $mGrade = $row['main_grade'];
        }
        if (isset($mGrade)) {
            $output .= '
<tr style="font-weight: bold; background-color: #ffff99;">
     <td align="center">'.$mGrade.'</td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <!-- <td></td>
     <td></td> -->
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td align="center">'.$cu_qnty.'</td>
     <td></td>
     <td align="center">'.$finalAmtSum.'</td>
     <td></td>
     
</tr>
';
        }
        return $output;
    }

    public function search_mGrade($mcode, $fdate, $tdate)
    {
        date_default_timezone_set('Asia/Kolkata');
        $current_month = date('Y-m-01', time());
        $cu_qnty = 0;
        $finalAmtSum = 0;
        $output = '';
        $sql = "SELECT distinct a.id,e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
b.total_bill_amt,h.isAprv,h.fi,h.deduction,h.aRate,i.rate,a.plant FROM inward_ind a
LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
LEFT OUTER JOIN psummary h on h.purchaseId = a.id
LEFT OUTER JOIN po_entry_details i on i.id = a.iid
LEFT OUTER JOIN rm_m_grade e on e.m_code= g.m_code
LEFT OUTER JOIN rm_s_grade f on f.s_code= g.s_code
where g.m_code='$mcode' and receive_date >= '$fdate' and receive_date <= '$tdate'
order by receive_date asc";
        $run = $this->con->query($sql) or die(print_r($run->errorInfo(), true));
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            $finalRate = ($row['aRate'] == 0 || $row['aRate'] == null) ? $row['rate'] : $row['aRate'];
            $finalAmt = $finalRate*$row['rec_qnty'];
            if ($row['isAprv']) {
                $x =  '<i class="fa fa-check-square checked_check" onclick="approve();" aria-hidden="true"></i>';
                $y = 'readonly';
            } else {
                $x =  '<input type="checkbox" value="'.$row['id'].'" class="largerCheckbox tdCheckbox" name="checkId[]">';
                $y = '';
            }
            if ($finalRate == $row['pur_rate']) {
                $rowHighLigth = "";
            } else {
                $rowHighLigth = "rowHighLigth";
            }
            $output .= '
 <tr class="text-center font-italic '.$rowHighLigth.'">
     <td>'.$row['main_grade'].'</td>
     <td>'.$row['plant'].'</td>
     <td>'.date('d-M-y', strtotime($row['receive_date'])).'</td>
     <td data-toggle="tooltip" title="'.$row['party_name'].'">'.substr($row['party_name'], 0, 15).'</td>
     <td>'.$row['sr_no'].'</td>
     <td>'.$row['invoice_no'].'</td>
     <td>'.date('d-M-y', strtotime($row['invoice_date'])).'</td>
     <td>'.date('d-M-y', strtotime($row['receive_date'])).'</td>
     <td>'.$row['sub_grade'].'</td>
     <td>'.$row['item'].'</td>
     
     <td class="setFont">'.round($row['pur_rate'], 3).'</td>
     <td class="setFont">'.round($row['taxable_amt'], 2).'</td>
     <td class="setFont">'.round($row['total_tax_amt'], 2).'</td>
     <td class="setFont">'.round($row['total_bill_amt'], 2).'
          <input type="hidden" value="'.$row['fi'].'" name="fi[]" class="inputInTable fi" '.$y.'>
          <input type="hidden" value="'.$row['deduction'].'" name="deduction[]" class="inputInTable deduction" '.$y.'>
     </td>
     <!-- <td></td>
     <td></td> -->
     <td><input type="number" value="'.round($finalRate, 3).'" step="0.01" name="aRate[]" class="inputInTable aRate" '.$y.'></td>
     <td class="setFont text-danger">'.round($row['rec_qnty'], 1).'</td>
     <td class="setFont text-danger">'.round($finalRate, 3).'</td>
     <td class="setFont text-danger">'.round($finalAmt, 2).'</td>
     <td>
          '.$x.'
     </td>
</tr>';

            $cu_qnty += $row['rec_qnty'];
            $finalAmtSum += (int)$finalAmt;
            $mGrade = $row['main_grade'];
        }
        if (isset($mGrade)) {
            $output .= '
<tr style="font-weight: bold; background-color: #ffff99;">
     <td align="center">'.$mGrade.'</td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <!-- <td></td>
     <td></td> -->
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td align="center">'.$cu_qnty.'</td>
     <td></td>
     <td align="center">'.$finalAmtSum.'</td>
     <td></td>
     
</tr>
';
        }
        return $output;
    }

    public function search_sGrade($mcode, $scode, $fdate, $tdate)
    {
        date_default_timezone_set('Asia/Kolkata');
        $current_month = date('Y-m-01', time());
        $cu_qnty = 0;
        $finalAmtSum = 0;
        $output = '';
        $sql = "SELECT distinct a.id,e.main_grade,c.party_name,b.sr_no,b.invoice_no,b.invoice_date,b.receive_date,f.sub_grade,g.item,a.rec_qnty,a.pur_rate,a.taxable_amt,a.total_tax_amt,
b.total_bill_amt,h.isAprv,h.fi,h.deduction,h.aRate,i.rate,a.plant FROM inward_ind a
LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_item g on g.i_code= a.p_item
LEFT OUTER JOIN psummary h on h.purchaseId = a.id
LEFT OUTER JOIN po_entry_details i on i.id = a.iid
LEFT OUTER JOIN rm_m_grade e on e.m_code= g.m_code
LEFT OUTER JOIN rm_s_grade f on f.s_code= g.s_code
where g.m_code='$mcode' and g.s_code='$scode' and receive_date >= '$fdate' and receive_date <= '$tdate'
order by receive_date asc";
        $run = $this->con->query($sql) or die(print_r($run->errorInfo(), true));
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            $finalRate = ($row['aRate'] == 0 || $row['aRate'] == null) ? $row['rate'] : $row['aRate'];
            $finalAmt = $finalRate*$row['rec_qnty'];
            if ($row['isAprv']) {
                $x =  '<i class="fa fa-check-square checked_check" onclick="approve();" aria-hidden="true"></i>';
                $y = 'readonly';
            } else {
                $x =  '<input type="checkbox" value="'.$row['id'].'" class="largerCheckbox tdCheckbox" name="checkId[]">';
                $y = '';
            }
            if ($finalRate == $row['pur_rate']) {
                $rowHighLigth = "";
            } else {
                $rowHighLigth = "rowHighLigth";
            }
            $output .= '
 <tr class="text-center font-italic '.$rowHighLigth.'">
     <td>'.$row['main_grade'].'</td>
     <td>'.$row['plant'].'</td>
     <td>'.date('d-M-y', strtotime($row['receive_date'])).'</td>
     <td data-toggle="tooltip" title="'.$row['party_name'].'">'.substr($row['party_name'], 0, 15).'</td>
     <td>'.$row['sr_no'].'</td>
     <td>'.$row['invoice_no'].'</td>
     <td>'.date('d-M-y', strtotime($row['invoice_date'])).'</td>
     <td>'.date('d-M-y', strtotime($row['receive_date'])).'</td>
     <td>'.$row['sub_grade'].'</td>
     <td>'.$row['item'].'</td>
     
     <td class="setFont">'.round($row['pur_rate'], 3).'</td>
     <td class="setFont">'.round($row['taxable_amt'], 2).'</td>
     <td class="setFont">'.round($row['total_tax_amt'], 2).'</td>
     <td class="setFont">'.round($row['total_bill_amt'], 2).'
          <input type="hidden" value="'.$row['fi'].'" name="fi[]" class="inputInTable fi" '.$y.'>
          <input type="hidden" value="'.$row['deduction'].'" name="deduction[]" class="inputInTable deduction" '.$y.'>
     </td>
     <!-- <td></td>
     <td></td> -->
     <td><input type="number" value="'.round($finalRate, 3).'" step="0.01" name="aRate[]" class="inputInTable aRate" '.$y.'></td>
     <td class="setFont text-danger">'.round($row['rec_qnty'], 1).'</td>
     <td class="setFont text-danger">'.round($finalRate, 3).'</td>
     <td class="setFont text-danger">'.round($finalAmt, 2).'</td>
     <td>
          '.$x.'
     </td>
</tr>';

            $cu_qnty += $row['rec_qnty'];
            $finalAmtSum += (int)$finalAmt;
            $mGrade = $row['main_grade'];
        }
        if (isset($mGrade)) {
            $output .= '
<tr style="font-weight: bold; background-color: #ffff99;">
     <td align="center">'.$mGrade.'</td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <!-- <td></td>
     <td></td> -->
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td align="center">'.$cu_qnty.'</td>
     <td></td>
     <td align="center">'.$finalAmtSum.'</td>
     <td></td>
     
</tr>
';
        }
        return $output;
    }
}
