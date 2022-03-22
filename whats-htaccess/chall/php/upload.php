<?php

session_start();

if (session_id() === false) {
    echo "No session id!";
    exit(1);
}

$target_dir = "/var/www/html/uploads/";
$upload_path = session_id() . "/" . basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $upload_path;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

mkdir($target_dir . session_id());

if (!preg_match_all("/^[0-9a-zA-Z.\-_]+$/", basename($_FILES["fileToUpload"]["name"], null))) {
  echo "Invalid filename!\nValid filename characters are as follows: A-Z a-z 0-9 - _ .";
  $uploadOk = 0;
  die();
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
  header("Location: " . "/uploads/" . $upload_path);
  die();
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    header("Location: " . "/uploads/" . $upload_path);
    die();
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>