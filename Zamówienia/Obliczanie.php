<?php
$radio = 509.99;
$quality_radio = isset($_POST["Radio"]) ? $_POST["Radio"] : 0;

$RakietyŚnieżne = 219.99;
$quality_RakietyŚnieżne = isset($_POST["RakietyŚnieżne"]) ? $_POST["RakietyŚnieżne"] : 0;

$Raki = 219.99;
$quality_Raki = isset($_POST["Raki"]) ? $_POST["Raki"] : 0;

$Kuchenka = 89.99;
$quality_Kuchenka = isset($_POST["Kuchenka"]) ? $_POST["Kuchenka"] : 0;

$Zestaw = 549.99;
$quality_Zestaw = isset($_POST["Zestaw"]) ? $_POST["Zestaw"] : 0;

$Kask = 379.99;
$quality_Kask = isset($_POST["Kask"]) ? $_POST["Kask"] : 0;

$Lina = 179.99;
$quality_Lina = isset($_POST["Lina"]) ? $_POST["Lina"] : 0;

$PowerBank = 159.99;
$quality_PowerBank = isset($_POST["PowerBank"]) ? $_POST["PowerBank"] : 0;

$Plecak = 209.99;
$quality_Plecak = isset($_POST["Plecak"]) ? $_POST["Plecak"] : 0;

$Apteczka = 89.99;
$quality_Apteczka = isset($_POST["Apteczka"]) ? $_POST["Apteczka"] : 0;

$Buty = 549.99;
$quality_Buty = isset($_POST["Buty"]) ? $_POST["Buty"] : 0;

$wynik = ($quality_radio * $radio) + ($quality_RakietyŚnieżne * $RakietyŚnieżne) + ($quality_Raki * $Raki) + ($quality_Kuchenka * $Kuchenka) + ($quality_Zestaw * $Zestaw) + ($quality_Kask * $Kask) + ($quality_Lina * $Lina) + ($quality_PowerBank * $PowerBank) + ($quality_Plecak * $Plecak) + ($quality_Apteczka * $Apteczka) + ($quality_Buty * $Buty);

if ($wynik == 0) {
    echo "<p style='color:white; font-size: 40px; text-align: center; padding: 20px; background-color: blue; font-family: inherit;'>Proszę o wypełnienie pól poprawnie.</p>";
} else {
    echo "<p style='color:white; font-size: 40px; text-align: center; padding: 20px; background-color: blue; font-family: inherit;'>Cena wyposażenia wynosi {$wynik} zł</p>";
}
?>