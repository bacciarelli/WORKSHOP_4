<?php

include_once 'connection.php';

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

    /**
     * 
     * @param type $email
     * @return boolean
     * return true when e-mail is in database
     * return false when e-mail isn't in database
     */
    static public function checkEmail($email) {
        $email = self::$conn->real_escape_string($email);
        $sql = "SELECT * FROM Users WHERE email='$email'";
        $result = self::$conn->query($sql);
        if ($result->num_rows == true) {
            return true;
        } else {
            return false;
        }
    }

    static public function loginUser($email, $password) {
        if (User::checkEmail($email) != null &&
            password_verify($password, User::loadUserByEmail($email)->hashedPassword) == true) {
            return User::loadUserByEmail($email);
        } else {
            return false;
        }
    }

    static public function registerNewUser($address, $email, $firstName, $lastName, $password) {
        $newUser = new User();
        $newUser->address = $address;
        $newUser->email = $email;
        $newUser->firstName = $firstName;
        $newUser->lastName = $lastName;
        $newUser->setHashedPassword($password);
        if ($newUser->saveUserToDB() == true) {
            return true;
        } else {
            return false;
        }
    }

    static public function loadUserById($userId) {
        $sql = "SELECT * FROM Users WHERE id = $userId";
        $result = self::$conn->query($sql);

        if ($result != FALSE && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->firstName = $row['first_name'];
            $loadedUser->lastName = $row['last_name'];
            $loadedUser->email = $row['email'];
            $loadedUser->hashedPassword = $row['hashed_password'];
            $loadedUser->address = $row['address'];

            return $loadedUser;
        } else {
            return null;
        }
    }

    static public function loadUserByEmail($userEmail) {
        $safeUserEmail = self::$conn->real_escape_string($userEmail);
        $sql = "SELECT * FROM Users WHERE email = '$safeUserEmail'";
        $result = self::$conn->query($sql);

        if ($result != FALSE && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->firstName = $row['first_name'];
            $loadedUser->lastName = $row['last_name'];
            $loadedUser->email = $row['email'];
            $loadedUser->hashedPassword = $row['hashed_password'];
            $loadedUser->address = $row['address'];

            return $loadedUser;
        } else {
            return null;
        }
    }

    public function loadAllUsersMessages() {
        $userId = $_SESSION['id'];
        $sql = "SELECT * FROM Messages WHERE user_id = $userId ORDER BY creation_date DESC";
        $result = self::$conn->query($sql);
        $ret = [];

        if ($result != false && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedMessage = new Tweet();
                $loadedMessage->id = $row['id'];
                $loadedMessage->adminId = $row['admin_id'];
                $loadedMessage->userId = $row['user_id'];
                $loadedMessage->messageTextId = $row['message_text_id'];
                $loadedMessage->creationDate = $row['creation_date'];

                $ret[] = $loadedMessage;
                return $ret;
            }
        } else {
            return null;
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