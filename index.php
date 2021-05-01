<?php 
require_once("includes/DB.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

?>

<?php 
if(isset($_SESSION["AdminLogin"])){
    Redirect_to("dashboard.php");
}



if(isset($_POST["Submit"])){
    $Username = $_POST["Username"];
    $Password = $_POST["Password"];

    if(empty($Username)|| empty($Password)){
        $_SESSION["ErrorMessage"] = "All field must be filled";
        Redirect_to("index.php");
    } 
    
    else {
        global $ConnectingDB;
        $sql = "SELECT id, fname, mname, lname, username, email, phone, password FROM admin WHERE username=:userName";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':userName', $Username);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);

        if($stmt->rowCount() > 0){
            foreach($results as $rows){
                $UserId = $rows->id;
                $FirstName = $rows->fname;
                $MiddleName = $rows->mname;
                $LastName = $rows->lname;
                $Email = $rows->email;
                $hashpass = $rows->password;
            }
            if(password_verify($Password, $hashpass)){
                $_SESSION["AdminLogin"] = $_POST["Username"];
                $_SESSION["UserId"] = $UserId;
                $_SESSION["FirstName"] = $FirstName;
                $_SESSION["MiddleName"] = $MiddleName;
                $_SESSION["LastName"] = $LastName;
                $_SESSION["Email"] = $Email;
                $_SESSION["SuccessMessage"] = "Welcome ".$_SESSION["FirstName"]. ' '. $_SESSION["LastName"];
                $_SESSION["last_login_timestamp"] = time();
                if(isset($_SESSION["TrackingURL"])){
                    Redirect_to($_SESSION["TrackingURL"]);
                } else {
                    Redirect_to("dashboard.php");
                }
            } else {
                $_SESSION["ErrorMessage"]="Wrong Password";
            }
        } else {
            $_SESSION["ErrorMessage"]="User Not Registered With Us";
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
    <title>Login</title>
</head>
<body style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.55)), url('images/b_salon.jpg'); background-position: center; background-size: cover; background-repeat: no-repeat; height: 698px;">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #355D5F;">
        <div class="container">
            <a href="#" class="navbar-brand">
                <div class="d-flex Justify-content-around">
                    <!-- <img src="" alt="AAP Logo" style="width:70px; height: 50px;"/> -->
                    <div class="position-relative">
                        <h4 class="text-uppercase">Sliver Dove</h4>
                        <h6 style="position: absolute; left: 80%; right: 0%; top: 22px; font-style: italic">Salon</h6>
                    </div>
                </div>
            </a>
        </div>
    </nav>

    <div class="container py-2" style="min-height: 580px;">
        <div class="row">
            <div class="col-sm-6 mx-auto">
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
                <form action="index.php" method="POST">
                    <div class="card mt-5">
                        <div class="card-header text-secondary">
                            <h5>Admin Login <i class="fas fa-sign-in-alt float-right text-success"></i></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-secondary"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="Username" placeholder="username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-secondary"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="Password" id="pwd">
                                </div>
                                <br>
                                <input type="checkbox" onclick="myFunction()"> Show Password
                            </div>
                            <input type="submit" class="btn btn-success btn-block mt-4" name="Submit" value="Login">
                        </div>
                    </div>
                </form>
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