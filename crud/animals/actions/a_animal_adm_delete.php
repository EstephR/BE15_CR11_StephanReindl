<?php
session_start();
require_once "../../components/db_connect.php";

// if user will redirect to home
if (isset($_SESSION['user'])) {
  header("Location: ../../home.php");
  exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
  header("Location: ../../login.php");
  exit;
}

$sql = "DELETE FROM animals WHERE id = {$_GET["id"]}";

if(mysqli_query($connect, $sql) === true) {
    $class = "success";
    $message = "Animal has been successfully deleted!";
} else {
    $class = "danger";
    $message = "Something went wrong, please try again!" . $connect->error;
}

mysqli_close($connect);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Delete Animal</title>
        <link rel="icon" href="../img/favicon.png" type="image/x-icon">
        <?php require_once "../../components/bootstrap.php"?>
        <link rel="stylesheet" href="../../../css/style.css">
    </head>
    <body>
    <div class="container flex-column d-flex align-items-center">
        <div class="d-flex flex-column align-items-center w-50">
            <h1 class="w-100 p-3 text-light text-center mt-5 mb-5">Delete Animal</h1>
        </div>
            
            <div class="alert w-50 alert-<?=$class?>" role="alert"> 
                <p><?=$message?></p>
                <a href="../../dashboard.php"><button class="btn btn-success" type='button'>Go Back</button></a>
            </div>
        </div>
    </body>
</html>