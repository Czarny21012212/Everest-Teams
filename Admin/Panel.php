<?php
$id_update = null;
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_update"])) {
    $id_update = $_GET["id_update"];
}

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "test";

$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}


if($id_update !== null) { 
    $sql = "SELECT * FROM twoja_tabela WHERE id = $id_update";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query Failed: " . mysqli_error($conn));
    }

    // Sprawdz czy znaleziono rekar 
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $imie = $row['imie'];
        $nazwisko = $row['nazwisko'];

    } else {
        echo "Nie znaleziono rekordu do edycji";
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $idToDelete = $_POST['idToDelete'];
        
        mysqli_begin_transaction($conn);
        
        try {
            $sqlDelete = "DELETE FROM adres WHERE id_Adres = ?";
            $stmt = mysqli_prepare($conn, $sqlDelete);
            mysqli_stmt_bind_param($stmt, "i", $idToDelete);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            $sqlDelete = "DELETE FROM biometria WHERE id_Biometria = ?";
            $stmt = mysqli_prepare($conn, $sqlDelete);
            mysqli_stmt_bind_param($stmt, "i", $idToDelete);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $sqlDelete = "DELETE FROM dane_wrazliwe WHERE id_Dane_Wrazliwe = ?";
            $stmt = mysqli_prepare($conn, $sqlDelete);
            mysqli_stmt_bind_param($stmt, "i", $idToDelete);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $sqlDelete = "DELETE FROM kontakt WHERE id_Kontakt = ?";
            $stmt = mysqli_prepare($conn, $sqlDelete);
            mysqli_stmt_bind_param($stmt, "i", $idToDelete);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $sqlDelete = "DELETE FROM osoba WHERE id_Osoba = ?";
            $stmt = mysqli_prepare($conn, $sqlDelete);
            mysqli_stmt_bind_param($stmt, "i", $idToDelete);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $sqlDelete = "DELETE FROM przewodnik WHERE id_przewodnik = ?";
            $stmt = mysqli_prepare($conn, $sqlDelete);
            mysqli_stmt_bind_param($stmt, "i", $idToDelete);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $sqlDelete = "DELETE FROM szczyty WHERE id_szczyt = ?";
            $stmt = mysqli_prepare($conn, $sqlDelete);
            mysqli_stmt_bind_param($stmt, "i", $idToDelete);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $sqlDelete = "DELETE FROM wyposarzenie WHERE id_Wyposarzenie = ?";
            $stmt = mysqli_prepare($conn, $sqlDelete);
            mysqli_stmt_bind_param($stmt, "i", $idToDelete);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            mysqli_commit($conn);
        } catch (Exception $e) {
            mysqli_rollback($conn);
        }
    }
}

$sql = "SELECT * FROM (
    SELECT 
        a.id_Adres AS a_id_Adres, 
        a.miejsce_zamieszknia AS a_miejsce_zamieszkania,
        a.adres AS a_adres,
        a.kod_pocztowy AS a_kod_pocztowy,

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

        pr.id_przewodnik AS pr_id_przewodnik,

        sz.id_szczyt AS sz_id_szczyt,
        sz.nazwa AS sz_nazwa,

        w.id_Wyposarzenie AS w_id_Wyposarzenie,
        w.Ilosc_par_butów AS w_Ilosc_par_butow,
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
) subquery
WHERE rnum <= 12
ORDER BY a_id_Adres;";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="icon.png">
    <title>Panel Admina</title>

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
        height: auto;
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
        height: 750px;
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

.Usuwanie {
    margin: 20px auto;
    padding: 20px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}


.Usuwanie label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #333;
}
.Usuwanie input[type="text"] {
    display: block;
    width: calc(100% - 20px); 
    padding: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}


.Usuwanie button[type="submit"] {
    display: block;
    width: calc(100% - 20px); 
    padding: 10px;
    background-color: #f44336; 
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}
.Usuwanie button[type="submit"]:hover {
    background-color: #d32f2f; 
}


    .wyloguj-sie{
        background-color: rgba(255, 255, 255, 1);
        background-image: linear-gradient(114deg, rgba(255, 255, 255, 1) 0%, rgba(209, 215, 255, 1) 100%);
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

.Edytowanie {
    margin-top: -200px;
    margin: 20px auto;
    padding: 20px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}


.Edytowanie label {
    font-weight: bold;
    margin-bottom: 10px;
    color: #333; 
}

.Edytowanie input[type="text"] {
    width: calc(100% - 20px); 
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 16px;
}


.Edytowanie input[type="submit"] {
    width: calc(100% - 20px); 
    padding: 12px;
    border: none;
    border-radius: 3px;
    background-color: #4CAF50; 
    color: white;
    cursor: pointer;
    font-size: 16px;
}

.Edytowanie input[type="submit"]:hover {
    background-color: #45a049; 
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
                    <li><a href="http://localhost:3000/Admin/Panel_w.php">Wiadomości</a></li>
                    <li class="wyloguj-sie"><a class="wyloguj-sie-a"href="http://localhost:3000/Admin/html_login.php">Wyloguj się</a></li>
                </ul>
            </div>
            <div class="container">
                <!-- Tabela 1 -->
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

                <!-- Tabela 2 -->
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

                <!-- Tabela 3 -->
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
                                <td><?php echo $row['a_miejsce_zamieszkania']; ?></td>
                                <td><?php echo $row['a_adres']; ?></td>
                                <td><?php echo $row['a_kod_pocztowy']; ?></td>
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
                                <td><?php echo $row['w_Ilosc_par_butow']; ?></td>
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
            <form class="Usuwanie" method="POST">
                        <input type="text" name="idToDelete" placeholder="Wpisz Id do Usunięcia">
                        <button type="submit" name="delete">Usuń</button>
                    </form>
                    
                    <form class="Edytowanie" method="GET" action="edit_user.php">
                        <input type="text" name="id_update" id="id_update"  placeholder="ID użytkownika do edycji">
                        <input type="submit" value="Edytuj">
                    </form>
</form>

    </div>
</body>
</html>