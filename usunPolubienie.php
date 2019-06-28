<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$userId = $_SESSION['userId'];
$idPosty = $_POST['idPosty'];
 

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    $sql = "DELETE FROM polubienia WHERE idPosty='$idPosty' AND idOsoba='$userId'";
if ($conn->query($sql) === TRUE) {
    $sql2 = "SELECT * FROM posty WHERE id='$idPosty'";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $ile = $row2['ile'];
    echo $ile;
    $ile2=--$ile;
    echo $ile2;
    $sql3 = "UPDATE posty SET ile='$ile2' WHERE id='$idPosty'";
    if ($conn->query($sql3) === TRUE) {
        
    }
    else{
        
    }
} else {
    
}
$conn->close();
}
 
?>