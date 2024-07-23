<?php

$server_name = "localhost";
$username = "root";
$password = "";
$database = "crud";

$conn = mysqli_connect($server_name, $username, $password, $database);

// if($conn->connect_error){
//   die("Connection Failed". $conn->connect_error);
// }
// echo "Connected Successfully";

if(mysqli_connect_errno()){
  die("Connectioned Failed". mysqli_connect_error());
}

define("UPLOAD_SRC",$_SERVER['DOCUMENT_ROOT']."/crud/uploads/");

define("FETCH_SRC","http://127.0.0.1/crud/uploads/");

?>