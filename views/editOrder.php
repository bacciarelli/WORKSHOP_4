<?php
session_start();
require_once '../src/User.php';
require_once '../src/Message.php';
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
    } else {
        header('Location: ./panel.php');
    }
    ?>
    <h1>Panel admina!!:)</h1>
    <h3>Edycja zamówienia</h3>
    <?php
    if (isset($_GET['orderId'])) {
        if (Order::loadOrderByOrderId($_GET['orderId']) != null) {
            $order = Order::loadOrderByOrderId($_GET['orderId']);
            $totalPrice = 0;
            print 'zamówienie nr: ' . $_GET['orderId'] . '<br>';
            $ret = Order::loadOrderStatus($_GET['orderId']);
            foreach ($ret as $order) {

            }
            print 'staus zamówienia: ' . $order['text'] . '<br>';
            $return = Item::loadItemsByOrder($_GET['orderId']);
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
            print "</ol>Całkowita cena: $totalPrice<br><br>";
        } else {
            print 'Nie ma zamówienia o takim id<br>';
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        switch ($_POST['submit']) {
            case "Zmień status":
                Order::loadOrderByOrderId($_GET['orderId'])
                        ->setStatusId($_POST['status'])->saveToDB();
                print "Status został zmieniony";
                break;

            case "Wyślij wiadomość":
                $message = new Message();
                $message->setCreationDate()->setAdminId($_SESSION['adminId'])
                        ->setUserId(Order::loadOrderByOrderId($_GET['orderId'])->getUserId())
                        ->setMessageText($_POST['text']);
                if ($message->saveMessageToDB() == true) {
                    echo 'dodano wiadomość';
                } else {
                    echo 'nie dodano wiadomości';
                }
                break;
            default:
                break;
        }
    }
    ?>

    <form action="" method="POST">
        Zmiana statusu zamówienia: <br>
        <select name="status">
            <option value="1">nieopłacone</option>
            <option value="2">opłacone</option>
            <option value="3">wysłane</option>
        </select>
        <input type="submit" name="submit" value="Zmień status"/>
    </form>

    <h2>Wyślij wiadomość</h2>
    <form action="" method="POST">
        Treść wiadomości: <br>
        <textarea name="text" rows="4" cols="50"></textarea><br>
        <input type="submit" name="submit" value="Wyślij wiadomość"/>
    </form>
    <?php ?>
</body>
</html>
