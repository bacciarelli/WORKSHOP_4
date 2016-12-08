<?php

include_once "Item.php";
include_once "connection.php";

class Cart {
    
    static public function displayCart($cart) {
        echo "<table>";
        echo "<tr>";
        echo "<th>Nazwa produktu</th>";
        echo "<th>Cena</th>";
        echo "<th>Ilość</th>";
        echo "<th>Wartość</th>";
        echo "<tr></tr>";
        
        foreach ($cart as $id => $amount) {
            $item = Item::loadItemById($id);
            echo "<tr>";
            echo "<td>" . $item->getItemName() . "</td>";
            echo "<td>" . $item->getPrice() . "</td>";
            echo "<td>" . $amount . "</td>";
            echo "<td>" . $_SESSION['item_value'] . "</td>";
            echo "</tr>";
        }
        
        echo "<tr>";
        echo "<th>Razem</th><td></td><td></td>";
        echo "<td>" . $_SESSION['total_price'] . "</td>";
        echo "</tr>";
    }
    
}

?>