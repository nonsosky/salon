<?php 
require_once("includes/DB.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

    require './vendor/autoload.php';
    require_once("includes/cloudinary.php");

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login();
?>
<?php
if (isset($_SESSION["AdminLogin"])) {
  // only if user is logged in perform this check
  if ((time() - $_SESSION['last_login_timestamp']) > 300) {
    Redirect_to("logout.php");
    exit;
  } else {
    $_SESSION['last_login_timestamp'] = time();
  }
}
?>


<?php 
$Admin = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM admin WHERE id='{$Admin}'";
$stmt = $ConnectingDB->query($sql);
while($DataRows = $stmt->fetch()){
    $ExistingFirstName = $DataRows["fname"];
    $ExistingMiddleName = $DataRows["mname"];
    $ExistingLastName = $DataRows["lname"];
    $ExistingUsername = $DataRows["username"];
    $ExistingEmail = $DataRows["email"];
    $ExistingMobile = $DataRows["phone"];
    $ExistingImage = $DataRows["image"];
}

if(isset($_POST["Submit"])){
    $FirstName = $_POST["FirstName"];
    $MiddleName = $_POST["MiddleName"];
    $LastName = $_POST["LastName"];
    $UserName = $_POST["UserName"];
    $Email = $_POST["Email"];
    $PhoneNum = $_POST["PhoneNo"];
    $Image = $_FILES["Image"]["name"];
    $Target = $_FILES["Image"]["tmp_name"];
    // $CloudImg = \Cloudinary\Uploader::upload($Target, array("folder" => "Folders/farmlink/"));
    // $Filename = $CloudImg["secure_url"];

    if(empty($FirstName)||empty($LastName)||empty($Email)){
        $_SESSION["ErrorMessage"]="All fields must be filled";
        Redirect_to("profile.php");
    }
    elseif(!preg_match("/^[A-Za-z\. ]*$/", $FirstName)){
        $_SESSION["ErrorMessage"] = "Only Letters and white spaces are allowed";
        Redirect_to("profile.php");
     }
     elseif(!preg_match("/^[A-Za-z\. ]*$/", $MiddleName)){
        $_SESSION["ErrorMessage"] = "Only Letters and white spaces are allowed";
        Redirect_to("profile.php");
     }
     elseif(!preg_match("/^[A-Za-z\. ]*$/", $LastName)){
        $_SESSION["ErrorMessage"] = "Only Letters and white spaces are allowed";
        Redirect_to("profile.php");
     }
     elseif(strlen($Phone) > 15){
        $_SESSION["ErrorMessage"] = "Phone Number must not be greather than 15 characters";
        Redirect_to("profile.php");
     } 
     else {
        global $ConnectingDB;
        if(!empty($Target)){
            $CloudImg = \Cloudinary\Uploader::upload($Target, array("folder" => "Folders/farmlink/"));
            $Filename = $CloudImg["secure_url"];
            $sql = "UPDATE admin SET fname='$FirstName', mname='$MiddleName', lname='$LastName', username='$UserName', email='$Email', mobile='$PhoneNum', aimage='$Filename' WHERE id='{$Admin}'";
        } else {
        $sql = "UPDATE admin SET fname='$FirstName', mname='$MiddleName', lname='$LastName', username='$UserName', email='$Email', mobile='$PhoneNum' WHERE id='{$Admin}'";
        }
        $Execute = $ConnectingDB->query($sql);
        // move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        // var_dump($Execute);
        if($Execute){
            $_SESSION["SuccessMessage"]="Profile Updated Successfully";
            Redirect_to("profile.php");
        } else {
            $_SESSION["ErrorMessage"]="Failed! Something went wrong";
            Redirect_to("profile.php");
        }
     }
}
?>

<style>.line1, .line2, .line3 {
    width: 30px;
    height: 1px;
    border: 1px solid #fff;
    margin: 5px auto;
    display: block;
    transition: all .4s;
  }

  .change .line1 {
    transform: rotate(45deg) translate(3px, 4px);
  }

  .change .line2 {
    display: none;
  }
  </style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/all.css">
    <link rel="stylesheet" type="text/css" href="dist/css/styles.css">
    <link rel="stylesheet" type="text/css" href="dist/css/dataTables.bootstrap4.min.css">
    <title>Profile</title>
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
    
            <div class="col-11 col-md-10 mx-auto mt-4 mb-4">
            <?php 
                    echo ErrorMessage();
                    echo SuccessMessage();
                    ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="<?php echo $ExistingImage; ?>" height="150px" width="160px" style="border-radius: 50%;">
                                </div>
                                <table class="mt-4">
                                    <tr>
                                        <th style="padding: 8px;">First Name: </th>
                                        <td style="padding: 8px; text-transform: uppercase;"><?php echo $ExistingFirstName; ?></td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 8px;">Middle Name: </th>
                                        <td style="padding: 8px; text-transform: uppercase;"><?php echo $ExistingMiddleName; ?></td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 8px;">Last Name: </th>
                                        <td style="padding: 8px; text-transform: uppercase;"><?php echo $ExistingLastName; ?></td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 8px;">Username: </th>
                                        <td style="padding: 8px; text-transform: uppercase;"><?php echo $ExistingUsername; ?></td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 8px;">Email: </th>
                                        <td style="padding: 8px; text-transform: uppercase;"><?php echo $ExistingEmail; ?></td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 8px;">Mobile: </th>
                                        <td style="padding: 8px; text-transform: uppercase;"><?php echo $ExistingMobile; ?></td>
                                    </tr>
                                </table>
                                <div>
                                    <button type="button" class="btn btn-warning float-right mt-3" data-toggle="modal" data-target="#myModal">change password <i class="fas fa-key"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <form action="profile.php" method="POST" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-header bg-warning">
                                    <h5>Edit Profile <i class="fas fa-edit"></i></h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="FirstName" placeholder="first name" value="<?php echo $ExistingFirstName; ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="MiddleName" placeholder="middle name" value="<?php echo $ExistingMiddleName; ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="LastName" placeholder="last name" value="<?php echo $ExistingLastName; ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="UserName" placeholder="user name" value="<?php echo $ExistingUsername; ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="Email" placeholder="email" value="<?php echo $ExistingEmail; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="PhoneNo" placeholder="phone number" value="<?php echo $ExistingMobile; ?>">
                                    </div>
                                    <div class="form-group">
                                    <div class="custom-file">
                                        <input class="custom-file-input" type="File" name="Image" id="ImageSelect">
                                         <label for="ImageSelect" class="custom-file-label"></label>
                                    </div> 
                                    </div>
                                    <button type="submit" class="btn btn-success float-right" name="Submit">Update</button> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            </div>
        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-key" style="color: #ffa500;"></i> Change Password</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <!--display success/error message-->
            <div id="mymessage"></div>
            <br>
        <form action="change-password.php" id="resetform" class="passform" method="POST" role="form">
            <div class="form-group">
                <input type="password" class="form-control"  name="new_password" placeholder="new password" id="new_password"> 
            </div>
            <div class="form-group">
                <input type="password" class="form-control"  name="con_password" placeholder="confirm password" id="con_password"> 
            </div>
            <button type="submit" class="btn btn-danger float-right" name="password_change" id="submit_btn">Change Password <i class="fas fa-save"></i></button>
        </form>

        
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

    <script>
        $(document).ready(function(){
            var frm = $('#resetform');
            frm.submit(function(e){
                e.preventDefault();

                var formData = frm.serialize();
                formData += '&' + $('#submit_btn').attr('name') + '=' + $('#submit_btn').attr('value');
                $.ajax({
                    type: frm.attr('method'),
                    url: frm.attr('action'),
                    data: formData,
                    success: function(data){
                        $('#mymessage').html(data).delay(3000).fadeOut(3000);
                        window.setTimeout(function(){location.reload()},5500);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#mymessage').html(textStatus).delay(10000).fadeOut(10000);
                    }
                });
            });
        });
    </script>

</body>
</html>