<?php

require_once 'database.class.php';

class Reserve {

    public $user_id = '';
    public $event_id = '';
    public $reservation_status = '';

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

    function deleteReserve($userId, $eventId) {
        $sql = "DELETE FROM reservations WHERE user_id = :user_id AND event_id = :event_id;";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':user_id', $userId);
        $query->bindParam(':event_id', $eventId);

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

    function fetchEvents($created_by)
    {
        $sql = "SELECT * FROM events e JOIN reservations r ON e.event_id = r.event_id JOIN users u ON r.user_id = u.user_id JOIN course c ON u.course_id = c.course_id WHERE e.created_by = :created_by;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':created_by', $created_by);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function fetchReservation($reservation_id) {
        // $sql = "UPDATE reservations SET reservation_status = :reservation_status WHERE reservation_id = :reservation_id;";
        $sql = " UPDATE reservations r JOIN events e ON r.event_id = e.event_id SET r.reservation_status = :reservation_status, e.available_capacity = e.available_capacity+ IF(:reservation_status = 'cancelled', 1, IF(:reservation_status = 'confirmed', 0, 0)) WHERE r.reservation_id = :reservation_id;";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':reservation_status', $this->reservation_status);
        $query->bindParam(':reservation_id', $reservation_id);
        
        return $query->execute();
    }

    function deleteCancelledReservation($reservation_id) {
        $sql = "DELETE r FROM reservations r JOIN events e ON r.event_id = e.event_id WHERE r.reservation_status = 'Cancelled' AND r.reservation_id = :reservation_id;";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':reservation_id', $reservation_id);

        return $query->execute();
    }

    function ticketInfo($reservation_id) {
        $sql = "SELECT * FROM events e JOIN reservations r ON e.event_id = r.event_id JOIN users u ON r.user_id = u.user_id WHERE r.reservation_id = :reservation_id;";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':reservation_id', $reservation_id);
        
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }
}
?>