<?php
session_start();

include_once "../src/Item.php";

if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $loadedUserId = $_SESSION['user_id'];
    //var_dump($loadedUserId);
}

