<?php

include_once 'connection.php';

class Category {

    static private $conn;
    private $id;
    private $text;

    static public function SetConnection($conn) {
        self::$conn = $conn;
    }

    public function __construct() {
        $this->id = -1;
        $this->text = "";
    }

    public function getId() {
        return $this->id;
    }

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
        return $this;
    }

    public function saveCategoryToDB() {
        if ($this->id == -1) {
            $statement = self::$conn->prepare
                    ("INSERT INTO Categories (text) VALUES (?)");
            if (!$statement) {
                return false;
            }
            $statement->bind_param('s', $this->text);
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
        $sql = "DELETE FROM Categories WHERE id=$safeId";
        if (self::$conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateCategory() {
        $safeText = self::$conn->real_escape_string($this->text);

        $sql = "UPDATE Categories SET text='$safeText' WHERE id=$this->id";
        if (self::$conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    static public function loadAllCategories() {
        $sql = "SELECT * FROM Categories";
        $result = self::$conn->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows > 0) {
            foreach ($result as $row) {
                $loadedCategory = new Category();
                $loadedCategory->id = $row['id'];
                $loadedCategory->text = $row['text'];

                $ret[$loadedCategory->id] = $loadedCategory;
            }
        }
        return $ret;
    }
    
    static public function loadCategoryById($id) {
        $safeId = self::$conn->real_escape_string($id);
        
        $sql = "SELECT * FROM Categories WHERE id=$safeId";
        $result = self::$conn->query($sql);
        
        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $loadedCategory = new Category();
            $loadedCategory->id = $row['id'];
            $loadedCategory->text = $row['text'];
            
            return $loadedCategory;
        }
        return null;
    }

}