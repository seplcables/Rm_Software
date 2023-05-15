<?php
session_start();
if (isset($_SESSION['oid'])) {
?>
<script>
window.open('Online_Portal/dashboard.php','_self');
</script>
<?php
  }
  else {
?>
<!doctype html>
<html lang="en">
    <head>
        <title>User login</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!------ Include the above in your HEAD tag ---------->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <style type="text/css" media="screen">
        body {
        background: #000 !important;
        }
        .card {
        border: 1px solid #28a745;
        }
        .card-login {
        margin-top: 130px;
        padding: 18px;
        max-width: 30rem;
        }
        .card-header {
        color: #fff;
        /*background: #ff0000;*/
        font-family: sans-serif;
        font-size: 20px;
        font-weight: 600 !important;
        margin-top: 10px;
        border-bottom: 0;
        }
        .input-group-prepend span{
        width: 50px;
        background-color: #ff0000;
        color: #fff;
        border:0 !important;
        }
        input:focus{
        outline: 0 0 0 0  !important;
        box-shadow: 0 0 0 0 !important;
        }
        .login_btn{
        width: 130px;
        }
        .login_btn:hover{
        color: #fff;
        background-color: #ff0000;
        }
        .btn-outline-danger {
        color: #fff;
        font-size: 18px;
        background-color: #28a745;
        background-image: none;
        border-color: #28a745;
        }
        .form-control {
        display: block;
        width: 100%;
        height: calc(2.25rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1.2rem;
        line-height: 1.6;
        color: #28a745;
        background-color: transparent;
        background-clip: padding-box;
        border: 1px solid #28a745;
        border-radius: 0;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .input-group-text {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding: 0.375rem 0.75rem;
        margin-bottom: 0;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1.6;
        color: #495057;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 0;
        }
        .div1{
            background-color: #f9f9f9;
            border-radius: 3px;
        }
        .check{
            width: 30px;
            height: 27px;
            margin: 2px 20px;
        }
        label{
            font-size: 17px;
        }
        .d1 span{
            font-size: 1.5rem;
        }
        </style>
    </head>
    <body class="">
        <div class="container">
            
            <div class="card card-login mx-auto text-center bg-dark">
                <?php if(isset($_SESSION['login'])): ?>
                <div class="alert alert-danger font-weight-bold font-italic">
                    <?php echo $_SESSION['login']; ?>
                </div>
                <?php unset($_SESSION['login']); ?>
                <?php endif; ?>
                <div class="card-header mx-auto bg-dark">
                    <span> <img src="Online_Portal\1.jpeg" class="w-25" alt="Logo"> </span><br/>
                    <span class="logo_title mt-5"> Login Dashboard </span>
                </div>
                <div class="card-body">
                
                    <form action="OnlinePortal_login.php" method="post" id="form">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="email" class="form-control" placeholder="Username">
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div> 
                        <div class="form-group py-4 mx-1 my-3 d-flex justify-content-between div1">
                            <div>
                                <input type="checkbox" name="check" class="float-left check" required>
                                <label>I'm not a robot</label>
                            </div>
                            <div class="mx-4 d1">
                                <span><i class="fas fa-sync"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="login" value="Login" class="btn btn-outline-danger login_btn float-left w-50">
                            <a class="btn btn-outline-danger login_btn w-25 float-right" href="index.php">  Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
include('dbcon.php');
if(isset($_POST['login']))
{
$username=$_POST['email'];
$password=$_POST['password'];
$qry="SELECT * FROM online_portal_user WHERE email='$username' AND password='$password'";
$params = array();
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$run=sqlsrv_query($con,$qry,$params,$options);
$row=sqlsrv_num_rows($run);
if($row<1)
{
?>
<script>
alert('Username and password not match !!');
window.open('OnlinePortal_login.php','_self');
</script>
<?php
}
else
{
$data=sqlsrv_fetch_array($run);
$iid=$data['id'];
$dpnt=$data['department'];
$name=$data['name'];
$res=$data['responsible'];
$from=$data['from_to'];
//$memo_id=$data['memo_id'];
$user_type=$data['user_type'];
if ($user_type == 'super_admin') {
    $_SESSION['user_type']='admin';
    $_SESSION['pur_user']='super_admin';
}
else if ($user_type == 'pur_admin'){
    $_SESSION['pur_user']='super_admin';
}
else if ($user_type == 'admin'){
    $_SESSION['user_type']='admin';
}
$_SESSION['iid']=$iid;
//$_SESSION['mid']=$memo_id;
$_SESSION['from']=$from;
$_SESSION['res']=$res;
$_SESSION['dpnt']=$dpnt;
$_SESSION['oid']=$name;//super global variable must be declare in capital letter not $_session instead of $_SESSION
if (isset($_SESSION['targetPage'])) {
    $targetLocation = $_SESSION['targetPage'];
}
else{
    $targetLocation = 'Online_Portal/dashboard.php';
}


?>
<script type="text/javascript">
window.open('<?php echo $targetLocation; ?>','_self');

</script>

<?php

}
}
?>
<?php
}
?>