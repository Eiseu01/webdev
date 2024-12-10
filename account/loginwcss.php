<?php
$page_title = "Event - Login";
include_once "../includes/_head.php";
require_once '../tools/functions.php';
require_once '../classes/account.class.php';

session_start();

$username = $password = '';
$accountObj = new Account();
$loginErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input(($_POST['username']));
    $password = clean_input($_POST['password']);

    if ($accountObj->login($username, $password)) {
        $data = $accountObj->fetch($username);
        $_SESSION['account'] = $data;

        if ($_SESSION['account']['role'] == "admin") {
            header('location: ../admin/events.php');
        } else if ($_SESSION['account']['role'] == "staff") {
            header('location: ../staff/dashboard.php');
        } else {
            header('location: ../user/dashboard.php');
        }
    } else {
        $loginErr = 'Invalid username/password';
    }
} else {
    if (isset($_SESSION['account'])) {
        if ($_SESSION['account']['role'] == "admin") {
            header('location: ../admin/dashboard.php');
        }else if (!$_SESSION['account']['role'] == "staff") {
            header('location: ../staff/dashboard.php');
        }else {
            header("location: ../user/dashboard.php");
        }
    }
}
?>
<style>
    .container {
        display: grid;
        align-items: center;
        justify-content: center;
        height: 100vh;
        width: 100%;
    }
    .box {
        position: relative;
        box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;
        border-radius: 5px;
        width: 300px;
    }
    input {
        width: 100%;
        padding-left: 5px;
        height: 35px;
    }
    input::placeholder {
        padding: 5px;
    }
    .inp {
        margin: 10px 30px;
        display: flex;
        gap: 10px;
    }
    img {
        border-radius: 100px;
        position: absolute;
        top: -70px;
        left: 85px;
    }
    .btn {
        background-color: #A20202;
        transition: 0.5s;
        color: white;
        height: 60px;
        border-radius: 0;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
    }
    .btn:hover {
        background-color: #D90000;
        color: white;
    }
    h1 {
        margin: 75px 0 30px 0;
        text-align: center;
        padding-top: 15px;
        border-top: 1px solid #D1D5DB;
    }
    .bi {
        color: #ACACAC;
    }
    .loginErr {
        text-align: center;
        color: red;
    }
</style>

<body>

    <div class="container">
        <div class="box">
            <form action="loginwcss.php" method="post">
                <img src="../img/wmsu-logo.png" width="120" height="120">
    
                <h1>Please log in</h1>

                <div class="inp">
                    <h2 class="bi bi-person"></h2>
                    <input type="text" id="username" name="username" placeholder="Username">
                </div>
                <div class="inp">
                    <h2 class="bi bi-key"></h2>
                    <input type="password" id="password" name="password" placeholder="Password">
                </div>
                <p class="loginErr"><?= $loginErr ?></p>
                <button class="btn w-100 py-2" type="submit">Log in</button>
                <!-- <a href="signup.php" class="btn btn-primary w-100 py-2 mt-2">Sign Up</a> -->
            </form>
        </div>
    </div>
    <?php
    require_once '../includes/_footer.php';
    ?>
</body>

</html>