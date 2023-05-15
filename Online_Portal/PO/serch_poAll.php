<?php
session_start();
include('..\..\dbcon.php');

    $sql = "SELECT id,po_date,po_gen_by,party_name,depart_ment,isPurchaseEntry,po_value from po_entry_head a
             LEFT OUTER JOIN rm_party_master b on a.party = b.pid where p_terms != 'cancle' order by id desc";
    $run=sqlsrv_query($con,$sql);
    $output = '';
    $output .= '
    
    <thead>
        <tr id="trow">
            <th>Po_Id</th>
            <th>Date</th>
             <th>Party</th>
             <th>Po_Gen_By</th>
             <th>Department</th>
             <th>PO Value</th>
            <th>Control</th>
            
        </tr>
    </thead>
    <tbody id="t_bdy1">
        ';
        while($row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
        {
        $output .= '
        	<tr>
        	<td>'.$row['id'].'</td>
        	<td>'.$row['po_date']->format('d-M-Y').'</td>
        	<td>'.$row['party_name'].'</td>
        	<td>'.$row['po_gen_by'].'</td>
        	<td>'.$row['depart_ment'].'</td>
        	<td>'.$row['po_value'].'</td>
        	<td><a class="btn btn-sm btn-danger" href="pdfdata.php?sid='.$row['id'].'">pdf</a> </td>
        	</tr>
               ';
         }      
    echo $output;
    ?>
    <script type="text/javascript">
    $(document).ready(function() {
                  $('#example thead th').each( function () {
			        var title = $(this).text();
			        $(this).html( '<input type="text" class="" placeholder="'+title+'" />' );
			    });

           var table = $('#example').DataTable({  
            

            "processing": true,
            "ordering": false,
            "destroy": true,
            "dom" : 'Bfrtip',
             
            "columns": [
                null,
                null,
                null,
                null,
                null,
                null,
                null
            ],
            
              
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
                text: 'PO ENTRY',"className": 'po_entry',
                action: function () { 
                  window.open("adddata.php","_self");  
               }
             }
           
        ],
         
            initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.header() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

        }


        });


     });   
    </script>
    <!--  -->