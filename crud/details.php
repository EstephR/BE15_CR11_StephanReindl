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

//Get animal details
if(isset($_GET["id"]) && !empty($_GET["id"])) {
$sql ="SELECT * FROM animals WHERE id = $_GET[id]";
$result = mysqli_query($connect, $sql);
$row_details = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once 'components/bootstrap.php' ?>
  <link rel="icon" href="../img/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/style.css">
    <title>Pet Details</title>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-admin p-5 navbar-expand-lg navbar-dark bg-light mb-5">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="home.php">
            <img class="userImage img-thumbnail rounded-circle" src="../img/<?php echo $row['picture']; ?>" alt="<?php echo $row['fname']; ?>" width="100" height="100" class="d-inline-block align-text-top">
            <div class="text-white ms-3">Hi <?php echo $row['fname']; ?></div></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-5">
                <a class="nav-link ms-3" href="pets_available.php"><button class="btn btn-success p-3">See available pets</button></a>
                <a class="nav-link" href="logout.php?logout"><button class="btn btn-outline-danger p-3">Log out</button></a>
            </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center h1-container">
            <h1 class="p-3 text-light text-center mt-5 mb-5 pets-headline">Pet Details</h1>
         </div>

    <div class="row justify-content-center m-auto mb-5">
         <div class="card border-0 shadow p-0 mb-3" style="max-width: 540px;">
         <div class="card-header text-center text-light h4"><?= $row_details["name"]?></div>
            <div class="row g-0">
            <div class="col-md-4">
            <img src="../img/<?=$row_details["picture"]?>" class="img-fluid rounded-start" alt="..." style="object-fit:cover; object-position:center; height: 100%;">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <p class="card-text m-0">Gender: <?= $row_details["gender"]?></p>
                <p class="card-text m-0">Breed: <?= $row_details["breed"]?></p>
                <p class="card-text m-0">Size: <?= $row_details["size"]?></p>
                <p class="card-text m-0">Age: <?= $row_details["age"]?></p>
                <p class="card-text m-0">Vaccine: <?= $row_details["vaccine"]?></p>
                <hr>
                <p class="card-text m-0">Description: <?= $row_details["description"]?></p>
                <p class="card-text m-0">Hobbies: <?= $row_details["hobbies"]?></p>
                <p class="card-text m-0">Location: <?= $row_details["location"]?></p>
        </div>
        </div>
        <div class="card-header d-flex justify-content-around p-3">
                <a href="pets_available.php?>"><button class="btn">Go Back</button></a>
                <a href="animals/actions/a_adopt.php?id=<?=$row["id"]?>"><button class="btn">Take me home</button></a>
        </div> 
    </div>         
  </div>
</div>
</div>

<?php require_once "components/footer.php" ?>

</body>
</html>
<?php } else {
    header("Location: ../home.php"); 
}
?>