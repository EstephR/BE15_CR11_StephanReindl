<?php
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "be15_cr11_petadoption_stephanreindl";

$connect = mysqli_connect($hostname, $username, $password, $dbname);

// Check if connection works
if ($connect) {
    // echo "Connection succeesful";
} else {
    die("connection failed". mysqli_connect_error());
}
?>