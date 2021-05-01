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

    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    $sql = "SELECT * FROM staff WHERE id='{$SearchQueryParameter}'";
    $stmt = $ConnectingDB->query($sql);
    While($DataRows = $stmt->fetch()){
        $Image = $DataRows["s_image"];
        $Firstname = $DataRows["fname"];
        $Middlename = $DataRows["mname"];
        $Lastname = $DataRows["lname"];
        $Email = $DataRows["email"];
        $Gender = $DataRows["gender"];
        $Status = $DataRows["m_status"];
        $Birth = $DataRows["birth_date"];
        $Phone = $DataRows["phone"];
        $Address = $DataRows["address"];
        $State = $DataRows["state"];
        $Country = $DataRows["country"];
        $Position = $DataRows["position"];
        $Salary = $DataRows["salary"];
        $AppDate = $DataRows["app_date"];
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
    <title>View Staff</title>
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
    
            

            <div class="col-12 col-md-10 mx-auto mt-4">  
                <div style="text-align: center; display: flex; justify-content: center; align-items: center;">
                    <img src="<?php echo $Image; ?>" alt="student image" style="width: 170px; height: 140px; margin-right: 5px;">
                    <span>
                    <h3 style="text-transform: uppercase; margin-bottom: 1px; "><?php echo $Firstname." ".$Middlename." ".$Lastname; ?></h3>
                    <h6 class="font-weight-bold">Position: <?php echo $Position ?></h6>
                    </span>
                </div>
                <div class="col-md-12 py-3 mx-auto mt-5">
                <h4 style="margin-left: 210px;">Staff Information</h4>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th style="padding: 8px">Gender:</th>
                                    <td style="padding: 8px"><?php echo $Gender ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                        <table>
                            <tr>
                                <th style="padding: 8px">Date of Birth:</th>
                                <td style="padding: 8px"><?php echo $Birth ?></td>
                            </tr>
                        </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th style="padding: 8px">Email:</th>
                                    <td style="padding: 8px"><?php echo $Email ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                        <table>
                            <tr>
                                <th style="padding: 8px">Marital Status:</th>
                                <td style="padding: 8px"><?php echo $Status ?></td>
                            </tr>
                        </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th style="padding: 8px">Phone:</th>
                                    <td style="padding: 8px"><?php echo $Phone ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                        <table>
                            <tr>
                                <th style="padding: 8px">State:</th>
                                <td style="padding: 8px"><?php echo $State ?></td>
                            </tr>
                        </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th style="padding: 8px">Country:</th>
                                    <td style="padding: 8px"><?php echo $Country ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th style="padding: 8px">Appointment Date:</th>
                                    <td style="padding: 8px"><?php echo $AppDate ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th style="padding: 8px">Salary:</th>
                                    <td style="padding: 8px"><?php echo $Salary ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th style="padding: 8px">Address:</th>
                                    <td style="padding: 8px"><?php echo $Address ?></td>
                                </tr>
                            </table>
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