<?php
session_start();

include_once "../src/Item.php";
include_once "../src/Order.php";
include_once "../src/Category.php";
include_once "../src/User.php";
include_once "../src/Admin.php";
include_once "../src/connection.php";

if (isset($_SESSION['adminId']) && $_SESSION['login'] == true) {
    echo '<a href="./logout.php">Wyloguj się</a> | ';
    echo '<a href="./panel.php">Panel główny</a> | ';
    echo '<a href="./usersList.php">Lista użytkowników</a> | ';

    print "<br>Witaj " . Admin::loadAdminById($_SESSION['adminId'])->getAdminName();
} else {
    header('Location: ./panel.php');
}

$categories = Category::loadAllCategories();
?>

<html>
    <head>

    </head>
    <body>
        <div class="categories">
            <?php
            foreach ($categories as $category) {
                echo "<a href='manageItems.php?category_id="
                . $category->getId() . "'>"
                . $category->getText() .
                " | </a>";
            }
            ?>
        </div>
        <hr/>
        <div class="all_items">
            <table>
                <?php
                if (!isset($_GET['category_id'])) {
                    $allItems = Item::loadAllItems();

                    foreach ($allItems as $item) {
                        echo "<tr>";
                        echo "<td>" . $item->getItemName() . "</td>";
                        echo "<td>" . $item->getDescription() . "</td>";
                        echo "<td>" . $item->getPrice() . " zł</td>";
                        echo "<td><a href='editItem.php?item_id=" . $item->getId() . "'>edytuj</a></td>";
                        echo "<td><a href='manageItems.php?item_id=" . $item->getId() . "&delete=true'>usuń</a></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </div>
        <hr/>
        <div class="items">
            <table>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == "GET") {
                    if (isset($_GET['category_id'])) {
                        $categoryId = $_GET['category_id'];
                        $items = Item::loadItemsByCategory($categoryId);

                        foreach ($items as $item) {
                            echo "<tr>";
                            echo "<td>" . $item->getItemName() . "</td>";
                            echo "<td>" . $item->getDescription() . "</td>";
                            echo "<td>" . $item->getPrice() . " zł</td>";
                            echo "<td><a href='editItem.php?item_id=" . $item->getId() . "'>edytuj</a></td>";
                            echo "<td><a href='manageItems.php?item_id=" . $item->getId() . "&delete=true'>usuń</a></td>";
                            echo "</tr>";
                        }
                    }
                }
                ?>

            </table>
        </div>
        <div>
            <a href="createItem.php">Dodaj nowy przedmiot</a>
        </div>
    </body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['item_id']) && isset($_GET['delete'])) {
        Item::deleteFromDB($_GET['item_id']);
        $allItems = Item::loadAllItems();
    }
}

?>