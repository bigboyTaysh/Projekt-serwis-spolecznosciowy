<?php
session_start();
if($_SESSION['zalogowany'] !== true){
        header('Location: login.php');
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Wiadomości</title>
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
        
        $userId=$_SESSION['userId'];
        
        $conn = new mysqli($servername, $username, $password, $dbname);

        $conn -> query ('SET NAMES utf8');
        $conn -> query ('SET CHARACTER_SET utf8_unicode_ci');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        echo '<div class="topnav">';
            echo '<a class="menu" href="tablica.php">Tablica</a>';
            echo '<a class="menu" id="selected" href="wiadomosci.php">Wiadomosci</a>';
            echo '<a class="menu" href="friends.php">Znajomi</a>';
            echo '<a class="menu" href="search.php">Szukaj</a>';
            echo '<a class="profil" href="logout.php">Wyloguj</a>';
            echo '<a class="profil" href="edytuj.php">Edytuj</a>';
            echo '<a class="profilavatar" href="zalogowany.php"><img class="menuavatar" src="'.$_SESSION['avatar'].'"/>&nbsp;Profil</a>';
        echo '</div>';

                echo '<div class="main">';
                echo '<div class="inmain">';
                
                echo '<div class="bladlogowania">';
                    if(isset($_SESSION['wiadomosc'])){
                        echo $_SESSION['wiadomosc'];
                    }
                echo '</div>';
                
                echo '<div id="divWrapper"></div>';
                
                echo '<div id="divShow">';
                echo '<form action="send.php" method="post">';
                echo '<div class="napis" style="margin-bottom: 0px">Do:</div>';
                
                echo '<select class="select" name="idOdbiorcy" style="margin-bottom: 5px">';
                $sql2 = "SELECT * FROM friends WHERE userId = '$userId'";
                $result2 = $conn->query($sql2);
                
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $id = $row2['friendId'];
                        
                        $sql3 = "SELECT * FROM osoba WHERE id = '$id'";
                        $result3 = $conn->query($sql3);
                        $row3 = $result3->fetch_assoc();
                        $nick = $row3['nick'];
                        echo "<option value=$id>".$nick."</option>";
                    }
                }
echo<<<END
                    </select>
                    <div class="napis" style="margin-bottom: 0px">Tytuł:</div>
                    <input class="input" type="text" name="tytul" required=""><br><br/>
                    <div class="napis" style="margin-bottom: 0px">Treść:</div>
                    <br><textarea name="tresc" rows="10" cols="60" required=""></textarea><br>
                    <input class="button"type="submit" value="Wyślij">
                </form> 
                </div>
END;
        

echo<<<END
                <form>
                <div class="napis" style="margin-bottom: 0px">Wiadomości od:</div>
                <select class="select" id="idNadawcy" style="margin-bottom: 22px">
END;
                $sql = "SELECT * FROM friends WHERE userId = '$userId'";
                $result = $conn->query($sql2);
                echo "<option value=''>Wszyscy</option>";
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['friendId'];
                        
                        $sql3 = "SELECT * FROM osoba WHERE id = '$id'";
                        $result3 = $conn->query($sql3);
                        $row3 = $result3->fetch_assoc();
                        $nick = $row3['nick'];
                        echo "<option value=$id>".$nick."</option>";
                    }
                }
echo<<<END
                
                </select><br/>
                </form>
                <div class="table-wrapper">
                    <table id='wynik'>
                </table>
                </div>
                <br/>                
END;

        	
        $conn->close();
            echo '</div>';
        echo '</div>';
        ?>
    </body>
</html>
<script>

    $(document).ready(function(){
        var b = document.createElement('button');
        b.setAttribute('class', 'button');
        b.setAttribute('id', 'wiadomosc');
        b.setAttribute('style', 'margin-top: 0px; margin-bottom: 10px');
        b.innerHTML = 'Napisz wiadomość</br>▼';

        var wrapper = document.getElementById("divWrapper");
        wrapper.appendChild(b);
        var y = document.getElementById("divShow");
        y.style.display = "none";
    });
    
    $(document).ready(function(){
        $("#wiadomosc").click( function(){
        var clicks = $(this).data('clicks');
        var x = document.getElementById("wiadomosc");
        var y = document.getElementById("divShow");
        
        if (clicks) {
            x.innerHTML = 'Napisz wiadomość</br>▼';
            y.style.display = "none";
        } else {
            x.innerHTML = 'Napisz wiadomość</br>▲';
            y.style.display = "block";
        } 
        $(this).data("clicks", !clicks);
        });
    });
 
 $(document).ready(function(){
        $("#wynik").on('click', 'tr', function(){
            var thisId = $(this).data("id");
        var clicks = $(this).data('clicks');
        var x = document.getElementById(thisId);
        
        if (clicks) {
            x.remove();
        } else {
           $('<div id="'+thisId+'"></div>').insertAfter($(this).closest('tr'));
           $('#'+thisId+'').load("tresc.php", { id: thisId});
        } 
        $(this).data("clicks", !clicks);
        });
    });


$.ajaxPrefilter(function( options, original_Options, jqXHR ) {
            options.async = true;
        });

        function countProperties(obj) {
            var count = 0;

                for(var prop in obj) {
                if(obj.hasOwnProperty(prop))
                    ++count;
                }

            return count;
        }
        
    $(document).ready(function(){
        $("#wynik").on('click', '#usun', function(){
                var thisId = $(this).data("id");
                
                $.ajax({
                type: "POST",
                url: "delete.php",
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
            var nadawca = $("#idNadawcy").val();
                $.ajax({
                type: "POST",
                url: "showWiadomosci.php",
                dataType: 'JSON',
                data: {
                    nadawca: nadawca
                },
                async: false,
                success: function (text) {
                    if (text!==null){
                        for(var i=0; i< countProperties(text); i++){
                           $('#wynik').append(text[i] + "</br>");
                           var table = document.getElementById("wynik");
                           var rowCount = table.rows.length;
                           table.deleteRow(rowCount -1);
                           
                           var list = document.getElementsByTagName("table")[0];
                           if(list.getElementsByTagName("TR")[i]!==undefined){
                               list.getElementsByTagName("TR")[i].classList.add('wynik');
                           }
                           
                        }
                    }
                    else{
                        $('#wynik').append('No results!');
                    }
                }
            });
        });
        
        

        $(document).ready(function(){
            $('#idNadawcy').on('change', function() {
                
            var myNode = document.getElementById("wynik");
            while (myNode.firstChild) {
                myNode.removeChild(myNode.firstChild);
            }
            
            var nadawca = $("#idNadawcy").val();
                $.ajax({
                type: "POST",
                url: "showWiadomosci.php",
                dataType: 'JSON',
                data: {
                    nadawca: nadawca
                },
                async: false,
                success: function (text) {
                    if (text!==null){
                        for(var i=0; i< countProperties(text); i++){
                           $('#wynik').append(text[i] + "</br><hr id='hr'>");
                           var table = document.getElementById("wynik");
                           var rowCount = table.rows.length;
                           table.deleteRow(rowCount -1);
                           
                           var list = document.getElementsByTagName("table")[0];
                           if(list.getElementsByTagName("TR")[i]!==undefined){
                               list.getElementsByTagName("TR")[i].classList.add('wynik');
                           }
                           
                        }
                    }
                    else{
                        $('#wynik').append('No results!');
                    }
                }
            });
        });
    });
</script>