<?php
session_start();

$target_dir = "C:/xampp/htdocs/PROJEKT/uploads/";
$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$filename = basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $_SESSION['upload'] =  "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $_SESSION['upload'] = "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $_SESSION['upload'] = "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $_SESSION['upload'] = "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $_SESSION['upload'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $_SESSION['upload'] = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $_SESSION['upload'] = "The file ".$filename. " has been uploaded.";
        
        $files = glob("uploads/".$_SESSION['userId'].".*");
        foreach ($files as $file) {
            unlink($file);
        }
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        echo $filename;
        rename('uploads/'.$filename, 'uploads/'.$_SESSION['userId'].".".$ext);
        
        $dirname = "uploads/";
        $images = glob($dirname.$_SESSION['id'].".*");
        if($images!=null){
            $image=$images[0];
            $_SESSION['avatar']=$image;
        }else{
            $dirname = "uploads/";
            $image = $dirname."default-avatar.png";
            $_SESSION['avatar']=$image;
        }
        
    } else {
        $_SESSION['upload'] = "Sorry, there was an error uploading your file.";
    }
}
header('Location: edytuj.php');
?>