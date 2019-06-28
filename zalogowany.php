<?php
    session_start();
    unset($_SESSION['upload']);
    unset($_SESSION['editHaslo']);
    unset($_SESSION['edit']);
    unset($_SESSION['wiadomosc']);
    if($_SESSION['zalogowany'] !== true){
        header('Location: login.php');
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Profil</title>
        <link rel="stylesheet" href="style.css" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>

        <?php	
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "projekt";

        $conn = new mysqli($servername, $username, $password, $dbname);

        $conn -> query ('SET NAMES utf8');
        $conn -> query ('SET CHARACTER_SET utf8_unicode_ci');


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM osoba WHERE id = '".$_SESSION['id']."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        
        $_SESSION['userId'] = $row['id'];
        $_SESSION['nick'] = $row['nick'];
        
        echo '<div class="topnav">';
            echo '<a class="menu" href="tablica.php">Tablica</a>';
            echo '<a class="menu" href="wiadomosci.php">Wiadomosci</a>';
            echo '<a class="menu" href="friends.php">Znajomi</a>';
            echo '<a class="menu" href="search.php">Szukaj</a>';
            echo '<a class="profil" href="logout.php">Wyloguj</a>';
            echo '<a class="profil" href="edytuj.php">Edytuj</a>';
            echo '<a class="profilavatar" id="selected" href="zalogowany.php"><img class="menuavatar" src="'.$_SESSION['avatar'].'"/>&nbsp;Profil</a>';
        echo '</div>';
        
        echo '<div class="main">';
           echo '<div class="inmain">';
        echo '<div class="col-container">';
            echo '<div class="napisy" style="height: 200px">';
            echo '</br>';
        $dirname = "uploads/";
        $images = glob($dirname.$_SESSION['userId'].".*");
        if($images!=null){
            $image=$images[0];
            echo '<img class="avatar" src="'.$image.'"/><br />';
        }else{
            $dirname = "uploads/";
            $image = $dirname."default-avatar.png";
            echo '<img class="avatar" src="'.$image.'"/><br />';
        }
        echo '</div>';
        
        echo '<div class="inputy" align="left" style="height: 200px">';
        echo '</br><div class="napis">'.$row["imie"].'</div>';
        echo '</br><div class="napis">'.$row["opis"].'</div>';

        
        $conn->close();
        echo '</div>';
        echo '</div>';
        
        echo '<br><textarea id="message" name="tresc" rows="10" cols="40" required=""></textarea><br>';
        echo '<button class="button" id="post" style="margin-bottom: 10px">Opublikuj</button>';

        echo '<div class="table-wrapper" id="tablica">';
        
        echo '</div>';
        echo '</div>';
        ?> 
        </br>
    </body>
</html>
<script>
    
    $(document).ready(function(){
        $("#tablica").on('click', '#edytuj', function(){
        var thisId = $(this).data("id");
        var clicks = $(this).data('clicks');
        var x = document.getElementById(thisId);
        var y = document.getElementById("to");
        
        if (clicks) {
            x.remove();
            y.remove();
        } else {
           $('<div id="to"><textarea class="textarea" id="'+thisId+'"  name="tresc" rows="10" cols="40" required=""></textarea></br>\n\
            <button class="button" id="buttonedytuj" data-id="'+thisId+'" style="margin-bottom: 10px">Edytuj</button></div>').insertAfter($(this).closest('div'));
           $('#'+thisId+'').load("trescPosta.php", { id: thisId});
        } 
        $(this).data("clicks", !clicks);
        });
    });
    
    $(document).ready(function(){
        $("#tablica").on('click', '#usun', function(){
                var thisId = $(this).data("id");
                
                $.ajax({
                type: "POST",
                url: "deletePost.php",
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
        $("#tablica").on('click', '#buttonedytuj', function(){
                var thisId = $(this).data("id");
                var tekst = $('.textarea#'+thisId+'').val();
                
                $.ajax({
                type: "POST",
                url: "edytujPost.php",
                dataType: 'text',
                data: {
                    tekst: tekst,
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