<?php
    session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Rejestracja</title>
        <link rel="stylesheet" href="style.css" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    
    <body>
        <div class="header">
            <h1>Rejestracja</h1>
        </div>
        <div class="main">
            <div class="inmain">
        <?php
        echo '<div class="bladlogowania">';
            if (isset($_SESSION['blad1']))
                echo $_SESSION['blad1'];
            echo '</br>';
            if (isset($_SESSION['blad2']))
                echo $_SESSION['blad2'];
        echo '</div>';
        echo '<div class="col-container">';
        echo '<div class="napisy">';
            echo '<div class="napis">Login:</div>';
            echo '</br><div class="napis">Hasło:</div>';
            echo '</br><div class="napis">Powtórz hasło:</div>';
            echo '</br><div class="napis">Nick:</div>';
            echo '</br><div class="napis">Imię:</div>';
            echo '</br><div class="napis">Płeć:</div>';
            echo '</br><div class="napis">Data: </div>'; 
            echo '</br><div class="napis">Miejscowość:</div>';
        echo '</div>';
        
        echo '<div class="inputy">';
        echo '<form id="form" method="post" action="registration2.php">';
                echo '<input id="login" class="input" type="text" name="login"></br>';
                echo '<input id="haslo1" class="input" type="password" name="haslo1"></br>';
                echo '<input id="haslo2" class="input" type="password" name="haslo2"></br>';
                echo '<input id="nick" class="input" type="text" name="nick"></br>';
                echo '<input id="imie" class="input" type="text" name="imie"></br>';

            echo '<label class="container">';
            echo '<input type="radio" name="plec" value="mężczyzna">Mężczyzna';
            echo '<span class="checkmark"></span>';
            echo '</label>';
            
            echo '<label class="container">';
            echo '<input type="radio" name="plec" value="kobieta" checked>Kobieta';
            echo '<span class="checkmark"></span>';
            echo '</label><br>';
            
                echo'<div id="spandate">';
                echo '<select id="day" name="day" method="post"></br>';
                for($i=1;$i<=31;$i++){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    } 
                echo '</select>';

                echo '<select id="month" name="month" method="post"></br>';   
                    for($i=1;$i<=12;$i++){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }  
                echo '</select>';
                
                echo '<select id="year" name="year" method="post"></br>';
                    for($i=2001;$i>=1920;--$i){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                echo '</select>';
                
                echo'</div>';
                echo '</br>';

                echo '<input id="miejscowosc" class="input" type="text" name="miejscowosc">';

        echo '</form>';
        echo '</div>';
        echo '</div>';
        
        echo '</br><button class="button" id="button" type="button">Zarejestruj</button>'; 
        echo '</br><a class="button" href="index.php" style="text-decoration: none;">Strona główna</a>';
        ?>
        </div>
    </div>
<script type="text/javascript">
            
            function isValidDate() {

            var day = document.getElementById("day").value;
            var month = document.getElementById("month").value;
            var year = document.getElementById("year").value;
            
            var date = new Date(year, month - 1, day);

            if ( (date.getFullYear() == year) && (date.getMonth() + 1 == month) && (date.getDate() == day) ){
                return true;
            } else{
                return false;
            }
            }
            
            function getAge(birthDateString) {
            var today = new Date();
            var birthDate = new Date(birthDateString);
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            return age;
}
            
$(document).ready(function(){
  $('#button').on('click', function(){
        //first get the value of input fields..
        var znaki = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
        var space = /\s/;
        var cyfry = /[0123456789]/;
        var shouldBrake=false;
        var login,haslo1,haslo2,nick,imie,day,month,year,miejscowosc;
        
        var radio = document.getElementsByName('gender');
        
        for (var i = 0, length = radio.length; i < length; i++){
            if (radio[i].checked){
            // do whatever you want with the checked radio
            alert(radio[i].value);

            // only one radio can be logically checked, don't check the rest
            break;
            }
        }

        if(document.getElementById("login")!==null){
            login = document.getElementById("login").value;
            if(login.length<3 || login.length>15 || znaki.test(login) || space.test(login)){
                shouldBrake=true;
                document.getElementById("login").setAttribute("class", "badinput");
            }
        } else {
            shouldBrake=true;
            document.getElementById("login").setAttribute("class", "badinput");
        }
        
        if(document.getElementById("haslo1")!==null){
            haslo1 = document.getElementById("haslo1").value;
            if(haslo1.length<3 || haslo1.length>15){
                shouldBrake=true;
                document.getElementById("haslo1").setAttribute("class", "badinput");
            }
        } else {
            shouldBrake=true;
            document.getElementById("haslo1").setAttribute("class", "badinput");
        }
        
        if(document.getElementById("haslo2")!==null){
            haslo2 = document.getElementById("haslo2").value;
            if(haslo1!==haslo2){
                shouldBrake=true;
                document.getElementById("haslo2").setAttribute("class", "badinput");
            }
        } else {
            shouldBrake=true;
            document.getElementById("haslo2").setAttribute("class", "badinput");
        }
        
        if(document.getElementById("nick")!==null){
            nick = document.getElementById("nick").value;
            if(nick.length<3 || nick.length>15 || znaki.test(nick) || space.test(nick)){
                shouldBrake=true;
                document.getElementById("nick").setAttribute("class", "badinput");
            }
        } else {
            shouldBrake=true;
            document.getElementById("nick").setAttribute("class", "badinput");
        }
            
        if(document.getElementById("imie")!==null){
            imie = document.getElementById("imie").value;
            if(imie.length<3 || imie.length>15 || znaki.test(imie) || cyfry.test(imie) || space.test(imie)){
                shouldBrake=true;
                document.getElementById("imie").setAttribute("class", "badinput");
            }
        } else {
            shouldBrake=true;
            document.getElementById("imie").setAttribute("class", "badinput");
        }

        if(!isValidDate()){
            shouldBrake=true;
            document.getElementById("spandate").setAttribute("class", "badspandate");
        } else {
            day = document.getElementById("day").value;
            month = document.getElementById("month").value;
            year = document.getElementById("year").value;
            if(getAge(year+"-"+month+"-"+day) < 18){
                shouldBrake=true;
                document.getElementById("spandate").setAttribute("class", "badspandate");
            }
        } 
        
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
                        document.getElementById("form").submit();
                    }
                    
                });
            });
            
            
        </script>
    </body>
</html>
