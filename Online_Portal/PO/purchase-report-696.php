<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css">
    <style type="text/css">
        .w2ui-col-header{
                font-weight: bold !important;
                background: #ffeb3b73 !important;
        }
        .warning,.primary{
            border: 1px solid #ff9800e0;
            border-radius: 5px;
            background: #ff9800e0;
            color: white;
            padding: 8px;
            margin: 0 5px;
            text-decoration: none;
            font-weight: 500;
        }  
        .primary{
            background: #2196f3 !important;
            border: 1px solid #2196f3 !important;
        }
    </style>
</head>
<body>
<div class="row" style="margin: 5px;"> <br>
    <a href="..\dashboard.php" class="warning"><<< Back</a>
    <a href="report-old-696.php?getcat=&fromdate=&todate=" class="primary">Load All Data</a>
</div> <br/> 
<div id="grid" style="height: 670px; overflow: hidden;"></div><br/>
<div style="clear:both; height: 10px;"></div>
<script type="module">
import { w2grid, w2ui } from 'https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.es6.min.js'

let grid = new w2grid({
    box: '#grid',
    name: 'grid',
    liveSearch: true,
    multiSearch: true,
    show: { 
        toolbar: true, 
        footer: true,
        // lineNumbers: true
        },
        limit: 50,
    columns: [
        { field: 'sr_no', text: 'Sr.No',size: '70px', searchable: { operator: 'contains' }, sortable: true },
        { field: 'receive_at', text: 'Receive_at',size: '90px', searchable: { operator: 'contains' }, sortable: true },
        { field: 'p_po_no', text: 'Po_No',size: '150px', searchable: { operator: 'contains' }, sortable: true },
        { field: 'rec_date', text: 'Receive_dte',size: '90px', searchable: { operator: 'contains' }, sortable: true },
        { field: 'invoice_no', text: 'I_no',size: '90px', searchable: { operator: 'contains' }, sortable: true },
        { field: 'inv_date', text: 'I_date',size: '90px', searchable: { operator: 'contains' }, sortable: true },
        { field: 'party_name', text: 'Party',size: '210px', searchable: { operator: 'contains' }, sortable: true },
        { field: 'category', text: 'Category',size: '130px', searchable: { operator: 'contains' }, sortable: true },
        { field: 'main_grade', text: 'Main_grade',size: '140px', searchable: { operator: 'contains' }, sortable: true },
        { field: 'sub_grade', text: 'Sub_Grdae',size: '150px', searchable: { operator: 'contains' }, sortable: true },
        { field: 'item', text: 'Item Description',size: '250px', searchable: { operator: 'contains' }, sortable: true },
        { field: 'mat_ord_by', text: 'Ord_By',size: '100px', searchable: { operator: 'contains' }, sortable: true },
        { field: 'plant', text: 'plant',size: '80px', sortable: true },
        { field: 'p_project', text: 'Project',size: '90px', sortable: true },
        { field: 'p_job', text: 'Job No',size: '90px', sortable: true },
        { field: 'p_remark', text: 'Remarks',size: '100px', sortable: true },
        { field: 'p_pkg', text: 'PKG',size: '60px', sortable: true },
        { field: 'p_unit', text: 'Unit',size: '80px', sortable: true },
        { field: 'rec_qnty', text: 'Qnty',size: '80px', sortable: true },
        { field: 'pur_rate', text: 'Rate',size: '80px', sortable: true },
        { field: 'basic_rate', text: 'Basic_amt',size: '100px', sortable: true },
        { field: 'gst_per', text: 'GST Type',size: '90px', sortable: true },
        { field: 'gst_amt', text: 'GST Amt',size: '90px', sortable: true },
        { field: 'total_amt', text: 'Total_bill_amt',size: '120px', sortable: true },
        { field: 'total_bill_amt', text: 'Payable_Amt',size: '110px', size: '120px', sortable: true },
        { field: 'matUsedBy', text: 'Mat Used by',size: '110px', size: '120px', sortable: true },
        { field: 'mcno', text: 'MachineNo',size: '110px', size: '120px', sortable: true },
        { field: 'superviser', text: 'Name',size: '110px', size: '120px', sortable: true },
        { field: 'department', text: 'Department',size: '110px', size: '120px', sortable: true },
        { field: 'plant', text: 'Plant',size: '110px', size: '120px', sortable: true },
        { field: 'type', text: 'Type',size: '110px', size: '120px', sortable: true },
        { field: 'old_status', text: 'OLD Part Status',size: '110px', size: '120px', sortable: true },

    ],
})
grid.load('getreport-696.php');
 
</script>

</body>
</html>