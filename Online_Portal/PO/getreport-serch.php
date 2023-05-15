<?php
 // error_reporting(0);
// DB table to use
$table = <<<EOT
 (  
    SELECT b.sr_no,b.receive_at,a.p_po_no,b.receive_date,b.invoice_no,b.invoice_date,c.party_name,g.category,f.main_grade,e.sub_grade,d.item,
b.mat_ord_by,a.p_project,a.plant,a.p_job,a.p_remark,a.p_pkg,a.p_unit,a.rec_qnty,a.pur_rate,(a.rec_qnty*a.pur_rate) as basic_rate,a.gst_per,a.gst_amt,a.total_amt,b.total_bill_amt FROM inward_com b
LEFT OUTER JOIN inward_ind a on a.sr_no= b.sr_no and a.receive_at=b.receive_at
LEFT OUTER JOIN rm_party_master c on c.pid= b.mat_from_party
LEFT OUTER JOIN rm_item d on d.i_code= a.p_item
LEFT OUTER JOIN rm_s_grade e on e.s_code= d.s_code
LEFT OUTER JOIN rm_m_grade f on f.m_code= d.m_code
LEFT OUTER JOIN rm_category g on g.c_code= d.c_code
  ) temp
EOT;

// Table's primary key
$primaryKey = 'sr_no';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'sr_no', 'dt' => 0 ),
    array( 'db' => 'receive_at', 'dt' => 1 ),
    array( 'db' => 'p_po_no',  'dt' => 2 ),
    array(
        'db'        => 'receive_date',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
            return date( 'd-M-Y', strtotime($d));
        }
    ),
    array( 'db' => 'invoice_no',  'dt' => 4 ),
    array(
    'db'        => 'invoice_date',
    'dt'        => 5,
    'formatter' => function( $d, $row ) {
        return date( 'd-M-Y', strtotime($d));
    }
    ),
    array( 'db' => 'party_name',  'dt' => 6 ),
    array( 'db' => 'mat_ord_by',  'dt' => 7 ),
    array( 'db' => 'category',  'dt' => 8 ),
    array( 'db' => 'main_grade',  'dt' => 9 ),
    array( 'db' => 'sub_grade',  'dt' => 10 ),
    array( 'db' => 'item',  'dt' => 11 ),
    array( 'db' => 'plant',  'dt' => 12 ),
    array( 'db' => 'p_project',   'dt' => 13 ),
    array( 'db' => 'p_job',     'dt' => 14 ),
    array( 'db' => 'p_remark',     'dt' => 15 ),
    array( 'db' => 'p_pkg',     'dt' => 16 ),
    array( 'db' => 'p_unit',     'dt' => 17 ),
    array( 'db' => 'rec_qnty',     'dt' => 18 ),
    array( 'db' => 'pur_rate',     'dt' => 19 ),
    array( 'db' => 'basic_rate',     'dt' => 20 ),
    array( 'db' => 'gst_per',     'dt' => 21 ),
    array( 'db' => 'gst_amt',     'dt' => 22 ),
    array( 'db' => 'total_amt',     'dt' => 23 ),
    array( 'db' => 'total_bill_amt',     'dt' => 24 ),
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'sa',
    'pass' => 'suyog@123',
    'db'   => 'RM_software',
    'host' => '192.168.0.245'
);
require( 'ssp.class.php' );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
?>