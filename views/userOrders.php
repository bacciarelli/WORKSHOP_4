<?php
session_start();
require_once '../src/User.php';
require_once '../src/Order.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <title>Candy Shop</title>
</head>
<body>

    <?php
    if (isset($_SESSION['adminId']) && $_SESSION['login'] == true) {
        echo '<a href="./logout.php">Wyloguj się</a> | ';
        echo '<a href="./panel.php">Panel główny</a> | ';
        echo '<a href="./usersList.php">Lista użytkowników</a> | ';

        print "<br>Witaj " . Admin::loadAdminById($_SESSION['adminId'])->getAdminName();
        
        $userEmail = User::loadUserById($_GET['userId'])->getEmail();
    } else {
        header('Location: ./panel.php');
    }
    ?>
    <h1>Panel admina!!:)</h1>
    <h3>Lista zamówień użytkownika <?=$userEmail?></h3>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['orderId'])) {
        if (Order::loadOrderByOrderId($_GET['orderId'])->deleteOrder() == true) {
            print 'usunięto zamówienie<br>';
        } else {
            print 'nie udało się usunąć zamówienia<br>';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['userId']) &&
            Order::loadOrdersByUserId($_GET['userId']) != null) {
        $ret = Order::loadOrdersByUserId($_GET['userId']);
        foreach ($ret as $order) {
            $totalPrice = 0;
            print 'zamówienie nr: ' . $order['id'] . '<br>';
            print 'staus zamówienia: ' . $order['text'] . '<br>';
            $return = Item::loadItemsByOrder($order['id']);
            $subTotal = 0;
            print "<ol>";
            foreach ($return as $item) {
                print "<li>";
                print $item['item_name'] . " opis: " . $item['description']
                        . ", cena: " . $item['price'] . ", ilość w zamówieniu: " . $item['quantity'];
                $subTotal += $item['price'] * $item['quantity'];
                print "</li>";
            }
            $totalPrice += $subTotal;
            print "</ol>Całkowita cena: $totalPrice<br>";
            ?>
            <a href="./editOrder.php?orderId=<?= $order['id'] ?>">Edytuj zamówienie/wyślij wiadomość</a><br>
            <a href="./userOrders.php?orderId=<?= $order['id'] ?>&userId=<?= $_GET['userId'] ?>">Usuń zamówienie</a><br><br><hr>
            <?php
        }
    } else {
        print "użytkownik $userEmail nie ma zamówień";
    }
    ?>
</body>
</html>
