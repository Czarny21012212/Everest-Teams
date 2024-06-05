<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "wiadomosc";

$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $idToDelete = $_POST['idToDelete'];

        if (filter_var($idToDelete, FILTER_VALIDATE_INT) === false) {
            die("Invalid ID");
        }

        mysqli_begin_transaction($conn);

        try {
            $sqlDelete = "DELETE FROM kontakt_w WHERE id_Kontakt = ?";
            $stmt = mysqli_prepare($conn, $sqlDelete);
            if (!$stmt) {
                throw new Exception(mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "i", $idToDelete);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception(mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);

            $sqlDelete = "DELETE FROM uzytkownik WHERE id_Uzytkownik = ?";
            $stmt = mysqli_prepare($conn, $sqlDelete);
            if (!$stmt) {
                throw new Exception(mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "i", $idToDelete);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception(mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);

            $sqlDelete = "DELETE FROM wiadomosc WHERE id_Wiadomosc = ?";
            $stmt = mysqli_prepare($conn, $sqlDelete);
            if (!$stmt) {
                throw new Exception(mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, "i", $idToDelete);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception(mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);

            mysqli_commit($conn);
        } catch (Exception $e) {
            mysqli_rollback($conn);
            error_log("Transaction failed: " . $e->getMessage());
        }
    }
}

$sql = "SELECT 
            u.id_Uzytkownik AS u_id_Uzytkownik, 
            u.imie AS u_imie,
            u.nazwisko AS u_nazwisko,

            k.id_Kontakt AS k_id_Kontakt,
            k.emial AS k_email,
            k.numer_telefonu AS k_numer_telefonu,

            w.id_Wiadomosc AS w_id_Wiadomosc,
            w.tytul AS w_tytul,
            w.tresc AS w_tresc

        FROM uzytkownik AS u
        JOIN kontakt_w AS k ON u.id_kontakt = k.id_Kontakt
        LEFT JOIN wiadomosc AS w ON u.id_Uzytkownik = w.id_użytkownik
        ORDER BY u.id_Uzytkownik;";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

mysqli_close($conn);
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
    .Usuwanie {
        display: flex;
        justify-content: center;
        margin-top: 10px;
        padding: 20px;
        margin-left: 50rem;
    }
    .Usuwanie input[type="text"] {
        padding: 10px;
        margin-right: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }
    .Usuwanie button {
        padding: 10px 15px;
        border-radius: 5px;
        border: none;
        background-color: red;
        color: white;
        cursor: pointer;
    }
    .Usuwanie button:hover {
        background-color: darkred;
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
                    <li><a href="http://localhost:3000/Admin/Panel.php">Dane klientów</a></li>
                    <li><a href="http://localhost:3000/Admin/Panel_w.php">Wiadomości</a></li>
                    <li class="wyloguj-sie"><a class="wyloguj-sie-a"href="http://localhost:3000/Admin/html_login.php">Wyloguj się</a></li>
                </ul>
            </div>
            <div class="container">

                <div class="table-wrapper">
                <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Email</th>
                        <th>Numer Telefonu</th>
                        <th>Tytuł</th>
                        <th colspan="2">Treść</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    foreach ($rows as $row): 
                    ?>
                    <tr>
                        <td><?php echo $row['u_id_Uzytkownik']; ?></td>
                        <td><?php echo $row['u_imie']; ?></td>
                        <td><?php echo $row['u_nazwisko']; ?></td>
                        <td><?php echo $row['k_email']; ?></td>
                        <td><?php echo $row['k_numer_telefonu']; ?></td>
                        <td><?php echo $row['w_tytul']; ?></td>
                        <td><?php echo $row['w_tresc']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                </div>
             </div>
             <form class="Usuwanie" method="POST">
                        <input type="text" name="idToDelete" placeholder="Wpisz Id do Usunięcia">
                        <button type="submit" name="delete">Usuń</button>
                    </form>
        </div>

    </div>
</body>
</html>