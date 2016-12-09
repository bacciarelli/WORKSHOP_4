<?php
session_start();

include_once "../src/Item.php";
include_once "../src/Order.php";
include_once "../src/Category.php";
include_once "../src/User.php";
include_once "../src/Cart.php";
include_once "../src/Admin.php";
include_once "../src/connection.php";

if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $loadedUserId = $_SESSION['userId'];
} else {
    echo "<br><a href='../index.php'>Zaloguj się</a>";
    exit;
}

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

        // kontynuacja zakupów - ustawienie ścieżki na ostatnio przeglądaną kategorię
        $categoryId = Item::loadItemById($itemId)->getCategoryId();
        $endpoint = "index.php?category_id=" . $categoryId;
    }

    if (isset($_SESSION['cart']) && count($_SESSION['cart']) != 0) {
        $cartContent = Cart::displayCart($_SESSION['cart']);
        $form = '<form action="createOrder.php" method="POST">
                                                <input type="submit" value="Potwierdź zamówienie">
                                         </form>';
    } else {
        echo "Twój koszyk jest pusty!";
    }

    // jeśli nie dodano produktu do koszyka, powrót do strony głównej
    $endpoint = "index.php";
}

?>
<div>
    <?php
    if (isset($cartContent)) {
        $cartContent;
    }
    ?>
</div>
<div>

    <?php
    if (isset($form)) {
        echo $form;
    }
    ?>

</div>
<div>
    <a href="<?= $endpoint ?> ">Kontynuuj zakupy | </a>
    <a href="showCart.php">Koszyk</a>
</div>

