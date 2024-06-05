<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "wiadomosc";

$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Wyslij'])) {
    $all_good = true;

    $imie = mysqli_real_escape_string($conn, $_POST['Imie']);
    $nazwisko = mysqli_real_escape_string($conn, $_POST['Nazwisko']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $numer = mysqli_real_escape_string($conn, $_POST['Numer']);
    $temat = mysqli_real_escape_string($conn, $_POST['Temat']);
    $wiadomosc = mysqli_real_escape_string($conn, $_POST['Wiadomosc']);

    if ($all_good) {
        $query_kontakt_w = "INSERT INTO kontakt_w (emial, numer_telefonu) VALUES ('$email', '$numer')";
    
        if (mysqli_query($conn, $query_kontakt_w)) {
            $id_kontakt = mysqli_insert_id($conn);
        } else {
            $all_good = false;
            echo "Błąd: " . mysqli_error($conn);
        }
    }

    if ($all_good) {
        $query_uzytkownik = "INSERT INTO uzytkownik (imie, nazwisko, id_kontakt) VALUES ('$imie', '$nazwisko', '$id_kontakt')";

        if (mysqli_query($conn, $query_uzytkownik)) {
            $id_uzytkownik = mysqli_insert_id($conn);
        } else {
            $all_good = false;
            echo "Błąd: " . mysqli_error($conn);
        }
    }

    if ($all_good) {
        $query_wiadomosc = "INSERT INTO wiadomosc (tytul, tresc, id_użytkownik) VALUES ('$temat', '$wiadomosc', '$id_uzytkownik')";

        if (mysqli_query($conn, $query_wiadomosc)) {
            echo '<div style="background-color: #4CAF50; color: white; padding: 10px; text-align: center;">Dane zostały zapisane pomyślnie!</div>';
        } else {
            echo "Błąd: " . mysqli_error($conn);
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="icon.png">
    <title>Napisz do nas</title>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

body {
    background-image: url(back.jpg);
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    background-size: cover;
}

.header {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
}

.logo {
    max-width: 250px;
}

ul {
    display: flex;
    padding: 10px;
}

li {
    padding: 2ch;
    list-style-type: none;
    font-weight: 500;
    font-family: "Roboto", sans-serif;
}

a {
    text-decoration: none;
    font-size: 2.3ch;
    color: rgb(0, 0, 0);
    font-weight: 600;
}

a:hover {
    color: white;
    text-shadow: 4px 4px 30px black;
}

.buttons {
    display: flex;
    padding: 10px;
    gap: 8px;
}

.Zadzwon {
    display: flex;
    justify-content: center;
    justify-items: center;
    font-family: "Roboto", sans-serif;
    font-weight: 500;
    padding: 20px;
    width: auto;
    border-radius: 30px;
    background-color: rgb(73, 156, 207);
}

.Zadzwon:hover {
    border: 2px solid rgb(73, 156, 207);
    background-color: rgba(73, 156, 207, 0.393);
    padding: 18px;
}

.Napisz {
    display: flex;
    justify-content: center;
    justify-items: center;
    font-family: "Roboto", sans-serif;
    font-weight: 500;
    padding: 20px;
    width: auto;
    border-radius: 30px;
    background-color: rgb(73, 156, 207);
}

.Napisz:hover {
    border: 2px solid rgb(77, 174, 226);
    background-color: rgba(73, 156, 207, 0.407);
    padding: 18px;
}

.footer {
    display: flex;
    justify-content: center;
    margin-top: 7ch;
}

.box {
    display: flex;
    justify-content: space-around;
    width: 400ch;
    height: auto;
    background-color: rgba(0, 0, 0, 0.469);
    border-radius: 5px;
}

.Motto_1 {
    font-size: 8ch;
    color: rgb(236, 178, 103);
    font-family: "Roboto", sans-serif;
    font-weight: 600;
}

.Motto_2 {
    font-size: 8ch;
    color: rgb(194, 114, 3);
    font-family: "Roboto", sans-serif;
    font-weight: 600;
    left: 20%;
}

.form_1 {
    width: 1600px;
    padding: 40px;
    text-align: center;
}

p {
    font-size: 15px;
    font-family: "Roboto", sans-serif;
}

input {
    height: 2em;
    width: 25em; 
    padding: 10px;
}

textarea {
    width: 40em; 
}

.form_1 {
    padding: 60px;
}

.form__group {
    position: relative;
    padding: 10px 0 0;
    margin-top: 10px;
    margin-left: 230px;
    width: 80%; 
    font-family: "Roboto", sans-serif;
}

.form__field {
    font-family: inherit;
    width: 100%;
    border: 0;
    border-bottom: 2px solid rgb(255, 255, 255);
    outline: 0;
    font-size: 1.3rem;
    color: rgb(193, 193, 193);
    padding: 7px 0;
    background: transparent;
    transition: border-color 0.2s;

    &::placeholder {
        color: transparent;
    }

    &:placeholder-shown ~ .form__label {
        font-size: 1.3rem;
        cursor: text;
        top: 20px;
    }
}

.form__label {
    position: absolute;
    top: 0;
    display: block;
    transition: 0.2s;
    font-size: 1rem;
    color: rgb(121, 171, 198);
    font-family: "Roboto", sans-serif;
}

.form__field:focus {
    ~ .form__label {
        position: absolute;
        top: 0;
        display: block;
        transition: 0.2s;
        font-size: 1rem;
        color: primary;
        font-weight: 700;
    }
    padding-bottom: 6px;
    font-weight: 700;
    border-width: 3px;
    border-image: linear-gradient(to right, primary, secondary);
    border-image-slice: 1;
}


.form__field {
    &:required, &:invalid {
        box-shadow: none;
    }
}

.Text {
    font-size: 30px;
    margin-top: 150px;
    margin-right: 280px;
    color: aliceblue;
    font-family: "Roboto", sans-serif;
}
h1{
    font-size: 80px;
}
h3{
    color: rgb(67, 170, 204);
}
span{
    font-size: 60px;
    color: rgb(173, 239, 255);
}

.form__group_1 {

position: relative;
padding: 100px 0 0;
margin-top: 10px;
margin-left: 230px;
width: 90%;
font-family: "Roboto", sans-serif;

}


.form__field_1 {
font-family: inherit;
width: 100%;
border: 0;
border-bottom: 2px solid rgb(255, 255, 255);
outline: 0;
font-size: 1.3rem;
color: rgb(193, 193, 193);
padding: 7px 0;
background: transparent;
transition: border-color 0.2s;

&::placeholder {
  color: transparent;
}
&:placeholder-shown ~ .form__label_1 {
  font-size: 1.3rem;
  cursor: text;
  top: 20px;
}
}
.form__label_1 {
position: absolute;
top: 0;
display: block;
transition: 0.2s;
font-size: 1rem;
color: rgb(121, 171, 198);
font-family: "Roboto", sans-serif;
}

.form__field_1:focus {
~ .form__label {
  position: absolute;
  top: 0;
  display: block;
  transition: 0.2s;
  font-size: 1rem;
  color: primary;
  font-weight:700;    
}
padding-bottom: 6px;  
font-weight: 700;
border-width: 3px;
border-image: linear-gradient(to right, primary, secondary);
border-image-slice: 1;
}

.form__field_1{
&:required,&:invalid { box-shadow:none; }
}
button{
    width: 200px;
    height: 50px;
    color: black;
    font-size: 30px;
    border-radius: 40px;
    background-color: rgb(33, 140, 223);
    font-family: "Roboto", sans-serif;
}
.Wyslij{
    padding: 2px;
    width: 700px;
    font-size: 38px;
    text-align: center;
    margin-left: 200px;
    background: rgb(0,255,235);
    background: linear-gradient(90deg, rgba(0,255,235,1) 0%, rgba(9,2,255,1) 100%);
    font-family: "Roboto", sans-serif;
    border-radius: 30px;
    transition: all 200ms ease-out;
    border: solid lightblue 2px;
}
.Wyslij:hover{
    color: white;
}

.form__field_1 {
            width: calc(100% - 40px);
            max-width: 100%;
        }

        #Wiadomosc {
            max-width: 180%;
            max-height: 600px; 
        }

        .form__field_1:not(#Wiadomosc) {
            width: calc(100% - 20px);
            max-width: 100%;
        }

        .Wyslij {
            width: calc(100% - 40px); 
            max-width: 100%;
            margin-top: 20px; 
        }




</style>


</head>
<body>
<header class="header">
        <div class="logo">
            <img class="logo"" src="loggo.png">
        </div>
        <div class="headlines">
            <ul>
                <li><a href="file:///C:/Users/asus/Desktop/Project%20II/Storna%20g%C5%82%C3%B3wna/StronaG%C5%82%C3%B3wna.html">Strona Główna</a></li>
                <li><a href="file:///C:/Users/asus/Desktop/Project%20II/Aktualno%C5%9Bci/Aktualno%C5%9Bci.html">Aktualności</a></li>
                <li><a href="file:///C:/Users/asus/Desktop/Project%20II/Zapisy/index.html">Zapisy</a></li>
                <li><a href="file:///C:/Users/asus/Desktop/Project%20II/Kontakt/Kontakt.html">Kontakt</a></li>
            </ul>
        </div>
        <div class="buttons">
            <p class="Zadzwon"><a href="">Zadzwoń do nas</a></p>
            <p class="Napisz"><a href="file:///D:/Projekt/Napisz%20do%20nad/Napisz.html">Napisz do nas</a></p>
        </div>
    </header>
    <footer class="footer">
    <div class="box">
        <form method="post" onsubmit="return validateForm()">
            <div class="form__group field">
                <input type="text" class="form__field_1" name="Imie" id="Imie" placeholder="Imię" required><br><br>
                <label class="form__label_1" for="Imie">Imię</label>
            </div>
            <div class="form__group field">
                <input type="text" class="form__field_1" name="Nazwisko" id="Nazwisko" placeholder="Nazwisko" required><br><br>
                <label class="form__label_1" for="Nazwisko">Nazwisko</label>
            </div>
            <div class="form__group field">
                <input type="email" class="form__field_1" name="Email" id="Email" placeholder="Email" required><br><br>
                <label class="form__label_1" for="Email">Email</label>
            </div>
            <div class="form__group field">
                <input type="text" class="form__field_1" name="Numer" id="Numer" placeholder="Numer telefonu" required><br><br>
                <label class="form__label_1" for="Numer">Numer telefonu</label>
            </div>
            <div class="form__group field">
                <input type="text" class="form__field_1" name="Temat" id="Temat" placeholder="Temat wiadomości" required><br><br>
                <label class="form__label_1" for="Temat">Temat wiadomości</label>
            </div>
            <div class="form__group field">
                <textarea class="form__field" maxlength="2000" name="Wiadomosc" id="Wiadomosc" placeholder="Wiadomość" rows="5" required></textarea><br><br>
                <label class="form__label" for="Wiadomosc">Wiadomość</label>
            </div>
            <input type="submit" class="Wyslij" name="Wyslij" value="Wyślij">
        </form>
            
            <script>
                function validateForm() {
                    var imie = document.getElementById("Imie").value;
                    var nazwisko = document.getElementById("Nazwisko").value;
                    var email = document.getElementById("Email").value;
                    var numer = document.getElementById("Numer").value;
                    var wiadomosc = document.getElementById("Wiadomosc").value;
            
                    var emailPattern = /^[a-zA-Z0-9._-]+@gmail\.com$/;
            
                    if (imie == "" || nazwisko == "" || !emailPattern.test(email) || numer == "" || wiadomosc == "") {
                        alert("Proszę wypełnić wszystkie pola poprawnie!");
                        return false;
                    }
                    return true;
                }
            </script>
            <div class="Text">
                <h1>Napisz do nas wiadomość</h1>
                <h3>Odpowiedz uzyskasz w ciągu <span>24h</span></h3>
            </div>
        </div>
        
        
    </footer>
   
</body>
</html>
