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
        
        print "<br>Witaj " . Admin::loadAdminById($_SESSION['adminId'])->getAdminName();
    } else {
        header('Location: ./panel.php');
    }
    ?>
    <h1>Panel admina</h1>
    <h3>Lista wszystkich użytkowników</h3>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['orderId'])) {
        if (Order::loadOrderByOrderId($_GET['orderId'])->deleteOrder() == true) {
            print 'usunięto zamówienie<br>';
        } else {
            print 'nie udało się usunąć zamówienia<br>';
        }
    }
    $ret = Order::loadAllOrders();
    foreach ($ret as $order) {
       $totalPrice = 0;
            print 'zamówienie nr: ' . $order->getId() . '<br>';
            print 'staus zamówienia: ' . Order::loadOrderStatus($order->getUserId()) . '<br>';
            $return = Item::loadItemsByOrder($order->getId());
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
            <a href="./editOrder.php?orderId=<?= $order->getId() ?>">Edytuj zamówienie/wyślij wiadomość</a><br>
            <a href="./ordersList.php?orderId=<?= $order->getId() ?>">Usuń zamówienie</a><br><br><hr>
            <?php
    }
    ?>
</body>
</html>
