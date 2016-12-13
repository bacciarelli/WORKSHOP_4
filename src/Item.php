<?php

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

    public function saveItemToDB() {
        if ($this->id == -1) {
            $statement = self::$conn->prepare
                    ("INSERT INTO Items (item_name, description, price, stock_quantity, category_id)
                                                        VALUES (?, ?, ?, ?, ?)");
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

    static public function deleteFromDB($id) {
        $safeId = self::$conn->real_escape_string($id);
        $sql = "DELETE FROM Items WHERE id=$safeId";
        if (self::$conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateItem() {
        $safeName = self::$conn->real_escape_string($this->itemName);
        $safeDescription = self::$conn->real_escape_string($this->description);
        $safePrice = self::$conn->real_escape_string($this->price);
        $safeStockQuantity = self::$conn->real_escape_string($this->stockQuantity);
        $safeCategoryId = self::$conn->real_escape_string($this->categoryId);

        $sql = "UPDATE Items SET item_name='$safeName', description='$safeDescription',
                                    price='$safePrice', stock_quantity='$safeStockQuantity', category_id='$safeCategoryId'
                                    WHERE id=$this->id";
        if (self::$conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    static public function loadItemsByOrder($orderId) {
        $safeOrderId = self::$conn->real_escape_string($orderId);

        $sql = "SELECT Items.item_name, Items.description, Items.price, "
                . "Items_Orders.quantity FROM Items JOIN Items_Orders ON "
                . "Items.id=Items_Orders.item_id WHERE order_id=$safeOrderId";
        $result = self::$conn->query($sql);
        if ($result != false && $result->num_rows > 0) {
            return $result;
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
            $loadedItem->description = $row['description'];
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
                $loadedItem->description = $row['description'];
                $loadedItem->stockQuantity = $row['stock_quantity'];
                $loadedItem->categoryId = $row['category_id'];

                $ret[$loadedItem->id] = $loadedItem;
            }
        }
        return $ret;
    }

    static public function loadRandomItems() {
        $sql = "SELECT * FROM Items WHERE id >= (SELECT FLOOR( MAX(id) * RAND()) FROM Items ) ORDER BY id LIMIT 10";
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

}