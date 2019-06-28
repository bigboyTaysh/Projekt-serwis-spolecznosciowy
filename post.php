<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";
 
$idOsoba = $_SESSION['userId'];
$tresc = $_POST['tresc'];
$conn = new mysqli($servername, $username, $password, $dbname);

$conn -> query ('SET CHARSET utf8');
$conn -> query ('SET CHARACTER_SET utf8_unicode_ci');
        
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    $sql = "INSERT INTO posty (idOsoba, tresc) "
            . "VALUES ('$idOsoba','$tresc' )";

if ($conn->query($sql) === TRUE) {

    $_SESSION['wiadomosc'] = '<span>Post opublikowano pomyślnie!</span>';
    
} else {
    $_SESSION['wiadomosc'] = '<span style="color:red">Nie udało się opublikować!</span>';
}
$conn->close();
}
?>