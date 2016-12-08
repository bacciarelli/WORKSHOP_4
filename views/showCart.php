<?php
session_start();

include_once "../src/Item.php";
include_once "../src/Order.php";
include_once "../src/Category.php";
include_once "../src/User.php";
include_once "../src/Cart.php";
include_once "../src/Admin.php";
include_once "../src/connection.php";

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // jeśli do strony showCart przekazujemy parametr item_id
    if (isset($_GET['item_id'])) {
        $itemId = $_GET['item_id'];

        // jeśli koszyk nie istnieje, tworzymy nowy koszyk
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
            $_SESSION['item_value'] = 0;
            $_SESSION['total_price'] = 0;
        }
        // jeśli przedmiot o przekazanym id jest w koszytku, zwiekszamy jego ilość o 1
        if (isset($_SESSION['cart'][$itemId])) {
            $_SESSION['cart'][$itemId] ++;
            // w przeciwnym wypadku, dodajemy produkt do koszyk
        } else {
            $_SESSION['cart'][$itemId] = 1;
        }
        // oblicz całkowitą wartość koszyka
        // oblicz produkty w koszyku
        $_SESSION['item_value'] = 0;
        
    } else {
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) != 0) {
            echo "Wyświetl koszyk";
            Cart::displayCart($_SESSION['cart']);
        } else {
            echo "Twój koszyk jest pusty!";
        }
    }
}


//var_dump($_SESSION['cart']);
//unset($_SESSION['cart']);
?>

<div>
    <a href="mainPage.php">Kontynuuj zakupy | </a>
    <a href="showCart.php">Koszyk</a>
</div>

