<?php

require_once 'database.class.php';

class Notifications
{
    public $userID = '';
    public $message = '';
    public $status = '';
    public $title = '';
    public $role = '';

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function addNotification()
    {
        $sql = "INSERT INTO notifications (message, status, title) VALUES (:message, :status, :title);";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':message', $this->message);
        $query->bindParam(':status', $this->status);
        $query->bindParam(':title', $this->title);

        return $query->execute();
    }


    function deleteEvent($recordID) {
        $sql = "DELETE FROM notiifications WHERE event_id = :recordID;";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':recordID', $recordID);

        return $query->execute();
    }

    function fetchNotifications($sender_id = "")
    {
        $sql = "SELECT * FROM notifications WHERE sender_id LIKE '%' :sender_id '%' ORDER BY created_at ASC;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':sender_id', $sender_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    
}

// $obj = new Account();

// $obj->add();
