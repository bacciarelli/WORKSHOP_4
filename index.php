<?php
session_start();

require_once './src/User.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <title>Candy Shop</title>
</head>
<body>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (trim($_POST['email']) == '' && trim($_POST['password']) == '') {
            echo 'Proszę wprowadzić dane użytkownika.';
        } else {
            if (User::loginUser($_POST['email'], $_POST['password']) == false) {
                print 'Niepoprawne dane użytkownika';
            } else {
                $user = User::loginUser($_POST['email'], $_POST['password']);
                $_SESSION['login'] = true;
                $_SESSION['userId'] = $user->getId();
            }
        }
    }
    if (isset($_SESSION['userId']) && $_SESSION['login'] == true) {
        echo '<a href="./views/logout.php">Wyloguj się</a> | ';
        echo '<a href="./views/userSite.php">Twoja strona</a><br>';
        print "Witaj " . User::loadUserById($_SESSION['userId'])->getFirstName();
    } else {
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
    }
    ?>
    
        <h1>Karuzela!!:)</h1>
    
   
</body>
</html>

