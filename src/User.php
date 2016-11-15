<?php
include_once '../connection.php';
class User {

    static private $conn;
    
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $hashedPassword;
    private $address;

    static public function SetConnection($conn) {
        self::$conn = $conn;
    }
    
    public function __construct() {
        $this->id = -1;
        $this->firstName = "";
        $this->lastName = "";
        $this->email = "";
        $this->hashedPassword = "";
        $this->address = "";
    }
    
    //getery:
    
    function getId() {
        return $this->id;
    }

    function getFirstName() {
        return $this->firstName;
    }

    function getLastName() {
        return $this->lastName;
    }

    function getEmail() {
        return $this->email;
    }

    function getHashedPassword() {
        return $this->hashedPassword;
    }

    function getAddress() {
        return $this->address;
    }

    //setery:

    function setFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }

    function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    function setHashedPassword($hashedPassword) {
        $newHashedPassword = password_hash($hashedPassword, PASSWORD_BCRYPT);
        $this->hashedPassword = $newHashedPassword;
        return $this;
    }

    function setAddress($address) {
        $this->address = $address;
        return $this;
    }
    
    //metody:

    public function saveUserToDB() {
        if ($this->id == -1) {
            $statement = self::$conn->prepare("INSERT INTO Users(first_name, last_name, email, hashed_password, address)
                    VALUES (?, ?, ?, ?, ?)");

            if (!$statement) {
                return false;
            }
            $statement->bind_param('sssss', $this->firstName, $this->lastName, $this->email, $this->hashedPassword, $this->address);
            if ($statement->execute()) {
                $this->id = $statement->insert_id;
                return true;
            } else {
                echo "Problem z zapytaniem. " . $statement->error;
            }
            return false;
        } else {
            $sql = "UPDATE Users SET first_name = '$this->firstName',
                                    last_name = '$this->lastName',
                                    email = '$this->email'
                                    hashed_password = '$this->hashedPassword'
                                    address = '$this->address'
                                    WHERE id = $this->id";
            $result = self::$conn->query($sql);
            if ($result) {
                return TRUE;
            }
            return FALSE;
        }
    }
    
    public function deleteUser() {
        if ($this->id == -1) {
           return true; 
        }
        
        $sql = "DELETE FROM Users WHERE id = $this->id";
        $result = self::$conn->query($sql);
        if ($result) {
            $this->id = -1;
            return true;
        }
        return false;
    }

}

?>