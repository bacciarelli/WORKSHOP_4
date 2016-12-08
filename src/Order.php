<?php

/*

  "create table Items_Orders(
  id int AUTO_INCREMENT NOT NULL,
  item_id int NOT NULL,
  order_id int NOT NULL,
  quantity int NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(item_id) REFERENCES Items(id),
  FOREIGN KEY(order_id) REFERENCES Orders(id))
  ENGINE=InnoDB, CHARACTER SET=utf8"
  ,
  "create table Orders(
  id int AUTO_INCREMENT NOT NULL,
  user_id int NOT NULL,
  status_id int NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(user_id) REFERENCES Users(id),
  FOREIGN KEY(status_id) REFERENCES Status(id))
  ENGINE=InnoDB, CHARACTER SET=utf8"];
 */

include_once 'connection.php';
include_once 'Item.php';

class Order {

    static private $conn;
    private $id;
    private $status;

    static public function SetConnection($conn) {
        self::$conn = $conn;
    }

    public function __construct() {
        $this->id = -1;
        $this->status = "oczekujace";
    }

    // setters and getters
    public function getId() {
        return $this->id;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    //public methods
    public function saveToDB() {
        if ($this->id == -1) {
            $sql = "INSERT INTO Orders (status) VALUES ($this->status)";
            if (self::$conn->query($sql)) {
                $this->id = self::$conn->insert_id;
                return true;
            } else {
                echo "Problem z zapytaniem: " . self::$conn->error;
                return false;
            }
        }
    }

    static public function loadOrdersByUserId($userId) {
        $safeUserId = self::$conn->real_escape_string($userId);
        $sql = "SELECT * FROM Orders
                                    JOIN Items_Orders ON Orders.id=Items_Orders.order_id
                                    JOIN Items ON Items.id = Items_Orders.item_id
                                    WHERE user_id = $safeUserId";
        $result = self::$conn->query($sql);

        $ret = [];

        if ($result != false && $result->num_rows > 0) {
            foreach ($result as $row) {
                $loadedOrder = new Order();
                $loadedOrder->id = $row['id'];
                $loadedOrder->status = $row['status_id'];

                $ret[$loadedOrder->id] = $loadedOrder;
            }
        }
        return $ret;
    }

    public function loadOrderByOrderId($orderId) {
        $safeOrderId = self::$conn->real_escape_string($orderId);
        $sql = "SELECT * FROM Orders
                                    JOIN Items_Orders ON Orders.id=Items_Orders.order_id
                                    JOIN Items ON Items.id = Items_Orders.item_id
                                    WHERE order_id = $safeOrderId";
        $result = self::$conn->query($sql);

        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedOrder = new Order();
            $loadedOrder->id = $row['id'];
            $loadedOrder->status = $row['status_id'];
            return $loadedOrder;
        }
        return false;
    }

//implementing abstract methods of Cart()
    public function getCartQuantity($itemId) {
        $sql = "SELECT quantity FROM Items_Orders WHERE item_id=$itemId";
        $result = self::$conn->query($sql);

        if ($result != false && $result == 1) {
            $row = $result->fetch_assoc();
            $quantity = $row['quantity'];
            return $quantity;
        }
        return false;
    }

    public function getCartItems() {
        $sql = "SELECT item_id, FROM Items_Orders WHERE order_id=$this->id";
        $cart = [];

        $result = self::$conn->query($sql);

        if ($result != false && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            foreach ($row as $cartItem) {
                $cartItem = new Item();
                $cartItem->loadItemById($row['item_id']);
                $cart[] = $cartItem;
            }
            return $cart;
        }
        return false;
    }

    public function calculateCartTotal() {
        $totalPrice = 0;
        $cart = $this->getCartItems();

        if ($cart != false) {
            foreach ($cart as $item) {
                $itemPrice = $item->getPrice();
                $quantity = $this->getCartQuantity($item->getId());
                $price = $itemPrice * $quantity;
                $totalPrice += $price;
            }
        }
        return $totalPrice;
    }

    public function addToCart($itemId, $orderId) {

        $sql = "INSERT INTO Items_Orders (item_id, order_id, quantity)
                                    VALUES ($itemId, $orderId, 1)";

        if ($this->loadOrderByOrderId($orderId) != false && $this->getStatus() == "oczekujace") {
            $result = self::$conn->query($sql);
            if ($result != false) {
                return true;
            } else {
                return false;
            }
        } else {
            $newOrder = new Order();
            if ($newOrder->saveToDB()) {
                $this->addToCart($itemId, $orderId);
            }
        }
    }

    public function removeFromCart($itemId) {

        $sql = "DELETE FROM Items_Orders WHERE item_id=$itemId";
    }

    public function changeCartQuantity($newQuantity, $itemId) {

        $sql = "UPDATE Items_Orders SET quantity=$newQuantity
                                     WHERE item_id = $itemId";
    }

}