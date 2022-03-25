<?php
//The function accepts one argument sent through the a_create.php: file_upload($_FILES['picture'])
// the source by default is user!
function file_upload($picture, $source = 'user') {
    $result = new stdClass();//this object will carry status from file upload
    $result->fileName = 'avatar.png';
    if (isset($_SESSION['adm'])) {
        $result->fileName = 'animal.png';
    }
    $result->error = 1;//it could also be a boolean true/false
    //collect data from object $picture
    $fileName = $picture["name"];
    $fileType = $picture["type"];
    $fileTmpName = $picture["tmp_name"];
    $fileError = $picture["error"];
    $fileSize = $picture["size"];
    //this grabs the file extension (i.e. .php) and converts it to lower string!
    $fileExtension = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));    
    $filesAllowed = ["png", "jpg", "jpeg"];
    //There are pre-defined error types in php - check: https://www.php.net/manual/en/features.file-upload.errors.php
    if ($fileError == 4) {       
        $result->ErrorMessage = "No picture was chosen. It can always be updated later.";
        return $result;
    } else {
        //this checks if the file type is valid!
        if (in_array($fileExtension, $filesAllowed)) {
            //File error 0 means that there is no error!
            if ($fileError === 0) {
                if ($fileSize < 5000000) { //5000kb this number is in bytes
                    //it gives a file name based microseconds
                    $fileNewName = uniqid('') . "." . $fileExtension; // 1233343434.jpg i.e
                    if ($source == 'animal') {
                        $destination = "../../img/$fileNewName";
                    } elseif ($source == 'user') {
                        $destination = "../img/$fileNewName";
                    }
                    if (move_uploaded_file($fileTmpName, $destination)) {
                        $result->error = 0;
                        $result->fileName = $fileNewName;
                        return $result;
                    } else {    
                        $result->ErrorMessage = "There was an error uploading this file.";
                        return $result;
                    }
                } else {                                      
                    $result->ErrorMessage = "This picture is bigger than the allowed 5000Kb. <br> Please choose a smaller one and update the product.";
                    return $result;
                }
            } else {                              
                $result->ErrorMessage = "There was an error uploading - $fileError code. Check the PHP documentation.";
                return $result;
            }
        } else {                      
            $result->ErrorMessage = "This file type can't be uploaded.";
            return $result;
        }
    }
}
?>