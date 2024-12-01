<?php
    session_start();
    require_once("../classes/notif.class.php");

    $notifObj = new Notifications;
    $array = $notifObj->fetchNotifications();
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
        border: 3px solid lightgrey;
        padding: 20px;
        color: black;
    }
    .small-box {
        border: 2px solid lightgrey;
        margin: 10px 0 10px 0;
        background-color: #F2F6FC;
        text-align: start;
        width: 100%;
    }
    .title h2{
        padding: 20px 0 20px 20px;
    }
    .message p {
        padding: 0 0 0 20px;
    }
    .time {
        font-size: 12px;
        color: grey;
    }
</style>
<div class="page-title">
    <h2>Notifications</h2>
</div>
<div class="card">
    <div class="card-body">
        <div class="box">
            <?php foreach($array as $arr): ?>
            <button class="small-box">
                <div class="title">
                    <h2><?= $arr["title"] ?></h2>
                </div>
                <div class="message">
                    <p><?= $arr["message"]  ?></p>
                    <p class="time"><?= $arr["created_at"] ?></p>
                </div>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
</div>