-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 04, 2024 at 03:39 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `Nazwa` varchar(55) NOT NULL,
  `Haslo` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `Nazwa`, `Haslo`) VALUES
(1, 'Admin123', '1234');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `adres`
--

CREATE TABLE `adres` (
  `id_Adres` int(11) NOT NULL,
  `miejsce_zamieszknia` varchar(55) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `adres` varchar(55) CHARACTER SET ucs2 COLLATE ucs2_polish_ci NOT NULL,
  `kod_pocztowy` varchar(55) CHARACTER SET ucs2 COLLATE ucs2_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `adres`
--

INSERT INTO `adres` (`id_Adres`, `miejsce_zamieszknia`, `adres`, `kod_pocztowy`) VALUES
(5, 'Gorzyce', 'Orliska 4', '29-432');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `biometria`
--

CREATE TABLE `biometria` (
  `id_Biometria` int(11) NOT NULL,
  `plec` enum('Kobieta','Mezczyzna') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `waga` float NOT NULL,
  `wzrost` float NOT NULL,
  `stan_zdrowia` enum('Dobry','Sredni','Zly') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `rozmiar_buta` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `biometria`
--

INSERT INTO `biometria` (`id_Biometria`, `plec`, `waga`, `wzrost`, `stan_zdrowia`, `rozmiar_buta`) VALUES
(5, 'Kobieta', 70, 180, 'Dobry', 39);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dane_wrazliwe`
--

CREATE TABLE `dane_wrazliwe` (
  `id_Dane_Wrazliwe` int(11) NOT NULL,
  `pesel` varchar(11) CHARACTER SET ucs2 COLLATE ucs2_polish_ci NOT NULL,
  `data_urodzenia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dane_wrazliwe`
--

INSERT INTO `dane_wrazliwe` (`id_Dane_Wrazliwe`, `pesel`, `data_urodzenia`) VALUES
(5, '12312312312', '1975-11-01');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kontakt`
--

CREATE TABLE `kontakt` (
  `id_Kontakt` int(11) NOT NULL,
  `email` varchar(55) CHARACTER SET ucs2 COLLATE ucs2_polish_ci NOT NULL,
  `numer_telefonu` varchar(15) CHARACTER SET ucs2 COLLATE ucs2_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kontakt`
--

INSERT INTO `kontakt` (`id_Kontakt`, `email`, `numer_telefonu`) VALUES
(5, 'wiktorstachula20@gmail.com', '432432432');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `osoba`
--

CREATE TABLE `osoba` (
  `id_Osoba` int(11) NOT NULL,
  `Imie` varchar(55) CHARACTER SET ucs2 COLLATE ucs2_polish_ci NOT NULL,
  `Nazwisko` varchar(55) CHARACTER SET ucs2 COLLATE ucs2_polish_ci NOT NULL,
  `id_kontaktu` int(11) NOT NULL,
  `id_biometrii` int(11) NOT NULL,
  `id_danych` int(11) NOT NULL,
  `id_adres` int(11) NOT NULL,
  `id_wyposarzenie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `osoba`
--

INSERT INTO `osoba` (`id_Osoba`, `Imie`, `Nazwisko`, `id_kontaktu`, `id_biometrii`, `id_danych`, `id_adres`, `id_wyposarzenie`) VALUES
(5, 'Wiktor', 'Stachula', 5, 5, 5, 5, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id_pracownicy` int(11) NOT NULL,
  `login` varchar(55) NOT NULL,
  `password` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_polish_ci;

--
-- Dumping data for table `pracownicy`
--

INSERT INTO `pracownicy` (`id_pracownicy`, `login`, `password`) VALUES
(1, 'pracownicy123', '1234');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przewodnik`
--

CREATE TABLE `przewodnik` (
  `id_przewodnik` int(11) NOT NULL,
  `imie` varchar(20) NOT NULL,
  `nazwisko` varchar(20) NOT NULL,
  `Wiek` varchar(20) NOT NULL,
  `Wykształcenie` varchar(55) NOT NULL,
  `data_wycieczki` date NOT NULL,
  `id_szczyt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `przewodnik`
--

INSERT INTO `przewodnik` (`id_przewodnik`, `imie`, `nazwisko`, `Wiek`, `Wykształcenie`, `data_wycieczki`, `id_szczyt`) VALUES
(5, 'Szymon', 'Niewidek', '29', 'wspinaczkowe', '0000-00-00', 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczyty`
--

CREATE TABLE `szczyty` (
  `id_Szczyt` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `szczyty`
--

INSERT INTO `szczyty` (`id_Szczyt`, `nazwa`) VALUES
(5, 'K2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wyposarzenie`
--

CREATE TABLE `wyposarzenie` (
  `id_Wyposarzenie` int(11) NOT NULL,
  `Ilosc_par_butów` int(5) NOT NULL,
  `Ilosc_apteczek` int(5) NOT NULL,
  `Ilosc_plecakow` int(5) NOT NULL,
  `Ilosc_powerbank` int(5) NOT NULL,
  `Ilosc_lin_wspinaczkowych` int(5) NOT NULL,
  `Ilosc_kaskow_wspinaczkowych` int(5) NOT NULL,
  `Ilosc_zestawow_wspinaczkowych` int(5) NOT NULL,
  `Ilosc_kuchenek_gazowych` int(5) NOT NULL,
  `Ilosc_rakow_snieznych` int(5) NOT NULL,
  `Ilosc_rakiet_snieznych` int(5) NOT NULL,
  `Ilosc_radio_stacji` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wyposarzenie`
--

INSERT INTO `wyposarzenie` (`id_Wyposarzenie`, `Ilosc_par_butów`, `Ilosc_apteczek`, `Ilosc_plecakow`, `Ilosc_powerbank`, `Ilosc_lin_wspinaczkowych`, `Ilosc_kaskow_wspinaczkowych`, `Ilosc_zestawow_wspinaczkowych`, `Ilosc_kuchenek_gazowych`, `Ilosc_rakow_snieznych`, `Ilosc_rakiet_snieznych`, `Ilosc_radio_stacji`) VALUES
(5, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienie`
--

CREATE TABLE `zamowienie` (
  `id_Zamowienie` int(11) NOT NULL,
  `data_wycieczki` date NOT NULL,
  `status` varchar(55) CHARACTER SET ucs2 COLLATE ucs2_polish_ci NOT NULL,
  `id_szczyt` int(11) DEFAULT NULL,
  `id_osoba` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `zamowienie`
--

INSERT INTO `zamowienie` (`id_Zamowienie`, `data_wycieczki`, `status`, `id_szczyt`, `id_osoba`) VALUES
(5, '0000-00-00', '', 5, 5);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeksy dla tabeli `adres`
--
ALTER TABLE `adres`
  ADD PRIMARY KEY (`id_Adres`);

--
-- Indeksy dla tabeli `biometria`
--
ALTER TABLE `biometria`
  ADD PRIMARY KEY (`id_Biometria`);

--
-- Indeksy dla tabeli `dane_wrazliwe`
--
ALTER TABLE `dane_wrazliwe`
  ADD PRIMARY KEY (`id_Dane_Wrazliwe`);

--
-- Indeksy dla tabeli `kontakt`
--
ALTER TABLE `kontakt`
  ADD PRIMARY KEY (`id_Kontakt`);

--
-- Indeksy dla tabeli `osoba`
--
ALTER TABLE `osoba`
  ADD PRIMARY KEY (`id_Osoba`),
  ADD UNIQUE KEY `id_kontaktu_2` (`id_kontaktu`),
  ADD UNIQUE KEY `id_biometrii` (`id_biometrii`),
  ADD UNIQUE KEY `id_wyposarzenie_2` (`id_wyposarzenie`),
  ADD UNIQUE KEY `id_adres_2` (`id_adres`),
  ADD UNIQUE KEY `id_danych` (`id_danych`),
  ADD KEY `id_kontaktu` (`id_kontaktu`,`id_biometrii`,`id_danych`),
  ADD KEY `id_adres` (`id_adres`),
  ADD KEY `id_wyposarzenie` (`id_wyposarzenie`);

--
-- Indeksy dla tabeli `przewodnik`
--
ALTER TABLE `przewodnik`
  ADD PRIMARY KEY (`id_przewodnik`),
  ADD KEY `fk_przewodnik_szczyt` (`id_szczyt`);

--
-- Indeksy dla tabeli `szczyty`
--
ALTER TABLE `szczyty`
  ADD PRIMARY KEY (`id_Szczyt`);

--
-- Indeksy dla tabeli `wyposarzenie`
--
ALTER TABLE `wyposarzenie`
  ADD PRIMARY KEY (`id_Wyposarzenie`);

--
-- Indeksy dla tabeli `zamowienie`
--
ALTER TABLE `zamowienie`
  ADD PRIMARY KEY (`id_Zamowienie`),
  ADD KEY `id_szczyt` (`id_szczyt`),
  ADD KEY `id_osoba` (`id_osoba`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adres`
--
ALTER TABLE `adres`
  MODIFY `id_Adres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `biometria`
--
ALTER TABLE `biometria`
  MODIFY `id_Biometria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dane_wrazliwe`
--
ALTER TABLE `dane_wrazliwe`
  MODIFY `id_Dane_Wrazliwe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kontakt`
--
ALTER TABLE `kontakt`
  MODIFY `id_Kontakt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `osoba`
--
ALTER TABLE `osoba`
  MODIFY `id_Osoba` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `przewodnik`
--
ALTER TABLE `przewodnik`
  MODIFY `id_przewodnik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `szczyty`
--
ALTER TABLE `szczyty`
  MODIFY `id_Szczyt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wyposarzenie`
--
ALTER TABLE `wyposarzenie`
  MODIFY `id_Wyposarzenie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `zamowienie`
--
ALTER TABLE `zamowienie`
  MODIFY `id_Zamowienie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `osoba`
--
ALTER TABLE `osoba`
  ADD CONSTRAINT `osoba_ibfk_1` FOREIGN KEY (`id_biometrii`) REFERENCES `biometria` (`id_Biometria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `osoba_ibfk_2` FOREIGN KEY (`id_kontaktu`) REFERENCES `kontakt` (`id_Kontakt`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `osoba_ibfk_3` FOREIGN KEY (`id_danych`) REFERENCES `dane_wrazliwe` (`id_Dane_Wrazliwe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `osoba_ibfk_4` FOREIGN KEY (`id_adres`) REFERENCES `adres` (`id_Adres`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `osoba_ibfk_5` FOREIGN KEY (`id_wyposarzenie`) REFERENCES `wyposarzenie` (`id_Wyposarzenie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `przewodnik`
--
ALTER TABLE `przewodnik`
  ADD CONSTRAINT `fk_przewodnik_szczyt` FOREIGN KEY (`id_szczyt`) REFERENCES `szczyty` (`id_szczyt`);

--
-- Constraints for table `zamowienie`
--
ALTER TABLE `zamowienie`
  ADD CONSTRAINT `zamowienie_ibfk_1` FOREIGN KEY (`id_szczyt`) REFERENCES `szczyty` (`id_szczyt`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zamowienie_ibfk_2` FOREIGN KEY (`id_osoba`) REFERENCES `osoba` (`id_Osoba`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
