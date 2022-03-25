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
$adoption_date = date("Y-m-d");
$sql_adoption = "INSERT INTO pet_adoption (`id`, `fk_user_id`, `fk_animal_id`, `adoption_date`) VALUES (null,$fk_user_id,$fk_animal_id, '$adoption_date')";



if(mysqli_query($connect, $sql_adoption) === true) {
    $class = "success";
    $message = "Congratulations, you are now an official pet owner!";
    $animal_status = "adopted";
    // Update animal status
    $sql_animal = "UPDATE animals SET status='$animal_status' WHERE id = $fk_animal_id";
    mysqli_query($connect, $sql_animal);
} else {
    $class = "danger";
    $message = "Something went wrong, please try again!" . $connect->error;
    $animal_status = "available";
}

mysqli_close($connect);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Adopt Animal</title>
        <?php require_once "../../components/bootstrap.php"?>
        <link rel="stylesheet" href="../../../css/style.css">
    </head>
    <body>
        <div class="container flex-column d-flex align-items-center">
        <div class="d-flex flex-column align-items-center">
            <h1 class="w-100 p-3 text-light text-center mt-5 mb-5">Animal Adoption</h1>
        </div>
            
            <div class="w-50 d-flex flex-column align-items-center alert alert-<?=$class?>" role="alert"> 
                <p><?=$message?></p>
                <a href="../../home.php"><button class="btn btn-success" type='button'>Go Back</button></a>
            </div>
        </div>
    </body>
</html>