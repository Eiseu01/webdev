<?php

require_once 'database.class.php';

class Reserve {

    public $user_id = '';
    public $event_id = '';

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function addReserve()
    {
        $sql = "INSERT INTO reservations (user_id, event_id) VALUES (:user_id, :event_id);";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':user_id', $this->user_id);
        $query->bindParam(':event_id', $this->event_id);

        return $query->execute();
    }

    function fetchReserve($recordID, $creation_status = '')
    {
        $sql = "SELECT * FROM reservations r JOIN events e ON r.event_id = e.event_id 
                WHERE user_id = :recordID AND e.creation_status LIKE '%' :creation_status '%' ORDER BY reservation_date;";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':recordID', $recordID);
        $query->bindParam(':creation_status', $creation_status);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function deleteEvent($recordID) {
        $sql = "DELETE FROM reservations WHERE event_id = :recordID;";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':recordID', $recordID);

        return $query->execute();
    }

    public function fetchEvents()
    {
        $sql = "SELECT * FROM events ORDER BY created_at ASC;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
}
?>