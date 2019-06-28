<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
        $conn->query("SET CHARACTER SET utf8");
        
        $nick = $_POST['nick'];
        $imie = $_POST['imie'];
        $plec = $_POST['plec'];
        $wiekOd = $_POST['wiekOd'];
        $wiekDo= $_POST['wiekDo'];
        $miejscowosc = $_POST['miejscowosc'];
        $limit = 15;
        
        $res = $conn->query("SELECT * FROM osoba WHERE nick LIKE '%$nick%' AND imie LIKE '%$imie%' AND plec LIKE '%$plec%' AND miejscowosc LIKE '%$miejscowosc%'");
        $data = array();
        header("Content-type: application/json");
        while($row = $res->fetch_assoc())
        {
            $from = new DateTime($row['data']);
            $to   = new DateTime('today');
            $age = date_diff(date_create($row['data']), date_create('today'))->y;
            
            $this1=$_SESSION['nick'];
            $this2 = $row['nick'];
            
            $dirname = "uploads/";
            $images = glob($dirname.$row['id'].".*");
            if($images!=null){
                $image=$images[0];
                $avatar = '<img class="smallavatar" src="'.$image.'"/><br />';
            }else{
                $dirname = "uploads/";
                $image = $dirname."default-avatar.png";
                $avatar = '<img class="smallavatar" src="'.$image.'"/><br />';
            }
            
            if($this1 != $this2 && $age>=$wiekOd && $age<=$wiekDo){
                $data[] = array("<tr data-id='".$row['id']."'><td>".$avatar."</td><td>".$row['nick']."</td><td>".$row['imie']."</td><td>".$row['plec']."</td><td>".$age."</td><td>".$row['miejscowosc']."</td><tr>");
            }
        }
        echo json_encode($data);
        $conn->close();
        exit;
}

?>