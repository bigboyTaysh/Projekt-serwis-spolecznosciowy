<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$haslo = $_POST['haslo3'];
$miejscowosc = $_POST['miejscowosc'];
$userId = $_SESSION['userId'];


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$conn->query("SET CHARACTER SET utf8");
$sql3 = "UPDATE osoba SET haslo='$haslo' WHERE id = '$userId'";

if ($conn->query($sql3) === TRUE) {
    $_SESSION['editHaslo'] = "Pomyślnie edytowano dane.";
} else {
    echo "Error: " . $sql3 . "<br>" . $conn->error;
}
header('Location: edytuj.php');
$conn->close();

?>