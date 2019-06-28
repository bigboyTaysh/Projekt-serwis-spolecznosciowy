<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$userId = $_SESSION['userId'];
$id = $_POST['thisId'];
 

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    $sql = "DELETE FROM wiadomosci WHERE id = '$id'";
if ($conn->query($sql) === TRUE) {
    echo 'alert("brawo2")';
} else {
    echo 'alert("nie brawo2")';
}

$conn->close();
}
 
?>