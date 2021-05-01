<?php 
    require_once("includes/DB.php");
    require_once("includes/functions.php");
    require_once("includes/sessions.php");
?>
<?php 
        $SearchQueryParameter = $_GET["id"];
        global $ConnectingDB;
        $sql = "DELETE FROM records WHERE id='$SearchQueryParameter'";
        $stmt = $ConnectingDB->query($sql);
        $Execute = $stmt->execute();
        if($Execute){
            echo json_encode(
            array(
                'success' => true,
                'msg' => 'success',
                'totalPrice' => TotalAmountAll()
            )
            );
        } else {
            echo json_encode(
            array(
                'success' => false,
                'msg' => 'failed'
                )
            );
        }


?>