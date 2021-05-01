<?php 
$DSN = 'mysql:host=localhost;dbname=salon';
$ConnectingDB = new PDO($DSN, 'root', '');

// try{
//     $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
//     $cleardb_server = "us-cdbr-east-03.cleardb.com";
//     $cleardb_port = "port"; 
//     $cleardb_username = "be96734551662a";
//     $cleardb_password = "2f262358";
//     $cleardb_db = "heroku_80fd5f11f7953ae";
//     $ConnectingDB = new PDO("mysql:host=$cleardb_server;port=$cleardb_port;dbname=$cleardb_db", $cleardb_username, $cleardb_password);
// }
// Catch(Exception $e){
//     echo'db connection failed';
// }
?>