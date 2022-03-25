<?php
session_start();

require_once 'components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}
//if session user exist it shouldn't access dashboard.php
if (isset($_SESSION["user"])) {
  header("Location: home.php");
  exit;
}

$id = $_SESSION['adm'];
$sql = "SELECT * FROM animals WHERE status ='available'";
$result = mysqli_query($connect, $sql);

//this variable will hold the body for the table
$tbody = '';
if ($result->num_rows > 0) {
  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $tbody .= "<tr>
          <td><img class='img-thumbnail rounded-circle adm-picture' src='../img/" . $row['picture'] . "' alt=" . $row['name'] . "></td>
          <td>" . $row['name'] . "</td>
          <td>" . $row['gender'] . "</td>
          <td>" . $row['breed'] . "</td>
          <td>" . $row['size'] . "</td>
          <td>" . $row['age'] . "</td>
          <td>" . $row['vaccine'] . "</td>
          <td>" . $row['description'] . "</td>
          <td>" . $row['hobbies'] . "</td>
          <td>" . $row['location'] . "</td>
          <td><a href='update.php?id=" . $row['id'] . "'><button class='btn btn-warning btn-sm' type='button'>Edit</button></a>
          <a href='delete.php?id=" . $row['id'] . "'><button class='btn btn-outline-danger btn-sm' type='button'>Delete</button></a></td>
       </tr>";
  }
} else {
  $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

// select logged in Admin details
$result_adm = mysqli_query($connect, "SELECT * FROM users WHERE id=" . $_SESSION['adm']);
$row_adm = mysqli_fetch_array($result_adm, MYSQLI_ASSOC);

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Area</title>
  <?php require_once 'components/bootstrap.php' ?>
  <link rel="icon" href="../img/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<?php require_once "components/navbar_admin.php"?>


  <div class="container admin-container">
        <div class="d-flex flex-column align-items-center">
            <h1 class="p-3 text-light text-center mt-5 mb-5">Animal Data</h1>
        </div>
    <table class='table table-striped'>
               <thead class='table-headline text-light'>
                   <tr>
                        <th>Picture</th>
                       <th>Name</th>
                       <th>Gender</th>
                       <th>Breed</th>
                       <th>Size</th>
                       <th>Age</th>
                       <th>Vaccine</th>
                       <th>Description</th>
                       <th>Hobbies</th>
                       <th>Location</th>
                       <th>Actions</th>
                   </tr>
               </thead>
               <tbody>
                    <?= $tbody ?>
                </tbody>
           </table>
      </div>
  </div>

  <?php require_once "components/footer.php" ?>

</body>
</html>

