<?php

require_once 'database.class.php';

class Notification
{
    public $notification_id = '';
    public $user_id = '';
    public $notification_type = '';
    public $message = '';

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function fetchNotifications($user_id)
    {
        $sql = "SELECT * FROM notifications WHERE user_id = :user_id";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':user_id', $user_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function addNotification($notification_type)
    {
        $sql = "INSERT INTO notifications (user_id, notification_type, message) VALUES (:user_id, :notification_type, :message)";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':user_id', $this->user_id);
        $query->bindParam(':notification_type', $notification_type);
        $query->bindParam(':message', $this->message);

        return $query->execute();
    }

    function deleteNotification($notificationId) {
        $sql = "DELETE FROM notifications WHERE notification_id = :notification_idd;";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':notification_idd', $notificationId);

        return $query->execute();
    }
}

// $obj = new Account();

// $obj->add();
