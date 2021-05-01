<?php 
require_once("includes/DB.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");
?>
<?php
if (isset($_SESSION["AdminLogin"])) {
  // only if user is logged in perform this check
  if ((time() - $_SESSION['last_login_timestamp']) > 500) {
    Redirect_to("logout.php");
    exit;
  } else {
    $_SESSION['last_login_timestamp'] = time();
  }
}
?>

<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login();

if(isset($_POST["submit"])){
    $Product_Name = $_POST["product_name"];
    $Amount = $_POST["amount"];
    $Staff = $_POST["soldby"];
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime = strftime("%H:%M:%S");
    $DateTime = date("y-m-d");
    echo $DateTime;

    if(empty($Product_Name)||empty($Amount)||empty($Staff)){
        $_SESSION["ErrorMessage"] = "All field must be filled";
    }
    else{
        global $ConnectingDB;
        $sql = "INSERT INTO records(date, time, product_name, amount, sold_by)
                VALUES(:daTe, :tiMe, :proDuct, :aMount, :soldBy)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':daTe', $DateTime);
        $stmt->bindValue(':tiMe', $CurrentTime);
        $stmt->bindValue(':proDuct', $Product_Name);
        $stmt->bindValue(':aMount', $Amount);
        $stmt->bindValue(':soldBy', $Staff);
        $Execute = $stmt->execute();
        if($Execute){
            $_SESSION["SuccessMessage"] = "Record submitted successfully";
            Redirect_to('add_record.php');
        } else{
            $_SESSION["ErrorMessage"] = "Something went wrong, Try again!";
            Redirect_to('add_record.php');
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/all.css">
    <link rel="stylesheet" type="text/css" href="dist/css/styles.css">
    <link rel="stylesheet" type="text/css" href="dist/css/dataTables.bootstrap4.min.css">
    <title>Add Sales</title>
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
    
            <div class="col-12 col-md-10 mt-5 mb-5">
                <div class="row">
                    <div class="col-6 col-sm-6 col-lg-6 mx-auto my-2">
                        <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                        ?>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h3>Add New Sales</h3>
                            </div>
                        <div class="card-body">
                        <form action="add_record.php" method="POST">
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="eg. brazilian hair">
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="eg. 5000">
                            </div>
                            <div class="form-group">
                                <label for="soldby">Staff Name</label>
                                <input type="text" class="form-control" id="soldby" name="soldby" placeholder="eg. Emma">
                            </div>

                            <button type="submit" class="btn btn-info btn-sm" name="submit">Submit</button>
                        </form>   
                    </div>
                </div>
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
    <script src="dist/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/dataTables.bootstrap4.min.js"></script>
</body>
</html>