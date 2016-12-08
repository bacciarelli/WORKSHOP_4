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
  category_id varchar(100) NOT NULL,
  PRIMARY KEY(id)),
  FOREIGN KEY(category_id) REFERENCES Categories (id)
 */

include_once 'connection.php';

class Item {

    static private $conn;
    private $id;
    private $itemName;
    private $description;
    private $price;
    private $stockQuantity;
    private $categoryId;

    static public function SetConnection($conn) {
        self::$conn = $conn;
    }

    public function __construct() {
        $this->id = -1;
        $this->itemName = "";
        $this->description = "";
        $this->price = null;
        $this->stockQuantity = null;
        $this->categoryId = null;
    }

    // getters and setters
    public function getId() {
        return $this->id;
    }

    public function getItemName() {
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

    public function getCategoryId() {
        return $this->categoryId;
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

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
        return $this;
    }

    //public methods
//    public function getPriceForQuantity($quantity) {
//        return $this->price * $quantity;
//    }

    public function saveItemToDB() {
        if ($this->id == -1) {
            $statement = self::$conn->prepare
                    ("INSERT INTO Items (item_name, description, price, stock_quantity, category_id)
                                                        VALUES (?, ?, ?. ?, ?)");
            if (!$statement) {
                return false;
            }
            $statement->bind_param('sssss', $this->itemName, $this->description, $this->price, $this->stockQuantity, $this->categoryId);
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

    public function updateItem($itemName, $description, $price, $stockQuantity, $categoryId) {
        $safeName = self::$conn->real_escape_string($itemName);
        $safeDescription = self::$conn->real_escape_string($description);
        $safePrice = self::$conn->real_escape_string($price);
        $safeStockQuantity = self::$conn->real_escape_string($stockQuantity);
        $safeCategoryId = self::$conn->real_escape_string($categoryId);

        $sql = "UPDATE Items SET item_name='$safeName', description='$safeDescription',
                                    price=$safePrice, stock_quantity=$safeStockQuantity, category_id=$safeCategoryId
                                    WHERE id=$this->id";
        if (self::$conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    static public function loadItemsByCategory($categoryId) {
        $safeCaegoryId = self::$conn->real_escape_string($categoryId);

        $sql = "SELECT * FROM Items WHERE category_id=$safeCaegoryId ";
        $result = self::$conn->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows > 0) {
            foreach ($result as $row) {
                $loadedItem = new Item();
                $loadedItem->id = $row['id'];
                $loadedItem->itemName = $row['item_name'];
                $loadedItem->price = $row['price'];
                $loadedItem->description = $row['description'];
                $loadedItem->stockQuantity = $row['stock_quantity'];
                $loadedItem->categoryId = $row['category_id'];

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
            $loadedItem->categoryId = $row['category_id'];

            return $loadedItem;
        }
        return null;
    }

    static public function loadAllItems() {
        $sql = "SELECT * FROM Items";
        $result = self::$conn->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows > 0) {
            foreach ($result as $row) {
                $loadedItem = new Item();
                $loadedItem->id = $row['id'];
                $loadedItem->itemName = $row['item_name'];
                $loadedItem->price = $row['price'];
                $loadedItem->stockQuantity = $row['stock_quantity'];
                $loadedItem->categoryId = $row['category_id'];

                $ret[$loadedItem->id] = $loadedItem;
            }
        }
    }

}