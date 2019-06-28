<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";
 
$login = $_POST['login'];
$haslo = $_POST['password'];
 
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    $sql = "SELECT  * FROM osoba WHERE  login = '$login' AND haslo = '$haslo'";
 
$result = $conn->query($sql);
if ($result->num_rows > 0) {
 
 
    $_SESSION['zalogowany'] = true;
	
    $row = $result->fetch_assoc();
    $_SESSION['id'] = $row['id'];  
    
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
        
    unset($_SESSION['blad']);
    $result->free_result();
    header('Location: tablica.php');
    
} else {
    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
    header('Location: login.php');
}
$sql->close();
}
 
?>