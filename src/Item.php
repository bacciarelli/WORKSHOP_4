<?php

/*
  CREATE TABLE Items(
  id int AUTO_INCREMENT NOT NULL,
  name varchar(255) NOT NULL UNIQUE,
  description varchar(255) NOT NULL,
  price decimal(8, 2) NOT NULL,
  stock_quantity int NOT NULL,
  group varchar(25),
  PRIMARY KEY(id)
  );

  CREATE TABLE Images(
  id int AUTO_INCREMENT NOT NULL,
  item_id int NOT NULL,
  path varchar(255) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(item_id) REFERENCES Items(id)
  );
 */

class Item {

    private $id;
    private $name;
    private $description;
    private $price;
    private $stockQuantity;
    private $group;

    public function __construct() {
        $this->id = -1;
        $this->name = "";
        $this->description = "";
        $this->price = null;
        $this->stockQuantity = null;
        $this->group = "";
    }

    // getters and setters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
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
        return $this->group;
    }

    public function setName($name) {
        $this->name = $name;
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

    public function setGroup($group) {
        $this->group = $group;
        return $this;
    }

    //public methods
    
//    public function getPriceForQuantity($quantity) {
//        return $this->price * $quantity;
//    }
    
    public function saveToDB(mysqli $connection) {
        if ($this->id == -1) {
            $statement = $connection->prepare
                    ("INSERT INTO Items (name, description, price, stock_quantity, group)
                                                        VALUES (?, ?, ?. ?, ?)");
            if (!$statement) {
                return false;
            }
            $statement->bind_param('sssss', $this->name, $this->description, $this->price, $this->stockQuantity, $this->group);
            if ($statement->execute()) {
                $this->id = $statement->insert_id;
                return true;
            } else {
                echo "Problem z zapytaniem: " . $statement->error;
            }
            return false;
        }
    }

    public function deleteFromDB(mysqli $connection, $id) {
        $safeId = $connection->real_escape_string($id);
        $sql = "DELETE FROM Items WHERE id=$safeId";
        if ($connection->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateItem(mysqli $connection, $name, $description, $price, $stockQuantity, $group) {
        $safeName = $connection->real_escape_string($name);
        $safeDescription = $connection->real_escape_string($description);
        $safePrice = $connection->real_escape_string($price);
        $safeStockQuantity = $connection->real_escape_string($stockQuantity);
        $safeGroup = $connection->real_escape_string($group);

        $sql = "UPDATE Items SET name='$safeName', description='$safeDescription',
                                    price=$safePrice, stock_quantity=$safeStockQuantity, group='$safeGroup'
                                    WHERE id=$this->id";
        if ($connection->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function loadItemsByGroup(mysqli $connection, $group) {
        $safeGroup = $connection->real_escape_string($group);

        $sql = "SELECT * FROM Items WHERE group='$safeGroup' ";
        $result = $connection->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows > 0) {
            foreach ($result as $row) {
                $loadedItem = new Item();
                $loadedItem->id = $row['id'];
                $loadedItem->name = $row['name'];
                $loadedItem->price = $row['price'];
                $loadedItem->stockQuantity = $row['stock_quantity'];
                $loadedItem->group = $row['group'];

                $ret[$loadedItem->id] = $loadedItem;
            }
        }
        return $ret;
    }

    public function loadItemById(mysqli $connection, $id) {
        $safeId = $connection->real_escape_string($id);

        $sql = "SELECT * FROM Items WHERE id=$safeId";
        $result = $connection->query($sql);

        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedItem = new Item();
            $loadedItem->id = $row['id'];
            $loadedItem->name = $row['name'];
            $loadedItem->price = $row['price'];
            $loadedItem->stockQuantity = $row['stock_quantity'];
            $loadedItem->group = $row['group'];
            
            return $loadedItem;
        }
        return null;
    }
    
//    public function loadAllItems() {
//        
//   }
    

}