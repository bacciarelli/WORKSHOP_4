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
 * 
  "create table Items(
  id int AUTO_INCREMENT NOT NULL,
  item_name varchar(255) NOT NULL UNIQUE,
  description varchar(255) NOT NULL,
  price decimal(8, 2) NOT NULL,
  stock_quantity int NOT NULL,
  group_name varchar(100) NOT NULL,
  PRIMARY KEY(id))
 */

include_once '../config/connection.php';

class Item {

    private $conn;
    private $id;
    private $itemName;
    private $description;
    private $price;
    private $stockQuantity;
    private $groupName;

    static public function SetConnection($conn) {
        self::$conn = $conn;
    }

    public function __construct() {
        $this->id = -1;
        $this->itemName = "";
        $this->description = "";
        $this->price = null;
        $this->stockQuantity = null;
        $this->groupName = "";
    }

    // getters and setters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->itemName;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getStockQuantity() {
        return $this->stockQuantity;
    }

    public function getGroup() {
        return $this->groupName;
    }

    public function setItemName($itemName) {
        $this->itemName = $itemName;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    public function setStockQuantity($stockQuantity) {
        $this->stockQuantity = $stockQuantity;
        return $this;
    }

    public function setGroupName($groupName) {
        $this->groupName = $groupName;
        return $this;
    }

    //public methods
//    public function getPriceForQuantity($quantity) {
//        return $this->price * $quantity;
//    }

    public function saveItemToDB() {
        if ($this->id == -1) {
            $statement = self::$conn->prepare
                    ("INSERT INTO Items (item_name, description, price, stock_quantity, group_name)
                                                        VALUES (?, ?, ?. ?, ?)");
            if (!$statement) {
                return false;
            }
            $statement->bind_param('sssss', $this->itemName, $this->description, $this->price, $this->stockQuantity, $this->groupName);
            if ($statement->execute()) {
                $this->id = $statement->insert_id;
                return true;
            } else {
                echo "Problem z zapytaniem: " . $statement->error;
            }
            return false;
        }
    }

    public function deleteFromDB($id) {
        $safeId = self::$conn->real_escape_string($id);
        $sql = "DELETE FROM Items WHERE id=$safeId";
        if (self::$conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateItem($itemName, $description, $price, $stockQuantity, $groupName) {
        $safeName = $connection->real_escape_string($itemName);
        $safeDescription = $connection->real_escape_string($description);
        $safePrice = $connection->real_escape_string($price);
        $safeStockQuantity = $connection->real_escape_string($stockQuantity);
        $safeGroup = $connection->real_escape_string($groupName);

        $sql = "UPDATE Items SET item_name='$safeName', description='$safeDescription',
                                    price=$safePrice, stock_quantity=$safeStockQuantity, group_name='$safeGroup'
                                    WHERE id=$this->id";
        if (self::$conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    static public function loadItemsByGroup($groupName) {
        $safeGroup = self::$conn->real_escape_string($groupName);

        $sql = "SELECT * FROM Items WHERE group_name='$safeGroup' ";
        $result = self::$conn->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows > 0) {
            foreach ($result as $row) {
                $loadedItem = new Item();
                $loadedItem->id = $row['id'];
                $loadedItem->itemName = $row['item_name'];
                $loadedItem->price = $row['price'];
                $loadedItem->stockQuantity = $row['stock_quantity'];
                $loadedItem->groupName = $row['group_name'];

                $ret[$loadedItem->id] = $loadedItem;
            }
        }
        return $ret;
    }

    static public function loadItemById($id) {
        $safeId = self::$conn->real_escape_string($id);

        $sql = "SELECT * FROM Items WHERE id=$safeId";
        $result = self::$conn->query($sql);

        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedItem = new Item();
            $loadedItem->id = $row['id'];
            $loadedItem->itemName = $row['item_name'];
            $loadedItem->price = $row['price'];
            $loadedItem->stockQuantity = $row['stock_quantity'];
            $loadedItem->groupName = $row['group_name'];

            return $loadedItem;
        }
        return null;
    }

    static public function loadAllItems() {
        $sql = "SELECT * FROM Items";
        $result = self::$conn->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows > 0) {
            $loadedItem = new Item();
            $loadedItem->id = $row['id'];
            $loadedItem->itemName = $row['item_name'];
            $loadedItem->price = $row['price'];
            $loadedItem->stockQuantity = $row['stock_quantity'];
            $loadedItem->groupName = $row['group_name'];

            $ret[$loadedItem->id] = $loadedItem;
        }
    }

}