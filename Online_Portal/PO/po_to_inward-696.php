<?php 
session_start();
include('..\..\dbcon.php');
date_default_timezone_set('Asia/Kolkata');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Po_To_Inward</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="Security_Sys/css/bootstrap.min.css" /> -->
        
        <!---------------------- JavaScript Bundle with Popper ------------------------------->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <!------------------------ BT-5 CSS -------------------------------------->
        
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <!------------------------ BT-5 JS ---------------------------->
        <!----------------------- jQuery UI --------------------------->
        
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
         

        <style type="text/css">
        #trow{
        background-color: #ffb3ff;
        text-align: center;
        }
        #example td:nth-child(10),
        #example th:nth-child(10) {
             text-align : center;
             font-weight: bold;
         }
         .HOME{
            background-color: #ffcc00 !important;
        }
        .view{
            background-color: #5cb85c !important;
            color: white !important;
        }
        .processrow{
            font-weight: bold;
            background-color: #bfc7c1;
            border-color: red;
            text-align: center;
        }
        .Back{
            background-color: #5cb85c !important;
            color: white !important;
        }

        .largerCheckbox{
            width: 20px;
            height: 18px;
            margin-top: 10px;
        } 
        #table1 th,#table1 td{
            border: 1px solid black;
        }
        #table1 input{
            border: none;
            box-shadow: none;
            outline: none;
        }
        </style>
    </head>
    <body>
       <h5 class="bg-info" align="center" style="color: white;">PENDING PO DETAILS</h5>
        <div class="table-responsive container-fluid mt-2">
            <table class="table table-bordered table-striped table-sm" id="example" style="width:100%">
                <thead>
                    <tr id="trow">
                        <th>poNo</th>
                        <th>poDate</th>
                        <th>partyName</th>
                        <th>poGenBy</th>
                        <th>reqDate</th>
                        <th>overDue</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <?php 
                    $sql = "SELECT distinct  a.id, format(a.po_date,'dd-MMM-yyyy') as poDate, b.party_name,a.po_gen_by,format(a.mat_req_date,'yyyy-MM-dd') as reqDate,  DATEDIFF(day, format(a.mat_req_date,'yyyy-MM-dd'),GETDATE()) AS DateDiff from 
 po_entry_head a left outer join rm_party_master b  on b.pid = a.party left outer join po_entry_details c on c.iid = a.id left join inward_ind d on 
d.iid = c.id  where  a.po_date > '2021-06-01' and DATEDIFF(day, format(a.mat_req_date,'yyyy-MM-dd'),GETDATE()) > 0 AND a.po_gen_by = 'Pratik' 
and c.isCancle IS NULL and c.id Not IN (SELECT iid from inward_ind) and c.plant = '696' order by a.id desc";
                        $run = sqlsrv_query($con,$sql);
                        while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
                        {                            
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['poDate']; ?></td>
                        <td><?php echo $row['party_name']; ?></td>
                        <td><?php echo $row['po_gen_by']; ?></td>
                        <td><?php echo $row['reqDate']; ?></td>
                        <td><?php echo $row['DateDiff']; ?></td>
                        <td><button class="btn btn-sm btn-danger canclePo" id="<?php echo $row['id']; ?>">Cancel</button></td>
                    </tr>
                    <?php } ?>
                
            </table>
        </div>
            <!-----------------------------------------   Edit Modal ----------------------------------------->
        <div class="modal fade small" id="edit_data" aria-labelledby="edit_data" aria-hidden="true" tabindex="-1">
            
            <!----------------- Scrollable modal --------------------------->
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header font-weight-bold bg-faded">
                        <h5>Po No. -<span id="pono" class="mx-2"></span></h5>
                       <button type="button" class="btn-bs-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body" id="edit_modal">
                        <div id="edit">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" name="save" class="btn btn-primary btn-md px-4" id="cancel">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
                        // Function of Control Button
        function getOptions(data, type, full) {
        var optionLink ='';
        optionLink = "<button class=\"btn btn-sm btn-danger canclePo\" id=" + data.id + ">Cancel</button> " ;
        return optionLink == 0 ? '' : optionLink;
    }

    

        $(document).ready(function() 
        {
            $('#example').DataTable( {
            processing: true,
            dom: 'Bfrtip',
            "deferRender": true,

            // "ajax": 
            // {
            //         "url" : "getpo_to_inw.php",
            //         "dataSrc" : ""
            // },
            // "columns": 
            // [
            //     { data: "id", width: "6%" },
            //     { data: "poDate", width: "8%" },
            //     { data: "party_name", width: "16%" }, 
            //     { data: "po_gen_by", width: "10%" },
            //     { data: "reqDate", width: "8%" },
            //     { data: "DateDiff", width: "4%" },
            //     { "mData": null, width: "6%",
            //         "bSortable": false,
            //         "mRender":  function(data, type, full)
            //         {
            //             return getOptions(data, type, full);
            //         }
            //     },
            // ],
        
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'pageLength', 'excel',
                {
                    text: 'HOME',"className": 'HOME',
                    action: function () 
                    { 
                        window.open("../dashboard.php","_self")
                    }
                },
                {
                text: 'VIEW ALL',"className": 'view',
                action: function () { 
                    $("#example").html('<tr class="processrow"><td colspan="10">processing.....</td></tr>');
                    $.ajax({
                            url: "getpo_to_inwAll-696.php",
                            success: function (data) {

                                $("#example").html(data);

                            }
                            });  
                    }
                }
                
        ]
        
        } );
        });
                 /* -----Memo Edit model---*/
         $(document).on('click', '.canclePo', function()
         {
            var id = $(this).attr("id"); 
            $('#pono').text(id); 
            $.ajax(
            {
                url:"canclePo-696.php",
                method:"POST",
                data:{id:id},
                success:function(data)
                {
                    $('#edit').html(data);
                    $('#edit_data').modal('show');
                }
            });
          });

         /*select All*/
        function toggle(source) 
        {
            var checkboxes = document.querySelectorAll('.term');
            for (var i = 0; i < checkboxes.length; i++) 
            {
                if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
            }
            //alert(checkboxes.length);
        }

        $(document).on('click','#cancel',function()
        {  
            var id = [];
            var remark = [];
            $('#idchk:checked').each(function(i)
            {
                id[i] = $(this).val();
                remark[i] = $(this).closest('tr').find('.remark').val();
            });

            if(id.length === 0) //tell you if the array is empty
            {
                alert("Please Select atleast one checkbox");
            }
            else
            {
                $.ajax({
                url:'canclePo_db-696.php',
                method:'POST',
                data:{id:id,remark:remark},
                success:function(data)
                {
                    alert(data);
                 },
                 complete:function()
                 {
                     location.reload(true);
                }

                });
            }                 
        })
        </script>
    </body>
</html>