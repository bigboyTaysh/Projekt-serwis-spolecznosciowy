<?php
    session_start();
    if($_SESSION['zalogowany'] !== true){
        header('Location: login.php');
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edytuj</title>
        <link rel="stylesheet" href="style.css" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <?php	     
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "projekt";
        
        $thisId = $_SESSION['userId'];
        
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
            echo '<a class="profil" id="selected" href="edytuj.php">Edytuj</a>';
            echo '<a class="profilavatar" href="zalogowany.php"><img class="menuavatar" src="'.$_SESSION['avatar'].'"/>&nbsp;Profil</a>';
        echo '</div>';
            
            $sql = "SELECT * FROM osoba WHERE id = '$thisId'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            $thisMiejscowosc = $row['miejscowosc'];
            $thisOpis = $row['opis'];
            $thisHaslo = $row['haslo'];

            $conn->close();
        }
            echo '<div class="bladlogowania">';
            if(isset($_SESSION['editHaslo'])){
                echo $_SESSION['editHaslo'];
            }
            echo '</div>';
            
            echo '<div class="main">';
           echo '<div class="inmain">';
            echo '<div class="col-container">';
            echo '<div class="napisy">';
                echo '<div class="napis">Bieżące:</div>';
                echo '</br><div class="napis">Nowe:</div>';
                echo '</br><div class="napis">Powtórz nowe:</div>';
                echo '</br></br></br></br><div class="napis">Opis:</div>';
                echo '</br></br></br></br></br></br><div class="napis">Miejscowość:</div>';
                echo '</br></br></br></br><div class="napis">Wybierz avatar:</div>';
            echo '</div>';

        echo '<div class="inputy" style="margin-left: 10%">';
        echo '<form id="zapiszForm" method="post" action="editHaslo.php">';
                echo '<input id="haslo1" class="input" type="password" name="haslo1"></br>';
                echo '<input id="haslo2" class="input" type="password" name="haslo2"></br>';
                echo '<input id="haslo3" class="input" type="password" name="haslo3"></br>';
            echo '<button class="button" id="zapisz" type="button">Zapisz haslo</button>'; 
        echo '</form>';
        
        echo '<div class="bladlogowania">';
        if(isset($_SESSION['edit'])){
                echo $_SESSION['edit'];
            }  
        echo '</div>';
        
        echo '<form id="edytujForm" method="post" action="edit.php">';
                echo '<textarea id="opis" type="text" rows="5" cols="50" name="opis">'.$thisOpis.'</textarea></br>';
                echo '<input id="miejscowosc" class="input" type="text" name="miejscowosc" value="'.$thisMiejscowosc.'"></br>';
            echo '<button class="button" id="edytuj" type="button">Edytuj</button>'; 
        echo '</form>';
        
        echo '<div class="bladlogowania">';
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
            }
        echo '</div>';
        ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input class="button" type="submit" value="Upload Image" name="submit">
        </form>
        </br>
        </div>
        </div>
        </div>
        </div>
    </body>
</html>

<script>
    $(document).ready(function(){
  $('#zapisz').on('click', function(){
        //first get the value of input fields..
        var znaki = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
        var space = /\s/;
        var cyfry = /[0123456789]/;
        var shouldBrake=false;
        var haslo1,haslo2,haslo3,miejscowosc;
        var thisHaslo = "<?php echo $thisHaslo; ?>";
        
        
        if(document.getElementById("haslo1")!==null){
            haslo1 = document.getElementById("haslo1").value;
            if(haslo1 !== thisHaslo){
                shouldBrake=true;
                document.getElementById("haslo1").setAttribute("class", "badinput");
            }
        } else {
            shouldBrake=true;
            document.getElementById("haslo1").setAttribute("class", "badinput");
        }
        
        if(document.getElementById("haslo2")!==null){
            haslo2 = document.getElementById("haslo2").value;
            if(haslo2.length<3 || haslo2.length>15){
                shouldBrake=true;
                document.getElementById("haslo2").setAttribute("class", "badinput");
            }
        } else {
            shouldBrake=true;
            document.getElementById("haslo2").setAttribute("class", "badinput");
        }
        
        if(document.getElementById("haslo3")!==null){
            haslo3 = document.getElementById("haslo3").value;
            if(haslo2!==haslo3){
                shouldBrake=true;
                document.getElementById("haslo3").setAttribute("class", "badinput");
            }
        } else {
            shouldBrake=true;
            document.getElementById("haslo3").setAttribute("class", "badinput");
        }
                    //now use ajax to send the data from client system to server...
                    if (!shouldBrake) {
                        document.getElementById("zapiszForm").submit();
                    }
                    
                });
            });
            
            $(document).ready(function(){
                $('#edytuj').on('click', function(){
        //first get the value of input fields..
        var znaki = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
        var space = /\s/;
        var cyfry = /[0123456789]/;
        var shouldBrake=false;
        var miejscowosc;

        if(document.getElementById("miejscowosc")!==null){
            miejscowosc = document.getElementById("miejscowosc").value;
            if(miejscowosc.length<3 || miejscowosc.length>15 || znaki.test(miejscowosc) || cyfry.test(miejscowosc)) {
                            shouldBrake = true;
                            document.getElementById("miejscowosc").setAttribute("class", "badinput");
                        }
                    } else {
            shouldBrake=true;
            document.getElementById("miejscowosc").setAttribute("class", "badinput");
        }
                    //now use ajax to send the data from client system to server...
                    if (!shouldBrake) {
                        document.getElementById("edytujForm").submit();
                    }
                    
                });
            });
</script>