<?php

require_once 'database.class.php';

class Event
{
    public $event_id = '';
    public $event_name = '';
    public $event_description = '';
    public $date = '';
    public $start_time = '';
    public $end_time = '';
    public $location = '';
    public $location_status = '';
    public $location_notes = '';
    public $created_by = '';
    public $reviewed_by = '';
    public $creation_status = '';
    public $progress_status = '';
    public $completion_status = '';
    public $updated_details = '';
    public $capacity = '';

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function addEvent()
    {
        $sql = "INSERT INTO events (event_name, event_description, date, start_time, end_time, location, created_by, total_capacity, available_capacity) VALUES (:event_name, :event_description,  :date, :start_time, :end_time, :location, :created_by, :capacity, :capacity);";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':event_name', $this->event_name);
        $query->bindParam(':event_description', $this->event_description);
        $query->bindParam(':date', $this->date);
        $query->bindParam(':start_time', $this->start_time);
        $query->bindParam(':end_time', $this->end_time);
        $query->bindParam(':location', $this->location);
        $query->bindParam(':created_by', $this->created_by);
        $query->bindParam(':capacity', $this->capacity);

        return $query->execute();
    }

    function updateEvent() {
        $sql = "UPDATE events SET event_name = :event_name, location = :location, event_description = :event_description, date = :date, start_time = :start_time, end_time = :end_time, total_capacity = :capacity, available_capacity = :capacity, creation_status = 'pending', progress_status = 'pending' WHERE event_id = :event_id;";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':event_id', $this->event_id);
        $query->bindParam(':event_name', $this->event_name);
        $query->bindParam(':location', $this->location);
        $query->bindParam(':event_description', $this->event_description);
        $query->bindParam(':date', $this->date);
        $query->bindParam(':start_time', $this->start_time);
        $query->bindParam(':end_time', $this->end_time);
        $query->bindParam(':capacity', $this->capacity);

        return $query->execute();
    }

    function reschedEvent() {
        $sql = "UPDATE events SET date = :date, start_time = :start_time, end_time = :end_time, progress_status = 'rescheduled' WHERE event_id = :event_id;";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':event_id', $this->event_id);
        $query->bindParam(':date', $this->date);
        $query->bindParam(':start_time', $this->start_time);
        $query->bindParam(':end_time', $this->end_time);

        return $query->execute();
    }

    function fetchRecord($recordID)
    {
        $sql = "SELECT * FROM events WHERE event_id = :recordID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':recordID', $recordID);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    function deleteEvent($recordID) {
        $sql = "DELETE FROM events WHERE event_id = :recordID;";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':recordID', $recordID);

        return $query->execute();
    }

    function fetchEventDates($date) {
        $sql = "SELECT date, start_time, end_time FROM events WHERE date = :date AND completion_status = 'finished'";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':date', $date);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function updateEventDateInProgress() {
        $sql = "UPDATE events SET completion_status = 'in_progress' WHERE CONCAT(date, ' ', start_time) <= NOW() AND CONCAT(date, ' ', end_time) >= NOW() AND completion_status != 'in_progress' AND progress_status = 'scheduled'";
        $query = $this->db->connect()->prepare($sql);
        return $query->execute();
    }

    function updateEventDateFinished() {
        $sql = "UPDATE events SET completion_status = 'finished' WHERE CONCAT(date, ' ', end_time) < NOW() AND completion_status != 'finished' AND progress_status = 'scheduled'";
        $query = $this->db->connect()->prepare($sql);
        return $query->execute();
    }

    function statistics() {
        $sql = "SELECT 
            COUNT(CASE WHEN completion_status = 'not_started' THEN 1 END) AS upcoming_events,
            COUNT(CASE WHEN completion_status = 'in_progress' THEN 1 END) AS in_progress_events,
            COUNT(CASE WHEN completion_status = 'finished' THEN 1 END) AS finished_events,
            (SELECT COUNT(*) FROM users) AS total_users
        FROM events";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        if ($query->execute()) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function fetchEvents($created_by = '', $creation_status = '', $completion_status = '')
    {
        $sql = "SELECT * FROM events e JOIN users u ON e.created_by = u.user_id WHERE creation_status LIKE '%' :creation_status '%' AND completion_status LIKE '%' :completion_status '%'";
        if($created_by) {
            $sql .= " AND created_by = :created_by ";
        }
        $sql .= " ORDER BY date DESC LIMIT 10";
        $query = $this->db->connect()->prepare($sql);
        if($created_by) {
            $query->bindParam(':created_by', $created_by);
        }
        $query->bindParam(':creation_status', $creation_status);
        $query->bindParam(':completion_status', $completion_status);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function fetchAvailableEvents($user_id) {
        $sql = "SELECT e.*, r.event_id as 'revent_id', r.reservation_status FROM events e LEFT JOIN reservations r ON e.event_id = r.event_id ";
        if($user_id) {
            $sql .= " AND r.user_id = :user_id ";
        }
        $sql .= " WHERE e.creation_status = 'approved' AND e.progress_status = 'scheduled' AND e.completion_status = 'not_started' ORDER BY created_at DESC;";

        $query = $this->db->connect()->prepare($sql);
        if($user_id) {
            $query->bindParam(':user_id', $user_id);
        }
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function changeEventStatus() {
        $sql = "UPDATE events SET progress_status = :progress_status, creation_status = :creation_status, reviewed_by = :reviewed_by WHERE event_id = :event_id;";

        $query = $this->db->connect()->prepare($sql);
        
        $query->bindParam(':progress_status', $this->progress_status);
        $query->bindParam(':creation_status', $this->creation_status);
        $query->bindParam(':reviewed_by', $this->reviewed_by);
        $query->bindParam(':event_id', $this->event_id);

        return $query->execute();
    }

    function subtractCapacity($event_id) {
        $sql = "UPDATE events SET available_capacity = available_capacity - 1 WHERE event_id = :event_id";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':event_id', $event_id);

        return $query->execute();
    }

    function addCapacity($event_id) {
        $sql = "UPDATE events SET available_capacity = available_capacity + 1 WHERE event_id = :event_id";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':event_id', $event_id);

        return $query->execute();
    }

}