<?php

require_once 'database.class.php';

class Account
{
    public $user_id = '';
    public $first_name = '';
    public $last_name = '';
    public $middle_name = '';
    public $email = '';
    public $phone_number = '';
    public $username = '';
    public $password = '';
    public $role = '';
    public $level = '';
    public $course_id = '';

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function add()
    {
        $sql = "INSERT INTO users (first_name, last_name, email, phone_number, username, password) VALUES (:first_name, :last_name, :email, :phone_number, :username, :password);";

        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':first_name', $this->first_name);
        $query->bindParam(':last_name', $this->last_name);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':phone_number', $this->phone_number);
        $query->bindParam(':username', $this->username);
        $hashpassword = password_hash($this->password, PASSWORD_DEFAULT);
        $query->bindParam(':password', $hashpassword);

        return $query->execute();
    }

    function editUser()
    {
        $sql = "UPDATE users SET username = :username, last_name = :last_name, first_name = :first_name, middle_name = :middle_name, course_id = :course_id, level = :level, role = :role, password = :password WHERE user_id = :user_id;";

        $query = $this->db->connect()->prepare($sql);
        
        $query->bindParam(':username', $this->username);
        $query->bindParam(':last_name', $this->last_name);
        $query->bindParam(':first_name', $this->first_name);
        $query->bindParam(':middle_name', $this->middle_name);
        $query->bindParam(':course_id', $this->course_id);
        $query->bindParam(':level', $this->level);
        $query->bindParam(':role', $this->role);
        $hashpassword = password_hash($this->password, PASSWORD_DEFAULT);
        $query->bindParam(':password', $hashpassword);
        $query->bindParam(':user_id', $this->user_id);
    
        return $query->execute();
    }

    function usernameExist($username, $excludeID = '')
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        if ($excludeID) {
            $sql .= " and id != :excludeID";
        }

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':username', $username);

        if ($excludeID) {
            $query->bindParam(':excludeID', $excludeID);
        }

        $count = $query->execute() ? $query->fetchColumn() : 0;

        return $count > 0;
    }

    function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam('username', $username);

        if ($query->execute()) {
            $data = $query->fetch();
            if ($data && password_verify($password, $data['password'])) {
                return true;
            }
        }

        return false;
    }

    function fetch($username)
    {
        $sql = "SELECT * FROM users u JOIN course c ON u.course_id = c.course_id WHERE username = :username LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam('username', $username);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }

        return $data;
    }

    function fetchUsers($user_id) {
        $sql = "SELECT u.role, u.user_id, u.username, u.password, u.first_name, u.last_name, u.middle_name, u.level, c.course_name, c.course_code FROM users u LEFT JOIN course c ON u.course_id = c.course_id WHERE u.user_id != :user_id ORDER BY role;";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam('user_id', $user_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function fetchRecord($recordID)
    {
        $sql = "SELECT * FROM users WHERE user_id = :recordID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':recordID', $recordID);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }
}

// $obj = new Account();

// $obj->add();
