<?php
session_start();

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "projekt";
        
        $nadawca = $_POST['nadawca'];    
        $userId=$_SESSION['userId'];
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        $conn -> query ('SET charset utf8');
        $conn -> query ('SET CHARACTER_SET utf8_polish_ci');
        
        $sql4 = "SELECT * FROM wiadomosci WHERE odbiorca='$userId' AND nadawca LIKE '%$nadawca%' ORDER BY data DESC";
        $result4 = $conn->query($sql4);

        $data = array();
        
        if ($result4->num_rows > 0) {
            while($row4 = $result4->fetch_assoc()) {
                        $nadawca = $row4['nadawca'];
                        $sql5 = "SELECT * FROM osoba WHERE id = '$nadawca'";
                        $result5 = $conn->query($sql5);
                        $row5 = $result5->fetch_assoc();
                        $nick = $row5['nick'];
                    $data[] = array("<tr data-id='".$row4["id"]."'><td><a href='profil.php?thisId=".$row5["id"]."' target='blank'>".$nick."</a></td><td style='cursor: pointer'>".$row4['tytul']."</td><td>".$row4["data"]."</td><td><a id='usun' data-id='".$row4["id"]."'><img id='img' src='delete.png'></a></td><tr>");
            }
        } else {
            $data[] = array("</br>Brak wiadomości");
        }
        echo json_encode($data);
        $conn->close();
        ?>