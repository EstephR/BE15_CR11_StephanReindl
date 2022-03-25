<?php
session_start();
require_once 'components/db_connect.php';

// if adm will redirect to dashboard
if (isset($_SESSION['adm'])) {
  header("Location: dashboard.php");
  exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION["user"];

// select logged-in users details - procedural style
$res = mysqli_query($connect, "SELECT * FROM users WHERE id=" . $_SESSION['user']);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);

// Insert Animal Data - only for available animals
$sql = "SELECT * FROM animals WHERE status='available'";
$result = mysqli_query($connect, $sql);

// Fetch the data
if (mysqli_num_rows($result) > 0) {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC); 
    } else {
        $rows = "Currently, there are no pets available!";
    }               

// Get Senior Animal data
$sql_senior = "SELECT * FROM animals WHERE status='available' AND age > 8";
$result_senior = mysqli_query($connect, $sql_senior);

//Fetch the data
if (mysqli_num_rows($result_senior) > 0) {
    $rows_senior = mysqli_fetch_all($result_senior, MYSQLI_ASSOC); 
    } else {
        $rows_senior = "Currently, there are no pets available!";
    }      

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome - <?php echo $row['fname']; ?></title>
  <?php require_once 'components/bootstrap.php' ?>
  <link rel="icon" href="../img/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php require_once "components/navbar.php" ?>    
  
<div class="container admin-container">
    <div class="d-flex flex-column align-items-center justify-content-center h1-container">
            <h1 class="p-3 text-light text-center mt-5 mb-2 pets-headline">Pets available</h1>
            <form class="w-50 justify-content-around d-flex mt-3 mb-5" method="POST"action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <button class="btn sort-btn" type="submit" name="btn-sort">Show Seniors</button></a>
            <a href="pets_available.php"><button class="btn sort-btn">Show All</button></a>
            </form>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 justify-content-center m-auto mb-5 gap-5">

    <!-- Loop Data -->
        <?php

        if(isset($_POST["btn-sort"])) {
        if(is_array($rows_senior)) {
            foreach($rows_senior as $row) {
         ?>
        <div class="card border-0 shadow p-0" style="width: 18rem;">
            <img src="../img/<?=$row["picture"]?>" class="card-img-top d-xl-block d-lg-block d-md-block d-sm-none" height="400" style="object-fit:cover; object-position:center" alt="<?=$row["name"]?>">
            <div class="card-header text-center text-light h4"><?= $row["name"]?></div>
            <div class="card-body">
                <p class="card-text m-0">Gender: <?= $row["gender"]?></p>
                <p class="card-text m-0">Breed: <?= $row["breed"]?></p>
                <p class="card-text m-0">Size: <?= $row["size"]?></p>
                <p class="card-text m-0">Age: <?= $row["age"]?></p>
                <p class="card-text m-0">Vaccine: <?= $row["vaccine"]?></p>
            </div>
            <div class="card-header d-flex justify-content-around p-3">
                <a href="details.php?id=<?=$row["id"]?>"><button class="btn">Show Details</button></a>
                <a href="animals/actions/a_adopt.php?id=<?=$row["id"]?>"><button class="btn">Take me home</button></a>
            </div>           
        </div>        
        <?php 
            }
        } else {
            echo $rows_senior;
        }
        } else {
            if(is_array($rows)) {
                foreach($rows as $row) {
             ?>
            <div class="card border-0 shadow p-0" style="width: 18rem;">
                <img src="../img/<?=$row["picture"]?>" class="card-img-top d-xl-block d-lg-block d-md-block d-sm-none" height="400" style="object-fit:cover; object-position:center" alt="<?=$row["name"]?>">
                <div class="card-header text-center text-light h4"><?= $row["name"]?></div>
                <div class="card-body">
                    <p class="card-text m-0">Gender: <?= $row["gender"]?></p>
                    <p class="card-text m-0">Breed: <?= $row["breed"]?></p>
                    <p class="card-text m-0">Size: <?= $row["size"]?></p>
                    <p class="card-text m-0">Age: <?= $row["age"]?></p>
                    <p class="card-text m-0">Vaccine: <?= $row["vaccine"]?></p>
                </div>
                <div class="card-header d-flex justify-content-around p-3">
                    <a href="details.php?id=<?=$row["id"]?>"><button class="btn">Show Details</button></a>
                    <a href="animals/actions/a_adopt.php?id=<?=$row["id"]?>"><button class="btn">Take me home</button></a>
                </div>           
            </div>        
            <?php 
                }
            } else {
                echo $rows;
            }
        }        
        ?>
    </div>
</div>

<!-- <a href="products/actions/a_book.php?id=<?=$row["id"]?>"><button class='btn'>Adopt Now</button> -->

  

  <?php require_once "components/footer.php" ?>



</body>
</html>