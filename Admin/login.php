<?php
ob_start(); // Start output buffering
session_start();
require_once("Panel.php"); // Include the correct config file with database credentials

// Function to protect against XSS
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Create database connection
$polaczenie = new mysqli($servername, $username, $password, $db_name);

if ($polaczenie->connect_errno) {
    echo "Error: " . $polaczenie->connect_errno . " Description: " . $polaczenie->connect_error;
} else {
    // Get and validate form data
    $username = validate_input($_POST['username']);
    $password = validate_input($_POST['password']);

    // Use prepared statements to prevent SQL injection
    $sql_admin = $polaczenie->prepare("SELECT * FROM admin WHERE Nazwa = ? AND Haslo = ?");
    $sql_pracownik = $polaczenie->prepare("SELECT * FROM pracownicy WHERE login = ? AND password = ?");

    if ($sql_admin && $sql_pracownik) {
        $sql_admin->bind_param("ss", $username, $password);
        $sql_pracownik->bind_param("ss", $username, $password);
        
        $sql_admin->execute();
        $result_admin = $sql_admin->get_result();

        if ($result_admin && $result_admin->num_rows > 0) {
            // Successful login for admin
            $wiersz = $result_admin->fetch_assoc();
            $_SESSION['user'] = $wiersz["Nazwa"];
            unset($_SESSION['blad']);
            $result_admin->free_result();
            $sql_admin->close();
            $polaczenie->close();
            header('Location: Panel.php'); // Przekieruj do Panel.php
            exit();
        }

        $sql_pracownik->execute();
        $result_pracownik = $sql_pracownik->get_result();

        if ($result_pracownik && $result_pracownik->num_rows > 0) {
            // Successful login for pracownik
            $wiersz = $result_pracownik->fetch_assoc();
            $_SESSION['user'] = $wiersz["login"];
            unset($_SESSION['blad']);
            $result_pracownik->free_result();
            $sql_pracownik->close();
            $polaczenie->close();
            header('Location: Panel_p.php'); // Przekieruj do Panel_p.php
            exit();
        }

        // Incorrect login credentials for both admin and pracownik
        $_SESSION['blad'] = '<span class="error-message">Nieprawidłowy login lub hasło</span>';
        $sql_admin->close();
        $sql_pracownik->close();
        $polaczenie->close();
        header('Location: html_login.php');
        exit();

    } else {
        echo "Failed to prepare the SQL statements.";
        $polaczenie->close();
        exit(); // Przerwij wykonanie skryptu
    }
}

ob_end_flush(); // Flush the output buffer and send output to the browser
?>
