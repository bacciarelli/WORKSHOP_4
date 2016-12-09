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

echo "<hr>";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!empty($_POST['text'])) {
        $newCategory = new Category();
        $newCategory->setText($_POST['text']);

        if ($newCategory->saveCategoryToDB()) {
            echo "Dodano kategorię do bazy danych";
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
                <label>Nazwa kategorii</label>
                <input type="text" name="text"><br/>
                <input type="submit" value="Dodaj kategorię">
            </form>
        </div>
        <div>
            <a href="manageCategories.php">Powrót do listy kategorii</a>
        </div>
    </body>
</html>