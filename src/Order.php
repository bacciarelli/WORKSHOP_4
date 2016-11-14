<?php

/*
  CREATE TABLE Items_Orders(
  id int AUTO_INCREMENT NOT NULL,
  item_id int NOT NULL,
  order_id int NOT NULL,
 * 
  quantity int NOT NULL,
 * 
  status ???

  PRIMARY KEY(id),
  FOREIGN KEY(item_id) REFERENCES Items(id),
  FOREIGN KEY(order_id) REFERENCES Orders(id)
  );
 */





include_once './Item.php';

class Order {

    private $id;
    private $status;

    public function __construct() {
        $this->id = -1;
        $this->status = null;
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
    public function loadOrdersByUserId(mysqli $connection, $userId) {
        $safeUserId = $connection->real_escape_string($userId);
        $sql = "SELECT * FROM Orders
                                    JOIN Items_Orders ON Orders.id=Items_Orders.order_id
                                    JOIN Items ON Items.id = Items_Orders.item_id
                                    WHERE user_id = $safeUserId";
    }

}