<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$db_name = "test";


$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if  ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Wyslij'])) {
    $all_good = true;

    $imie = mysqli_real_escape_string($conn, $_POST['Imie']);
    $nazwisko = mysqli_real_escape_string($conn, $_POST['Nazwisko']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $numer = mysqli_real_escape_string($conn, $_POST['Numer']);
    $miejsce = mysqli_real_escape_string($conn, $_POST['Miejsce']);
    $adres = mysqli_real_escape_string($conn, $_POST['Adres']);
    $kod = mysqli_real_escape_string($conn, $_POST['Kod']);
    $plec = mysqli_real_escape_string($conn, $_POST['Plec']);
    $waga = mysqli_real_escape_string($conn, $_POST['Waga']);
    $wzrost = mysqli_real_escape_string($conn, $_POST['Wzrost']);
    $pesel = mysqli_real_escape_string($conn, $_POST['Pesel']);
    $data = mysqli_real_escape_string($conn, $_POST['Data']);
    $szczyt = isset($_POST['szczyt']) ? mysqli_real_escape_string($conn, $_POST['szczyt']) : '';
    $rozmiar_buta = mysqli_real_escape_string($conn, $_POST['Buty-size-person_1']);
    $stan = mysqli_real_escape_string($conn, $_POST['Stan']);
    $buty = mysqli_real_escape_string($conn, $_POST['Buty']);
    $apteczka = mysqli_real_escape_string($conn, $_POST['Apteczka']);
    $plecak = mysqli_real_escape_string($conn, $_POST['Plecak']);
    $powerbank = mysqli_real_escape_string($conn, $_POST['PowerBank']);
    $lina = mysqli_real_escape_string($conn, $_POST['Lina']);
    $kask = mysqli_real_escape_string($conn, $_POST['Kask']);
    $zestaw = mysqli_real_escape_string($conn, $_POST['Zestaw']);
    $kuchenka = mysqli_real_escape_string($conn, $_POST['Kuchenka']);
    $raki = mysqli_real_escape_string($conn, $_POST['Raki']);
    $rakietysniezne = mysqli_real_escape_string($conn, $_POST['RakietyŚnieżne']);
    $radio = mysqli_real_escape_string($conn, $_POST['Radio']);

    if (strlen($imie) < 2 || strlen($imie) > 30) {
        $all_good = false;
        $_SESSION['e_imie'] = "Imię musi posiadać od 2 do 30 znaków";
    }

    if (($waga) < 60 || ($waga) > 140) {
        $all_good = false;
        $_SESSION['e_waga'] = "Twoja waga jest niedekwatna do regulaminu";
    }

    if (($wzrost) < 150 || ($wzrost) > 230 ) {
        $all_good = false;
        $_SESSION['e_wzrost'] = "Twój wzrost jest niedekwatna do regulaminu";
    }

    if (strlen($nazwisko) < 2 || strlen($nazwisko) > 45) {
        $all_good = false;
        $_SESSION['e_nazwisko'] = "Nazwisko musi posiadać od 2 do 45 znaków";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $all_good = false;
        $_SESSION['e_email'] = "Podaj poprawny adres email!";
      } else {
        if (strpos($email, '.com') === false) {
          $email .= '.com';
        }
      }

    if (!preg_match('/^[0-9]{9}$/', $numer)) {
        $all_good = false;
        $_SESSION['e_numer'] = "Numer telefonu musi składać się z 9 cyfr.";
    }

    if (!preg_match('/^[0-9]{11}$/', $pesel)) {
        $all_good = false;
        $_SESSION['e_pesel'] = "PESEL musi składać się z 11 cyfr.";
    }

    $data_czesci = explode('-', $data);
    if (count($data_czesci) == 3) {
        $data_porownawcza = date('Y-m-d', mktime(0, 0, 0, $data_czesci[1], $data_czesci[2], $data_czesci[0]));
        $data_minimalna = date('Y-m-d', strtotime('-18 years'));
        if ($data_porownawcza > $data_minimalna) {
            $all_good = false;
            $_SESSION['e_data'] = "Musisz mieć ukończone 18 lat, aby wziąć udział w wycieczce.";
        }
    } else {
        $all_good = false;
        $_SESSION['e_data'] = "Podaj datę w formacie rok-miesiąc-dzień (np. 2024-05-15).";
    }

    $allowed_szczyty = array("Mount Everest", "K2", "Manaslu", "Dhaulagiri");
    if (!in_array($szczyt, $allowed_szczyty)) {
        $all_good = false;
        $_SESSION['e_szczyt'] = "Nieprawidłowy wybór szczytu.";
    }
    
    $allowed_plec = array("Mezczyzna", "Kobieta");
    $allowed_stan = array("Dobry", "Sredni", "Zly");


    if ($all_good) {
        $query_biometria = "INSERT INTO biometria (plec, waga, wzrost, rozmiar_buta) VALUES ('$plec', '$waga', '$wzrost', '$rozmiar_buta')";
    
        if (mysqli_query($conn, $query_biometria)) {
            $id_Biometria = mysqli_insert_id($conn);
        } else {
            $all_good = false;
            echo "Błąd: " . mysqli_error($conn);
        }
    }
    
    if ($all_good) {
        $query_kontakt = "INSERT INTO kontakt (email, numer_telefonu)
                          VALUES ('$email', '$numer')";
        if (mysqli_query($conn, $query_kontakt)) {
            $id_Kontakt = mysqli_insert_id($conn);
        } else {
            $all_good = false;
            echo "Błąd: " . mysqli_error($conn);
        }
    }
    
    if ($all_good) {
        $query_dane_wrazliwe = "INSERT INTO dane_wrazliwe (pesel, data_urodzenia)
                                VALUES ('$pesel', '$data')";
        if (mysqli_query($conn, $query_dane_wrazliwe)) {
            $id_Dane_Wrazliwe = mysqli_insert_id($conn);
        } else {
            $all_good = false;
            echo "Błąd: " . mysqli_error($conn);
        }
    }
    
    if ($all_good) {
        $query_adres = "INSERT INTO adres (miejsce_zamieszknia, adres, kod_pocztowy)
                        VALUES ('$miejsce', '$adres', '$kod')";
        if (mysqli_query($conn, $query_adres)) {
            $id_adres = mysqli_insert_id($conn);
        } else {
            $all_good = false;
            echo "Błąd: " . mysqli_error($conn);
        }
    }
    
    if ($all_good) {
        $query_wyposarzenie = "INSERT INTO wyposarzenie (Ilosc_par_butów, Ilosc_apteczek, Ilosc_plecakow, Ilosc_powerbank, Ilosc_lin_wspinaczkowych, Ilosc_kaskow_wspinaczkowych, Ilosc_zestawow_wspinaczkowych, Ilosc_kuchenek_gazowych, Ilosc_rakow_snieznych, Ilosc_rakiet_snieznych, Ilosc_radio_stacji)
                               VALUES ('$buty', '$apteczka', '$plecak', '$powerbank', '$lina', '$kask', '$zestaw', '$kuchenka', '$raki', '$rakietysniezne', '$radio')";
        if (mysqli_query($conn, $query_wyposarzenie)) {
            $id_Wyposarzenie = mysqli_insert_id($conn);
        } else {
            $all_good = false;
            echo "Błąd: " . mysqli_error($conn);
        }
    }
    
    if ($all_good) {
        $query_osoba = "INSERT INTO osoba (Imie, Nazwisko, id_kontaktu, id_biometrii, id_danych, id_adres, id_wyposarzenie)
                        VALUES ('$imie', '$nazwisko', '$id_Kontakt', '$id_Biometria', '$id_Dane_Wrazliwe', '$id_adres', '$id_Wyposarzenie')";
        if (mysqli_query($conn, $query_osoba)) {
        } else {
            echo "Błąd: " . mysqli_error($conn);
        }
    }

    $allowed_szczyty = array("Mount Everest", "K2", "Manaslu", "Dhaulagiri");
    if (!in_array($szczyt, $allowed_szczyty)) {
        $all_good = false;
        $_SESSION['e_szczyt'] = "Nieprawidłowy wybór szczytu.";
    }

    if ($all_good) {
        $query_szczyty = "INSERT INTO szczyty (nazwa) VALUES ('$szczyt')";
        if (mysqli_query($conn, $query_szczyty)) {
        } else {
            echo "Błąd: " . mysqli_error($conn);
        }
    }
    
    if ($all_good) {
        $query_przewodnik = "";
        switch ($szczyt) {
            case "Mount Everest":
                $query_przewodnik = "INSERT INTO przewodnik (Imie, Nazwisko, Wiek, Wykształcenie, id_szczyt)
                                     VALUES ('Marek', 'Górski', '42', 'wspinaczkowe', (SELECT id_szczyt FROM szczyty WHERE nazwa = 'Mount Everest' LIMIT 1))";
                break;
            case "K2":
                $query_przewodnik = "INSERT INTO przewodnik (Imie, Nazwisko, Wiek, Wykształcenie, id_szczyt)
                                     VALUES ('Szymon', 'Niewidek', '29', 'wspinaczkowe', (SELECT id_szczyt FROM szczyty WHERE nazwa = 'K2' LIMIT 1))";
                break;
            case "Manaslu":
                $query_przewodnik = "INSERT INTO przewodnik (Imie, Nazwisko, Wiek, Wykształcenie, id_szczyt)
                                     VALUES ('Wojtek', 'Lipski', '50', 'wspinaczkowe', (SELECT id_szczyt FROM szczyty WHERE nazwa = 'Manaslu' LIMIT 1))";
                break;
            case "Dhaulagiri":
                $query_przewodnik = "INSERT INTO przewodnik (Imie, Nazwisko, Wiek, Wykształcenie, id_szczyt)
                                     VALUES ('Robert', 'Mylski', '46', 'wspinaczkowe', (SELECT id_szczyt FROM szczyty WHERE nazwa = 'Dhaulagiri' LIMIT 1))";
                break;
            default:
                break;
        }
    
        if ($query_przewodnik != "") {
            if (mysqli_query($conn, $query_przewodnik)) {
            } else {
                echo "Błąd: " . mysqli_error($conn);
            }
        }
    }
    
    if ($all_good) {
        $query_zamowienie = "INSERT INTO zamowienie (id_szczyt, id_osoba)
                             VALUES ((SELECT id_szczyt FROM szczyty WHERE nazwa = '$szczyt' LIMIT 1), (SELECT id_osoba FROM osoba ORDER BY id_osoba DESC LIMIT 1))";
        if (mysqli_query($conn, $query_zamowienie)) {
            echo '<div style="background-color: #4CAF50; color: white; padding: 10px; text-align: center;">Dane zostały zapisane pomyślnie!</div>';
            echo '<div style="background-color: #fff; color: green; padding: 10px; text-align: center;">Wyczekuj na email od nas</div>';

        } else {
            echo '<div style="background-color: #f2dede; color: #a94442; padding: 10px; border: 1px solid #ebccd1; text-align: center;">Wystąpił błąd</div>';
        }
    }
    
}







if (isset($_POST['Oblicz'])) {
    $radio = 509.99;
    $quality_radio = isset($_POST["Radio"]) ? intval($_POST["Radio"]) : 0;

    $RakietySniezne = 219.99;
    $quality_RakietySniezne = isset($_POST["RakietySniezne"]) ? intval($_POST["RakietySniezne"]) : 0;

    $Raki = 219.99;
    $quality_Raki = isset($_POST["Raki"]) ? intval($_POST["Raki"]) : 0;

    $Kuchenka = 89.99;
    $quality_Kuchenka = isset($_POST["Kuchenka"]) ? intval($_POST["Kuchenka"]) : 0;

    $Zestaw = 549.99;
    $quality_Zestaw = isset($_POST["Zestaw"]) ? intval($_POST["Zestaw"]) : 0;

    $Kask = 379.99;
    $quality_Kask = isset($_POST["Kask"]) ? intval($_POST["Kask"]) : 0;

    $Lina = 179.99;
    $quality_Lina = isset($_POST["Lina"]) ? intval($_POST["Lina"]) : 0;

    $PowerBank = 159.99;
    $quality_PowerBank = isset($_POST["PowerBank"]) ? intval($_POST["PowerBank"]) : 0;

    $Plecak = 209.99;
    $quality_Plecak = isset($_POST["Plecak"]) ? intval($_POST["Plecak"]) : 0;

    $Apteczka = 89.99;
    $quality_Apteczka = isset($_POST["Apteczka"]) ? intval($_POST["Apteczka"]) : 0;

    $Buty = 549.99;
    $quality_Buty = isset($_POST["Buty"]) ? intval($_POST["Buty"]) : 0;

    $wynik = ($quality_radio * $radio) + ($quality_RakietySniezne * $RakietySniezne) + ($quality_Raki * $Raki) + ($quality_Kuchenka * $Kuchenka) + ($quality_Zestaw * $Zestaw) + ($quality_Kask * $Kask) + ($quality_Lina * $Lina) + ($quality_PowerBank * $PowerBank) + ($quality_Plecak * $Plecak) + ($quality_Apteczka * $Apteczka) + ($quality_Buty * $Buty);

    if ($wynik == 0) {
        echo "<p style='color:white; font-size: 40px; text-align: center; padding: 20px; background-color: blue; font-family: inherit;'>Proszę o wypełnienie pól poprawnie.</p>";
    } else {
        echo "<p style='color:white; font-size: 40px; text-align: center; padding: 20px; background-color: #007bff; font-family: inherit;'>Cena wyposażenia wynosi {$wynik} zł</p>";
    }
}

mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="icon.png">
    <title>Zapisy</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style>
   @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
body{
    background-image: url(back.jpg);
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    background-size: cover;
    
}
.input-group {
    opacity: 0;
    transform: translateX(-100%);
    transition: opacity 0.5s ease, transform 0.5s ease;
}

.input-group.show {
    opacity: 1;
    transform: translateX(0);
}

.header{
    display: flex;
    justify-content:space-evenly;
    align-items: center;
}
.logo{
    max-width: 250px;
}
ul{
    display: flex;
    padding: 10px;
}
li{
    padding: 2ch;
    list-style-type: none;
    font-weight: 500;
    font-family: "Roboto", sans-serif;
}
a{
    text-decoration: none;
    font-size: 2.3ch;
    color: rgb(0, 0, 0);
    font-weight: 600;
}
a:hover{
    color: white;;
    text-shadow: 4px 4px 30px black;
}
.buttons{
    display:flex;
    padding: 10px;
    gap: 8px;
    
}
.Zadzwon{
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
.Zadzwon:hover{
    border: 2px solid rgb(73, 156, 207);
    background-color: rgba(73, 156, 207, 0.393);
    padding: 18px;
}
.Napisz{
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
.Napisz:hover{
    border: 2px solid rgb(77, 174, 226);
    background-color: rgba(73, 156, 207, 0.407);
    padding: 18px;
}
.footer{
    display: flex;
    justify-content: center;
    margin-top: 7ch;
}
.box{
    display: flex;
    justify-content: space-around;
    
    width:400ch;
    height: auto;
    background-color: rgba(0, 0, 0, 0.469);
    border-radius: 5px;
}
.Motto_1{
    font-size: 8ch;
    color: rgb(236, 178, 103);
    font-family: "Roboto", sans-serif;
    font-weight: 600;
    
}
.Motto_2{
    font-size: 8ch;
    color: rgb(194, 114, 3);
    font-family: "Roboto", sans-serif;
    font-weight: 600;
    left:20%;
}
h4 {
    text-align: center;
    display: flex;
    justify-content: center;
    color: rgb(90, 172, 244);
    font-size: 70px;
    padding: 30px;
    font-family: "Roboto", sans-serif;
    text-shadow: 4px 4px 30px black;
    animation: flyingText 3s infinite alternate;
}

@keyframes flyingText {
    0% {
        transform: translateY(0);
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.4);
    }
    50% {
        transform: translateY(-20px);
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.6);
    }
    100% {
        transform: translateY(0);
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.4);
    }
}

.text-write{
    display: flex;
    align-content: space-around;
}
input{
    height: 2em;
    width: 15em;
    padding: 10px;
}

.form_1{
    padding: 60px;
}

.form__group {

    position: relative;
    padding: 10px 0 0;
    margin-top: 10px;
    margin-left: 230px;
    width: 50%;
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
    font-weight:700;
  }
  padding-bottom: 6px;
  font-weight: 700;
  border-width: 3px;
  border-image: linear-gradient(to right, primary, secondary);
  border-image-slice: 1;
}
.form__field{
  &:required,&:invalid { box-shadow:none; }
}

.Text{
    font-size: 30px;
    margin-top: 150px;
    margin-right: 280px;
    color:aliceblue;
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
    margin-left: 240px;
    width: 200px;
    height: 50px;
    color: black;
    font-size: 30px;
    border-radius: 40px;
    background-color: rgb(33, 140, 223);
    font-family: "Roboto", sans-serif;
}





.Buty-img{
    align-items: center;
    margin-left: 240px;
    width: 400px;
}



.Radio{
    align-items: center;
    color: aliceblue;
    font-size: 20px;
    font-family: "Roboto", sans-serif;
    padding: 20px;
}
.All-radio{
    padding: 30px;
}
p{
    color: green;
    font-width: 500;
    font-size: 15px
}

@keyframes gradientBackground {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.Wyslij {
    padding: 15px;
    max-width: 250px;
    font-size: 24px;
    text-align: center;
    background: linear-gradient(232deg, rgba(230,236,250,1) 0%, rgba(42,144,227,1) 50%, rgba(0,212,255,1) 100%);
    background-size: 200% 200%;
    font-family: "Roboto", sans-serif;
    border-radius: 30px;
    transition: all 500ms ease;
    border: solid lightblue 2px;
    box-shadow: 0px 4px 15px rgba(42,144,227,0.4);
    position: relative;
    overflow: hidden;
    color: white;
    text-transform: uppercase;
    letter-spacing: 2px;
    cursor: pointer;
    display: inline-block;
    margin: 20px;
    animation: gradientBackground 10s ease infinite;
}

.Wyslij:hover {
    transform: scale(1.1);
    border: solid blue 2px;
    box-shadow: 0px 8px 25px rgba(42,144,227,0.6);
}

.Wyslij::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300%;
    height: 300%;
    background: rgba(42,144,227,0.1);
    border-radius: 50%;
    transition: transform 0.5s ease, background 0.5s ease;
    transform: translate(-50%, -50%) scale(0);
    z-index: 0;
}

.Wyslij:hover::before {
    transform: translate(-50%, -50%) scale(1);
    background: rgba(42,144,227,0.2);
}

.Wyslij span {
    position: relative;
    z-index: 1;
}

.buton {
    width: 90%;
    padding: 50px;
    text-align: center;
    gap: 200px;
}

.Wyslij span::after {
    content: '!';
    opacity: 0;
    position: absolute;
    right: -10px;
    top: -10px;
    font-size: 30px;
    transition: all 0.5s ease;
}

.Wyslij:hover span::after {
    opacity: 1;
    right: -20px;
    top: -20px;
    color: #2a90e3;
}




.Oblicz {
    padding: 15px;
    max-width: 250px;
    font-size: 24px;
    text-align: center;
    background: linear-gradient(232deg, rgba(230,236,250,1) 0%, rgba(42,144,227,1) 50%, rgba(0,212,255,1) 100%);
    background-size: 200% 200%;
    font-family: "Roboto", sans-serif;
    border-radius: 30px;
    transition: all 500ms ease;
    border: solid lightblue 2px;
    box-shadow: 0px 4px 15px rgba(42,144,227,0.4);
    position: relative;
    overflow: hidden;
    color: white;
    text-transform: uppercase;
    letter-spacing: 2px;
    cursor: pointer;
    display: inline-block;
    margin: 20px;
    animation: gradientBackground 10s ease infinite;
}

.Oblicz:hover {
    transform: scale(1.1);
    border: solid blue 2px;
    box-shadow: 0px 8px 25px rgba(42,144,227,0.6);
}

.Oblicz::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300%;
    height: 300%;
    background: rgba(42,144,227,0.1);
    border-radius: 50%;
    transition: transform 0.5s ease, background 0.5s ease;
    transform: translate(-50%, -50%) scale(0);
    z-index: 0;
}

.Oblicz:hover::before {
    transform: translate(-50%, -50%) scale(1);
    background: rgba(42,144,227,0.2);
}

.Oblicz span {
    position: relative;
    z-index: 1;
}

.buton {
    width: 90%;
    padding: 50px;
    text-align: center;
    gap: 200px;
}


.Wyslij span::after {
    content: '!';
    opacity: 0;
    position: absolute;
    right: -10px;
    top: -10px;
    font-size: 30px;
    transition: all 0.5s ease;
}

.Wyslij:hover span::after {
    opacity: 1;
    right: -20px;
    top: -20px;
    color: #2a90e3;
}


.error {
    background-color: #f8d7da;
    border-radius: 20px;
    padding: 15px;
    font-size: 16px;
    margin-top: 10px;
    margin-bottom: 10px;
    color: #721c24;
    border: 1px solid #f5c6cb;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
h3, h4, h6 {
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    color: rgb(255, 255, 255);
    padding: 15px 30px;
    font-family: "Roboto", sans-serif;
    text-shadow: 4px 4px 30px rgba(0, 0, 0, 0.5);
    border-radius: 15px;
    background: linear-gradient(to bottom, #6DC7FF, #0099FF);
    box-shadow: 1px 3px 64px -29px rgba(255, 255, 255, 1);
    transition: transform 0.5s, box-shadow 0.5s, background 0.5s;
}

h3 {
    font-size: 30px;
    background: linear-gradient(to bottom, #6DC7FF, #0099FF);

}

h4 {
    font-size: 45px;
    background: linear-gradient(to bottom, #4A90E2, #0066CC);
    animation: zoomAnimation 3s infinite alternate;
}

h6 {
    font-size: 28px;
    background: linear-gradient(to bottom, #6DC7FF, #0099FF);
    animation: zoomAnimation 2s infinite alternate;
}

 h4:hover, h6:hover {
    transform: scale(1.1);
    background: linear-gradient(to bottom, #5DADE2, #1B4F72);
}

@keyframes zoomAnimation {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.10);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    50% {
        opacity: 1;
    }
    100% {
        opacity: 0;
    }
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
                <li><a href="file:///D:/Projekt/Storna%20g%C5%82%C3%B3wna/StronaG%C5%82%C3%B3wna.html">Strona Główna</a></li>
                <li><a href="file:///D:/Projekt/Aktualno%C5%9Bci/Aktualno%C5%9Bci.html">Aktualności</a></li>
                <li><a href="file:///D:/Projekt/Zapisy/index.html">Zapisy</a></li>
                <li><a href="file:///D:/Projekt/Kontakt/Kontakt.html">Kontakt</a></li>
            </ul>
        </div>
        <div class="buttons">
            <p class="Zadzwon"><a href="">Zadzwoń do nas</a></p>
            <p class="Napisz"><a href="http://localhost:3000/Napisz%20do%20nad/Napisz.php">Napisz do nas</a></p>
        </div>
    </header>
    <footer class="footer">
        <div class="box">
            <div class="text-write">
                
                <form action="zamówienia.php" method="post">
                <div class="text-top">
                    <h4>Czy jesteś gotów przeżyć<br> podróż swojego życia </h4>
                </div>
                <br>
                    <h3>Wybierz szczyt, na który zamierzasz się udać</h3>
                    <br><br><br>
                    <div class="form__group field">
                        <label for="szczyt" class="form__label">Wybierz szczyt</label>
                        <select name="szczyt" id="szczyt" class="form__field">
                            <option value="" disabled selected>Wybierz szczyt</option>
                            <option value="Mount Everest">Mount Everest</option>
                            <option value="K2">K2</option>
                            <option value="Manaslu">Manaslu</option>
                            <option value="Dhaulagiri">Dhaulagiri</option>
                        </select>
                    </div>

                    <div class="form__group field">
                        <input maxlength="30" type="input" class="form__field" placeholder="Imie" name="Imie" id='Imievalue=" <?php if(isset($_POST['Imie'])) echo $_POST['Imie']; ?>"' />
                        <?php
                            if (isset($_SESSION['e_imie']))
                            {
                                echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
                                unset($_SESSION['e_imie']);
                            }
                        ?>
                        <label class="form__label">Imie</label>
                        
                        
                        
                    </div>
                    <br><br><br>
                    <div class="form__group field">
                        <input maxlength="45" type="input" class="form__field" placeholder="Nazwisko" name="Nazwisko" id='Nazwisko'  value="<?php if(isset($_POST['Nazwisko'])) echo $_POST['Nazwisko']; ?>" />
                        <?php
                            if (isset($_SESSION['e_nazwisko']))
                            {
                                echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
                                unset($_SESSION['e_nazwisko']);
                            }
                        ?>
                        <label class="form__label">Nazwisko</label>
                    </div>
                    <br><br><br>
                    <div class="form__group field">
                        <input maxlength="50" type="input" class="form__field" placeholder="Miejsce" name="Miejsce" id='Miejsce' value="<?php if(isset($_POST['Miejsce'])) echo $_POST['Miejsce']; ?>" />
                        <?php
                            if (isset($_SESSION['e_miejsce']))
                            {
                                echo '<div class="error">'.$_SESSION['e_miejsce'].'</div>';
                                unset($_SESSION['e_miejsce']);
                            }
                        ?>
                        <label class="form__label">Miejsce zamieszkania(Miasto)</label>
                    </div>
                    <br><br><br>
                    <div class="form__group field">
                        <input maxlength="70" type="input" class="form__field" placeholder="Adres" name="Adres" id='adres' value="<?php if(isset($_POST['Adres'])) echo $_POST['Adres']; ?>" />
                        <?php
                            if (isset($_SESSION['e_adres']))
                            {
                                echo '<div class="error">'.$_SESSION['e_adres'].'</div>';
                                unset($_SESSION['e_adres']);
                            }
                        ?>
                        <label class="form__label">Dokładny adres zamieszkania </label>
                    </div>
                    <br><br><br>
                    <div class="form__group field">
                        <input maxlength="15" type="input" class="form__field" placeholder="Kod" name="Kod" id='Kod' value="<?php if(isset($_POST['Kod'])) echo $_POST['Kod']; ?>" />
                        <?php
                            if (isset($_SESSION['e_kod']))
                            {
                                echo '<div class="error">'.$_SESSION['e_kod'].'</div>';
                                unset($_SESSION['e_kod']);
                            }
                        ?>
                        <label class="form__label">Kod pocztowy</label>
                    </div>
                    <br><br><br>
                    <div class="form__group field">
                        <input maxlength="50" type="email" class="form__field" placeholder="Email" name="Email" id="Email" value="<?php if(isset($_POST['Email'])) echo $_POST['Email']; ?>"  />
                        <?php
                            if (isset($_SESSION['e_email_1']))
                            {
                                echo '<div class="error">'.$_SESSION['e_email_1'].'</div>';
                                unset($_SESSION['e_email_1']);
                            }
                        ?>
                        <label class="form__label">Email</label>
                    </div>
                    <br><br><br>
                    <div class="form__group field">
                        <input maxlength="14" type="input" class="form__field" placeholder="Numer" name="Numer" id='Numer' value="<?php if(isset($_POST['Numer'])) echo $_POST['Numer']; ?>"  />
                        <?php
                            if (isset($_SESSION['e_numer']))
                            {
                                echo '<div class="error">'.$_SESSION['e_numer'].'</div>';
                                unset($_SESSION['e_numer']);
                            }
                        ?>
                        <label class="form__label">Numer Telefonu</label>
                    </div>
                    <br><br><br>
                    <div class="form__group field">
                        <input maxlength="11" type="input" class="form__field" placeholder="Pesel" name="Pesel" id='Pesel'  value="<?php if(isset($_POST['Pesel'])) echo $_POST['Pesel']; ?>"/>
                        <?php
                            if (isset($_SESSION['e_pesel']))
                            {
                                echo '<div class="error">'.$_SESSION['e_pesel'].'</div>';
                                unset($_SESSION['e_pesel']);
                            }
                        ?>
                        <label class="form__label">Pesel</label>
                    </div>
                    <br><br><br>
                    <div class="form__group field">
                        <input maxlength="10" type="input" class="form__field" placeholder="Data" name="Data" id='Data' value="<?php if(isset($_POST['Data'])) echo $_POST['Data']; ?>" />
                        <?php
                            if (isset($_SESSION['e_data']))
                            {
                                echo '<div class="error">'.$_SESSION['e_data'].'</div>';
                                unset($_SESSION['e_data']);
                            }
                        ?>
                        <label class="form__label">Data urodzenia (np: 1999-12-29)</label>
                    </div>
                    <br><br><br>
                    <div class="form__group field">
                        <select class="form__field" name="Stan" id="Stan">
                            <option value="Dobry">Dobry</option>
                            <option value="Średni">Sredni</option>
                            <option value="Zły">Zly</option>
                        </select>
                        <label class="form__label">Stan zdrowia</label>
                    </div>

                    <br><br><br>
                    <div class="form__group field">
                        <select class="form__field" name="Plec" id="Plec">
                            <option value="" disabled selected>Wybierz Płeć</option>
                            <option value="Mezczyzna">Mezczyzna</option>
                            <option value="Kobieta">Kobieta</option>
                        </select>
                        <label class="form__label">Płeć</label>
                    </div>

                    <br><br><br>
                    <div class="form__group field">
                        <input maxlength="5" type="input" class="form__field" placeholder="Waga" name="Waga" id='Waga' value="<?php if(isset($_POST['Waga'])) echo $_POST['Waga']; ?>" />
                        <?php
                            if (isset($_SESSION['e_waga']))
                            {
                                echo '<div class="error">'.$_SESSION['e_waga'].'</div>';
                                unset($_SESSION['e_waga']);
                            }
                        ?>
                        <label class="form__label">Waga(kg)</label>
                    </div>
                    <br><br><br>
                    <div class="form__group field">
                        <input maxlength="5" type="input" class="form__field" placeholder="Wzrost" name="Wzrost" id='Wzrost' value="<?php if(isset($_POST['Wzrost'])) echo $_POST['Wzrost']; ?>" />
                        <?php
                            if (isset($_SESSION['e_wzrost']))
                            {
                                echo '<div class="error">'.$_SESSION['e_wzrost'].'</div>';
                                unset($_SESSION['e_wzrost']);
                            }
                        ?>
                        <label  class="form__label">Wzrost(cm)</label>
                    </div>
                    
                            <br><br>
                    <h6>Niezbędne przedmioty do wyprawy<br>Jeżeli posiadasz dany przedmiot w miejsce puste wstaw 0</h6>
                    <h6>Koszt wyprawy na szczyt zależy od wielu czynników prawnych<br> cena wacha się między
                        40 000zł do 80 000zł</h6>
                    <br><br><br>
                    <form action="zamówienia.php" method="POST">
                        
                        <img src="Buty.png"  class="Buty-img">
                        <div class="form__group field">
                            <input maxlength="5" type="input" class="form__field"  name="Buty" id='Buty' value="<?php if(isset($_POST['Buty'])) echo $_POST['Buty']; ?>" />
                            <?php
                                if (isset($_SESSION['e_Buty']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_Buty'].'</div>';
                                    unset($_SESSION['e_Buty']);
                                }
                            ?>
                            <label class="form__label">Ilość par butów</label>
                            <p>Cena: 549.99zł za pare</p>
                        </div>
                        <br><br><br><br>
                        <div class="form__group field">
                            <input maxlength="4" type="input" class="form__field"  name="Buty-size-person_1" id='Buty-size-person_1' value="<?php if(isset($_POST['Buty-size-person_1'])) echo $_POST['Buty-size-person_1']; ?>" />
                            <?php
                                if (isset($_SESSION['e_rozmiar_buta']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_rozmiar_buta'].'</div>';
                                    unset($_SESSION['e_rozmiar_buta']);
                                }
                            ?>
                            <label class="form__label">Numer buta </label>
                        </div>
                        <br><br><br>
                        
                        <img src="Apteczka.png"  class="Buty-img">
                        <div class="form__group field">
                            <input maxlength="5" type="input" class="form__field"  name="Apteczka" id='Apteczka' value="<?php if(isset($_POST['Apteczka'])) echo $_POST['Apteczka']; ?>" />
                            <?php
                                if (isset($_SESSION['e_Apteczka']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_Apteczka'].'</div>';
                                    unset($_SESSION['e_Apteczka']);
                                }
                            ?>
                            <label class="form__label">Ilość Apteczek(Wyposażenie podstawowe)</label>
                            <p>Cena: 89.99zł za szt</p>
                        </div>
                        <br><br><br><br>
                        <img src="Plecak-Górski.png"  class="Buty-img">
                        <div class="form__group field">
                            <input maxlength="5" type="input" class="form__field"  name="Plecak" id='Plecak'  value="<?php if(isset($_POST['Plecak'])) echo $_POST['Plecak']; ?>"/>
                            <?php
                                if (isset($_SESSION['e_Plecak']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_Plecak'].'</div>';
                                    unset($_SESSION['e_Plecak']);
                                }
                            ?>
                            <label class="form__label">Ilość Plecaków(60 litrów)</label>
                            <p>Cena: 209.99zł za szt</p>
                        </div>
                        <br><br><br><br>
                        <img src="PowerBank.png"  class="Buty-img">
                        <div class="form__group field">
                            <input maxlength="5" type="input" class="form__field"  name="PowerBank" id='PowerBank'  value="<?php if(isset($_POST['PowerBank'])) echo $_POST['PowerBank']; ?>"/>
                            <?php
                                if (isset($_SESSION['e_PowerBank']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_PowerBank'].'</div>';
                                    unset($_SESSION['e_PowerBank']);
                                }
                            ?>
                            <label class="form__label">Ilość PowerBank(12 000 mAh)</label>
                            <p>Cena: 159.99zł za szt</p>
                        </div>
                        
                        <br><br><br><br>
                        <img src="lina.png"  class="Buty-img">
                        <div class="form__group field">
                            <input maxlength="5" type="input" class="form__field"  name="Lina" id='Lina'  value="<?php if(isset($_POST['Lina'])) echo $_POST['Lina']; ?>" />
                            <?php
                                if (isset($_SESSION['e_Lina']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_Lina'].'</div>';
                                    unset($_SESSION['e_Lina']);
                                }
                            ?>
                            <label class="form__label">Ilość lin wspinaczkowych</label>
                            <p>Cena: 179.99zł za szt</p>
                        </div>
                        <br><br><br><br>
                        <img src="kask.png"  class="Buty-img">
                        <div class="form__group field">
                            <input maxlength="5" type="input" class="form__field"  name="Kask" id='Kask'  value="<?php if(isset($_POST['Kask'])) echo $_POST['Kask']; ?>"/>
                            <?php
                                if (isset($_SESSION['e_Kask']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_Kask'].'</div>';
                                    unset($_SESSION['e_Kask']);
                                }
                            ?>
                            <label class="form__label">Ilość kasków wspinaczkowych</label>
                            <p>Cena: 379.99zł za szt</p>
                        </div>
                        <br><br><br><br>
                        <img src="zestaw.png"  class="Buty-img">
                        <div class="form__group field">
                            <input maxlength="5" type="input" class="form__field"  name="Zestaw" id='Zestaw' value="<?php if(isset($_POST['Zestaw'])) echo $_POST['Zestaw']; ?>" />
                            <?php
                                if (isset($_SESSION['e_zestaw']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_zestaw'].'</div>';
                                    unset($_SESSION['e_zestaw']);
                                }
                            ?>
                            <label class="form__label">Ilość zestawów wspinaczkowych</label>
                            <p>Cena: 549.99zł za szt</p>
                        </div>
                        <br><br><br><br>
                        <img src="kuchenka.png"  class="Buty-img">
                        <div class="form__group field">
                            <input maxlength="5" type="input" class="form__field"  name="Kuchenka" id='Kuchenka'  value="<?php if(isset($_POST['Kuchenka'])) echo $_POST['Kuchenka']; ?>"/>
                            <?php
                                if (isset($_SESSION['e_Kuchenka']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_Kuchenka'].'</div>';
                                    unset($_SESSION['e_Kuchenka']);
                                }
                            ?>
                            <label class="form__label">Ilość Kuchenek gazowych</label>
                            <p>Cena: 89.99zł za szt</p>
                        </div>
                        <br><br><br><br>
                        <img src="Raki.png"  class="Buty-img">
                        <div class="form__group field">
                            <input maxlength="5" type="input" class="form__field"  name="Raki" id='Raki'  value="<?php if(isset($_POST['Raki'])) echo $_POST['Raki']; ?>"/>
                            <?php
                                if (isset($_SESSION['e_Raki']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_Raki'].'</div>';
                                    unset($_SESSION['e_Raki']);
                                }
                            ?>
                            <label class="form__label">Ilość Raków Śnieżnych</label>
                            <p>Cena: 219.99zł za sz</p>
                        </div>
                        <br><br><br><br>
                        <img src="RakietyŚnieżne.png"  class="Buty-img">
                        <div class="form__group field">
                            <input maxlength="5" type="input" class="form__field"  name="RakietyŚnieżne" id='RakietyŚnieżne' value="<?php if(isset($_POST['RakietyŚnieżne'])) echo $_POST['RakietyŚnieżne']; ?>"/>
                            <?php
                                if (isset($_SESSION['e_rakiety']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_rakiety'].'</div>';
                                    unset($_SESSION['e_rakiety']);
                                }
                            ?>
                            <label class="form__label">Ilość Rakiet Śnieżnych</label>
                            <p>Cena: 219.99zł za szt</p>
                        </div>
                        <br><br><br><br>
                        <img src="radio.png"  class="Buty-img">
                        <div class="form__group field">
                            
                            <input maxlength="5" type="input" class="form__field"  name="Radio" id='Radio'  value="<?php if(isset($_POST['Radio'])) echo $_POST['Radio']; ?>"/>
                            <?php
                                if (isset($_SESSION['e_Radio']))
                                {
                                    echo '<div class="error">'.$_SESSION['e_Radio'].'</div>';
                                    unset($_SESSION['e_Radio']);
                                }
                            ?>
                            <label class="form__label">Ilość Radio Stacji</label>
                            <p>Cena: 509.99zł za szt</p>
                        </div>
                        <div class="buton">
                        <div class="g-recaptcha" data-sitekey="TWÓJ_KLUCZ_STRONY"></div>
                        <input class="Oblicz" type="submit" name="Oblicz" value="Oblicz">

                        <input class="Wyslij" type="submit" name="Wyslij" value="Wyślij">
                        </div>

                    </form>
                </form>
                
            </div>
            
        </div>
         
        
        
    </footer>

</body>
</html>