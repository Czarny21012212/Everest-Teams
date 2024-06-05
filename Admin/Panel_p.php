<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "test";

// Tworzenie połączenia
$conn = mysqli_connect($servername, $username, $password, $db_name);

// Sprawdzenie połączenia
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Przygotowanie zapytania
$sql = "
    SELECT * FROM (
        SELECT 
            a.id_Adres AS a_id_Adres, 
            a.miejsce_zamieszknia AS a_miejsce_zamieszknia,
            a.adres AS a_adres,
            a.kod_pocztowy AS a_kos_pocztowy,

            b.id_Biometria AS b_id_Biometria,
            b.plec AS b_plec,
            b.waga AS b_waga,
            b.wzrost AS b_wzrost,
            b.stan_zdrowia AS b_stan_zdrowia,
            b.rozmiar_buta AS b_rozmiar_buta,

            dw.id_Dane_Wrazliwe AS dw_id_Dane_Wrazliwe,
            dw.pesel AS dw_pesel,
            dw.data_urodzenia AS dw_data_urodzenia,

            k.id_Kontakt AS k_id_Kontakt,
            k.email AS k_email,
            k.numer_telefonu AS k_numer_telefonu,

            o.id_Osoba AS o_id_Osoba,
            o.Imie AS o_Imie,
            o.Nazwisko AS o_Nazwisko,

            pr.id_przewodnik,

            sz.id_szczyt AS sz_id_szczyt,
            sz.nazwa AS sz_nazwa,

            w.id_Wyposarzenie AS w_id_Wyposarzenie,
            w.Ilosc_par_butów AS w_Ilosc_par_butów,
            w.Ilosc_apteczek AS w_Ilosc_apteczek,
            w.Ilosc_plecakow AS w_Ilosc_plecakow,
            w.Ilosc_powerbank AS w_Ilosc_powerbank,
            w.Ilosc_lin_wspinaczkowych AS w_Ilosc_lin_wspinaczkowych,
            w.Ilosc_kaskow_wspinaczkowych AS w_Ilosc_kaskow_wspinaczkowych,
            w.Ilosc_zestawow_wspinaczkowych AS w_Ilosc_zestawow_wspinaczkowych,
            w.Ilosc_kuchenek_gazowych AS w_Ilosc_kuchenek_gazowych,
            w.Ilosc_rakow_snieznych AS w_Ilosc_rakow_snieznych,
            w.Ilosc_rakiet_snieznych AS w_Ilosc_rakiet_snieznych,
            w.Ilosc_radio_stacji AS w_Ilosc_radio_stacji, 
            ROW_NUMBER() OVER (ORDER BY a.id_Adres) AS rnum
        FROM adres AS a
        JOIN biometria AS b ON a.id_Adres = b.id_Biometria
        JOIN dane_wrazliwe AS dw ON a.id_Adres = dw.id_Dane_Wrazliwe
        JOIN kontakt AS k ON a.id_Adres = k.id_Kontakt
        JOIN osoba AS o ON a.id_Adres = o.id_Osoba
        JOIN przewodnik AS pr ON a.id_Adres = pr.id_przewodnik
        JOIN szczyty AS sz ON a.id_Adres = sz.id_szczyt
        JOIN wyposarzenie AS w ON a.id_Adres = w.id_Wyposarzenie
        JOIN zamowienie AS z ON a.id_Adres = z.id_Zamowienie
    ) subquery
    WHERE rnum <= 12
    ORDER BY a_id_Adres;
";

// Wykonanie zapytania
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Zamknięcie połączenia
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="icon.png">
    <title>Panel Pracownika</title>

    <style>
    body {
        background-image: url(ladne_1.png);
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        background-size: cover;
    }
    .all {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }
    .Panel {
        width: 1600px;
        border-radius: 50px;
        background-color: rgba(255, 255, 255, 0.8);
    }
    .logo {
        width: 170px;
    }
    li {
        color: white;
        text-align: center;
        list-style-type: none;
        font-size: 20px;
        font-weight: 500;
        height: 20px;
        padding: 20px;
        width: 200px;
        margin-top: 35px;
        transition: all 300ms ease-in-out;
    }
    a {
        text-decoration: none;
        color: white;
        text-align: center;
        list-style-type: none;
        font-size: 20px;
        font-weight: 500;
        height: 20px;
        padding: 20px;
        width: 200px;
        margin-top: 35px;
        transition: all 300ms ease-in-out;
    }
    a:hover {
        background-color: white;
        border-radius: 30px;
        color: black;
    }
    ul {
        display: flex;
        justify-content: space-between;
        text-align: center;
        padding: 20px;
        width: 75%;
        font-family: Verdana;
    }
    .naglowek {
        margin-top: -16px;
        height: 170px;
        width: 1600px;
        background-color: blue;
        border-radius: 50px;
    }
    .container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 20px;
        width: 1200px;
        height: 700px;
        margin-top: 0px;
        margin-left: 200px;
        margin-right: auto;
        overflow: auto;
        font-family: Verdana;
    }
    .table-wrapper {
        flex: 1 1 calc(25% - 20px);
        margin: 10px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        overflow: hidden;
        font-size: 10px;
    }
    .table-wrapper_long {
        flex: 1 1 calc(25% - 20px);
        font-size: 10px;
        margin: 10px;
        background-color: white;
        border-radius: 30px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table thead {
        background-color: blue;
        color: white;
    }
    table thead tr th {
        padding: 8px;
        text-align: left;
    }
    table tbody tr td {
        padding: 8px;
        border: 1px solid #dddddd;
    }
    table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }
    .wyloguj-sie{
        background-color: #dddddd;
        height: 1.6rem;
        padding: 20px;
        border-radius: 20px;
    }
    .wyloguj-sie-a{
        color: black;

    }
    .wyloguj-sie:hover{
        color: black;
        background-color: white;
        border-radius: 20px;
    }

    </style>
 </style>
</head>
<body>
    <div class="all">
        <div class="Panel">
            <div class="naglowek">
                <ul>
                    <img class="logo" src="logo_admin.png">
                    <li><a>Dane klientów</a></li>
                    <li><a href="http://localhost:3000/Admin/Panel_w_p.php">Wiadomości</a></li>
                    <li class="wyloguj-sie"><a class="wyloguj-sie-a"href="http://localhost:3000/Admin/html_login.php">Wyloguj się</a></li>
                </ul>
            </div>
            <div class="container">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Szczyt</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            foreach ($rows as $row): 
                            ?>
                            <tr>
                                <td><?php echo $row['sz_id_szczyt']; ?></td>
                                <td><?php echo $row['sz_nazwa']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Imie</th>
                                <th>Nazwisko</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($rows as $row): 
                            ?>
                            <tr>
                                <td><?php echo $row['o_id_Osoba']; ?></td>
                                <td><?php echo $row['o_Imie']; ?></td>
                                <td><?php echo $row['o_Nazwisko']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Miasto</th>
                                <th>Adres</th>
                                <th>Kod pocztowy</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($rows as $row): 
                            ?>
                            <tr>
                                <td><?php echo $row['a_id_Adres']; ?></td>
                                <td><?php echo $row['a_miejsce_zamieszknia']; ?></td>
                                <td><?php echo $row['a_adres']; ?></td>
                                <td><?php echo $row['a_kos_pocztowy']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Email</th>
                        <th>Telefon</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                            foreach ($rows as $row): 
                            ?>
                            <tr>
                                <td><?php echo $row['k_id_Kontakt']; ?></td>
                                <td><?php echo $row['k_email']; ?></td>
                                <td><?php echo $row['k_numer_telefonu']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Pesel</th>
                        <th>Data urodzenia</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                            foreach ($rows as $row): 
                            ?>
                            <tr>
                                <td><?php echo $row['dw_id_Dane_Wrazliwe']; ?></td>
                                <td><?php echo $row['dw_pesel']; ?></td>
                                <td><?php echo $row['dw_data_urodzenia']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>


        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Stan zdrowia</th>
                        <th>Płeć</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                            foreach ($rows as $row): 
                            ?>
                            <tr>
                                <td><?php echo $row['b_id_Biometria']; ?></td>
                                <td><?php echo $row['b_stan_zdrowia']; ?></td>
                                <td><?php echo $row['b_plec']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Waga</th>
                        <th>Wzrost</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                            foreach ($rows as $row): 
                            ?>
                            <tr>
                                <td><?php echo $row['b_id_Biometria']; ?></td>
                                <td><?php echo $row['b_waga']; ?></td>
                                <td><?php echo $row['b_wzrost']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
        <div class="table-wrapper_long">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Ilość par butów</th>
                        <th>Numer buta</th>
                        <th>Ilość apteczek</th>
                        <th>Ilość plecaków</th>
                        <th>Ilość PowerBank</th>
                        <th>Ilość lin wspinaczkowych</th>
                        <th>Ilość kasków wspinaczkowych</th>
                        <th>Ilość zestawów wspinaczkowych</th>
                        <th>Ilość kuchenek gazowych</th>
                        <th>Ilość Raków Śnieżnych</th>
                        <th>Ilość Rakiet Śnieżnych</th>
                        <th>Ilość Radio Stacji</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                            foreach ($rows as $row): 
                            ?>
                            <tr>
                                <td><?php echo $row['w_id_Wyposarzenie']; ?></td>
                                <td><?php echo $row['w_Ilosc_par_butów']; ?></td>
                                <td><?php echo $row['b_rozmiar_buta']; ?></td>

                                <td><?php echo $row['w_Ilosc_apteczek']; ?></td>
                                <td><?php echo $row['w_Ilosc_plecakow']; ?></td>
                                <td><?php echo $row['w_Ilosc_powerbank']; ?></td>
                                <td><?php echo $row['w_Ilosc_lin_wspinaczkowych']; ?></td>
                                <td><?php echo $row['w_Ilosc_kaskow_wspinaczkowych']; ?></td>
                                <td><?php echo $row['w_Ilosc_zestawow_wspinaczkowych']; ?></td>
                                <td><?php echo $row['w_Ilosc_kuchenek_gazowych']; ?></td>
                                <td><?php echo $row['w_Ilosc_rakow_snieznych']; ?></td>
                                <td><?php echo $row['w_Ilosc_rakiet_snieznych']; ?></td>
                                <td><?php echo $row['w_Ilosc_radio_stacji']; ?></td>
                                
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php mysqli_free_result($result); ?>
                
    </div>

        </div>

    </div>
</body>
</html>