<?php
session_start();
require_once '../src/User.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Candy Shop</title>
</head>
<body>
    <?php
    if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
        header('Location: ../index.php');
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $userId = $_SESSION['userId'];
        $user = User::loadUserById($userId);
        switch ($_POST['submit']) {
            case "Zmień dane":

                $user->setFirstName($_POST['firstName']);
                $user->setLastName($_POST['lastName']);
                $user->setAddress($_POST['address']);

                $user->saveUserToDB();
                print "Dane użytkownika zostały zmienione";
                break;

            case "Zmień hasło":
                $oldPassword = $_POST['oldPassword'];
                $userPass = $user->getHashedPassword();
                if (!password_verify($oldPassword, $userPass)) {
                    exit("Podano złe stare hasło!<br>");
                }
                if ($_POST['newPassword'] == $_POST['newPassword2']) {
                    $user->setHashedPassword($_POST['newPassword2']);
                    $user->saveUserToDB();
                    print "Hasło zostało zmienione.";
                } else {
                    print "Powtórzono różne hasła!";
                }
                break;

            default:
                break;
        }
    }
    $user = User::loadUserById($_SESSION['userId']);
    $firstName = $user->getFirstName();
    $lastName = $user->getLastName();
    $address = $user->getAddress();
    $hashedPassword = $user->getHashedPassword();
    ?>

    <a href="./logout.php">Wyloguj się</a>
    <a href="../index.php">Strona głowna</a>

    <h2>Formularz zmiany danych użytkownika</h2>
    <form action="" method="POST">
        Zmień dane użytkownika: <br>
        <input type="text" name ="firstName" value='<?= $firstName; ?>'/><br>
        <input type="text" name ="lastName" value='<?= $lastName; ?>'/><br>
        <input type="text" name ="address" value='<?= $address; ?>'/><br>
        <input type="submit" name="submit" value="Zmień dane"/>
    </form>

    <h2>Formularz zmiany hasła użytkownika</h2>
    <form action="" method="POST">
        Podaj swoje hasło: <br>
        <input type="password" name ="oldPassword"/><br>
        Podaj nowe hasło:<br>
        <input type="password" name ="newPassword"/><br><br>
        Powtórz nowe hasło:<br>
        <input type="password" name ="newPassword2"/><br><br>
        <input type="submit" name="submit" value="Zmień hasło"/>
    </form>


</body>
</html>

