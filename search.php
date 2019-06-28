<?php
session_start();
if($_SESSION['zalogowany'] !== true){
        header('Location: login.php');
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Szukaj</title>
        <link rel="stylesheet" href="style.css" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
	<meta charset="UTF-8">
</head>
	
	
	
<body>	

        <div class="topnav">
            <a class="menu" href="tablica.php">Tablica</a>
            <a class="menu" href="wiadomosci.php">Wiadomosci</a>
            <a class="menu" href="friends.php">Znajomi</a>
            <a class="menu" id="selected" href="search.php">Szukaj</a>
            <a class="profil" href="logout.php">Wyloguj</a>
            <a class="profil" href="edytuj.php">Edytuj</a>
            <a class="profilavatar" href="zalogowany.php"><img class="menuavatar" src="<?php echo $_SESSION['avatar']; ?>"/>&nbsp;Profil</a>
        </div>
    
        <div class="main">
            <div class="inmain">
                
            <div class="col-container" style="height: 310px">
            <div class="napisy" style="height: 340px">
                <div class="napis" style="margin-bottom:0px;" >Nick:</div>
                </br><div class="napis" style="margin-top:0px;">Imię:</div>
                </br><div class="napis">Płeć:</div>
                </br></br></br><div class="napis" style="padding-top: 20px; margin-bottom: 0px;">Wiek od: </div>
                </br><div class="napis" style="margin-top:0px; margin-bottom: 0px;">Do: </div>
                </br><div class="napis" style="margin-top:0px;">Miejscowość:</div>
            </div>
            
            <div class="inputy" style="width: 25%; height: 310px">
            <input class="input" type ="text" id="nick" name="nick">
            <input class="input" type="text" id="imie" name="imie">
            
            <label class="container">
            <input type="radio" name="plec" value="mężczyzna">Mężczyzna
            <span class="checkmark"></span>
            </label>
            
            <label class="container">
            <input type="radio" name="plec" value="kobieta" checked>Kobieta
            <span class="checkmark"></span>
            </label><br>
            
            <label class="container">
            <input type="radio" name="plec" value="" checked>Brak
            <span class="checkmark"></span>
            </label><br>
            
            </br>
            </br>
            <input class="input" type="number" id="wiekOd" name="wiekOd" min="18" max="100"></br>
            <input class="input" type="number" id="wiekDo" name="wiekDo" min="18" max="100"></br>
            <input class="input" type="text" id="miejscowosc" name="miejscowosc">
                </div>
            </div>
            <button class="button" id="szukaj" style="margin-top:0px;">Wyszukaj</button>
        </br>
        <div class="table-wrapper">
        <table id="wynik" style="margin-top:20px;">
        </table>
        </div>
        </div>
    </div>
    <script>
        
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
        
        $(document).ready(function () {
            $("#szukaj").click(function(){
            var nick = document.getElementById("nick").value;
            var imie = document.getElementById("imie").value;
            var plec= $("input:radio[name=plec]:checked").val();
            var wiekOd = document.getElementById("wiekOd").value;
            var wiekDo = document.getElementById("wiekDo").value;
            
            if(wiekOd>wiekDo && wiekDo!==""){
                var x=wiekOd;
                wiekOd=wiekDo;
                wiekDo=x;
            }
            
            if(wiekOd!==""){
                if(wiekOd>=18){
                    var wiekOd = wiekOd;
                }
                else{
                    var wiekOd = 18;
                }
            }
            else{
                var wiekOd = 18;
            }
            if(wiekDo!==""){
                if(wiekDo<=100){
                    var wiekDo = wiekDo;
                }
                else{
                    var wiekDo = 100;
                }
            }
            else{
                var wiekDo = 100;
            }
            
            var miejscowosc = document.getElementById("miejscowosc").value;
            
            var myNode = document.getElementById("wynik");
            while (myNode.firstChild) {
                myNode.removeChild(myNode.firstChild);
            }
            
            $.ajax({
                type: "POST",
                url: "search2.php",
                dataType: 'JSON',
                data: {
                    nick: nick,
                    imie: imie,
                    plec: plec,
                    wiekOd: wiekOd,
                    wiekDo: wiekDo,
                    miejscowosc: miejscowosc
                },
                async: false,
                success: function (text) {
                    if (text!==null){
                        for(var i=0; i< countProperties(text); i++){
                           $('#wynik').append(text[i] + "</br>");
                           var table = document.getElementById("wynik");
                           table.style.borderCollapse = "collapse";
                           var rowCount = table.rows.length;
                           table.deleteRow(rowCount -1);
                           
                           var list = document.getElementsByTagName("table")[0];
                           list.getElementsByTagName("TR")[i].classList.add('wynik');
                           list.getElementsByTagName("TR")[i].setAttribute("style", "cursor: pointer");
                           
                        }
                    }
                    else{
                        $('#wynik').append('No results!');
                    }
                }

            });
        });
    });
    
    $(document).ready(function(){
        $("#wynik").on('click', 'tr', function(){
            var id = $(this).data("id");
            window.open('profil.php?thisId=' + id);
        });
    });

</script>
</body>
</html>