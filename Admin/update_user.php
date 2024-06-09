<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "test";

$conn = mysqli_connect($servername, $username, $password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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
    die("Query failed: " . mysqli_error($conn));
}

$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($conn);
?>
!
