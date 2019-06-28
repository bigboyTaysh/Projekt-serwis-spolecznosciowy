<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Profil</title>
        <link rel="stylesheet" href="style.css" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
	<meta charset="UTF-8">
    </head>
    
    <body>
        <?php
	session_start();
        
        if($_SESSION['zalogowany'] !== true){
            header('Location: login.php');
        }
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "projekt";
        
        $thisId = $_GET['thisId'];
        $userId=$_SESSION['userId'];
        
        $conn = new mysqli($servername, $username, $password, $dbname);

        $conn -> query ('SET NAMES utf8');
        $conn -> query ('SET CHARACTER_SET utf8_unicode_ci');


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        else{
            

        echo '<div class="topnav">';
            echo '<a class="menu" href="tablica.php">Tablica</a>';
            echo '<a class="menu" href="wiadomosci.php">Wiadomosci</a>';
            echo '<a class="menu" href="friends.php">Znajomi</a>';
            echo '<a class="menu" href="search.php">Szukaj</a>';
            echo '<a class="profil" href="logout.php">Wyloguj</a>';
            echo '<a class="profil" href="edytuj.php">Edytuj</a>';
            echo '<a class="profilavatar" href="zalogowany.php"><img class="menuavatar" src="'.$_SESSION['avatar'].'"/>&nbsp;Profil</a>';
        echo '</div>';
        
            $sql = "SELECT * FROM osoba WHERE id = '$thisId'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            
            echo '<div class="main">';
           echo '<div class="inmain">';
        echo '<div class="col-container">';
            echo '<div class="napisy">';
            echo '</br>';
            $dirname = "uploads/";
            $images = glob($dirname.$thisId.".*");
            if($images!=null){
                $image=$images[0];
                echo '<img class="avatar" src="'.$image.'"/><br />';
            }else{
                $dirname = "uploads/";
                $image = $dirname."default-avatar.png";
                echo '<img class="avatar" src="'.$image.'"/><br />';
            }
            
            echo '</div>';
        echo '<div class="inputy" align="left">';
        echo '</br><div class="napis">'.$row["nick"].'</div>';
        echo '</br><div class="napis">'.$row["imie"].'</div>';
        echo '</br><div class="napis">'.$row["plec"].'</div>';
            $from = new DateTime($row['data']);
            $to   = new DateTime('today');
            $age = date_diff(date_create($row['data']), date_create('today'))->y;
            echo '</br><div class="napis">'.$age.'</div>';
            echo '</br><div class="napis">'.$row["miejscowosc"].'</div>';
            echo '</br><div class="napis">'.$row["opis"].'</div>';
            
            echo '</div>';
            echo '</div>';
            $sql2 = "SELECT * FROM friends WHERE friendId = '$thisId' AND userId='$userId'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                echo '<button class="button" id="usun2" type="button">Usuń ze znajomych</button>';
            }
            else{
                echo '<button class="button" id="dodaj" type="button">Dodaj do znajomych</button></br>'; 
            }
            
            echo '<div class="table-wrapper" id="tablica">';
            
            $conn->close();
        }
            echo '</div>';
        echo '</div>';
        ?> 
    <script>
        
        $.ajaxPrefilter(function( options, original_Options, jqXHR ) {
            options.async = true;
        });
        
        $(document).ready(function(){
            $("#dodaj").click(function(){
                var thisId = "<?php echo $thisId; ?>";
                $.ajax({
                type: "POST",
                url: "dodaj.php",
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
        $(document).ready(function(){
            $("#usun2").click(function(){
                var thisId = "<?php echo $thisId; ?>";
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
        
        function countProperties(obj) {
            var count = 0;

                for(var prop in obj) {
                if(obj.hasOwnProperty(prop))
                    ++count;
                }

            return count;
    }
    
    function refresh () {
       
       var myNode = document.getElementById("tablica");
            while (myNode.firstChild) {
                myNode.removeChild(myNode.firstChild);
            }
                var nadawca = "<?php echo $_SESSION['userId'] ?>";
                $.ajax({
                type: "POST",
                url: "showPosty.php",
                dataType: 'JSON',
                data: {
                    nadawca: nadawca
                },
                async: false,
                success: function (text) {
                    if (text!==null){
                        for(var i=0; i< countProperties(text); i++){
                           $('.table-wrapper').append(text[i]);
                        }
                    }
                    else{
                        $('#wynik').append('No results!');
                    }
                }
            });
    
    }
    
    $(document).ready(function(){
                var nadawca = "<?php echo $thisId ?>";
                $.ajax({
                type: "POST",
                url: "showPosty.php",
                dataType: 'JSON',
                data: {
                    nadawca: nadawca
                },
                async: false,
                success: function (text) {
                    if (text!==null){
                        for(var i=0; i< countProperties(text); i++){
                           $('.table-wrapper').append(text[i]);
                        }
                    }
                    else{
                        $('#wynik').append('No results!');
                    }
                }
            });
        });
    
    $(document).ready(function(){
        $(".table-wrapper").on('click', '#serce', function(){
        var clicks = $(this).data('clicks');
        var form = $(this);
        var y = $(this).attr('src');
        var x = $(this).parent().attr('data-id');
        var nadawca = "";
        
        if (y === "heart2.png") {
            $(this).attr('src',"heart1.png");
            $.ajax({
                type: "POST",
                url: "usunPolubienie.php",
                dataType: 'text',
                data: {
                    idPosty: x
                },
                async: false,
                success: function (text) {
                form.closest('.post').children('#ile').load("ile.php", { idPosty: x});
                }
            });
            
        } else {
           $(this).attr('src',"heart2.png");
           $.ajax({
                type: "POST",
                url: "dodajPolubienie.php",
                dataType: 'text',
                data: {
                    idPosty: x
                },
                async: false,
                success: function (text) {
                    form.closest('.post').children('#ile').load("ile.php", { idPosty: x});
                }
            });
        } 
        $(this).data("clicks", !clicks);
        });
    });
    </script>
    </body>
    
</html>

