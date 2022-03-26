<!-- File for the User to book rooms -->
<?php
session_start();
require_once "../../components/db_connect.php";

// if adm will redirect to dashboard
if (isset($_SESSION['adm'])) {
  header("Location: ../../dashboard.php");
  exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
  header("Location: ../../login.php");
  exit;
}


$fk_animal_id = $_GET["id"];
$fk_user_id = $_SESSION["user"];
$animal_status = "";
$sql_delete = "DELETE FROM `pet_adoption` WHERE fk_animal_id = $fk_animal_id AND fk_user_id = $fk_user_id";

if(mysqli_query($connect, $sql_delete) === true) {
    $class = "success";
    $message = "Your pet will be returned!";
    $animal_status = "available";
    // Update Room status
    $sql_animal = "UPDATE animals SET status='$animal_status' WHERE id = $fk_animal_id";
    mysqli_query($connect, $sql_animal);
} else {
    $class = "danger";
    $message = "Something went wrong, please try again!" . $connect->error;
    $room_status = "adopted";
}

mysqli_close($connect);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Return Animal</title>
        <link rel="icon" href="../img/favicon.png" type="image/x-icon">
        <?php require_once "../../components/bootstrap.php"?>
        <link rel="stylesheet" href="../../../css/style.css">
    </head>
    <body>
        <div class="container flex-column d-flex align-items-center">
        <div class="d-flex flex-column align-items-center">
            <h1 class="w-100 p-3 text-light text-center mt-5 mb-5">Animal Return</h1>
        </div>
            
            <div class="w-50 d-flex flex-column align-items-center alert alert-<?=$class?>" role="alert"> 
                <p><?=$message?></p>
                <a href="../../home.php"><button class="btn btn-success" type='button'>Go Back</button></a>
            </div>
        </div>
    </body>
</html>