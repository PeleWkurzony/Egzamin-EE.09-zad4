<?php
    function loginExist($login) {
        $sql = "SELECT * FROM uzytkownicy WHERE login = '$login'";
        $conn = mysqli_connect('localhost', 'root', '', 'psy');
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    $mysql = new mysqli('localhost', 'root', '', 'psy');
    
    $login = $_POST['login'] ?? null;
    $password = $_POST['password'] ?? null;
    $rePassword = $_POST['rePassword'] ?? null;
    $komunikat = null;

    if (!$login || !$password || !$rePassword) {
        $komunikat = "wypełnij wszystkie pola";
        goto end;
    }
    if (loginExist($login)) {
        $komunikat = "login występuje w bazie danych, konto nie zostało dodane";
        goto end;
    }
    if ($password != $rePassword) {
        $komunikat = "hasła nie są takie same, konto nie zostało dodane";
        goto end;
    }

    $passHash = sha1($password);

    $sql = "INSERT INTO uzytkownicy (login, haslo) VALUES ('$login', '$passHash')";
    $mysql->query($sql);
    $komunikat = "Konto zostało dodane";

    $mysql->close();
    end:
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Forum o psach</title>
    <link rel="stylesheet" href="styl4.css">
</head>
<body>
    <div id="baner"> <h1> Forum wielbicieli psów </h1> </div>
    <div id="lewy">
        <img src="obraz.jpg" alt="foksterier">
    </div>
    <div id="prawyTop">
        <h2> Zapisz się </h2>
        <form method="POST">
            <div> login: <input type="text" name="login"> </div>
            <div> hasło: <input type="password" name="password"> </div>
            <div> powtórz hasło: <input type="password" name="rePassword"> </div>
            <div> <input type="submit" value="Zapisz"> </div>
        </form>
        <?php 
            if ($komunikat) {
                echo "<p> $komunikat </p>";
            }
        ?>
    </div>
    <div id="prawyBot">
        <h2> Zapraszamy wszystkich </h2>
        <ol>
            <li> właścicieli psów </li>
            <li> weterynarzy </li>
            <li> tych, co chcą kupić psa </li>
            <li> tych, co lubią psy </li>
        </ol>
        <a href="regulamin.html"> Przeczytaj regulamin forum </a>
    </div>
    <div id="stopka">
        Stronę wykonał: 00000000000
    </div>
</body>
</html>