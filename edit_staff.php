<?php 
require_once("includes/DB.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

    require 'vendor/autoload.php';
    require_once("includes/cloudinary.php");
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
    $firstname = $_POST["firstname"];
    $middlename = $_POST["middlename"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $status = $_POST["status"];
    $dob = $_POST["dob"];
    $Image = $_FILES["image"]["name"];
    $Target = $_FILES["image"]["tmp_name"];
    $phone = $_POST["phone"];
    $state = $_POST["state"];
    $country = $_POST["country"];
    $position = $_POST["position"];
    $salary = $_POST["salary"];
    $appdate = $_POST["appdate"];
    $address = $_POST["address"];
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    echo $DateTime;

    if(empty($firstname)||empty($lastname)||empty($email)){
        $_SESSION["ErrorMessage"] = "All field must be filled";
    }
    elseif(!preg_match("/^[A-Za-z\. ]*$/", $firstname)){
        $_SESSION["ErrorMessage"] = "Only Letters and White Spaces is Allowed";
        Redirect_to("edit_staff.php?id={$SearchQueryParameter}");
    }

    elseif(!preg_match("/^[A-Za-z\. ]*$/", $middlename)){
        $_SESSION["ErrorMessage"] = "Only Letters and White Spaces is Allowed";
        Redirect_to("edit_staff.php?id={$SearchQueryParameter}");
    }

    elseif(!preg_match("/^[A-Za-z\. ]*$/", $lastname)){
        $_SESSION["ErrorMessage"] = "Only Letters and White Spaces is Allowed";
        Redirect_to("edit_staff.php?id={$SearchQueryParameter}");
    }

    elseif(!preg_match("/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/", $email)){
        $_SESSION["ErrorMessage"] = "Invalid Email format";
        Redirect_to("edit_staff.php?id={$SearchQueryParameter}");
    }

    // elseif(CheckEmailExistorNot($email)){
    //     $_SESSION["ErrorMessage"] = "Email Already Exist";
    //     Redirect_to("add_staff.php");
    // }

    else {
        global $ConnectingDB;
        if(!empty($Target)){
            $CloudImg = \Cloudinary\Uploader::upload($Target, array("folder" => "Folders/farmlink/"));
            $Filename = $CloudImg["secure_url"];
            $sql = "UPDATE staff SET updationDate='$DateTime', fname='$firstname', mname='$middlename', lname='$lastname', gender='$gender', birth_date='$dob', email='$email', m_status='$status', phone='$phone', country='$country', state='$state', address='$address', position='$position', salary='$salary', app_date='$appdate', s_image='$Filename' WHERE id='$SearchQueryParameter'";
        } else {
            $sql = "UPDATE staff SET updationDate='$DateTime', fname='$firstname', mname='$middlename', lname='$lastname', gender='$gender', birth_date='$dob', email='$email', m_status='$status', phone='$phone', country='$country', state='$state', address='$address', position='$position', salary='$salary', app_date='$appdate' WHERE id='$SearchQueryParameter'";   
        }
        $Execute = $ConnectingDB->query($sql);
        if($Execute){
            $_SESSION["SuccessMessage"] = "Staff Details Updated Successfully";
            Redirect_to("edit_staff.php?id={$SearchQueryParameter}");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong! Try Again";
            Redirect_to("edit_staff.php?id={$SearchQueryParameter}");
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
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/dataTables.bootstrap4.min.css">
    <title>Edit Staff</title>
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
    
            <div class="col-12 col-md-10 mt-2 mb-5">
                        <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                        ?>
                        <?php 
                            $SearchQueryParameter = $_GET["id"];
                            global $ConnectingDB;
                            $sql = "SELECT * FROM staff WHERE id='{$SearchQueryParameter}'";
                            $stmt = $ConnectingDB->query($sql);
                            While($DataRows = $stmt->fetch()){
                                $ImageToBeUpdated = $DataRows["s_image"];
                                $FirstNameToBeUpdated = $DataRows["fname"];
                                $MiddleNameToBeUpdated = $DataRows["mname"];
                                $LastNameToBeUpdated = $DataRows["lname"];
                                $EmailToBeUpdated = $DataRows["email"];
                                $GenderToBeUpdated = $DataRows["gender"];
                                $StatusToBeUpdated = $DataRows["m_status"];
                                $BirthToBeUpdated = $DataRows["birth_date"];
                                $PhoneToBeUpdated = $DataRows["phone"];
                                $AddressToBeUpdated = $DataRows["address"];
                                $StateToBeUpdated = $DataRows["state"];
                                $CountryToBeUpdated = $DataRows["country"];
                                $PositionToBeUpdated = $DataRows["position"];
                                $SalaryToBeUpdated = $DataRows["salary"];
                                $AppDateToBeUpdated = $DataRows["app_date"];
                            }
                        ?>
                        <form action="edit_staff.php?id=<?php echo $SearchQueryParameter ?>" method="POST" enctype="multipart/form-data">
                        <div class="card mt-3">
                            <div class="card-header">
                                <h4>Add New Staff</h4>
                            </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <span class="FieldInfo">Existing Image: </span>
                                        <img src="<?php echo $ImageToBeUpdated; ?>" width="170px" ; height="70px";>
                                        <br>
                                        <label for="ImageSelect"> <span class="FieldInfo">Select Image</span></label>
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="File" name="image" id="ImageSelect" value="">
                                            <label for="ImageSelect" class="custom-file-label"></label>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" class="form-control rounded-pill" id="firstname" name="firstname" value="<?php echo htmlentities($FirstNameToBeUpdated) ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="middlename">Middle Name</label>
                                        <input type="text" class="form-control rounded-pill" id="middlename" name="middlename" value="<?php echo htmlentities($MiddleNameToBeUpdated) ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" class="form-control rounded-pill" id="lastname" name="lastname" value="<?php echo htmlentities($LastNameToBeUpdated) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="gender">Gender</label><br>
                                        <?php 
    			                                if (strcasecmp($GenderToBeUpdated,"Male")==0){?>
                                        <input type="radio" name="gender" id="male" value="Male" required="required"
                                            checked> &nbsp; Male &nbsp;
                                        <?php }else{ ?>
                                        <input type="radio" name="gender" id="male" value="Male" required="required"> &nbsp;
                                        Male &nbsp;
                                        <?php }?>
                                        <?php 
    			                                        if (strcasecmp($GenderToBeUpdated,"female")==0){?>
                                        <input type="radio" name="gender" id="female" value="female" checked> &nbsp; Female
                                        &nbsp;
                                        <?php } else{?>
                                        <input type="radio" name="gender" id="female" value="female"> &nbsp; Female &nbsp;
                                        <?php }?>
                                        <?php 
    			                                        if (strcasecmp($GenderToBeUpdated,"other")==0){?>
                                        <input type="radio" name="gender" id="other" value="other" checked> &nbsp; Other
                                        &nbsp;
                                        <?php } else{?>
                                        <input type="radio" name="gender" id="other" value="other"> &nbsp; Other &nbsp;
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control rounded-pill" id="email" name="email" value="<?php echo htmlentities($EmailToBeUpdated) ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="status">Marrital Status</label>
                                        <select class="form-control rounded-pill" id="status" name="status">
                                            <option value="<?php echo htmlentities($StatusToBeUpdated) ?>"><?php echo htmlentities($StatusToBeUpdated) ?></option>
                                            <option value="single">single</option>
                                            <option value="married">married</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label><br>
                                        <input type="text" class="form-control rounded-pill" data-provide="datepicker" data-date-format="yyyy-mm-dd" name="dob" value="<?php echo htmlentities($BirthToBeUpdated) ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control rounded-pill" id="phone" name="phone" value="<?php echo htmlentities($PhoneToBeUpdated) ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="state">State of Origin</label>
                                        <input type="text" class="form-control rounded-pill" id="state" name="state" value="<?php echo htmlentities($StateToBeUpdated) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="country">Country</label><br>
                                        <input type="text" class="form-control rounded-pill" id="country" name="country" value="<?php echo htmlentities($CountryToBeUpdated) ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <input type="text" class="form-control rounded-pill" id="position" name="position" placeholder="e.g scretary, manager" value="<?php echo htmlentities($PositionToBeUpdated) ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="state">Salary</label>
                                        <input type="text" class="form-control rounded-pill" id="salary" name="salary" placeholder="eg. 30000, 50000" value="<?php echo htmlentities($SalaryToBeUpdated) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="appdate">Appointment Date</label><br>
                                        <input type="text" class="form-control rounded-pill" data-provide="datepicker" data-date-format="yyyy-mm-dd" name="appdate" value="<?php echo htmlentities($AppDateToBeUpdated) ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea type="text" class="form-control" id="position" rols="8" cols="5" name="address"><?php echo htmlentities($AddressToBeUpdated) ?></textarea>
                                    </div>
                                </div>
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
    <script src="dist/js/bootstrap-datepicker.min.js"></script>
    <script src="dist/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/dataTables.bootstrap4.min.js"></script>
</body>
</html>