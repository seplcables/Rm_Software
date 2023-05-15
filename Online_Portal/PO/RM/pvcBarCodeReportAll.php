<?php

session_start();
include('../../../dbcon.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Barcode Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> 
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

    <style type="text/css">
        table
       {
          width: 100% !important;
          color: black;
       }
        thead
       {
          background: linear-gradient(150deg, #f1f7ff, #cbc2bb);
          font-weight: bold;
       }
       .view
       {
            background-color: #5cb85c !important;
            color: white !important;
       }
    </style>
</head>
<body>
    <div class="container-fluid mt-2">
        <div class="row bg-warning text-center text-white">
            <h4 class="">PVC Barcode Report</h4>
        </div><br/>
        <div class="col-auto">
                <a href="../../dashboard.php" class="btn btn-danger">Back</a>
            </div>
        <div class="p-4">
               <table class="table table-bordered dataTable no-footer" id="myTable">
                  <thead>
                     <tr>
                        <td class="border">rmta</td>
                        <td class="border">receieve_at</td>
                        <td class="border">issue_date</td>
                        <td class="border">item_name</td>
                        <td class="border">party</td>
                        <td class="border">barcode_no</td>
                        <td class="border">mcno</td>
                     </tr>
                  </thead>
                  <tbody>
                    <?php

                     $sql = "SELECT DISTINCT b.sr_no, b.receive_at,  a.issue_date, a.barcode_no, a.mc, a.issue_qnty , c.item, e.party_name  FROM 
                            barcode_pvcissue a  join inward_ind b on a.inward_id = b.id join rm_item c on c.i_code = b.p_item
                            join inward_com d on d.sr_no = b.sr_no  and d.receive_at = b.receive_at  join rm_party_master e on d.mat_from_party = e.pid order by a.issue_date desc";
                     $run = sqlsrv_query($con,$sql);
                     while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
                     {
                     ?>
                     <tr>
                        <td class="border"><?php echo $row['sr_no']; ?></td>
                        <td class="border"><?php echo $row['receive_at']; ?></td>
                        <td class="border"><?php echo $row['issue_date']->format('d-M-Y'); ?></td>
                        <td class="border"><?php echo $row['item']; ?></td>
                        <td class="border"><?php echo $row['party_name']; ?></td>
                        <td class="border"><?php echo $row['barcode_no']; ?></td>
                        <td class="border"><?php echo $row['mc']; ?></td>
                     </tr>
                    <?php } ?>
                  </tbody>     
               </table>
            </div>
    </div>

</body>
</html>

<script type="text/javascript">
    $(document).ready( function ()
    {
        $('#myTable').DataTable(
        {
            dom: 'Bfrtip',
            ordering:false,
            buttons: [
                'pageLength','excel', 
            
                {
                text: 'BACK',"className": 'view',
                action: function () { 
                     window.open("pvcBarCodeReoprt.php","_self");
                 }
               },

            ],
        });
    });
</script>