<?php
session_start();
require_once '../src/Admin.php';
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
            echo 'Proszę wprowadzić dane administratora.';
        } else {
            if (Admin::loginAdmin($_POST['email'], $_POST['password']) == false) {
                print 'Niepoprawne dane administratora';
            } else {
                $admin = Admin::loginAdmin($_POST['email'], $_POST['password']);
                $_SESSION['login'] = true;
                $_SESSION['adminId'] = $admin->getId();
            }
        }
    }
    if (isset($_SESSION['adminId']) && $_SESSION['login'] == true) {
        echo '<a href="./logout.php">Wyloguj się</a> | ';
        echo '<a href="./usersList.php">Lista użytkowników</a> | ';
        echo '<a href="./views/logout.php">Wyloguj się</a> | ';
        echo '<a href="./views/logout.php">Wyloguj się</a> | ';
        
        print "<br>Witaj " . Admin::loadAdminById($_SESSION['adminId'])->getAdminName();
    } else {
        ?>
        <form action="" method="POST">
            Podaj swój e-mail: <br>
            <input type="text" name ="email"/><br>
            Podaj swoje hasło:<br>
            <input type="password" name ="password"/><br><br>
            <input type="submit" value="Zaloguj się"/>
        </form>
        <?php
    }
    ?>
    <h1>Panel admina!!:)</h1>
    
</body>
</html>
