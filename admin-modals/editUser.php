<?php

session_start();

require_once('../tools/functions.php');
require_once('../classes/account.class.php');

$user_id = $_GET['user_id'];
$username = $last_name = $first_name = $middle_name = $course_id = $level = $role = $password = '';
$usernameErr = $last_nameErr = $first_nameErr = $middle_nameErr = $course_idErr = $levelErr = $roleErr = $passwordErr = '';

$userObj = new Account();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = clean_input($_POST['username']);
    $last_name = clean_input($_POST['last_name']);
    $first_name = clean_input($_POST['first_name']);
    $middle_name = clean_input($_POST['middle_name']);
    $course_id = clean_input($_POST['course_id']);
    $level = clean_input($_POST['level']);
    $role = clean_input($_POST['role']);
    // $password = clean_input($_POST['password']);

    if (empty($username)) {
        $usernameErr = "Username is required";
    } 
    if (empty($last_name)) {
        $last_nameErr = "Last name is required";
    }
    if (empty($first_name)) {
        $first_nameErr = "First name is required";
    } 
    if (empty($middle_name)) {
        $middle_nameErr = "Middle name is required";
    }
    // if (empty($password)) {
    //     $passwordErr = "Password is required";
    // } 
    if (empty($role)) {
        $roleErr = "Role is required";
    }
    if (empty($course_id)) {
        $course_idErr = "Course is required";
    }

    if (!empty($usernameErr) || !empty($last_nameErr) || !empty($first_nameErr) || !empty($middle_nameErr) || !empty($course_idErr) || !empty($roleErr)) {
        echo json_encode([
            'status' => 'error',
            'usernameErr' => $usernameErr,
            // 'passwordErr' => $passwordErr,
            'roleErr' => $roleErr,
            'last_nameErr' => $last_nameErr,
            'first_nameErr' => $first_nameErr,
            'middle_nameErr' => $middle_nameErr,
            'course_idErr' => $course_idErr,
        ]);
        exit;
    }

    if (empty($usernameErr) && empty($last_nameErr) && empty($first_nameErr) && empty($middle_nameErr) && empty($course_idErr) && empty($roleErr)) {
        
        $userObj->user_id = $user_id;
        $userObj->username = $username;
        $userObj->last_name = $last_name;
        $userObj->first_name = $first_name;
        $userObj->middle_name = $middle_name;
        $userObj->course_id = $course_id;
        $userObj->role = $role;
        // $userObj->password = $password;
        $userObj->level = $level;

        if ($userObj->editUser()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong when adding the new product.']);
        }
        exit;
    }
}   
?>
