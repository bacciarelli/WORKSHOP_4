<?php

require_once 'User.php';
require_once 'Admin.php';
require_once 'Item.php';
require_once 'Order.php';
require_once 'Category.php';
//tutaj analogicznie dajemy require_once('Klasa.php')


$configDB = array(
    'servername' => "localhost",
    'username' => "root",
    'password' => "coderslab",
    'baseName' => "internet_shop_db"
);

// Tworzymy nowe połączenie
$conn = new mysqli($configDB['servername'], $configDB['username'], $configDB['password'], $configDB['baseName']);
// Sprawdzamy czy połączcenie się udało
if ($conn->connect_error) {
    die("Polaczenie nieudane. Blad: " . $conn->connect_error . "<br>");
}

//setting connections for Models
User::SetConnection($conn);
Admin::SetConnection($conn);
//tutaj analogicznie dajemy Klasa::SetConnection($conn);
Item::SetConnection($conn);
Order::SetConnection($conn);
Category::SetConnection($conn);
?>