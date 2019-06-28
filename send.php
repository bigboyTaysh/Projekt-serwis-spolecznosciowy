<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";
 
$nadawca = $_SESSION['userId'];
$odbiorca = $_POST['idOdbiorcy'];
$tytul = $_POST['tytul'];
$tresc = $_POST['tresc'];
echo $tresc; 
$conn = new mysqli($servername, $username, $password, $dbname);

$conn -> query ('SET CHARSET utf8');
$conn -> query ('SET CHARACTER_SET utf8_unicode_ci');
        
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    $sql = "INSERT INTO wiadomosci (nadawca, odbiorca, tytul, tresc) "
            . "VALUES ('$nadawca','$odbiorca', '$tytul', '$tresc' )";

if ($conn->query($sql) === TRUE) {

    $_SESSION['wiadomosc'] = '<span>Wiadomość wysłano pomyślnie!</span>';
    
} else {
    $_SESSION['wiadomosc'] = '<span style="color:red">Nie udało się wysłać wiadomość!</span>';
}
$conn->close();
}
 header('Location: wiadomosci.php');
?>