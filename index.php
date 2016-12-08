<?php
session_start();

require_once './src/User.php';
require_once './src/Admin.php';
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
        ?>
        <form action="" method="POST">
            Podaj swój e-mail: <br>
            <input type="text" name ="email"/><br>
            Podaj swoje hasło:<br>
            <input type="password" name ="password"/><br><br>
            <input type="submit" value="Zaloguj się"/>
        </form>
        <p><a href="./views/register.php">Zarejestruj się</a></p>
        <?php
    } else {
        echo '<a href="./src/logout.php">Wyloguj się</a><br><br>';
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (trim($_POST['email']) == '' && trim($_POST['password']) == '') {
            echo 'Proszę wprowadzić dane użytkownika.';
        } else {
            $email = $conn->real_escape_string($_POST['email']);
            $password = $conn->real_escape_string($_POST['password']);
            $loadedUser = User::loadUserByEmail($email);
            if ($loadedUser === null) {
                echo 'Użytkownik o podanym e-mailu nie istnieje.';
            } else {
                $hashedPassword = $loadedUser->getHashedPassword();
                if (password_verify($password, $hashedPassword) === false) {
                    echo 'Niepoprawne hasło.';
                } else {
                    $_SESSION['login'] = true;
                    $_SESSION['user_id'] = $loadedUser->getId();
                }
            }
        }
    }
    ?>


</body>
</html>

