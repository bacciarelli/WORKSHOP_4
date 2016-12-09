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
    private $statusId;
    private $userId;

    static public function SetConnection($conn) {
        self::$conn = $conn;
    }

    public function __construct($userId) {
        $this->id = -1;
        $this->statusId = 1;
        $this->setUserId($userId);
    }

    // setters and getters

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function getStatusId() {
        return $this->statusId;
    }

    public function setStatusId($statusId) {
        $this->statusId = $statusId;
        return $this;
    }

    //public methods
    public function saveToDB() {
        if ($this->id == -1) {
            $sql = "INSERT INTO Orders (user_id, status_id) VALUES ($this->userId, $this->statusId)";
            if (self::$conn->query($sql)) {
                $this->id = self::$conn->insert_id;
                return true;
            } else {
                echo "Problem z zapytaniem: " . self::$conn->error;
                return false;
            }
        } else {
            $sql = "UPDATE Orders SET status_id=$this->statusId WHERE id=$this->id";
            if (self::$conn->query($sql)) {
                $this->id = self::$conn->insert_id;
                return true;
            } else {
                echo "Problem z zapytaniem: " . self::$conn->error;
                return false;
            }
        }
    }

    public function deleteOrder() {
        $sql = "DELETE FROM Orders WHERE id = $this->id";
        $result = self::$conn->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }

    static public function loadOrderStatus($orderId) {
        $sql = "SELECT Status.text FROM Orders JOIN Status ON "
                . "Orders.status_id=Status.id WHERE Orders.id = $orderId";
        $result = self::$conn->query($sql);
        if ($result != false && $result->num_rows > 0) {
            return $result;
        } else {
            return null;
        }
    }
    
    static public function loadOrdersByUserId($userId) {
        $safeUserId = self::$conn->real_escape_string($userId);
        $sql = "SELECT Orders.id, Status.text FROM Orders JOIN Status ON "
                . "Orders.status_id=Status.id WHERE user_id = $safeUserId "
                . "ORDER BY status_id";
        $result = self::$conn->query($sql);
        if ($result != false && $result->num_rows > 0) {
            return $result;
        } else {
            return null;
        }
    }

    static public function loadOrderByOrderId($orderId) {
        $safeOrderId = self::$conn->real_escape_string($orderId);
        $sql = "SELECT * FROM Orders WHERE id = $safeOrderId";
        $result = self::$conn->query($sql);

        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedOrder = new Order($row['user_id']);
            $loadedOrder->id = $row['id'];
            $loadedOrder->statusId = $row['status_id'];
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

    public function removeFromCart($itemId) {

        $sql = "DELETE FROM Items_Orders WHERE item_id=$itemId";
    }

    public function changeCartQuantity($newQuantity, $itemId) {

        $sql = "UPDATE Items_Orders SET quantity=$newQuantity
                                     WHERE item_id = $itemId";
    }

}
