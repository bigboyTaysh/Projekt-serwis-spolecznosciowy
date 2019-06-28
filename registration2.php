<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";
unset($_SESSION['blad1']);
unset($_SESSION['blad2']);
$shouldBrake = false;

$login = $_POST['login'];
$haslo = $_POST['haslo2'];
$nick = $_POST['nick'];
$imie = $_POST['imie'];
$plec = $_POST['plec'];
$day = $_POST['day'];
$month = $_POST['month'];
$year = $_POST['year'];
$miejscowosc = $_POST['miejscowosc'];
$date = "$year-$month-$day";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    $_SESSION['blad1'] = '<span style="color:red; font-size: 25px">Brak połączenia</span>';
    header('Location: registration.php');
}
else{
$conn -> query ('SET CHARSET utf8');
$conn -> query ('SET CHARACTER_SET utf8_unicode_ci');


$sql = "SELECT  * FROM osoba WHERE  login = '$login'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $_SESSION['blad1'] = '<span style="color:red; font-size: 25px">Podany login istnieje!</span>';
    header('Location: registration.php');
    exit();
}

$sql2 = "SELECT  * FROM osoba WHERE  nick = '$nick'";
$result2 = $conn->query($sql2);
     
if ($result2->num_rows > 0) {
    $_SESSION['blad2'] = '<span style="color:red; font-size: 25px">Podany nick istnieje!</span>';
    header('Location: registration.php');
    exit();
}

$sql5 = "INSERT INTO osoba (login, haslo, nick, imie, plec, data, miejscowosc) VALUES ('$login','$haslo','$nick','$imie','$plec','$date','$miejscowosc')";
if ($conn->query($sql5) === TRUE) {
    header('Location: login.php');
} else {
    $_SESSION['blad1'] = '<span style="color:red; font-size: 25px">Nieoczekiwany błąd.</span>';
    header('Location: registration.php');
}
}
$conn->close();
?>