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
if(isset($_POST["submit"])){
    $Product_Name = $_POST["product_name"];
    $Price = $_POST["price"];
    $Stock = $_POST["stock"];
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    echo $DateTime;


    if(empty($Product_Name)||empty($Price)||empty($Stock)){
        $_SESSION["ErrorMessage"] = "All field must be filled";
        Redirect_to("edit_product.php?id={$SearchQueryParameter}");
    }
    else{
        global $ConnectingDB;
    $sql = "UPDATE products SET updationdate='$DateTime', product_name='$Product_Name', price='$Price', quantity='$Stock' WHERE id='$SearchQueryParameter'";
        $Execute = $ConnectingDB->query($sql);
        if($Execute){
            $_SESSION["SuccessMessage"] = "Product Updated Successfully";
            Redirect_to("edit_product.php?id={$SearchQueryParameter}");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong! Try Again";
            Redirect_to("edit_product.php?id={$SearchQueryParameter}");
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
    <title>Edit Product</title>
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
                        <?php 
                            $SearchQueryParameter = $_GET["id"];
                            global $ConnectingDB;
                            $sql = "SELECT * FROM products WHERE id='{$SearchQueryParameter}'";
                            $stmt = $ConnectingDB->query($sql);
                            While($DataRows = $stmt->fetch()){
                                $ProductToBeUpdated = $DataRows["product_name"];
                                $PriceToBeUpdated = $DataRows["price"];
                                $StockToBeUpdated = $DataRows["quantity"];
                            }
                        ?>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h4>Add New Products</h4>
                            </div>
                        <div class="card-body">
                        <form action="edit_product.php?id=<?php echo $SearchQueryParameter; ?>" method="POST">
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="eg. hair dryer, shampo" value="<?php echo htmlentities($ProductToBeUpdated) ?>">
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price" placeholder="eg. 5000" value="<?php echo htmlentities($PriceToBeUpdated) ?>">
                            </div>
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" id="stock" min="0" name="stock" value="<?php echo htmlentities($StockToBeUpdated) ?>">
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