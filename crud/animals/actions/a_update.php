<?php
session_start();

if (isset($_SESSION['user']) != "") {
  header("Location: ../../home.php");
  exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
  header("Location: ../../login.php");
  exit;
}

require_once '../../components/db_connect.php';
require_once '../../components/file_upload.php';

if ($_POST) {    
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $breed = $_POST['breed'];
    $size = $_POST['size'];
    $age = $_POST['age'];
    $vaccine = $_POST['vaccine'];
    $description = $_POST['description'];
    $hobbies = $_POST['hobbies'];
    $location = $_POST['location'];
    $id = $_POST['id'];

    //variable for upload pictures errors is initialised
    $uploadError = '';

    $picture = file_upload($_FILES['picture']); 
    if($picture->error===0){
        ($_POST["picture"]=="animal.png")?: unlink("../img/$_POST[picture]");           
        $sql = "UPDATE animals SET name = '$name', gender = '$gender', breed = '$breed', size = '$size', age = '$age', vaccine = '$vaccine', description = '$description', hobbies = '$hobbies', location = '$location', picture = '$picture->fileName' WHERE id = {$id}";
    }else{
        $sql = "UPDATE animals SET name = '$name', gender = '$gender', breed = '$breed', size = '$size', age = '$age', vaccine = '$vaccine', description = '$description', hobbies = '$hobbies', location = '$location' WHERE id = {$id}";
    }    
    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "The record was successfully updated";
        $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
    } else {
        $class = "danger";
        $message = "Error while updating record : <br>" . mysqli_connect_error();
        $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
    }
    mysqli_close($connect);    
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Update Data</title>
        <link rel="icon" href="../img/favicon.png" type="image/x-icon">
        <?php require_once '../../components/bootstrap.php'?> 
    </head>
    <body>
    <div class="container flex-column d-flex align-items-center">
        <div class="d-flex flex-column align-items-center">
            <h1 class="w-100 p-3 text-light text-center mt-5 mb-5">Animal Update</h1>
        </div>
            <div class="alert alert-<?php echo $class;?>" role="alert">
                <p><?php echo ($message) ?? ''; ?></p>
                <p><?php echo ($uploadError) ?? ''; ?></p>
                <a href='../update.php?id=<?=$id;?>'><button class="btn btn-warning" type='button'>Back</button></a>
                <a href='../index.php'><button class="btn btn-success" type='button'>Home</button></a>
            </div>
        </div>
    </body>
</html>