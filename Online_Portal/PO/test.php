<html>
<script src="https://jspreadsheet.com/v7/jspreadsheet.js"></script>
<script src="https://jsuites.net/v4/jsuites.js"></script>
<link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
<link rel="stylesheet" href="https://jspreadsheet.com/v7/jspreadsheet.css" type="text/css" />
 <style type="text/css">
    /*odd/even row*/
   /*.jexcel tbody tr:nth-child(even) {
     background-color: #EEE9F1 !important;
   }*/
   tbody>tr>:nth-child(4),tbody>tr>:nth-child(8),tbody>tr>:nth-child(10),tbody>tr>:nth-child(11),tbody>tr>:nth-child(12),tbody>tr>:nth-child(13),tbody>tr>:nth-child(17){
       font-size: 13px;
       text-align-last: left;
   }
   tbody>tr>:nth-child(2){
        font-weight: bold;
        font-size: 14px;

   }
   tbody>tr>:nth-child(20),tbody>tr>:nth-child(21){
        font-size: 14px;
        font-family: tahoma;  
        text-align-last: left;
        color: #ff4da6;  
   }
   tbody>tr>:nth-child(22),tbody>tr>:nth-child(23),tbody>tr>:nth-child(24),tbody>tr>:nth-child(25),tbody>tr>:nth-child(26),tbody>tr>:nth-child(27){
    font-family: cursive;
    text-align-last: left;
    font-size: 13px;
   } 
   
</style>
<div id="spreadsheet"></div>
 <?php 
    include('..\..\dbcon.php');
$sql = "SELECT b.sr_no,b.receive_at,a.p_po_no,format(b.receive_date,'dd-MMM-yyyy') as rec_date,b.invoice_no,format(b.invoice_date,'dd-MMM-yyyy') as inv_date,c.party_name,g.category,f.main_grade,e.sub_grade,d.item,
b.mat_ord_by,a.p_project,a.plant,a.p_job,a.p_remark,a.p_pkg,a.p_unit,a.rec_qnty,a.pur_rate,ROUND(a.rec_qnty*a.pur_rate, 2) AS basic_rate,a.cgst_amt,a.sgst_amt,a.igst_amt,a.total_amt,b.total_bill_amt FROM inward_ind a
LEFT OUTER JOIN inward_com b on a.sr_no= b.sr_no and a.receive_at=b.receive_at
LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_item d on d.i_code= a.p_item
LEFT OUTER JOIN rm_s_grade e on e.s_code= d.s_code
LEFT OUTER JOIN rm_m_grade f on f.m_code= d.m_code
LEFT OUTER JOIN rm_category g on g.c_code= d.c_code order by sr_no desc";
$run = sqlsrv_query($con,$sql);
$rows = array();
while($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC))
{
       $rows[] = $row;
}
  $dt = json_encode($rows);

  ?>
<script>

var data = <?php echo $dt; ?>


 
 var table = jspreadsheet(document.getElementById('spreadsheet'), {
        //minDimensions: [40,10],
        tableOverflow: true,
        tableWidth: '100%',
        tableHeight: '95%',
        freezeColumns: 2,
        filters: true,
        //columnSorting:false,
         search: true,
         pagination: 30,
         paginationOptions: [30,90,150],
        //worksheetName: 'Employees',
        //columnDrag: false,
        data: data,
        columns: [
            {
                title: 'Sr.No',
                type: 'text',
                name: 'sr_no',
                //readOnly: true,
                width: '60px',
            },
            {
                title: 'Receive_at',
                type: 'text',
                name: 'receive_at',
                //readOnly: true,
                width: '100px',
            },
            {
                title: 'Po_No',
                type: 'text',
                name: 'p_po_no',
                width: '160px',
            },
            {
            type:'text',
            title:'Receive_dte',
            name: 'rec_date',
            width:'100px',
            },
            {
                title: 'I_no',
                type: 'text',
                name: 'invoice_no',
                width: '80px',
            },
            {
            type:'text',
            title:'I_date',
            name: 'inv_date',
            width:'100px',
            },
            {
                title: 'Party',
                type: 'text',
                name: 'party_name',
                width: '200px',
            },
            {
                title: 'Ord_By',
                type: 'text',
                name: 'mat_ord_by',
                width: '100px',
            },
            {
                title: 'Category',
                type: 'text',
                name: 'category',
                width: '120px',
            },
            {
                title: 'Main_grade',
                type: 'text',
                name: 'main_grade',
                width: '140px',
            },
            {
                title: 'Sub_Grdae',
                type: 'text',
                name: 'sub_grade',
                width: '180px',
            },
            {
                title: 'Item Description',
                type: 'text',
                name: 'item',
                width: '200px',
            },
            {
                title: 'Plant',
                type: 'text',
                name: 'plant',
                width: '60px',
            },
            {
                title: 'Project',
                type: 'text',
                name: 'p_project',
                width: '60px',
            },
            {
                title: 'Job No',
                type: 'text',
                name: 'p_job',
                width: '80px',
            },
            {
                title: 'Remarks',
                type: 'text',
                name: 'p_remark',
                width: '120px',
            },
            {
                title: 'PKG',
                type: 'text',
                name: 'p_pkg',
                width: '30px',
            },
            {
                title: 'Unit',
                type: 'text',
                name: 'p_unit',
                width: '40px',
            },
            {
                title: 'Qty',
                type: 'text',
                name: 'rec_qnty',
                width: '60px',
            },
            {
                title: 'Rate',
                type: 'text',
                name: 'pur_rate',
                width: '80px',
            },
            {
                title: 'Basic_amt',
                type: 'text',
                name: 'basic_rate',
                width: '100px',
            },
            {
                title: 'CGST',
                type: 'text',
                name: 'cgst_amt',
                width: '80px',
            },
            {
                title: 'SGST',
                type: 'text',
                name: 'sgst_amt',
                width: '80px',
            },
            {
                title: 'IGST',
                type: 'text',
                name: 'igst_amt',
                width: '80px',
            },
            {
                title: 'Total_bill_amt',
                type: 'text',
                name: 'total_amt',
                width: '120px',
            },
            {
                title: 'Payable_Amt',
                type: 'text',
                name: 'total_bill_amt',
                width: '120px',
            },
        
        ],
        /*mergeCells:{
        G1:[3,2]
         },*/
        
     license: 'MWEzMTE4MGFkNWY5YzQzNjE4NjZiNmE1NThhM2M0Yjc1NmUyNGM2N2YzZjU2NDQ5ZjM1MGFiYWNmOTFkNTkwODFiYmYwNDE1YjhhM2ViNGUyMzM2YjYzY2Q4NTcyMWE4MGQ4YjVjNjI2NWY4NWYyMTBjMWU5M2ZmNTU4OGI1MDQsZXlKdVlXMWxJam9pY0dGMWJDNW9iMlJsYkNJc0ltUmhkR1VpT2pFMk5UZzVOakk0TURBc0ltUnZiV0ZwYmlJNld5SnFjM0J5WldGa2MyaGxaWFF1WTI5dElpd2lZM05pTG1Gd2NDSXNJbXB6YUdWc2JDNXVaWFFpTENKc2IyTmhiR2h2YzNRaVhTd2ljR3hoYmlJNklqSWlMQ0p6WTI5d1pTSTZXeUoyTnlJc0luWTRJaXdpY0dGeWMyVnlJaXdpYzJobFpYUnpJaXdpWm05eWJYTWlMQ0p5Wlc1a1pYSWlMQ0ptYjNKdGRXeGhJbDE5',

});
table.orderBy(0);
table.orderBy(0);
</script>