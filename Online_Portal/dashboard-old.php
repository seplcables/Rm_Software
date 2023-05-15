<?php
session_start();
if (!isset($_SESSION['oid'])) {
$_SESSION['login'] = "Please Login First";
header("location:..\OnlinePortal_login.php");
}
else {
if (isset($_SESSION['utype'])) {
?>
<script>
 var msg = "<?php echo $_SESSION['utype']; ?>";   
alert(msg);
</script>
<?php
unset($_SESSION['utype']);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>online portal</title>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="style4.css">
        <!-- Font Awesome JS -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style type="text/css" media="screen">
        .logout_btn{
            padding: 5px;
            background: #19B3D3;
            text-decoration: none;

            font-size: 15px;
            font-weight: 600;
            color: #fff;
            transition: 0.5s;
            transition-property: background;
        }
        .logout_btn:hover{
        background: #0B87A6;
        }
        .content{
              width: 100%;
              background: url(1.jpeg) no-repeat;
              background-position: center;
              background-size: contain;
              height: 50vh;

            }

        </style>
    </head>
    <body>
        <div class="wrapper">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Suyog Electrical Ltd.</h3>
                    <strong>SE</strong>
                </div>
                <ul class="list-unstyled components">
                    <li class="">
                        <a href="#purchase" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fa fa-download"></i>
                            Po Purchase
                        </a>
                        <ul class="collapse list-unstyled" id="purchase">
							
                            <li>
                                <a href="PO\Requisition\showRequisition.php"><span>1.0</span> Requisition</a>
                            </li>
                            <li>
                                <a href="PO\adddata.php"><span>2.1</span> PO entry</a>
                            </li>
                            <li>
                                <a href="PO\showdata.php"><span>2.2</span> Search PO</a>
                            </li>
                            <li>
                                <a href="PO\inward_field.php"><span>3.1</span> Purchase entry</a>
                            </li>
                            <li>
                               <a href="PO\showinvoice.php"><span>3.2</span> Search Purchase</a>
                            </li>
                            <li>
                               <a href="PO\po_to_inward.php"><span>4.0</span> Pending PO </a>
                            </li>
                            </li>
                            <li>
                               <a href="PO\report.php"><span>5.0</span> Purchase Report</a>
                            </li>
                            <li>
                               <a href="PO\psummary\psummary.php"><span>6.0</span> Purchase Summary </a>
                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="#payment" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-rupee-sign"></i>
                            Payment Sys.
                        </a>
                        <ul class="collapse list-unstyled" id="payment">
                            <li>
                                <a href="PO\payment_sys\bill_out.php"><span>1.</span> Bill_Out</a>
                            </li>
                            <li>
                                <a href="PO\payment_sys\bill_in.php"><span>2.</span> Bill_In</a>
                            </li>
                            <li>
                                <a href="PO\payment_sys\approve.php"><span>3.</span> Bill Approve</a>
                            </li>
                            <li>
                                <a href="PO\payment_sys\payment_table.php"><span>4.</span> Payment</a>
                            </li>
                            <li>
                               <a href="PO\payment_sys\pymt_report.php"><span>5.</span> Payment Report</a>
                            </li>
                            <li>
                               <a href="PO\payment_sys\pymt_verify.php"><span>6.</span> Payment Verify</a>
                            </li>
                        </ul>
                    </li>

                    <li class="">
                        <a href="#store" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-store"></i>
                            Store
                        </a>
                        <ul class="collapse list-unstyled" id="store">
                        	<li>
                                <a href="PO\store\inward.php"><span>1.</span> Inward Material</a>
                            </li>
                            <li>
                                <a href="PO\store\rm_issue.php"><span>2.</span> Material Issue</a>
                            </li>
                            <li>
                                <a href="PO\store\opening.php"><span>3.</span> Add New Item</a>
                            </li>
                            <li>
                                <a href="PO\store\opening_table.php"><span>4.</span> Monthly Opening</a>
                            </li>
                            <li>
                                <a href="PO\store\min_limit.php"><span>5.</span> Min Ord Qnty</a>
                            </li>
                            <li>
                                <a href="PO\store\stock_mismatch.php"><span>6.</span> Stock mismatch</a>
                            </li>
                            <li>
                                <a href="PO\store\report.php"><span>7.</span> Live Stock</a>
                            </li>
                            <li>
                                <a href="PO\store\issue_rep.php"><span>8.</span> Issue Report</a>
                            </li>
                            <li>
                                <a href="PO\store\store_rep.php"><span>9.</span> Store Report</a>
                            </li>

                        </ul>
                    </li>

                    <li class="">
                        <a href="#RM" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-cube"></i>
                            Raw Material
                        </a>
                        <ul class="collapse list-unstyled" id="RM">
                            <li>
                                <a href="PO\RM\inward.php">Inward Material</a>
                            </li>
                            <li>
                                <a href="PO\RM\rm_issue.php">Material Issue</a>
                            </li>
                            <li>
                                <a href="PO\RM\rmIssueBC.php">Barcode Issue</a>
                            </li>
                            <li>
                                <a href="PO\RM\opening.php">Add New Grade</a>
                            </li>
                            <li>
                                <a href="PO\RM\opening_table.php">Monthly Opening</a>
                            </li>
                            
                            <li>
                                <a href="PO\RM\stock_mismatch.php">Stock mismatch</a>
                            </li>
                            <li>
                                <a href="PO\RM\report.php">Live Stock</a>
                            </li>
                            <li>
                                <a href="PO\RM\issue_rep.php">Issue Report</a>
                            </li>

                        </ul>
                    </li>
                    <li class="">
                        <a href="#rubber" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fab fa-bitbucket"></i>
                            Rubber 
                        </a>
                        <ul class="collapse list-unstyled" id="rubber">
                            <li>
                                <a href="PO\Rubber\inward.php">Inward Material</a>
                            </li>
                           <!--  <li>
                                <a href="PO\Rubber\groupitem.php">Issue Item</a>
                            </li> -->
                            <li>
                                <a href="PO\Rubber\rb_issue.php">Issue Rubber</a>
                            </li>
                             <li>
                                <a href="PO\Rubber\issue_report.php">Issue Report</a>
                            </li>
                            <li>
                                <a href="PO\Rubber\liveReport.php">Live Stock</a>
                            </li>
                        </ul>
                    </li>

                    <li class="">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-truck-moving"></i>
                            Job Work
                        </a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li>
                                <a href="PO\Job_Work\adddata.php">Create JW</a>
                            </li>
                            <li>
                                <a href="PO\Job_Work\showdata.php">Search JW</a>
                            </li>
                            <li>
                                <a href="PO\Job_Work\report.php">Report JW</a>
                            </li>

                        </ul>
                    </li>

                    <li class="">
                        <a href="#master" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-cog"></i>
                            Master
                        </a>
                        <ul class="collapse list-unstyled" id="master">
                            <li>
                                <a href="PO\add_master\category.php">Item Master</a>
                            </li>
                            <li>
                                <a href="PO\add_master\showparty.php">Party master</a>
                            </li>
                            <li>
                                <a href="PO\add_master\minMax_limit.php">Min/Max Qty Limit</a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </nav>
            <!-- Page Content  -->
            <div id="content">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span></span>
                        </button>
                        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link logout_btn mr-1" href="change_password.php"><?php echo $_SESSION['oid']; ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link logout_btn" href="logout.php">LogOut</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="content">

                </div>
                <div class="line"></div>

            <h1>Suyog Electricals Limited</h1>
            <p>Suyog Electricals Ltd., an ISO 9001:2015 company engaged in manufacturing of the complete range of power, control, signal, instrumentation, rubber & pvdf cables. The company was incorporated in the year 1983 & has been in progressively established itself since past 28 years</p>

            <div class="line"></div>

            </div>
        </div>
        <!-- jQuery CDN - Slim version (=without AJAX) -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <script type="text/javascript">
        $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        });
        });
        
        </script>
    </body>
</html>
<?php
}
?>
