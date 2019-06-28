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
        
        
        if($nadawca !== ""){
            $sql4 = "SELECT * FROM posty WHERE idOsoba = '$nadawca' ORDER BY data DESC";
            $result4 = $conn->query($sql4);
        } else {
            $sql4 = "SELECT * FROM posty ORDER BY data DESC";
            $result4 = $conn->query($sql4);
        }
        $data = array();
        
        if ($result4->num_rows > 0) {
            while($row4 = $result4->fetch_assoc()) {
                        $idPosty = $row4['id'];
                        $wlasciciel = $row4['idOsoba'];
                        $sql5 = "SELECT * FROM osoba WHERE id = '$wlasciciel'";
                        $result5 = $conn->query($sql5);
                        $row5 = $result5->fetch_assoc();
                        $nick = $row5['nick'];
                        $date = $row4['data'];
                        $date2 = time_elapsed_string($date);
                        
            $dirname = "uploads/";
            $images = glob($dirname.$row5['id'].".*");
            if($images!=null){
                $image=$images[0];
                $avatar = '<img class="smallavatar" src="'.$image.'"/><br />';
            }else{
                $dirname = "uploads/";
                $image = $dirname."default-avatar.png";
                $avatar = '<img class="smallavatar" src="'.$image.'"/><br />';
            }
            
            $sql = "SELECT * FROM polubienia WHERE idPosty='$idPosty' AND idOsoba ='$userId'";
            $result = $conn->query($sql);
            
                if($result->num_rows > 0){
                    $dirname = "uploads/";
                    $image = "heart2.png";
                    $serce = '<img class="serce" id="serce" src="'.$image.'"/><br />';
                }else{
                    $dirname = "uploads/";
                    $image = "heart1.png";
                    $serce = '<img class="serce" id="serce" src="'.$image.'"/><br />';
                }
                    
                if($nick == $_SESSION['nick']){
                    $data[] = array("<div class='post' id='post' data-id='".$row4["id"]."'></br>"
                        . "<a id='usun' data-id='".$row4["id"]."' style='float: right; margin-right: 10px;' ><img id='img' src='delete.png'></a>"
                        . "<a id='edytuj' data-id='".$row4["id"]."' style='float: right; margin-right: 10px; cursor: pointer;' ><img id='img' src='edit.jpg'></a>"
                        . "</br><a href='profil.php?thisId=".$row5["id"]."' target='blank'>".$avatar."</a>"
                        . "<a href='profil.php?thisId=".$row5["id"]."' target='blank'>".$nick."</a></br>"
                        . "<div style='font-size: 10px'>".$date2."</div></br>".$row4['tresc']."</br>"
                        . "</br>".$serce."<div id='ile'>".$row4['ile']."</div></br></div>");
                } else {
                    $data[] = array("<div class='post' id='post' data-id='".$row4["id"]."'></br>"
                        . "<a href='profil.php?thisId=".$row5["id"]."' target='blank'>".$avatar."</a>"
                        . "<a href='profil.php?thisId=".$row5["id"]."' target='blank'>".$nick."</a></br>"
                        . "<div style='font-size: 10px'>".$date2."</div></br>".$row4['tresc']."</br>"
                        . "</br>".$serce."<div id='ile'>".$row4['ile']."</div></br></div>");
                }

            }
        } else {
            $data[] = array("</br>Brak postów");
        }
        echo json_encode($data);
        $conn->close();
        
        
        function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full){
        $string = array_slice($string, 0, 1);
    }
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>

