<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="icon.png">
    <title>Logowanie</title>
</head>
<style>
body {
    background-image: url(ladne.jpg);
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    background-size: cover;
    font-family: "Roboto", sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #fff;
    overflow: hidden;
}

.login-container {
    background: rgba(255, 255, 255, 0.1);
    padding: 30px 40px;
    border-radius: 15px;
    box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    backdrop-filter: blur(10px);
    width: 300px;
    animation: fadeIn 2s ease-in-out;
}

h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #fff;
}

.input-group {
    margin-bottom: 20px;
    text-align: left;
}

label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
    color: #fff;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease-in-out;
}

input[type="text"]:focus,
input[type="password"]:focus {
    box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.3);
}

.login-button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background: linear-gradient(to right, #6DC7FF, #0099FF);
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease-in-out, transform 0.3s ease-in-out;
}

.login-button:hover {
    background: linear-gradient(to right, #0099FF, #6DC7FF);
    transform: scale(1.05);
}

@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

input[type="text"],
input[type="password"] {
    animation: glow 2s infinite alternate;
}

label {
    animation: fadeIn 1s ease-in-out;
}

.login-button {
    animation: fadeIn 2s ease-in-out, glow 2s infinite alternate;
}

.login-container:hover {
    box-shadow: 0px 4px 50px rgba(0, 0, 0, 0.3);
    transition: box-shadow 0.3s ease-in-out;
}

@keyframes slideIn {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(0);
    }
}
body {
    animation: slideIn 1s ease-in-out;
}

@media (max-width: 400px) {
    .login-container {
        width: 90%;
        padding: 20px;
    }
}

body::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,0,0,0.5) 0%, rgba(255,255,255,0.3) 40%, rgba(0,0,255,0.2) 100%);
    border-radius: 50%;
    z-index: -1;
    opacity: 0.7;
    animation: rotateBg 60s infinite linear, fadeInOut 15s infinite alternate, moveUpDown 25s infinite alternate, changeColor 20s infinite alternate, scaleBg 30s infinite alternate, flicker 2s infinite;
    mix-blend-mode: overlay;
    filter: blur(20px) brightness(130%) saturate(130%);
}

@keyframes rotateBg {
    0% {
        transform: translate(-50%, -50%) rotate(0deg);
    }
    100% {
        transform: translate(-50%, -50%) rotate(360deg);
    }
}

@keyframes fadeInOut {
    0%, 100% {
        opacity: 0.7;
    }
    50% {
        opacity: 0.9;
    }
}

@keyframes moveUpDown {
    0%, 100% {
        transform: translate(-50%, -50%) translateY(-5%);
    }
    50% {
        transform: translate(-50%, -50%) translateY(5%);
    }
}

@keyframes changeColor {
    0% {
        background-color: rgba(255,0,0,0.5);
    }
    50% {
        background-color: rgba(0,255,255,0.3);
    }
    100% {
        background-color: rgba(255,240,245, 0.5);
    }
}

@keyframes scaleBg {
    0% {
        transform: translate(-50%, -50%) scale(1);
    }
    50% {
        transform: translate(-50%, -50%) scale(1.2);
    }
    100% {
        transform: translate(-50%, -50%) scale(1);
    }
}

@keyframes flicker {
    0%, 80%, 100% {
        opacity: 0.7;
    }
    40%, 60% {
        opacity: 0.5;
    }
}

@keyframes rotateBg {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

input::placeholder {
    color: #ccc;
    font-size: 12px;
    opacity: 1; 
    font-style: italic;
}

button {
    font-family: "Roboto", sans-serif;
    font-size: 16px;
    margin: 10px;
    padding: 10px 20px;
    border: 2px solid transparent;
    border-radius: 25px;
    background-color: transparent;
    color: #0099FF;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
}

button:hover {
    background-color: #0099FF;
    color: #fff;
    transform: scale(1.1);
    border: 2px solid #fff;
}

button:focus {
    outline: none;
}

input {
    font-family: "Roboto", sans-serif;
    font-size: 14px;
    margin: 10px 0;
    padding: 10px;
    border: 2px solid #0099FF;
    border-radius: 5px;
    transition: border-color 0.3s ease-in-out;
}

input:focus {
    border-color: #0066CC;
    outline: none;
}

a {
    color: #0099FF;
    text-decoration: none;
    transition: color 0.3s ease-in-out;
}

a:hover {
    color: #0066CC;
}

.login-container::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    pointer-events: none;
}

input:disabled {
    background-color: #f0f0f0;
    border-color: #ddd;
    cursor: not-allowed;
}

button:disabled {
    background-color: #ddd;
    color: #aaa;
    cursor: not-allowed;
}

h2 {
    text-transform: uppercase;
    letter-spacing: 2px;
    animation: textGlow 2s ease-in-out infinite alternate;
}

@keyframes textGlow {
    0% {
        text-shadow: 0 0 5px rgba(255, 255, 255, 0.2);
    }
    100% {
        text-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
    }
}

.login-container {
    position: relative;
    overflow: hidden;
}

.login-container > * {
    position: relative;
    z-index:0;

}

.error-message {
    display: inline-block;
    padding: 8px 12px;
    color: #fff;
    background-color: #e74c3c;
    border-radius: 5px;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
    font-size: 14px;
    font-weight: bold;
    animation: error 3s ;
}

.error-message::before {
    content: '⚠️ ';
}

.error-message:hover {
    background-color: #c0392b;
}
@keyframes error{
    0%{
        opacity: -1.0;
    }
    30%{
        opacity: 0.1;
    }
    100%{
        opacity: 1;
    }
}


</style>
<body>
    <div class="login-container">
        <h2>Panel Admina</h2>
        <form action="login.php" method="post">
            <div class="input-group">
                <label for="username">login</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Hasło</label>
                <input type="password" id="password" name="password" required>
            </div>
            <?php
                if(isset($_SESSION['blad'])) {
                    echo  $_SESSION['blad'];
                    unset($_SESSION['blad']); 
                }
            ?>
            <button type="submit" class="login-button">Zaloguj się</button>
        </form>
    </div>
</body>
</html>