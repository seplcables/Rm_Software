<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purchase Summary</title>
    <link rel="stylesheet" href="Jquery/jquery-ui.min.css">
    <script src="jquery/jquery.js"></script>
    <script src="jquery/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.13/sorting/datetime-moment.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />
    <script>
    $( function() {
    $( "#accordion" ).accordion({
    /*active seting se kon sa slidder aap page load hone pe expand kar sakte hai ye 0 se start hota hai
    active: 2*/
    /*collapsible true hone se all slidder collaps ho jata hai otherwize min one slidder collaps nahi ho pata
    collapsible: true*/
    //disabled: true
    //event: "mouseover"
    /*heightStyle fill use karne se content height fixed ho jata hai chahe cotent jyada hone se scroll hota hai
    heightStyle: "fill"*/
    collapsible: true,
    heightStyle: "content"
    });
    } );
    </script>
    <style type="text/css">
    #trow{
    background-color: #ccff99;
    
    }
    th{
    color: black;
    font-size: 14px;
    font-family:Sitka Text;
    }
    </style>
  </head>
  <body>
    
    <div id="accordion" class="container-fluid">
      <!-- Section First Start -->
      <h3>COPPER</h3>
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="copper" style="width:100%">
          <thead>
            <tr id="trow">
              <th>MAIN G.</th>
              <th>Month</th>
              <th>PARTY</th>
              <th>RMTA</th>
              <th>BILL NO</th>
              <th>BILL DT.</th>
              <th>REC DT.</th>
              <th>SUB G.</th>
              <th>SIZE/GRADE</th>
              <th>QNTY</th>
              <th>RATE</th>
              <th>BASIC</th>
              <th>Tax Amt</th>
              <th>Bill Amt</th>
              
              
            </tr>
          </thead>
          
        </table>
      </div>
      <!-- Section First End -->
      <!-- Section Second Start -->
      <h3>ALUMINIUM</h3>
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="aluminium" style="width:100%">
          <thead>
            <tr id="trow">
              <th>MAIN G.</th>
              <th>Month</th>
              <th>PARTY</th>
              <th>RMTA</th>
              <th>BILL NO</th>
              <th>BILL DT.</th>
              <th>REC DT.</th>
              <th>SUB G.</th>
              <th>SIZE/GRADE</th>
              <th>QNTY</th>
              <th>RATE</th>
              <th>BASIC</th>
              <th>Tax Amt</th>
              <th>Bill Amt</th>
              
              
            </tr>
          </thead>
          
        </table>
      </div>
      <!-- Section Second End -->
      <!-- Section Third Start -->
      <h3>PVC</h3>
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="pvc" style="width:100%">
          <thead>
            <tr id="trow">
              <th>MAIN G.</th>
              <th>Month</th>
              <th>PARTY</th>
              <th>RMTA</th>
              <th>BILL NO</th>
              <th>BILL DT.</th>
              <th>REC DT.</th>
              <th>SUB G.</th>
              <th>SIZE/GRADE</th>
              <th>QNTY</th>
              <th>RATE</th>
              <th>BASIC</th>
              <th>Tax Amt</th>
              <th>Bill Amt</th>
              
              
            </tr>
          </thead>
          
        </table>
      </div>
      <!-- Section Third End -->
      <!-- Section Third Start -->
      <h3>GI-WIRE</h3>
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm" id="gi_wire" style="width:100%">
          <thead>
            <tr id="trow">
              <th>MAIN G.</th>
              <th>Month</th>
              <th>PARTY</th>
              <th>RMTA</th>
              <th>BILL NO</th>
              <th>BILL DT.</th>
              <th>REC DT.</th>
              <th>SUB G.</th>
              <th>SIZE/GRADE</th>
              <th>QNTY</th>
              <th>RATE</th>
              <th>BASIC</th>
              <th>Tax Amt</th>
              <th>Bill Amt</th>
              
              
            </tr>
          </thead>
          
        </table>
      </div>
      <!-- Section Third End -->
    </div>
    <script type="text/javascript">
    
    $(document).ready(function() {
    
    var table = $('#copper').DataTable({
    "processing": true,
    "ordering": true,
    "dom": 'Bfrtip',
    
    "columns": [
    { data: "main_grade", width: "6%" },
    {
    data: "receive_date.date", width: "2%",
    type: "date",
    render: function (data, type, row) { return data ? moment(data).format('MMM-YY') : ''; }
    },
    { data: "party_name", width: "10%" },
    { data: "sr_no", width: "4%" },
    { data: "invoice_no", width: "5%" },
    {
    data: "invoice_date.date", width: "6%",
    type: "date",
    render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
    },
    {
    data: "receive_date.date", width: "6%",
    type: "date",
    render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
    },
    { data: "sub_grade", width: "10%" },
    { data: "item", width: "16%" },
    { data: "rec_qnty", width: "6%" },
    { data: "pur_rate", width: "6%" },
    { data: "taxable_amt", width: "8%" },
    { data: "total_tax_amt", width: "8%" },
    { data: "total_amt", width: "8%" },
    ],
    "ajax": {
    url: 'serch_psummary.php?type=copper',
    "dataSrc" : ""
    },
    
    lengthMenu: [
    [ 10, 25, 50, -1 ],
    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
    buttons: [
    'pageLength', 'excel', 'print'
    ],
    
    });

// Aluminium
    var table = $('#aluminium').DataTable({
    "processing": true,
    "ordering": true,
    "dom": 'Bfrtip',
    
    "columns": [
    { data: "main_grade", width: "6%" },
    {
    data: "receive_date.date", width: "2%",
    type: "date",
    render: function (data, type, row) { return data ? moment(data).format('MMM-YY') : ''; }
    },
    { data: "party_name", width: "10%" },
    { data: "sr_no", width: "4%" },
    { data: "invoice_no", width: "5%" },
    {
    data: "invoice_date.date", width: "6%",
    type: "date",
    render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
    },
    {
    data: "receive_date.date", width: "6%",
    type: "date",
    render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
    },
    { data: "sub_grade", width: "10%" },
    { data: "item", width: "16%" },
    { data: "rec_qnty", width: "6%" },
    { data: "pur_rate", width: "6%" },
    { data: "taxable_amt", width: "8%" },
    { data: "total_tax_amt", width: "8%" },
    { data: "total_amt", width: "8%" },
    ],
    "ajax": {
    url: 'serch_psummary.php?type=aluminium',
    "dataSrc" : ""
    },
    
    lengthMenu: [
    [ 10, 25, 50, -1 ],
    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
    buttons: [
    'pageLength', 'excel', 'print'
    ],
    
    });

    // PVC
    var table = $('#pvc').DataTable({
    "processing": true,
    "ordering": false,
    "dom": 'Bfrtip',
    
    "columns": [
    { data: "main_grade", width: "6%" },
    {
    data: "receive_date.date", width: "2%",
    type: "date",
    render: function (data, type, row) { return data ? moment(data).format('MMM-YY') : ''; }
    },
    { data: "party_name", width: "10%" },
    { data: "sr_no", width: "4%" },
    { data: "invoice_no", width: "5%" },
    {
    data: "invoice_date.date", width: "6%",
    type: "date",
    render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
    },
    {
    data: "receive_date.date", width: "6%",
    type: "date",
    render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
    },
    { data: "sub_grade", width: "10%" },
    { data: "item", width: "16%" },
    { data: "rec_qnty", width: "6%" },
    { data: "pur_rate", width: "6%" },
    { data: "taxable_amt", width: "8%" },
    { data: "total_tax_amt", width: "8%" },
    { data: "total_amt", width: "8%" },
    ],
    "ajax": {
    url: 'serch_psummary.php?type=pvc',
    "dataSrc" : ""
    },
    
    lengthMenu: [
    [ 10, 25, 50, -1 ],
    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
    buttons: [
    'pageLength', 'excel', 'print'
    ],
    
    });

    // GI-WIRE
    var table = $('#gi_wire').DataTable({
    "processing": true,
    "ordering": false,
    "dom": 'Bfrtip',
    
    "columns": [
    { data: "main_grade", width: "6%" },
    {
    data: "receive_date.date", width: "2%",
    type: "date",
    render: function (data, type, row) { return data ? moment(data).format('MMM-YY') : ''; }
    },
    { data: "party_name", width: "10%" },
    { data: "sr_no", width: "4%" },
    { data: "invoice_no", width: "5%" },
    {
    data: "invoice_date.date", width: "6%",
    type: "date",
    render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
    },
    {
    data: "receive_date.date", width: "6%",
    type: "date",
    render: function (data, type, row) { return data ? moment(data).format('DD-MMM-YY') : ''; }
    },
    { data: "sub_grade", width: "10%" },
    { data: "item", width: "16%" },
    { data: "rec_qnty", width: "6%" },
    { data: "pur_rate", width: "6%" },
    { data: "taxable_amt", width: "8%" },
    { data: "total_tax_amt", width: "8%" },
    { data: "total_amt", width: "8%" },
    ],
    "ajax": {
    url: 'serch_psummary.php?type=gi_wire',
    "dataSrc" : ""
    },
    
    lengthMenu: [
    [ 10, 25, 50, -1 ],
    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ],
    buttons: [
    'pageLength', 'excel', 'print'
    ],
    
    });


    });
    </script>
  </body>
</html>