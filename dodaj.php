<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$userId = $_SESSION['userId'];
$friendId = $_POST['thisId'];
 

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    $sql = "INSERT INTO friends (userId, friendId)
VALUES ('$userId', '$friendId')";
if ($conn->query($sql) === TRUE) {
} else {

}

$sql = "INSERT INTO friends (userId, friendId)
VALUES ('$friendId', '$userId')";
if ($conn->query($sql) === TRUE) {
} else {
}

$conn->close();
}
 
?>