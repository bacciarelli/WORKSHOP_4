<?php
require_once("User.php");
require_once("Tweet.php");
require_once("Comment.php");
require_once("Message.php");

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
Tweet::SetConnection($conn);
Comment::SetConnection($conn);
Message::SetConnection($conn);
?>