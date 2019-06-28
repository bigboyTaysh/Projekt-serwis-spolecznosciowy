<?php
    session_start();
    if($_SESSION['zalogowany'] !== true){
        header('Location: login.php');
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Znajomi</title>
        <link rel="stylesheet" href="style.css" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
	<meta charset="UTF-8">
    </head>
    
    <body>
        <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$userId = $_SESSION['userId'];
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
        $conn->query("SET CHARACTER SET utf8");
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        echo '<div class="topnav">';
            echo '<a class="menu" href="tablica.php">Tablica</a>';
            echo '<a class="menu" href="wiadomosci.php">Wiadomosci</a>';
            echo '<a class="menu" id="selected" href="friends.php">Znajomi</a>';
            echo '<a class="menu" href="search.php">Szukaj</a>';
            echo '<a class="profil" href="logout.php">Wyloguj</a>';
            echo '<a class="profil" href="edytuj.php">Edytuj</a>';
            echo '<a class="profilavatar" href="zalogowany.php"><img class="menuavatar" src="'.$_SESSION['avatar'].'"/>&nbsp;Profil</a>';
        echo '</div>';
        
        echo '<div class="main">';
            echo '<div class="inmain">';
        $sql = "SELECT * FROM friends WHERE userId='$userId'";
        $result = $conn->query($sql);
                               
        echo "<table id='wynik'>";
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $friendId = $row['friendId'];
                $sql2 = "SELECT * FROM osoba WHERE id='$friendId'";
                $result2 = $conn->query($sql2);
                $row2 = $result2->fetch_assoc();
                
                $dirname = "uploads/";
                    $images = glob($dirname.$friendId.".*");
                    if($images!=null){
                    $image=$images[0];
                    $avatar = '<img class="smallavatar" src="'.$image.'"/><br />';
                }else{
                    $dirname = "uploads/";
                    $image = $dirname."default-avatar.png";
                    $avatar = '<img class="smallavatar" src="'.$image.'"/><br />';
                }
                
                echo  "<tr class='wynik' data-id='".$row2["id"]."'><td>".$avatar."</td><td><a href='profil.php?thisId=".$row2["id"]."' target='blank'>".$row2["nick"]."</a></td><td><a id='usun' data-id='".$row2["id"]."'><img id='img' src='delete.png'><td><tr>";
                $thisId = $row2["id"];
                
            }
                echo " </table>";
        } else {
            echo "<tr class='wynik'><td>Brak znajomych :c</td></tr>";
        }
        	
        $conn->close();
        
}
        echo '</div>';
        echo '</div>';
?>
    </body>
</html>

<script>
            
            
            $.ajaxPrefilter(function( options, original_Options, jqXHR ) {
                options.async = true;
            });
        

            $(document).ready(function(){
                 $("#usun").click(function (){
                var thisId = $(this).data("id");
                
                $.ajax({
                type: "POST",
                url: "usun.php",
                dataType: 'text',
                data: {
                    thisId: thisId
                },
                async: false,
                success: function (text) {
                    location.reload();
                }

            });
                
            });
        });
</script>