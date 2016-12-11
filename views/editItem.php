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
} else {
    header('Location: ./panel.php');
}

$categories = Category::loadAllCategories();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $item = Item::loadItemById($_GET['item_id']);

    if (!empty($_POST['item_name'])) {
        $item->setItemName($_POST['item_name']);
    }

    if (!empty($_POST['description'])) {
        $item->setDescription($_POST['description']);
    }

    if (!empty($_POST['price'])) {
        $item->setPrice($_POST['price']);
    }

    if (!empty($_POST['stock_quantity'])) {
        $item->setStockQuantity($_POST['stock_quantity']);
    }

    if (!empty($_POST['category_id'])) {
        $item->setCategoryId($_POST['category_id']);
    }

    $item->updateItem();

    if ($item->updateItem()) {
        echo "Informacje o przedmiocie zostały zaktualizowane!";
    } else {
        echo "Błąd";
    }
}
?>

<html>
    <head>

    </head>
    <body>
        <hr/>
        <div>
            <div class="items">
                <table>

<?php
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['item_id'])) {
        $itemId = $_GET['item_id'];
        $item = Item::loadItemById($itemId);

        echo "<tr>";
        echo "<th>" . $item->getItemName() . "</th>";
        echo "<td>" . $item->getDescription() . "</td>";
        echo "<td>" . $item->getPrice() . " zł</td>";
        echo "</tr>";
    }
}
?>

                </table>
            </div>
            <hr/>
            <form action="" method="POST">
                <label>Nazwa przedmiotu</label>
                <input type="text" name="item_name"><br/>
                <label>Opis</label>
                <textarea name="description"></textarea><br/>
                <label>Cena</label>
                <input type="number" name="price" step="0.01"><br/>
                <label>Ilość w magazynie</label>
                <input type="number" name="stock_quantity"><br/>
                <label>Kategoria</label>
                <select name="category_id">
<?php
foreach ($categories as $category) {
    echo "<option value='"
    . $category->getId() . "'>"
    . $category->getText() .
    "</option>";
}
?>
                </select><br/>
                <input type="submit" name="submit" value="Aktualizuj przedmiot">
            </form>
        </div>
        <div>
            <a href="manageItems.php">Powrót do listy</a>
        </div>
    </body>
</html>