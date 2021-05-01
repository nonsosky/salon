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
    <title>Sales</title>
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
                                <a href="add_product.php" class="text-white d-block font-weight-bold nav-link" style="padding-left: 20px; background-color: #355D5F;">Add Product</a>
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
                                <a href="add_staff.php" class="text-white d-block font-weight-bold nav-link" style="padding-left: 20px; background-color: #355D5F;">Add Staff</a>
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
    
            <div class="col-lg-10 col-md-10 mt-5 mb-5" style="min-height: 450px;">
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <div class="row">
                <div class="col-sm-4 col-lg-3 mx-auto my-2">
                    <div class="card bg-gray justify-content-center">
                        <div class="card-body text-uppercase font-weight-bold text-center">
                            <span class="d-block text-center">Today</span>
                            <span class=""><?php echo TotalToday() ?></span>
                        </div>
                        <div class="card-footer text-right">
                            <a href="today.php" class="btn-sm ux-btn-ghost">
                                View
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4 col-lg-3 mx-auto my-2">
                    <div class="card bg-gray justify-content-center">
                        <div class="card-body text-uppercase font-weight-bold text-center">
                            <span class="d-block text-center">Yesterday</span>
                            <span class=""><?php echo TotalYesterday() ?></span>
                        </div>
                        <div class="card-footer text-right">
                            <a href="yesterday.php" class="btn-sm ux-btn-ghost">
                                View
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-6 col-lg-3 mx-auto">
                    <div class="card bg-gray justify-content-center">
                        <div class="card-body text-uppercase font-weight-bold text-center">
                            <span class="d-block text-center">Last 30days</span>
                            <span class=""><?php echo TotalLast30days() ?></span>
                        </div>
                        <div class="card-footer text-right">
                            <a href="last30days.php" class="btn-sm ux-btn-ghost">
                                View
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 mx-auto my-2">
                    <div class="card bg-gray justify-content-center">
                        <div class="card-body text-uppercase font-weight-bold text-center">
                            <span class="d-block text-center">All</span>
                            <span class=""><?php echo TotalAll() ?></span>
                        </div>
                        <div class="card-footer text-right">
                            <a href="all.php" class="btn-sm ux-btn-ghost">
                                View
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
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