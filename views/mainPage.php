<?php
session_start();

include_once "../src/Item.php";
include_once "../src/Order.php";
include_once "../src/Category.php";
include_once "../src/User.php";
include_once "../src/Admin.php";
include_once "../src/connection.php";

if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $loadedUserId = $_SESSION['user_id'];
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
        <div>
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
            echo "<td>" . $item->getPrice() . "</td>";
            echo "</tr>";
        }
    }
}

?>

            </table>
        </div>
    </body>
</html>