<?php 
require_once("includes/functions.php");
require_once("includes/sessions.php");

// $_SESSION["AdminLogin"] = null;
// $_SESSION["UserId"] = null;
// $_SESSION["Name"] = null;
unset($_SESSION);

session_destroy();
Redirect_to("index.php");
?>