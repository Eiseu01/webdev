<?php
    session_start();
    require_once("../classes/account.class.php");

    $eventObj = new Account;
    $info = $eventObj->fetch($_SESSION["account"]["username"]);
?>
<style>
    th, td {
        text-align: left;
    }
    .page-title {
        text-align: center;
        padding: 15px;
    }
    .box {
        display: grid;
        grid-template-rows: 1fr 1fr 50px;
        justify-content: center;
        align-items: center;
    }
    .profile-pic {
        display: grid;
        justify-content: center;
    }
    .profile-pic img{
        width: 200px;
        height: 200px;
        border-radius: 1000px;
        border: 3px solid #B22222;
    }
    .information {
        text-align: center;
        font-size: 18px;
    }
    .logout {
        display: grid;
        justify-content: center;
    }
    .logout a {
        text-decoration: none;
        color: white;
        background-color: #B22222;
        padding: 10px 25px;
        border-radius: 10px;
    }
</style>
<div class="page-title">
    <h2>Profile</h2>
</div>
<div class="card-body">
    <div class="box">
        <div class="profile-pic">
            <img src="../img/empty.jpg" alt="Profile Picture">
        </div>
        <div class="information">
            <h3><?= $info["last_name"] . ', ' . $info["first_name"] . " " . $info["middle_name"] ?></h3>
            <p>Username: <?= $info["username"] ?></p>
            <p>Course & Section: <?= $info["course_code"] . " - " . $info["level"] ?></p>
            <p>Email: <?= $info["email"] ?></p>
            <p>Contact Number: <?= $info["phone_number"] ?></p>
        </div>
        <div class="logout">
            <a href="../account/logout.php">Logout</a>
        </div>
    </div>
</div>
