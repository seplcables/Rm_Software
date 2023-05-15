<?php
session_start();
$user = $_SESSION['oid'];
$output = '';
    
    include('../../../dbcon.php');

      $sql = "SELECT party_name,rate FROM requisition_rate a
      INNER JOIN rm_party_master b on a.party_id = b.pid
      where iid = '".$_POST['id']."'";
      $run=sqlsrv_query($con,$sql);
      while($row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
      {
$output .= '
      	                <div class="row justify-content-center p-2">
                              <div class="col-lg-8 col-md-8 col-sm-12 ">
                              <input type="text" value="'.$row['party_name'].'" class="form-control" readonly>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-12">
                              <input type="number" value="'.$row['rate'].'" class="form-control" readonly>
                              </div>
                            </div>
        ';                    

      }

    



    $output .= '
    	 <div class="row justify-content-center p-2">
           <div class="col-lg-8 col-md-8 col-sm-12 "><label class="form-control-label">Party Name **</label><input type="text" name="party_name" id="1party_name" onFocus="SearchParty(this)" placeholder="Enter Here" class="form-control party_name"><input type="hidden" name="pid[]" class="pid" id="pid"></div>
           <div class="col-lg-4 col-md-4 col-sm-12"><label class="form-control-label">Amount **</label><input type="number" name="rate[]" placeholder="Enter Here" class="form-control partyRate"></div>
            </div>

      ';
        
    

echo $output;
?>