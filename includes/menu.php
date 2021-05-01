<?php 
    require_once("includes/DB.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");

?>

<nav class="navbar navbar-expand-md navbar-dark main-nav" style="background-color: #355D5F; min-height: 90px;">
    <div class="container">
        <a href="Dashboard.php" class="navbar-brand">
            <div class="d-flex Justify-content-around">
                <!-- <img src="" alt="AAP Logo" style="width:70px; height: 50px;" /> -->
                <div class="position-relative">
                    <h4 class="text-uppercase">Sliver Dove</h4>
                    <h6 style="position: absolute; left: 100px; right: 0%; top: 22px; font-style: italic">Salon</h6>
                </div>
            </div>
        </a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#Menu">
            <span class="bg-light line1"></span>
            <span class="bg-light line2"></span>
            <span class="bg-light line3"></span>
        </button>
        <div class="collapse navbar-collapse" id="Menu">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-uppercase text-light font-weight-bold" data-toggle="dropdown"><i class="fas fa-user text-warning mr-1"></i> Admin</a>
                
                <div class="dropdown-menu text-light account-dropdown" style="background-color: #355D5F;">
                    <a href="profile.php" class="dropdown-item text-center text-uppercase text-light font-weight-bold" style="background-color: #355D5F;">
                    <?php
                        $AdminId = $_SESSION["UserId"];
                        global $ConnectingDB;
                        $sql = "SELECT * FROM admin WHERE id='$AdminId'";
                        $stmt = $ConnectingDB->query($sql);
                        while($DataRows = $stmt->fetch()){
                        $ExistingImage = $DataRows["image"];
                        }
                    ?>
                    <img src="images/<?php echo $ExistingImage; ?>" style="width: 80px; height: 68px; border-radius: 50%;">
                    <br>
                        Profile
                    </a>
                    <a href="add_admin.php" class="dropdown-item d-flex align-items-center justify-content-center justify-content-md-between text-uppercase text-light font-weight-bold" style="background-color: #355D5F;">
                        <span><i class="fas fa-user-plus text-warning"></i>
                            New Admin
                        </span>
                    </a>
                    <a href="logout.php" class="dropdown-item d-flex align-items-center justify-content-center justify-content-md-between text-uppercase text-light font-weight-bold" style="background-color: #355D5F;">
                        <span><i class="fas fa-sign-out-alt text-danger"></i>
                            Logout
                        </span>
                    </a>
                </div>
                </li>
            </ul>
        </div>
    </div>
</nav>