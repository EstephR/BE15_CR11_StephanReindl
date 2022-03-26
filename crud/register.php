<?php
session_start(); // start a new session or continues the previous
if (isset($_SESSION['user']) != "") {
  header("Location: home.php"); // redirects to home.php
}
if (isset($_SESSION['adm']) != "") {
  header("Location: dashboard.php"); // redirects to home.php
}
require_once 'components/db_connect.php';
require_once 'components/file_upload.php';
$error = false;
$fname = $lname = $email = $phone = $address = $pass = $picture = '';
$fnameError = $lnameError = $emailError = $phoneError =$addressError = $passError = $picError = '';
if (isset($_POST['btn-signup'])) {

  // sanitise user input to prevent sql injection
  // trim - strips whitespace (or other characters) from the beginning and end of a string
  $fname = trim($_POST['fname']);


  // strip_tags -- strips HTML and PHP tags from a string
  $fname = strip_tags($fname);

  // htmlspecialchars converts special characters to HTML entities
  $fname = htmlspecialchars($fname);

  $lname = trim($_POST['lname']);
  $lname = strip_tags($lname);
  $lname = htmlspecialchars($lname);

  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);

  $phone = trim($_POST['phone']);
  $phone = strip_tags($phone);
  $phone = htmlspecialchars($phone);

  $address = trim($_POST['address']);
  $address = strip_tags($address);
  $address = htmlspecialchars($address);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);

  $uploadError = '';
  $picture = file_upload($_FILES['picture']);

  // basic name validation
  if (empty($fname) || empty($lname)) {
      $error = true;
      $fnameError = "Please enter your full name and surname";
  } else if (strlen($fname) < 3 || strlen($lname) < 3) {
      $error = true;
      $fnameError = "Name and surname must have at least 3 characters.";
  } else if (!preg_match("/^[a-zA-Z]+$/", $fname) || !preg_match("/^[a-zA-Z]+$/", $lname)) {
      $error = true;
      $fnameError = "Name and surname must contain only letters and no spaces.";
  }

  // basic email validation
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = true;
      $emailError = "Please enter valid email address.";
  } else {
      // checks whether the email exists or not
      $query = "SELECT email FROM users WHERE email='$email'";
      $result = mysqli_query($connect, $query);
      $count = mysqli_num_rows($result);
      if ($count != 0) {
          $error = true;
          $emailError = "Provided Email is already in use.";
      }
  }

    // basic phone validation
    if (empty($phone)) {
        $error = true;
        $phoneError = "Please enter a valid phone number";
    } else if (strlen($phone) < 6) {
        $error = true;
        $phoneError = "Your phone number must have at least 6 numbers";
    } else if (!preg_match("/^[0-9\-\(\)\/\+\s]*$/", $phone)) {
        $error = true;
        $phoneError = "Your phone number can only contain specific characters!";
    }

    // basic address validation
    if (empty($address)) {
        $error = true;
        $addressError = "Please enter a valid address";
    } else if (strlen($address) < 6) {
        $error = true;
        $addressError = "Your address must have at least 8 characters";
    } else if (!preg_match("/^[A-Za-z0-9'\.\-\s\,]/", $address)) {
        $error = true;
        $addressError = "Your address can only contain specific characters";
    }

  // password validation
  if (empty($pass)) {
      $error = true;
      $passError = "Please enter password.";
  } else if (strlen($pass) < 6) {
      $error = true;
      $passError = "Password must have at least 6 characters.";
  }

  // password hashing for security
  $password = hash('sha256', $pass);
  // if there's no error, continue to signup
  if (!$error) {

      $query = "INSERT INTO users(fname, lname, email, phone, address, picture, password)
                VALUES('$fname', '$lname', '$email', '$phone', '$address', '$picture->fileName', '$password')";
      $res = mysqli_query($connect, $query);

      if ($res) {
          $errTyp = "success";
          $errMSG = "Successfully registered, you may login now";
          $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
          header("refresh:2;url=login.php");
      } else {
          $errTyp = "danger";
          $errMSG = "Something went wrong, try again later...";
          $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
      }
  }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pet's Up - Adoption Register</title>
  <?php require_once 'components/bootstrap.php' ?>
  <link rel="icon" href="../img/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php require_once "components/navbar_register.php" ?>


  <div class="container admin-container d-flex flex-column align-items-center">
      <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
      <div class="d-flex flex-column align-items-center">
            <h1 class="p-3 text-light text-center mt-3 mb-5">Sign in</h1>
        </div>
          <?php
          if (isset($errMSG)) {
          ?>
              <div class="d-flex flex-column align-items-center alert alert-<?php echo $errTyp ?>">
                  <p><?php echo $errMSG; ?></p>
                  <p><?php echo $uploadError; ?></p>
              </div>

          <?php
          }
          ?>
        <div class="d-flex flex-column align-items-center">
          <input type="text" name="fname" class="form-control mb-2" placeholder="First name" maxlength="50" value="<?php echo $fname ?>" />
          <span class="text-danger"> <?php echo $fnameError; ?> </span>

          <input type="text" name="lname" class="form-control mb-2" placeholder="Last Name" maxlength="50" value="<?php echo $lname ?>" />
          <span class="text-danger"> <?php echo $fnameError; ?> </span>

          <input type="email" name="email" class="form-control mb-2" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
          <span class="text-danger"> <?php echo $emailError; ?> </span>

          <input type="text" name="address" class="form-control mb-2" placeholder="Your Address" maxlength="100" value="<?php echo $address ?>" />
          <span class="text-danger"> <?php echo $addressError; ?> </span>

          <input type="text" name="phone" class="form-control mb-2" placeholder="Your Phone" maxlength="100" value="<?php echo $phone ?>" />
          <span class="text-danger"> <?php echo $phoneError; ?> </span>

          <input type="password" name="pass" class="form-control mb-2" placeholder="Enter Password" maxlength="15" />
          <span class="text-danger"> <?php echo $passError; ?> </span>

            <input class='form-control mb-2 start' type="file" name="picture">
            <span class="text-danger"> <?php echo $picError; ?> </span>

     
          <button type="submit" class="btn btn-block btn-warning w-25 mb-2" name="btn-signup">Sign Up</button>
        
          <a href="login.php">Sign in Here...</a>
        </div>  
      </form>
  </div>

  <?php require_once "components/footer.php" ?>

</body>
</html>