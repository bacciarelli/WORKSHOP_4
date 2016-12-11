<?php
session_start();

include_once "../src/Item.php";
include_once "../src/Order.php";
include_once "../src/User.php";
include_once "../src/Cart.php";
include_once "../src/connection.php";

if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $loadedUserId = $_SESSION['userId'];
} else {
    echo "<br><a href='../index.php'>Zaloguj się</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['confirm']) && $_POST['confirm'] === "true") {
        $newOrder = new Order($_SESSION['userId']);
        $newOrder->saveToDB();
        $orderId = $newOrder->getId();

        foreach ($_SESSION['cart'] as $itemId => $quantity) {
            Cart::addToCart($itemId, $orderId, $quantity);
        }

        unset($_SESSION['cart']);
        unset($_SESSION['item_value']);
        unset($_SESSION['total_price']);

        echo "Zamówienie zostało przyjęte<br/>";
    }

    if (isset($_SESSION['cart']) && count($_SESSION['cart']) != 0) {
        $cartContent = Cart::displayCart($_SESSION['cart']);
        echo "<hr/>";
        $user = User::loadUserById($loadedUserId);
        echo "Adres do wysyłki: " . $user->getAddress();
        echo "<hr/>";
        $form = '<form action="" method="POST">
                                    <label />Sposób płatności
                                    <input tyle="text" name="payment">
                                    <input type="checkbox" name="confirm" value="true">potwierdzam dane<br/>
                                    <input type="submit" value="Złóż zamówienie">
                                </form>';
    }
}

?>

<html>
    <head>

    </head>
    <body>
        <div>
<?php

    if (isset($form)) {
        echo $form;
    }

?>
        </div>
        <div>
            <a href='../index.php'>Powrót do strony głównej<a/>
        </div>
    </body>
</html>

