<?php

session_start();

require_once('../tools/functions.php');
require_once('../classes/notification.class.php');

$notifObj = new Notification();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if($notifObj->truncateNotif()){
        if($_SESSION["account"]["role"] == "organizer") {
            header("location: ../staff/notifications.php");
        } else {
            header("location: ../user/notifications.php");
        }
    } else {
        echo 'Something went wrong when you tried truncate notifications.';
    }
    exit;

}
?>
<div class="modal fade" id="staticBackdropedit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #EE4C51; color: white;">
                <h5 class="modal-title" id="staticBackdropLabel">Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="form-register" action="../modals/truncateNotification.php">
                <div class="modal-body">
                    <div id="label" class="mb-2">
                        <label for="notification_id"><h4>Do you want to delete all the notifications?</h4></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        No
                    </button>
                    <button type="submit" class="btn btn-primary brand-bg-color">
                        Yes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>