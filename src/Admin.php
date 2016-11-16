<?php
include_once './connection.php';
class Admin {

    static private $conn;
    
    private $id;
    private $adminName;
    private $email;
    private $hashedPassword;

    static public function SetConnection($conn) {
        self::$conn = $conn;
    }
    
    public function __construct() {
        $this->id = -1;
        $this->adminName = "";
        $this->email = "";
        $this->hashedPassword = "";
    }
    
    //getery:
    
    function getId() {
        return $this->id;
    }

    function getAdminName() {
        return $this->adminName;
    }

    function getEmail() {
        return $this->email;
    }

    function getHashedPassword() {
        return $this->hashedPassword;
    }

    //setery:

    function setAdminName($firstName) {
        $this->adminName = $firstName;
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

    //metody:

    public function saveAdminToDB() {
        if ($this->id == -1) {
            $statement = self::$conn->prepare("INSERT INTO Admins(admin_name, email, hashed_password)
                    VALUES (?, ?, ?)");

            if (!$statement) {
                return false;
            }
            $statement->bind_param('sss', $this->adminName, $this->email, $this->hashedPassword);
            if ($statement->execute()) {
                $this->id = $statement->insert_id;
                return true;
            } else {
                echo "Problem z zapytaniem. " . $statement->error;
            }
            return false;
        } else {
            $sql = "UPDATE Admins SET admin_name = '$this->adminName',
                                    email = '$this->email',
                                    hashed_password = '$this->hashedPassword'
                                    WHERE id = $this->id";
            $result = self::$conn->query($sql);
            if ($result) {
                return TRUE;
            }
            return FALSE;
        }
    }
    
    static public function loadAdminById($adminId) {
        $sql = "SELECT * FROM Admins WHERE id = $adminId";
        $result = self::$conn->query($sql);

        if ($result != FALSE && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedAdmin = new Admin();
            $loadedAdmin->id = $row['id'];
            $loadedAdmin->adminName = $row['admin_name'];
            $loadedAdmin->email = $row['email'];
            $loadedAdmin->hashedPassword = $row['hashed_password'];

            return $loadedAdmin;
        } else {
            return null;
        }
    }
    
    static public function loadAdminByEmail($adminEmail) {
        $sql = "SELECT * FROM Admins WHERE id = $adminEmail";
        $result = self::$conn->query($sql);

        if ($result != FALSE && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedAdmin = new Admin();
            $loadedAdmin->id = $row['id'];
            $loadedAdmin->adminName = $row['admin_name'];
            $loadedAdmin->email = $row['email'];
            $loadedAdmin->hashedPassword = $row['hashed_password'];

            return $loadedAdmin;
        } else {
            return null;
        }
    }
    
    public function deleteAdmin() {
        if ($this->id == -1) {
           return true; 
        }
        
        $sql = "DELETE FROM Admins WHERE id = $this->id";
        $result = self::$conn->query($sql);
        if ($result) {
            $this->id = -1;
            return true;
        }
        return false;
    }

}

?>