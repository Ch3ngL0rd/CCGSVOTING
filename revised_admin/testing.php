<?php
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $target_dir = "../components/uploaded/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $errors = [];
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if (file_exists($target_file)) {
        array_push($errors,"File with name [".$_FILES["fileToUpload"]["name"]."] already exists.");
    }
    if ($_FILES["fileToUpload"]["size"] > 1000000) {
        array_push($errors,"File is too large.");
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        array_push($errors,"Only files of type JPG, JPEG & PNG are allowed.");
    }

    if (count($errors) != 0) {
        foreach ($errors as $error) {
            echo "$error<br>";
        }
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<body>

<form action="testing.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>