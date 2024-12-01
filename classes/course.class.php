<?php

require_once 'database.class.php';

class Course
{
    public $course_code = '';
    public $course_name = '';

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function addCourse()
    {
        $sql = "INSERT INTO notifications (course_code, course_name) VALUES (:course_code, :course_name);";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':course_code', $this->course_code);
        $query->bindParam(':course_name', $this->course_name);

        return $query->execute();
    }

    function fetchCourse() {
        $sql = "SELECT * FROM course ORDER BY course_code ASC;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    
}

// $obj = new Account();

// $obj->add();
