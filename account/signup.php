<?php
$page_title = "CodeLuck - Sign Up";
include_once "../includes/_head.php";
require_once '../tools/functions.php';
require_once '../classes/account.class.php';
require_once '../classes/course.class.php';

session_start();

$accountObj = new Account();
$courseObj = new Course();
$array = $courseObj->fetchCourse();
$first_name = $last_name = $middle_name = $username = $password = $phone_number = $email = $course_id = $level = '';
$first_nameErr = $last_nameErr = $usernameErr = $passwordErr = $phone_numberErr = $emailErr = $course_idErr = $levelErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = clean_input(($_POST['firstname']));
    $last_name = clean_input(($_POST['lastname']));
    $middle_name = clean_input(($_POST['middlename']));
    $email = clean_input(($_POST['email']));
    $phone_number = clean_input(($_POST['number']));
    $username = clean_input(($_POST['username']));
    $password = clean_input($_POST['password']);
    $course_id = clean_input($_POST['course']);
    $level = clean_input($_POST['level']);

    if (empty($first_name)) {
        $first_nameErr = "First name is Required!";
    }
    if (empty($last_name)) {
        $last_nameErr = "Last name is Required!";
    }
    if (empty($email)) {
        $emailErr = "email is Required!";
    }
    if (empty($phone_number)) {
        $phone_numberErr = "phone number is Required!";
    }
    if (empty($username)) {
        $usernameErr = "username is Required!";
    } elseif ($accountObj->usernameExist($username)) {
        $usernameErr = "username already taken!";
    }
    if (empty($password)) {
        $passwordErr = "password is Required!";
    }
    if (empty($course_id)) {
        $course_idErr = "Course is Required!";
    }
    if (empty($level)) {
        $levelErr = "Year level is Required!";
    }

    if (empty($first_nameErr) && empty($last_nameErr) && empty($emailErr) && empty($phone_numberErr) && empty($usernameErr) && empty($passwordErr) && empty($levelErr) && empty($course_idErr)) {
        $accountObj->first_name = $first_name;
        $accountObj->last_name = $last_name;
        $accountObj->middle_name = $middle_name;
        $accountObj->email = $email;
        $accountObj->phone_number = $phone_number;
        $accountObj->username = $username;
        $accountObj->password = $password;
        $accountObj->course_id = $course_id;
        $accountObj->level = $level;
        $accountObj->add();
        header("location: loginwcss.php");
    }
}
?>
<style>
    .signin {
        text-decoration: none;
        color: #A20202;
    }
    .btn {
        background-color: #A20202;
        color: white;
        transition: 0.2s;
    }
    .btn:hover {
        background-color: #D90000;
        color: white;
    }
    h1 {
        text-align: center;
    }
    img {
        border-radius: 100px;
        position: absolute;
        top: -160px;
        left: 210px;
    }
    p {
        margin: 5px;
    }
    .box {
        position: relative;
        margin-top: 60px;
    }
    .container {
        display: grid;
        align-items: center;
        justify-content: center;
        height: 100vh;
        width: 100%;
    }
    input::placeholder {
        color: grey;
    }
    select {
        width: 170px;
    }
    #sign {
        padding: 10px;
    }
    .form-control {
        height: 30px;
    }
    .course {
        border: 1px solid #DEE2E6;
        padding: 15px;
        display: grid;
        grid-template-columns: 50px 1fr;
        gap: 15px;
    }
    .course select {
        text-align: center;
        border: none;
    }
    .bigbox {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        width: 550px;
    }
</style>
<body>

    <div class="container">
        <div class="box">
            <form action="signup.php" method="post">
                <a href="../homepage/home.php"><img src="../img/wmsu-logo.png" width="140" height="140"></a>

                <h1>Sign Up</h1>

                <div class="bigbox">
                    <div class="smallbox">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname" value="<?= $first_name ?>">
                            <label for="firstname">First name</label>
                            <p class="text-danger"><?= $first_nameErr ?></p>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" value="<?= $last_name ?>">
                            <label for="lastname">Last name</label>
                            <p class="text-danger"><?= $last_nameErr ?></p>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middlename" value="<?= $middle_name ?>">
                            <label for="middlename">Middle name</label>
                            <p></p>
                        </div>
                        <div class="course">
                            <label for="course">Course</label>
                            <select name="course" id="course">
                                <option value=""></option>
                                <?php foreach($array as $arr): ?>
                                    <option value="<?= $arr["course_id"] ?>" 
                                        <?= ($arr["course_id"] == $course_id) ? 'selected' : '' ?>>
                                        <?= $arr["course_code"] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <p class="text-danger"><?= $course_idErr ?></p>
                        <div class="course">
                            <label for="level">Level</label>
                            <select name="level" id="level">
                                <option value=""></option>
                                <option value="1" <?= ($level == "1") ? 'selected' : '' ?>>1st Year</option>
                                <option value="2" <?= ($level == "2") ? 'selected' : '' ?>>2nd Year</option>
                                <option value="3" <?= ($level == "3") ? 'selected' : '' ?>>3rd Year</option>
                                <option value="4" <?= ($level == "4") ? 'selected' : '' ?>>4th Year</option>
                            </select>
                        </div>
                        <p class="text-danger"><?= $levelErr ?></p>
                    </div>
                    <div class="smallbox1">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= $email ?>">
                            <label for="email">Email</label>
                            <p class="text-danger"><?= $emailErr ?></p>
                        </div>
                        <div class="form-floating">
                            <input type="number" class="form-control" id="number" name="number" placeholder="Phone Number" value="<?= $phone_number ?>">
                            <label for="number">Phone Number</label>
                            <p class="text-danger"><?= $phone_numberErr ?></p>
                        </div>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= $username ?>">
                            <label for="username">Username</label>
                            <p class="text-danger"><?= $usernameErr ?></p>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?= $password ?>">
                            <label for="password">Password</label>
                            <p class="text-danger"><?= $passwordErr ?></p>
                        </div>
                        <p id="sign" class="text-center">You already have an account? <a href="loginwcss.php" class="signin">Sign In</a></p>
                    </div>
                </div>
                <button class="btn w-100 py-2" type="submit">Sign Up</button>
            </form>
        </div>
    </div>
    <?php
    require_once '../includes/_footer.php';
    ?>
</body>

</html>