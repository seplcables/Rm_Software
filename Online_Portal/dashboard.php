<?php
session_start();
include('../dbcon.php');
if (!isset($_SESSION['oid'])) 
{
$_SESSION['login'] = "Please Login First";
header("location:..\OnlinePortal_login.php");
}
else 
{
    if (isset($_SESSION['utype'])) 
    {
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
        <title>RM Software</title>
        <link rel="icon" type="image/png" sizes="16x16" href="sepl.jpeg">
        <!-- Bootstrap CSS CDN -->
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="style4.css">
        <!-- Font Awesome JS -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

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
        .contentimg
        {
              width: 450px;
              background: url(1.jpeg) no-repeat;
              background-position: center;
              background-size: contain;
              height:500px;
              border: 1px solid white;
              font-size: 24px;
              border:5px solid black;
              padding: 2rem 1rem;
              min-height: 3em;
              resize: both;
              border-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg'%3E %3Cstyle%3Epath%7Banimation:stroke infinite linear%3B%7D%40keyframes stroke%7Bto%7Bstroke-dashoffset:776%3B%7D%7D%3C/style%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='red' /%3E%3Cstop offset='25%25' /%3E%3Cstop offset='50%25' stop-color='blue' /%3E%3Cstop offset='100%25' stop-color='red' /%3E%3C/linearGradient%3E %3Cpath d='M1.5 1.5 l97 0l0 97l-97 0 l0 -97' stroke-linecap='square' stroke='url(%23g)' stroke-width='3' stroke-dasharray='388'/%3E %3C/svg%3E") 1;
            }

            #grid
            {
                width: 100%;
                padding: 10px 0;
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                grid-gap: 1rem;
            }
            @media (max-width: 768px)
            {
                #grid
                {
                    grid-template-columns: repeat(1, 1fr);
                }
            }
            .modal-lg
            {
                max-width: 1500px;
            }
            .modallg
            {
                max-width: 2000px;
            }
            .createbtnitem
            {
                cursor: pointer;
            }
            .createbtnitem:hover
            {
                background-color: #ccdbde;
                font-weight: bold;
            }

#loader 
{
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #3498db;
      width: 80px;
      height: 80px;
      -webkit-animation: spin 2s linear infinite;
      /* animation: spin 2s linear infinite; */
      margin-left: 5%;
      margin-top: 5%;   
}   
 
@-webkit-keyframes spin 
{
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

#textAni{
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            max-height: 100px;
        }
        #textAni h2{
            position: relative;
            font-size: 1.5rem;
            /*color: #ffd4c0;*/
            color: #7386d5;
            font-family: 'Fondamento', serif !important;
        }
        #textAni h2::before{
            content: attr(data-text);
            position: absolute;
            /*color: #ff5722;*/
            color: #7386d5;
            width: 350px;
            overflow: hidden;
            white-space: nowrap;
            /*border-right: 3px solid #ff5722;*/
            animation: animate 8s linear infinite;
            filter: drop-shadow(2px 2px 5px #7386d5);
            /*filter: drop-shadow(0 0 3px #FF0000 #ff4800);*/
        }
        @keyframes animate{
            0%,10%,100%{
                width: 0;
            }
            70%,90%{
                width: 100%;
            }
        }

h1 {
  font: 2em 'Roboto', sans-serif;
  
}

#loading {

  display: inline-block;
    width: 80px;
    height: 80px;
    border: 10px solid #7386d5;
    border-radius: 50%;
    border-top-color: #fff;
    animation:  8s infinite;
    -webkit-animation: pulse 3s ease infinite alternate, 
    nudge 5s linear infinite alternate;
    margin-left: 2%;
}

@keyframes pulse  {
  to { -webkit-transform: rotate(360deg); }
}
@-webkit-keyframes pulse {
  to { -webkit-transform: rotate(360deg); }
}

/*--------------------get data button-----------------*/
/*html,
body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    background: #000;
}*/

.glow-on-hover {
    width: 450px;
    height: 50px;
    border: solid 1px #2d3192;
    outline: none;
    color: red;
    background: #111;
    cursor: pointer;
    position: relative;
    z-index: 0;
    border-radius: 10px;
    font-weight: bold;
    font-size: 20px;

}

.glow-on-hover:before {
    content: '';
    background: linear-gradient(45deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bff, #7a00ff, #ff00c8, #ff0000);
    position: absolute;
    top: -2px;
    left:-2px;
    background-size: 400%;
    z-index: -1;
    filter: blur(5px);
    width: calc(100% + 4px);
    height: calc(100% + 4px);
    animation: glowing 20s linear infinite;
    opacity: 0;
    transition: opacity .3s ease-in-out;
    border-radius: 10px;
}

.glow-on-hover:active {
    color: #000
}

.glow-on-hover:active:after {
    background: transparent;
}

.glow-on-hover:hover:before {
    opacity: 1;
}

.glow-on-hover:after {
    z-index: -1;
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: #fff;
    left: 0;
    top: 0;
    border-radius: 10px;
}

@keyframes glowing {
    0% { background-position: 0 0; }
    50% { background-position: 400% 0; }
    100% { background-position: 0 0; }
}
            
        </style>
    </head>
    
    <body>
        
        <!---------store------------->
        <div class="modal fade" id="createstore" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">Current Inventory (Store)</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createstore" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!---------end store------------->

        <div class="modal fade" id="create" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-info bg-gradient text-white">
                        
                        
                        <h3 class="h4 text-center">PRODUCT DETAILS</h3>
                        
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_create" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>


        <div class="modal fade" id="createitem" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg modallg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-secondary text-white">
                        <h3 class="h4 text-center">ITEM DETAILS</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createitem" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>

        <!---------pending po------------->
        <div class="modal fade" id="creatependingpo" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PENDING PO LIST</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createpo" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>


        <!---------pending po------------->
        <div class="modal fade" id="creatependingpoadv" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PENDING PO LIST (ADVANCE)</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createpoadv" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>


        <div class="modal fade" id="creatependingpoitem" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 800px;">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-info text-white">
                        <h3 class="h4 text-center">PENDING PO ITEM LIST</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->

                        <h5>Po No. -<span id="pono" class="mx-2"></span></h5>
                        <div class="modal-body" id="t_body_createpoitem" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!------end--------------->

        <!----start adnvance po----------------->
        <div class="modal fade" id="creatependingpoitemadv" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 800px;">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-info text-white">
                        <h3 class="h4 text-center">PENDING PO ITEM LIST(Advance)</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->

                        <h5>Po No. -<span id="ponoadv" class="mx-2"></span></h5>
                        <div class="modal-body" id="t_body_createpoitemAdv" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!------end--------------->
        <!------------------store--------------->
        <div class="modal fade" id="createstoreitem" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 800px;">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-info text-white">
                        <h3 class="h4 text-center">STORE - ITEM LIST</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <h5>Item No. -<span id="itemno" class="mx-2"></span></h5>
                        <div class="modal-body" id="t_body_createstoreitem" style="height:800px; overflow: auto;"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>

        <!--------------end ------------------>

        <!------------qnty miss match-------------->
        <div class="modal fade" id="createqtymissmatch" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PO QNTY MISS MATCH</h3>
                       <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>

                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createqtymissmatch" style="height:800px; overflow: auto;">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->

        <!------------rate miss match-------------->
        <div class="modal fade" id="createratemissmatch" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PO RATE MISS MATCH</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createratemissmatch" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->

        <!------------Late Delivery po-------------->
        <div class="modal fade" id="createlatedelPO" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PO LATE DELIVERY</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createlatedelpo" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->

        <!------------Pending Approval-------------->
        <div class="modal fade" id="createpenapproval" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width:1500px;">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PO PENDING APPROVAL</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                    <div class="modal-body" id="t_body_createpenapv" style="height:800px; overflow: auto;">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->


        <!------------Pending MRS-------------->
        <div class="modal fade" id="createpenmrs" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width:1500px;">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">PO PENDING MRS</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createpenmrs" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->

        <!-------------ve Stock Modal-------------->
        <div class="modal fade" id="createnegetivestock" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width:1500px;">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">-VE Stock List</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createnegetivestock" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->


        <!-------------ve Stock Modal-------------->
        <div class="modal fade" id="createbtninwardmodal" tabindex="-1" aria-labelledby="pare" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width:1700px;">
                <div class="modal-content" align="center">
                    <div class="modal-header text-center bg-light bg-gradient text-black">
                        <h3 class="h4 text-center">Pending Inward</h3>
                        <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <!-- <form action="#" method="POST"  > -->
                        <div class="modal-body" id="t_body_createinwardpending" style="height:800px; overflow: auto;">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closebtn" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" name="savee" class="btn btn-primary savee" onclick="return checkQnty(this);">Save</button> -->
                        </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <!-----------------end------------------->

        <div class="wrapper">
            <!-- Sidebar  -->
            <?php include('sidebar.php') ?>
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
                    <div id="contentload" align="center">
                        <div class="data">
                            <div class="contentimg"></div><br/>
                            <button class="glow-on-hover getdata" type="button"  name="getdata" id="getdata">GET DATA</button>                           
                        </div>
                        <div class="data1" style="display: none;">
                            <div class="contentimg"></div><br/>
                            <div id="textAni">
                                <h2 data-text="Please wait while data loading...">Please wait while data loading...</h2><br/><br/>
                            </div><br/>
                            <div id="loading"></div>
                        </div>
                        
                    </div>
                </div>
                <!-- <div class="content">

                </div>
                <div class="line"></div>

            <h1>Suyog Electricals Limited</h1>
            <p>Suyog Electricals Ltd., an ISO 9001:2015 company engaged in manufacturing of the complete range of power, control, signal, instrumentation, rubber & pvdf cables. The company was incorporated in the year 1983 & has been in progressively established itself since past 28 years</p>

            <div class="line"></div>

            </div> -->
        </div>
       
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

       
        <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () 
            {
                $('#sidebar').toggleClass('active');
            });
        });

        $(document).on('click','#getdata',function() 
        {
            $('.data').hide();
            $('.data1').show();
            $.ajax({
                url: "dashboard_content.php",

                success: function(data) 
                {
                    $("#contentload").html(data);
                },
            });
        });
        
        </script>
            
    </body>
</html>
<?php
}
?>
