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

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['category_id']) && isset($_GET['delete'])) {
        Category::deleteFromDB($_GET['category_id']);
        $categories = Category::loadAllCategories();
    }
}

$categories = Category::loadAllCategories();
?>

<html>
    <head>

    </head>
    <body>
        <hr/>
        <div class="categories">
            <table>
                <?php
                foreach ($categories as $category) {
                    echo "<tr>";
                    echo "<td>" . $category->getText() . "</td>";
                    echo "<td><a href='editCategory.php?category_id=" . $category->getId() . "'>edytuj</a></td>";
                    echo "<td><a href='manageCategories.php?category_id=" . $category->getId() . "&delete=true'>usuń</a></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
    <div>
        <a href="createCategory.php">Dodaj nową kategorię</a>
    </div>
</body>
</html>

<?php
?>