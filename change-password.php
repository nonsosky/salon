<?php
require_once("includes/DB.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");
?>

<?php 
$_SESSION["TrackingUrl"]=$_SERVER["PHP_SELF"];
Confirm_Login();
?>

<?php
 if(isset($_POST["password_change"])){
    $newpassword = strip_tags($_POST['new_password']);
    $confirmnewpassword = strip_tags($_POST['con_password']);

        if(empty($newpassword)||empty($confirmnewpassword)){
            echo "All Field Must Be Filled";
        }
        elseif(strlen($newpassword) < 4){
            echo "Password must be 4 characters long.";
        }
        elseif($confirmnewpassword !== $newpassword){
            echo "Passwords do not match!";
        } else {
            global $ConnectingDB;
            $Admin = $_SESSION["UserId"];
            $Password = password_hash($newpassword, PASSWORD_DEFAULT);
            $sql = "UPDATE admin SET password = '{$Password}' WHERE id = '$Admin'";
            $stmt = $ConnectingDB->query($sql);
            if($stmt){
                echo "Password Changed Successfully";
            } else{
                echo "Password Could Not be Updated";
            }
    }
}

?>