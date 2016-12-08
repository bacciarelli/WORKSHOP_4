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
    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['userId'])) {
        User::loadUserById($_GET['userId'])->deleteUser();
    }
    if (isset($_SESSION['adminId']) && $_SESSION['login'] == true) {
        echo '<a href="./logout.php">Wyloguj się</a> | ';
        echo '<a href="./panel.php">Panel główny</a> | ';
        
        print "<br>Witaj " . Admin::loadAdminById($_SESSION['adminId'])->getAdminName();
    } else {
        header('Location: ./panel.php');
    }
    ?>
    <h1>Panel admina!!:)</h1>
    <h3>Lista wszystkich użytkowników</h3>
    <?php
    $ret = User::loadAllUsers();
    foreach ($ret as $user) {
        print 'id: ' . $user->getId() . '<br>';
        print 'imię: ' . $user->getFirstName() . '<br>';
        print 'nazwisko: ' . $user->getLastName() . '<br>';
        print 'email: ' . $user->getEmail() . '<br>';
        print 'adres: ' . $user->getAddress() . '<br>';
        ?>
        <a href="./userOrders.php?userId=<?=$user->getId()?>">Zamówienia użytkownika</a><br><br>
        <a href="./usersList.php?userId=<?=$user->getId()?>">Usuń użytkownika</a><br><br><hr>
        <?php
    }
    ?>
</body>
</html>
