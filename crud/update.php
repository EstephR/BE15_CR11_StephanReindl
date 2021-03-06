<?php
session_start();
require_once 'components/db_connect.php';
require_once 'components/file_upload.php';

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


if($_GET["id"]) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM animals WHERE id = $id";
    $result = mysqli_query($connect, $sql);

    if(mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $name = $data["name"];
        $gender = $data["gender"];
        $breed = $data["breed"];
        $size = $data["size"];
        $age = $data["age"];
        $vaccine = $data["vaccine"];
        $description = $data["description"];
        $hobbies = $data["hobbies"];
        $location = $data["location"];
        $picture = $data["picture"];
    } else {
        header("location: dashboard.php");
    }
   
} else {
    header("location: dashboard.php");
}

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
    $id = $_POST['id'];

    //variable for upload pictures errors is initialised
    $uploadError = '';

    $picture = file_upload($_FILES['picture']); 
    if($picture->error===0){
        ($_POST["picture"]=="animal.png")?: unlink("../img/$_POST[picture]");           
        $sql = "UPDATE animals SET name = '$name', gender = '$gender', breed = '$breed', size = '$size', age = $age, vaccine = '$vaccine', description = '$description', hobbies = '$hobbies', location = '$location', picture = '$picture->fileName' WHERE id = {$id}";
    }else{
        $sql = "UPDATE animals SET name = '$name', gender = '$gender', breed = '$breed', size = '$size', age = '$age', vaccine = '$vaccine', description = '$description', hobbies = '$hobbies', location = '$location' WHERE id = {$id}";
    }    
    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "The record was successfully updated";
        $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
        header("refresh:2;url=dashboard.php");
    } else {
        $class = "danger";
        $message = "Error while updating record : <br>" . mysqli_connect_error();
        $uploadError = ($picture->error !=0)? $picture->ErrorMessage :'';
        header("refresh:2;url=dashboard.php");
    } 
}
mysqli_close($connect);

?>


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
        <div class="alert-<?= $class ?> w-50 p-3 mb-3" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
        </div>
        <div class="d-flex flex-column align-items-center w-100">
            <h1 class="p-3 text-light text-center mb-5">Update Data</h1>
        </div>

    <fieldset class="mb-5">
        <form method="POST" enctype="multipart/form-data">
            <table class='table'>
                <tr>
                    <th>Name</th>
                    <td><input class='form-control' type="text" name="name"  placeholder="Name" value="<?=$name?>"/></td>
                </tr>    
                <tr>
                    <th>Gender</th>
                    <td><input class='form-control' type="text" name= "gender" placeholder="Gender"value="<?=$gender?>"/></td>
                </tr>
                <tr>
                    <th>Breed</th>
                    <td><input class='form-control' type="text" name= "breed" placeholder="Breed"value="<?=$breed?>"/></td>
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
                    <td><input class='form-control' type="number" name= "age" value="<?=$age?>"/></td>
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
                    <td><input class='form-control' type="text" name= "description" placeholder="Description"value="<?=$description?>"/></td>
                </tr>
                <tr>
                    <th>Hobbies</th>
                    <td><input class='form-control' type="text" name= "hobbies" placeholder="Hobbies"value="<?=$hobbies?>"/></td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td><input class='form-control' type="text" name= "location" placeholder="Location" value="<?=$location?>"/></td>
                </tr>
                <tr>
                    <th>Picture</th>
                    <td><input class='form-control' type="file" name="picture"  placeholder="media Type" value="<?=$type?>"/></td>
                </tr>
                <tr>
                    <input type="hidden" name="id" value="<?=$id ?>" />
                    <input type="hidden" name="picture" value="<?=$picture ?>" /> 
                </tr>    
                <tr> 
                <td></td>
                    <td class="d-flex justify-content-center"><button class='btn btn-warning p-3 w-50' name="submit" type="submit">Change Data</button></td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>




  </div>

  <?php require_once "components/footer.php" ?>
  <?php require_once "components/bootstrap_script.php" ?>
</body>
</html>

