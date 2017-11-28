<?php
include("conexion.php");
// $server = "10.164.62.124";
// $user = "root";
// $pass = "qwerty";
// $db = "samsung";
// // $server = "localhost";
// // $user = "root";
// // $pass = "";
// // $db = "samsung";
$user = $_POST["user"];
$pass = $_POST["pass"];

if (!($link=mysqli_connect($server,$user,$pass,$db)))  
{  
    echo "Error conectando a la base de datos.";  
    exit();  
}  
mysqli_set_charset($link, "utf8");

$query = "select user, pass from user where user = "dfrod01" and (pass = "Dfrf4312356" collate UTF8_bin)";

$result = mysqli_query($link, $query);

?>