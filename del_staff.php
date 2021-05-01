<?php 
    require_once("includes/DB.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");

    $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
    Confirm_Login();
?>
<?php 
    if(isset($_GET["id"])){
        $SearchQueryParemeter = $_GET["id"];
        global $ConnectingDB;
        $sql = "DELETE FROM staff WHERE id='$SearchQueryParemeter'";
        $stmt = $ConnectingDB->query($sql);
        $Execute = $stmt->execute();
        if($Execute){
            $_SESSION["SuccessMessage"] = "Staff deleted successfully";
            Redirect_to("staff.php");
        } else {
            $_SESSION["ErrorMessage"]="Something went wrong, Try Again!";
            Redirect_to("staff.php");
        }
    }


?>