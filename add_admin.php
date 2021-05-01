<?php 
require_once("includes/functions.php");
require_once("includes/DB.php");
require_once("includes/sessions.php");

?>

<?php
// if (isset($_SESSION["AdminLogin"])) {
//   // only if user is logged in perform this check
//   if ((time() - $_SESSION['last_login_timestamp']) > 500) {
//     Redirect_to("logout.php");
//     exit;
//   } else {
//     $_SESSION['last_login_timestamp'] = time();
//   }
// }
?>

<?php

// $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
// Confirm_Login();

if(isset($_POST["Submit"])){
    $Firstname = $_POST["FirstName"];
    $Middlename = $_POST["MiddleName"];
    $Lastname = $_POST["LastName"];
    $Username = $_POST["Username"];
    $Email = $_POST["Email"];
    $Phone = $_POST["Phone"];
    $Admin = $_SESSION["AdminLogin"];
    $Password = $_POST["Password"];
    $ConfirmPassword = $_POST["ConfirmPassword"];
    $hash = password_hash($Password, PASSWORD_DEFAULT);
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    echo $DateTime;

    if(empty($Firstname)||empty($Lastname)||empty($Username)||empty($Email)){
        $_SESSION["ErrorMessage"] = "All field must be filled";
        Redirect_to("add_admin.php");
    }

    elseif(!preg_match("/^[A-Za-z\. ]*$/", $Firstname)){
        $_SESSION["ErrorMessage"] = "Only Letters and White Spaces is Allowed";
        Redirect_to("add_admin.php");
    }

    elseif(!preg_match("/^[A-Za-z\. ]*$/", $Middlename)){
        $_SESSION["ErrorMessage"] = "Only Letters and White Spaces is Allowed";
        Redirect_to("add_admin.php");
    }

    elseif(!preg_match("/^[A-Za-z\. ]*$/", $Lastname)){
        $_SESSION["ErrorMessage"] = "Only Letters and White Spaces is Allowed";
        Redirect_to("add_admin.php");
    }

    elseif(!preg_match("/^[A-Za-z\. ]*$/", $Username)){
        $_SESSION["ErrorMessage"] = "Only Letters and White Spaces is Allowed";
        Redirect_to("add_admin.php");
    }
    elseif(CheckUsernameExistorNot($Username)){
        $_SESSION["ErrorMessage"] = "Username Already Exist";
        Redirect_to("add_admin.php");
    }

    elseif(!preg_match("/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/", $Email)){
        $_SESSION["ErrorMessage"] = "Invalid Email format";
        Redirect_to("add_admin.php");
    }

    elseif(CheckEmailExistorNot($Email)){
        $_SESSION["ErrorMessage"] = "Email Already Exist";
        Redirect_to("add_admin.php");
    }

    elseif($Password !== $ConfirmPassword){
        $_SESSION["ErrorMessage"] = "Password Must Match with Comfirm Password";
        Redirect_to("add_admin.php");
    }
    
    else {
        global $ConnectingDB;
        $sql = "INSERT INTO admin(datetime, fname, mname, lname, username, email, phone, password, addedby)
        VALUES(:dateTime, :fName, :mName, :lName, :userName, :emaiL, :moBile, :passWord, :addedBy)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':fName', $Firstname);
        $stmt->bindValue(':mName', $Middlename);
        $stmt->bindValue(':lName', $Lastname);
        $stmt->bindValue(':userName', $Username);
        $stmt->bindValue(':emaiL', $Email);
        $stmt->bindValue(':moBile', $Phone);
        $stmt->bindValue(':passWord', $hash);
        $stmt->bindValue(':addedBy', $Admin);
        $Execute = $stmt->execute();
        if($Execute){
            $_SESSION["SuccessMessage"] = "Admin registered Successfully";
            Redirect_to("add_admin.php");
        } else{ 
            $_SESSION["ErrorMessage"] = "Error Occured, Try Again";
            Redirect_to("add_admin.php");
        }

    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/styles.css">
    <link rel="stylesheet" type="text/css" href="dist/css/all.css">
    <title>Add Admin</title>
</head>
<body>
<?php require_once("includes/menu.php");?>
<div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-2 p-none m-0 sidebar" style="background-color: #355D5F;">
                <ul class="navbar-nav px-3">
                    <li class="nav-item mb-2" title="Logged in as">
                        <a href="" class="nav-link text-center text-white"></a>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link text-white d-block text-uppercase font-weight-bold">
                            <i class="fa fa-tachometer-alt text-warning"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#pageSubmenu" class="nav-link dropdown-toggle d-block text-white text-uppercase font-weight-bold" data-toggle="collapse" aria-expanded="false"><i class="fa fa-chart-bar mr-2 text-warning"></i>Sales</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li>
                                <a href="add_record.php" class="text-white d-block font-weight-bold nav-link" style="padding-left: 20px; background-color: #355D5F;">Add Sales</a>
                            </li>
                            <li>
                                <a href="record.php" class="text-white d-block font-weight-bold nav-link" style="padding-left: 20px; background-color: #355D5F; hover-item: white;">View</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#dept" class="nav-link dropdown-toggle d-block text-white text-uppercase font-weight-bold" data-toggle="collapse" aria-expanded="false"><i class="fa fa-chart-bar mr-2 text-warning"></i>Product</a>
                        <ul class="collapse list-unstyled" id="dept">
                            <li>
                                <a href="Add_product.php" class="text-white d-block font-weight-bold nav-link" style="padding-left: 20px; background-color: #355D5F;">Add Product</a>
                            </li>
                            <li>
                                <a href="product.php" class="text-white d-block font-weight-bold nav-link" style="padding-left: 20px; background-color: #355D5F; hover-item: white;">View</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#staff" class="nav-link dropdown-toggle d-block text-white text-uppercase font-weight-bold" data-toggle="collapse" aria-expanded="false"><i class="fa fa-chart-bar mr-2 text-warning"></i>Staff</a>
                        <ul class="collapse list-unstyled" id="staff">
                            <li>
                                <a href="Add_staff.php" class="text-white d-block font-weight-bold nav-link" style="padding-left: 20px; background-color: #355D5F;">Add Staff</a>
                            </li>
                            <li>
                                <a href="staff.php" class="text-white d-block font-weight-bold nav-link" style="padding-left: 20px; background-color: #355D5F; hover-item: white;">View</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="view_admin.php" class="nav-link text-white d-block text-uppercase font-weight-bold">
                            <i class="fa fa-users text-warning"></i>
                            Admin
                        </a>
                    </li>
                </ul>
            </div>
    
        <div class="col-12 col-md-10 mx-auto mt-4 mb-5" style="min-height: 480px;">
            <div class="row">
                <div class="col-sm-9 mx-auto">
                <?php
                echo SuccessMessage();
                echo ErrorMessage();
                ?>
                <form action="add_admin.php" method="POST">
                    <div class="card mt-5">
                        <div class="card-body">
                            <h4 class="font-weight-bold text-center mb-4">Add Admin</h4>
                            <div class="row">
                                <div class="col-md-4 mt-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;" Name="FirstName" placeholder="firstname">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;" Name="MiddleName" placeholder="othername">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;" Name="LastName" placeholder="lastname">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;" Name="Username" placeholder="Username">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;" Name="Email" placeholder="email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;" Name="Phone" placeholder="phone number">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <input type="password" class="form-control" style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;" Name="Password" placeholder="password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                <div class="form-group">
                                        <input type="password" class="form-control" style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;" Name="ConfirmPassword" placeholder="confirm password">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-success" Name="Submit" style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">Create Account</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

    <?php require_once("includes/footer.php") ?>

    <script src="dist/js/jquery-3.5.1.js"></script>
    <script src="dist/js/popper.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/all.js"></script>
    <script src="dist/js/main.js"></script>
</body>
</html>