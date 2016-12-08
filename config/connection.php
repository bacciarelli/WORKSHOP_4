<?php
use src\User;
use src\Order;
use src\Item;
//tutaj analogicznie dajemy require_once('Klasa.php')


$configDB = array(
    'servername' => "localhost",
    'username' => "internet_shop",
    'password' => "coderslab",
    'baseName' => "internet_shop_db"
);

// Tworzymy nowe połączenie
$conn = new mysqli($configDB['servername'], $configDB['username'], $configDB['password'], $configDB['baseName']);
// Sprawdzamy czy połączcenie się udało
if ($conn->connect_error) {
    die("Polaczenie nieudane. Blad: " . $conn->connect_error."<br>");
}


//setting connections for Models
User::SetConnection($conn);
//tutaj analogicznie dajemy Klasa::SetConnection($conn);
Item::SetConnection($conn);
Order::SetConnection($conn);
?>