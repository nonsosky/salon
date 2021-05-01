<?php 
require_once("includes/DB.php");
?>

<?php
function Redirect_to($New_Location){
    header('Location:'.$New_Location);
    exit;
}

function CheckEmailExistorNot($email){
    global $ConnectingDB;
    $sql = "SELECT email FROM  admins WHERE (email=:emaiL)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':emaiL', $email);
    $stmt->execute();
    $Result = $stmt->fetchAll(PDO::FETCH_OBJ);
    if($stmt->rowCount()==1){
        return true;
    } else {
        return false;
    }
}

function CheckUsernameExistorNot($Username){
    global $ConnectingDB;
    $sql = "SELECT username FROM  admins WHERE (username=:userName)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':userName', $Username);
    $stmt->execute();
    $Result = $stmt->fetchAll(PDO::FETCH_OBJ);
    if($stmt->rowCount()==1){
        return true;
    } else {
        return false;
    }
}

function Confirm_Login(){
    if(isset($_SESSION["AdminLogin"])){
        return true;
    } else {
        $_SESSION["ErrorMessage"] = "Login is Required";
        Redirect_to("index.php");
    }
}


function TotalStaff(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM staff";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalStaffs = array_shift($TotalRows);
    echo $TotalStaffs;
}

function TotalProducts(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM products";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalFaculty = array_shift($TotalRows);
    echo $TotalFaculty;
}

function TotalRecords(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM records";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalDepartment = array_shift($TotalRows);
    echo $TotalDepartment;
}

function TotalAdmins(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM admin";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalAdmins = array_shift($TotalRows);
    echo $TotalAdmins;
}

function TotalAmountToday(){
    global $ConnectingDB;
    $sql = "SELECT SUM(amount) FROM records WHERE date(date) = CURDATE()";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCost = array_shift($TotalRows);
    return $TotalCost;
} 

function TotalToday(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM records WHERE date(date) = CURDATE()";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCost = array_shift($TotalRows);
    return $TotalCost;
} 

function TotalAmountYesterday(){
    global $ConnectingDB;
    $sql = "SELECT SUM(amount) FROM records WHERE date = CURDATE() - INTERVAL 1 DAY";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCost = array_shift($TotalRows);
    return $TotalCost;
}

function TotalYesterday(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM records WHERE date = CURDATE() - INTERVAL 1 DAY";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCost = array_shift($TotalRows);
    return $TotalCost;
}

function TotalAmountLast30days(){
    global $ConnectingDB;
    $sql = "SELECT SUM(amount) FROM records WHERE date = CURDATE() - INTERVAL 30 DAY";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCost = array_shift($TotalRows);
    return $TotalCost;
} 

function TotalLast30days(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM records WHERE date = CURDATE() - INTERVAL 30 DAY";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCost = array_shift($TotalRows);
    return $TotalCost;
} 

function TotalAmountAll(){
    global $ConnectingDB;
    $sql = "SELECT SUM(amount) FROM records";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCost = array_shift($TotalRows);
    return $TotalCost;
} 

function TotalAll(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM records";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCost = array_shift($TotalRows);
    return $TotalCost;
} 


?>