<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$userId = $_SESSION['userId'];
$tekst = $_POST['tekst'];
$thisId = $_POST['thisId'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$conn->query("SET CHARACTER SET utf8");
$sql = "UPDATE posty SET tresc ='$tekst' WHERE id = '$thisId'";

if ($conn->query($sql) === TRUE) {
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>