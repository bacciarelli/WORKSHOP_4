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

echo "<hr>";

$categories = Category::loadAllCategories();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['item_name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['stock_quantity']) && isset($_POST['category_id'])) {
        $newItem = new Item();
        $newItem->setItemName($_POST['item_name']);
        $newItem->setDescription($_POST['description']);
        $newItem->setPrice($_POST['price']);
        $newItem->setStockQuantity($_POST['stock_quantity']);
        $newItem->setCategoryId($_POST['category_id']);

        if ($newItem->saveItemToDB()) {
            echo "Dodano przedmiot do bazy danych";
        }
    } else {
        echo "Uzupełnij informacje";
    }
}
?>

<html>
    <head>

    </head>
    <body>
        <div>
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
                <input type="submit" value="Dodaj przedmiot">
            </form>
        </div>
        <div>
            <a href="manageItems.php">Powrót do listy</a>
        </div>
    </body>
</html>