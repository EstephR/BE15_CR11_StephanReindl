<?php
session_start();

require_once "components/db_connect.php";
require_once "components/file_upload.php";
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

// select logged in Admin details
$result_adm = mysqli_query($connect, "SELECT * FROM users WHERE id=" . $_SESSION['adm']);
$row_adm = mysqli_fetch_array($result_adm, MYSQLI_ASSOC);

if (isset($_POST["submit"])) {    
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $breed = $_POST['breed'];
    $size = $_POST['size'];
    $age = $_POST['age'];
    $vaccine = $_POST['vaccine'];
    $description = $_POST['description'];
    $hobbies = $_POST['hobbies'];
    $location = $_POST['location'];
    $availability = "available";


    //variable for upload pictures errors is initialised
    $uploadError = '';

    $picture = file_upload($_FILES['picture']); 

    $sql = "INSERT INTO animals (name, gender, breed, size, age, vaccine, description, hobbies, location, picture, status) VALUES ('$name', '$gender','$breed', '$size', $age, '$vaccine', '$description', '$hobbies', '$location', '$picture->fileName', '$availability')";
   
    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "The record was successfully created";
        $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
        header("refresh:2;url=dashboard.php");
    } else {
        $class = "danger";
        $message = "Error while creating record : <br>" . mysqli_connect_error();
        $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
        header("refresh:2;url=dashboard.php");
    } 
}
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



  <div class="container admin-container d-flex flex-column align-items-center">
    <div class="d-flex flex-column align-items-center w-100">

    <div class="alert-<?= $class ?> w-50 p-3 mb-3" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
        </div>

    <h1 class="p-3 text-light text-center mt-5 mb-5">Add New Animal</h1>
    </div>
   
    <fieldset class="mb-5">
        <form method="POST" enctype="multipart/form-data">
            <table class='table'>
                <tr>
                    <th>Name</th>
                    <td><input class='form-control' type="text" name="name"  placeholder="Name"></td>
                </tr>    
                <tr>
                    <th>Gender</th>
                    <td><input class='form-control' type="text" name= "gender" placeholder="Gender"></td>
                </tr>
                <tr>
                    <th>Breed</th>
                    <td><input class='form-control' type="text" name= "breed" placeholder="Breed"></td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td><select class='form-control' type="text" name= "size">
                        <option value="default">...</option>
                        <option value="small">small</option>
                        <option value="medium">medium</option>
                        <option value="big">big</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><input class='form-control' type="number" name= "age"></td>
                </tr>
                <tr>
                    <th>Vaccine</th>
                    <td><select class='form-control' type="text" name= "vaccine">
                        <option value="default">...</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><input class='form-control' type="text" name= "description" placeholder="Description"></td>
                </tr>
                <tr>
                    <th>Hobbies</th>
                    <td><input class='form-control' type="text" name= "hobbies" placeholder="Hobbies"></td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td><input class='form-control' type="text" name= "location" placeholder="Location"></td>
                </tr>
                <tr>
                    <th>Picture</th>
                    <td><input class='form-control' type="file" name="picture"  placeholder="media Type"></td>
                </tr>
                <tr> 
                <td></td>
                    <td class="d-flex justify-content-center"><button class='btn btn-warning p-3 w-50' name="submit" type="submit">Add Animal</button></td>
                </tr>
            </table>
        </form>
    </fieldset>

  </div>


  <?php require_once "components/footer.php" ?>

  <?php require_once "components/bootstrap_script.php" ?>
</body>
</html>



