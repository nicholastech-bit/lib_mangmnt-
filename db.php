<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ucaa_library"; // make sure this is your actual DB name

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

