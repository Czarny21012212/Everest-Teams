<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "test";


$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

ob_start();

$sql = "SELECT * FROM admin";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
    body{ 
        background-image: url(ladne_1.png);
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        background-size: cover;
        
    }
    .all{
        display: flex;
        justify-content: center;
        margin-top: 30px;
        width: 1900px;
        item-align: center;
        
    }
    .Panel{
        width:1600px;
        height:auto;
        border-radius: 50px;
        background-color: rgba(255, 255, 255, 0.8);
}

    .logo{
        width: 170px;
    }
    li{
        color:white;
        text-align: center;
        list-style-type: none;
        font-size: 20px;
        height: 20px;
        padding: 20px;
        width: 200px;
        margin-top: 35px;
        transition: all 300ms ease-in-out;
    }
    li:hover{
        background-color: white;
        border-radius: 30px;
        color: black;

    }

    ul{
        display: flex;
        justify-content: space-between;
        text-align: center;
        padding: 20px;
        width: 75%;
        font-family: Verdana;
        
    }
    .naglowek{
        margin-top: -16px;
        height:170px;
        width:1600px;
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
    .table-wrapper_long{
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

    </style>
</head>
<body>
    <div class="all">
        <div class="Panel">
            <div class="naglowek">
                <ul>
                    <img class="logo" src="logo_admin.png">
                    <li><a href="you">Dane klientów</a></li>
                    <li><a href="<?php header('Location: html_login.php');?>">Wiadomości</a></li>
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
                    <tr>
                        <th>1</th>
                        <td>Mount Everest</td>
                    </tr>

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
                    <tr>
                        <th>1</th>
                        <td>Jan</td>
                        <td>Kowalski</td>
                    </tr>
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
                    <tr>
                        <th>1</th>
                        <td>Gorzyce</td>
                        <td>ul.Przykł1</td>
                        <td>00-001</td>
                    </tr>
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
                    <tr>
                        <th>1</th>
                        <td>jan.kowalski@example.com</td>
                        <td>123456789</td>
                    </tr>
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
                    <tr>
                        <th>1</th>
                        <td>12345678901</td>
                        <td>01-01-1990</td>
                    </tr>
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
                    <tr>
                        <th>1</th>
                        <td>Dobry</td>
                        <td>M</td>
                    </tr>
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
                    <tr>
                        <th>1</th>
                        <td>70 kg</td>
                        <td>180 cm</td>
                    </tr>
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
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>42</td>
                        <td>1</td>
                        <td>3</td>
                        <td>2</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>

        </div>

    </div>
</body>
</html>
