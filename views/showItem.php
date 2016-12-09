<?php
session_start();

include_once "../src/Item.php";
include_once "../src/Order.php";
include_once "../src/Category.php";
include_once "../src/User.php";
include_once "../src/Admin.php";
include_once "../src/connection.php";

if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $loadedUserId = $_SESSION['userId'];
} else {
    echo "<br><a href='../index.php'>Zaloguj się</a>";
    exit;
}
?>

<html>
    <head>

    </head>
    <body>
        <div class="items">
            <table>

<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['item_id'])) {
        $itemId = $_GET['item_id'];
        $item = Item::loadItemById($itemId);

        echo "<tr>";
        echo "<td>" . $item->getItemName() . "</td>";
        echo "<td>" . $item->getDescription() . "</td>";
        echo "<td>" . $item->getPrice() . " zł</td>";
        echo "<td><a href='showCart.php?item_id=" . $itemId . "'>Dodaj do koszyka</a></td>";
        echo "</tr>";
    }
}

?>

            </table>
        </div>
        <div>
            <a href="../index.php?category_id=<?= $item->getCategoryId() ?>">Powrót do listy | </a>
            <a href="showCart.php">Koszyk</a>
        </div>
    </body>
</html>

