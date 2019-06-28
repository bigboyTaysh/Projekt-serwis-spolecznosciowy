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
    $sql = "DELETE FROM friends WHERE userId = '$userId' AND friendId = '$friendId'";
if ($conn->query($sql) === TRUE) {
    echo 'alert("brawo2")';
} else {
    echo 'alert("nie brawo2")';
}

$sql = "DELETE FROM friends WHERE userId = '$friendId' AND friendId = '$userId'";
if ($conn->query($sql) === TRUE) {
    echo 'alert("brawo2")';
} else {
    echo 'alert("nie brawo2")';
}

$conn->close();
}
 
?>