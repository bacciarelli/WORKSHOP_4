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
                echo "<a href='mainPage.php?category_id="
                . $category->getId() . "'>"
                . $category->getText() .
                " | </a>";
            }
            ?>
        </div>
        <hr/>
        <div class="random_items">
            <table>
            <?php
            if (!isset($_GET['category_id'])) {
            $randomItems = Item::loadRandomItems();
            
            foreach ($randomItems as $item) {
                echo "<tr>";
                echo "<td><a href='showItem.php?item_id=" . $item->getId() . "'>"
                . $item->getItemName() . "</a></td>";
                echo "<td>" . $item->getDescription() . "</td>";
                echo "<td>" . $item->getPrice() . " zł</td>";
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
            echo "<td><a href='showItem.php?item_id=" . $item->getId() . "'>"
            . $item->getItemName() . "</a></td>";
            echo "<td>" . $item->getDescription() . "</td>";
            echo "<td>" . $item->getPrice() . " zł</td>";
            echo "</tr>";
        }
    }
}
?>

            </table>
        </div>
    </body>
</html>