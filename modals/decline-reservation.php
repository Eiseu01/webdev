<?php

session_start();

require_once('../tools/functions.php');
require_once('../classes/reserve.class.php');
require_once('../classes/notification.class.php');

$reservation_status = $reservation_id = '';
$user_id = $message = '';

$reserveObj = new Reserve();
$notifObj = new Notification();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $reservation_id = $_POST["reservation_id"];
    $reservation_status = "cancelled";
    $user_id = $_POST["user_id"];
    $event_name = $_POST["event_name"];
    $message = "We regret to inform you that your registration to " . $event_name . " has been declined.";

    if(empty($reservation_id)){
        $reservation_idErr = 'Reservation ID is required.';
    }

    if(empty($user_id)){
        $user_idErr = 'User ID is required.';
    }

    if(empty($reservation_status)){
        $reservation_statusErr = 'Reservation Status is required.';
    }

    if(empty($reservation_idErr) && empty($reservation_statusErr)){
        $reserveObj->reservation_status = $reservation_status;
        $notifObj->user_id = $user_id;
        $notifObj->message = $message;

        if($notifObj->addNotification("reservation_update")) {
            if($reserveObj->fetchReservation($reservation_id)) {
                if($_SESSION["account"]["role"] == "admin") {
                    header("location: ../admin/participants.php");
                } else {
                    header("location: ../staff/users.php");
                }
            }
        } else {
            echo 'Something went wrong when you tried to approve.';
        }
        exit;
    }
}
?>
<div class="modal fade" id="staticBackdropedit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #EE4C51; color: white;">
                <h5 class="modal-title" id="staticBackdropLabel">Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="form-reservation" action="../modals/decline-reservation.php">
                <div class="modal-body">
                    <div id="label" class="mb-2">
                        <label for="reservation_id"><h4>Do you want to decline this?</h4></label>
                        <input style="display:none;" type="text" value="" id="reservation_id" name="reservation_id">
                        <input style="display:none;" type="text" value="" id="user_id" name="user_id">
                        <input style="display:none;" type="text" value="" id="event_name" name="event_name">
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