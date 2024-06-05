<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edycja Danych Użytkownika</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(ladne_1.png);
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
        }
        form {
    margin: 20px auto;
    padding: 30px;
    width: 800px;
    border: 2px solid #0056b3;
    border-radius: 20px;
    background-color: #f9f9f9;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

input[type="text"],
input[type="submit"],
input[type="number"],
input[type="date"] {
    display: block;
    margin-bottom: 15px;
    width: calc(100% - 16px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s;
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="date"]:focus {
    border-color: #0056b3;
}

input[type="submit"] {
    background-color: #0056b3;
    color: white;
    font-size: 20px;
    border: none;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: darkblue;
}

        span{
            color: #0056b3;
            
        }
        .Return {
            background-color: #007bff;
            color: white; 
            padding: 10px 20px; 
            text-decoration: none; 
            border-radius: 5px; 
            display: inline-block; 
            transition: background-color 0.3s; 
        }
 
        .Return:hover {
            background-color: #0056b3; 
        }

    </style>
</head>
<body>

<?php
// Połączenie z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "test";

$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$id_Osoba = $_GET["id_update"];

// Jeśli formularz został przesłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobranie danych z formularza
    $imie = $_POST["imie"];
    $nazwisko = $_POST["nazwisko"];
    $miejsce_zamieszkania = $_POST["miejsce_zamieszkania"];
    $adres = $_POST["adres"];
    $kod_pocztowy = $_POST["kod_pocztowy"];
    $waga = $_POST["waga"];
    $wzrost = $_POST["wzrost"];
    $stan_zdrowia = $_POST["stan_zdrowia"];
    $rozmiar_buta = $_POST["rozmiar_buta"];
    $plec = $_POST["plec"];
    $pesel = $_POST["pesel"];
    $data_urodzenia = $_POST["data_urodzenia"];
    $ilosc_par_butow = $_POST["ilosc_par_butow"];
    $ilosc_apteczek = $_POST["ilosc_apteczek"];
    $ilosc_plecakow = $_POST["ilosc_plecakow"];
    $ilosc_powerbank = $_POST["ilosc_powerbank"];
    $ilosc_lin_wspinaczkowych = $_POST["ilosc_lin_wspinaczkowych"];
    $ilosc_kaskow_wspinaczkowych = $_POST["ilosc_kaskow_wspinaczkowych"];
    $ilosc_zestawow_wspinaczkowych = $_POST["ilosc_zestawow_wspinaczkowych"];
    $ilosc_kuchenek_gazowych = $_POST["ilosc_kuchenek_gazowych"];
    $ilosc_rakow_snieznych = $_POST["ilosc_rakow_snieznych"];
    $ilosc_rakiet_snieznych = $_POST["ilosc_rakiet_snieznych"];
    $ilosc_radio_stacji = $_POST["ilosc_radio_stacji"];

    // Zaktualizowanie danych w bazie
    $sql = "UPDATE osoba SET Imie = '$imie', Nazwisko = '$nazwisko' WHERE id_Osoba = $id_Osoba";
    mysqli_query($conn, $sql);

    $sql = "UPDATE adres SET miejsce_zamieszknia = '$miejsce_zamieszkania', adres = '$adres', kod_pocztowy = '$kod_pocztowy' WHERE id_Adres = $id_Osoba";
    mysqli_query($conn, $sql);

    $sql = "UPDATE biometria SET waga = '$waga', wzrost = '$wzrost', stan_zdrowia = '$stan_zdrowia', rozmiar_buta = '$rozmiar_buta', plec = '$plec' WHERE id_Biometria = $id_Osoba";
    mysqli_query($conn, $sql);

    $sql = "UPDATE dane_wrazliwe SET pesel = '$pesel', data_urodzenia = '$data_urodzenia' WHERE id_Dane_Wrazliwe = $id_Osoba";
    mysqli_query($conn, $sql);

    $sql = "UPDATE wyposarzenie SET Ilosc_par_butów = '$ilosc_par_butow', Ilosc_apteczek = '$ilosc_apteczek', Ilosc_plecakow = '$ilosc_plecakow', Ilosc_powerbank = '$ilosc_powerbank', Ilosc_lin_wspinaczkowych = '$ilosc_lin_wspinaczkowych', Ilosc_kaskow_wspinaczkowych = '$ilosc_kaskow_wspinaczkowych', Ilosc_zestawow_wspinaczkowych = '$ilosc_zestawow_wspinaczkowych', Ilosc_kuchenek_gazowych = '$ilosc_kuchenek_gazowych', Ilosc_rakow_snieznych = '$ilosc_rakow_snieznych', Ilosc_rakiet_snieznych = '$ilosc_rakiet_snieznych', Ilosc_radio_stacji = '$ilosc_radio_stacji' WHERE id_Wyposarzenie = $id_Osoba";
    mysqli_query($conn, $sql);

    echo '<div style="background-color: #4CAF50; color: white; padding: 10px; text-align: center;">Dane zostały zapisane pomyślnie!</div>';

}

// Pobranie istniejących danych z bazy
$sql = "SELECT * FROM osoba WHERE id_Osoba = $id_Osoba";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
?>
    <form method="post" action="">
    <h1>Edytowanie <span>danych</span></h1>
    <a class="Return" href="http://localhost:3000/Admin/Panel.php"> Powrót</a><br><br>
    <label for="imie">Imie:</label>
    <input type="text" id="imie" name="imie" value="<?php echo $row['Imie']; ?>" required><br>
    <label for="nazwisko">Nazwisko:</label>
    <input type="text" id="nazwisko" name="nazwisko" value="<?php echo $row['Nazwisko']; ?>" required><br>
    
<?php
$sql = "SELECT * FROM adres WHERE id_Adres = $id_Osoba";
$result = mysqli_query($conn, $sql);
$adres = mysqli_fetch_assoc($result);
?>
    <label for="miejsce_zamieszkania">Miejsce zamieszkania:</label>
    <input type="text" id="miejsce_zamieszkania" name="miejsce_zamieszkania" value="<?php echo $adres['miejsce_zamieszknia']; ?>" required><br>
    <label for="adres">Adres:</label>
    <input type="text" id="adres" name="adres" value="<?php echo $adres['adres']; ?>" required><br>
    <label for="kod_pocztowy">Kod pocztowy:</label>
    <input type="text" id="kod_pocztowy" name="kod_pocztowy" value="<?php echo $adres['kod_pocztowy']; ?>" required><br>

<?php
$sql = "SELECT * FROM biometria WHERE id_Biometria = $id_Osoba";
$result = mysqli_query($conn, $sql);
$biometria = mysqli_fetch_assoc($result);
?>
    <label for="waga">Waga:</label>
    <input type="text" id="waga" name="waga" value="<?php echo $biometria['waga']; ?>" required><br>
    <label for="wzrost">Wzrost:</label>
    <input type="text" id="wzrost" name="wzrost" value="<?php echo $biometria['wzrost']; ?>" required><br>
    <label for="stan_zdrowia">Stan zdrowia:</label>
    <input type="text" id="stan_zdrowia" name="stan_zdrowia" value="<?php echo $biometria['stan_zdrowia']; ?>" required><br>
    <label for="rozmiar_buta">Rozmiar buta:</label>
    <input type="text" id="rozmiar_buta" name="rozmiar_buta" value="<?php echo $biometria['rozmiar_buta']; ?>" required><br>
    <label for="plec">Płeć:</label>
    <input type="text" id="plec" name="plec" value="<?php echo $biometria['plec']; ?>" required><br>

<?php
$sql = "SELECT * FROM dane_wrazliwe WHERE id_Dane_Wrazliwe = $id_Osoba";
$result = mysqli_query($conn, $sql);
$dane_wrazliwe = mysqli_fetch_assoc($result);
?>
    <label for="pesel">PESEL:</label>
    <input type="text" id="pesel" name="pesel" value="<?php echo $dane_wrazliwe['pesel']; ?>" required><br>
    <label for="data_urodzenia">Data urodzenia:</label>
    <input type="date" id="data_urodzenia" name="data_urodzenia" value="<?php echo $dane_wrazliwe['data_urodzenia']; ?>" required><br>

<?php
$sql = "SELECT * FROM wyposarzenie WHERE id_Wyposarzenie = $id_Osoba";
$result = mysqli_query($conn, $sql);
$wyposarzenie = mysqli_fetch_assoc($result);
?>
    <label for="ilosc_par_butow">Ilość par butów:</label>
    <input type="number" id="ilosc_par_butow" name="ilosc_par_butow" value="<?php echo $wyposarzenie['Ilosc_par_butów']; ?>" required><br><br>
    <label for="ilosc_apteczek">Ilość apteczek:</label>
    <input type="number" id="ilosc_apteczek" name="ilosc_apteczek" value="<?php echo $wyposarzenie['Ilosc_apteczek']; ?>" required><br><br>
    <label for="ilosc_plecakow">Ilość plecaków:</label>
    <input type="number" id="ilosc_plecakow" name="ilosc_plecakow" value="<?php echo $wyposarzenie['Ilosc_plecakow']; ?>" required><br><br>
    <label for="ilosc_powerbank">Ilość powerbanków:</label>
    <input type="number" id="ilosc_powerbank" name="ilosc_powerbank" value="<?php echo $wyposarzenie['Ilosc_powerbank']; ?>" required><br><br>
    <label for="ilosc_lin_wspinaczkowych">Ilość lin wspinaczkowych:</label>
    <input type="number" id="ilosc_lin_wspinaczkowych" name="ilosc_lin_wspinaczkowych" value="<?php echo $wyposarzenie['Ilosc_lin_wspinaczkowych']; ?>" required><br><br>
    <label for="ilosc_kaskow_wspinaczkowych">Ilość kasków wspinaczkowych:</label>
    <input type="number" id="ilosc_kaskow_wspinaczkowych" name="ilosc_kaskow_wspinaczkowych" value="<?php echo $wyposarzenie['Ilosc_kaskow_wspinaczkowych']; ?>" required><br><br>
    <label for="ilosc_zestawow_wspinaczkowych">Ilość zestawów wspinaczkowych:</label>
    <input type="number" id="ilosc_zestawow_wspinaczkowych" name="ilosc_zestawow_wspinaczkowych" value="<?php echo $wyposarzenie['Ilosc_zestawow_wspinaczkowych']; ?>" required><br><br>
    <label for="ilosc_kuchenek_gazowych">Ilość kuchenek gazowych:</label>
    <input type="number" id="ilosc_kuchenek_gazowych" name="ilosc_kuchenek_gazowych" value="<?php echo $wyposarzenie['Ilosc_kuchenek_gazowych']; ?>" required><br><br>
    <label for="ilosc_rakow_snieznych">Ilość raków śnieżnych:</label>
    <input type="number" id="ilosc_rakow_snieznych" name="ilosc_rakow_snieznych" value="<?php echo $wyposarzenie['Ilosc_rakow_snieznych']; ?>" required><br><br>
    <label for="ilosc_rakiet_snieznych">Ilość rakiet śnieżnych:</label>
    <input type="number" id="ilosc_rakiet_snieznych" name="ilosc_rakiet_snieznych" value="<?php echo $wyposarzenie['Ilosc_rakiet_snieznych']; ?>" required><br><br>
    <label for="ilosc_radio_stacji">Ilość radiostacji:</label><br>
    <input type="number" id="ilosc_radio_stacji" name="ilosc_radio_stacji" value="<?php echo $wyposarzenie['Ilosc_radio_stacji']; ?>" required><br>
    <br>
    <input type="submit" value="Aktualizuj">
    </form>
<?php
} else {
    echo "Nie znaleziono rekordu do edycji.";
}
?>

</body>
</html>
