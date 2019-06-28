<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$userId = $_SESSION['userId'];
$miejscowosc = $_POST['miejscowosc'];
$opis = $_POST['opis'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$conn->query("SET CHARACTER SET utf8");
$sql = "UPDATE osoba SET miejscowosc ='$miejscowosc', opis ='$opis' WHERE id = '$userId'";

if ($conn->query($sql) === TRUE) {
    $_SESSION['edit'] = "Pomyślnie edytowano dane.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
header('Location: edytuj.php');
$conn->close();

?>