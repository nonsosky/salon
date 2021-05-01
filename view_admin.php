<?php 
require_once("includes/DB.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login();
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/all.css">
    <link rel="stylesheet" type="text/css" href="dist/css/styles.css">
    <link rel="stylesheet" type="text/css" href="dist/css/dataTables.bootstrap4.min.css">
    <title>View Admin</title>
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
                <div class="card mt-4 mb-4">
                    <div class="card-header">
                        <h5>Admin</h5>
                    </div>
                    <div class="card-body scrollable" style="max-height: 55vh; overflow-y: scroll">
                        <table id="my-table" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Created Date</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Addedby</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                        $SRNO = 0;
                                        global $ConnectingDB;
                                        $sql = "SELECT * FROM admin ORDER BY id desc";
                                        $stmt = $ConnectingDB->query($sql);
                                        while($DataRows = $stmt->fetch()){
                                            $Id = $DataRows["id"];
                                            $DateTime = $DataRows["datetime"];
                                            $FirstName = $DataRows["fname"];
                                            $Phone = $DataRows["phone"];
                                            $LastName = $DataRows["lname"];
                                            $Username = $DataRows["username"];
                                            $Email = $DataRows["email"];
                                            $Addedby = $DataRows["addedby"];
                                            $SRNO++;
                                    
                                    
                                    ?>
                                <tr>
                                    <td><?php echo $SRNO ?></td>
                                    <td><?php echo htmlentities($FirstName. " " . $LastName); ?></td>
                                    <td><?php if(strlen($DateTime)> 15){$DateTime= substr($DateTime,0,14);} echo htmlentities($DateTime) ?>
                                    <td><?php echo htmlentities($Username); ?></td>
                                    <td><?php echo htmlentities($Email); ?></td>
                                    <td><?php echo htmlentities($Phone); ?></td>
                                    <td><?php echo htmlentities($Addedby); ?></td>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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
<script type="text/javascript">
    $(document).ready(function() {
    $('#my-table').DataTable();
    } );
</script>
</body>
</html>