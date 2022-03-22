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

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
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