<?php
	session_start();
  $tid = $_GET['tid'];
            include('..\..\dbcon.php');
            if (isset($_POST['save'])) {
              $dpnt = $_POST['dpnt'];
              $podate = $_POST['podate'];
              $pono = $_POST['pono'];
              $pogen = $_POST['pogen'];
              $party = $_POST['party'];
              $req_date = $_POST['req_date'];

              
              $description = $_POST['description'];
              $hsn_code = $_POST['hsn_code'];
              $project = $_POST['project'];
              $job = $_POST['job'];
              $remark = $_POST['remark'];
              $stock = $_POST['stock'];
              $mat = $_POST['mat'];
              $m_grade = $_POST['m_grade'];
              $s_grade = $_POST['s_grade'];
              $pkg = $_POST['pkg'];
              $qnty = $_POST['qnty'];
              $unit = $_POST['unit'];
              $rate = $_POST['rate'];
              $basic_rate = $_POST['basic_rate'];

              $del_add = $_POST['del_add1'];
              $del_add2 = $_POST['del_add2'];
              $del_add3 = $_POST['del_add3'];
              $del_add4 = $_POST['del_add4'];

              $term1 = $_POST['title1'];
              $term1 .=$_POST['desc1'];
              $term2 = $_POST['title2'];
              $term2 .=$_POST['desc2'];
              $term3 = $_POST['title3'];
              $term3 .=$_POST['desc3'];
              $term4 = $_POST['title4'];
              $term4 .=$_POST['desc4'];
              $term5 = $_POST['title5'];
              $term5 .=$_POST['desc5'];
              $term6 = $_POST['title6'];
              $term6 .=$_POST['desc6'];
              $term7 = $_POST['title7'];
              $term7 .=$_POST['desc7'];
              $term8 = $_POST['title8'];
              $term8 .=$_POST['desc8'];
              $term9 = $_POST['title9'];
              $term9 .=$_POST['desc9'];

              $p_days = $_POST['p_days'];
              $p_term = $_POST['p_term'];
              $user = $_SESSION['oid'];

           

    $query = "UPDATE po_entry SET depart_ment = '$dpnt',po_date = '$podate',po_no = '$pono',po_gen_by = '$pogen',party = '$party',mat_req_date = '$req_date',item_desc = '$description',hsn_code = '$hsn_code' ,project = '$project',job = '$job',remark = '$remark',stock = '$stock',material_type = '$mat',main_grade = '$m_grade',sub_grade = '$s_grade',pkg='$pkg',qnty = '$qnty',unit = '$unit',rate = '$rate',basic_value = '$basic_rate',delivery_address = '$del_add',delivery_address2 = '$del_add2',delivery_address3 = '$del_add3',delivery_address4 = '$del_add4',terms1 = '$term1',terms2 = '$term2',terms3 = '$term3',terms4 = '$term4',terms5 = '$term5',terms6 = '$term6',terms7 = '$term7',terms8 = '$term8',extra = '$term9',p_days = '$p_days',p_terms = '$p_term',update_by = '$user' WHERE id = '$tid'";

    $run = sqlsrv_query($con,$query);
    if($run == true)
    {
      $_SESSION['mess'] = "Data Updated Successfully";
            header("location:showdata.php");
    }
    else{
      
        echo "ERROR!!!";
    }

}
            ?>