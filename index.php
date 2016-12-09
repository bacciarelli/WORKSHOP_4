<?php
session_start();

include_once "./src/Item.php";
include_once "./src/Order.php";
include_once "./src/Category.php";
include_once "./src/User.php";
include_once "./src/Admin.php";
include_once "./src/connection.php";
?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <title>Candy Shop</title>
</head>
<body>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (trim($_POST['email']) == '' && trim($_POST['password']) == '') {
            echo 'Proszę wprowadzić dane użytkownika.';
        } else {
            if (User::loginUser($_POST['email'], $_POST['password']) == false) {
                print 'Niepoprawne dane użytkownika';
            } else {
                $user = User::loginUser($_POST['email'], $_POST['password']);
                $_SESSION['login'] = true;
                $_SESSION['userId'] = $user->getId();
            }
        }
    }
    if (isset($_SESSION['userId']) && $_SESSION['login'] == true) {
        $loadedUserId = $_SESSION['userId'];
        echo '<a href="./views/logout.php">Wyloguj się</a> | ';
        echo '<a href="./views/userSite.php">Twoja strona</a><br>';
        print "Witaj " . User::loadUserById($_SESSION['userId'])->getFirstName();
    } else {
        ?>
        <form action="" method="POST">
            Podaj swój e-mail: <br>
            <input type="text" name ="email"/><br>
            Podaj swoje hasło:<br>
            <input type="password" name ="password"/><br><br>
            <input type="submit" value="Zaloguj się"/>
        </form>
        <p><a href="./views/register.php">Zarejestruj się</a></p>
        <?php
    }
    ?>
    
        <h1>Karuzela</h1>
    <div class="categories">
            <?php
            $categories = Category::loadAllCategories();
            foreach ($categories as $category) {
                echo "<a href='index.php?category_id="
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
                echo "<td><a href='views/showItem.php?item_id=" . $item->getId() . "'>"
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
            echo "<td><a href='views/showItem.php?item_id=" . $item->getId() . "'>"
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

