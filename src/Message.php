<?php
namespace WORKSHOP_4\src;
include_once '../config/connection.php';

class Message {

    static private $conn;
    private $id;
    private $adminId;
    private $userId;
    private $messageText;
    private $creationDate;

    static public function SetConnection($conn) {
        self::$conn = $conn;
    }
    
//tutaj chyba wszystko seterami się będzie ustawiać...?
//    public function __construct() {
//        
//    }

    //getery:

    public function getId() {
        return $this->id;
    }

    public function getAdminId() {
        return $this->adminId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getMessageText() {
        return $this->messageTextId;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }
    
    //setery:

    public function setAdminId($adminId) {
        $this->adminId = $adminId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setMessageText($messageText) {
        $this->messageText = $messageText;
    }

    public function setCreationDate() {
        $this->creationDate = date('Y-m-d H:i:s');
        return $this;
    }

    //metody:

    public function saveMessageToDB() {
            $statement = self::$conn->prepare("INSERT INTO Messages(admin_id, user_id, messge_text, creation_date)
                    VALUES (?, ?, ?, ?)");

            if (!$statement) {
                return false;
            }
            $statement->bind_param('iiss', $this->adminId, $this->userId, $this->messageText, $this->creationDate);
            if ($statement->execute()) {
                //$this->id = $statement->insert_id;   to w zasadzize nie potrebne?
                return true;
            } else {
                echo "Problem z zapytaniem. " . $statement->error;
                return false;
            }
    }

}

?>