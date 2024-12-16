<?php

session_start();

require_once('../tools/functions.php');
require_once('../classes/reserve.class.php');
require_once('../classes/event.class.php');

$user_id = $event_id = '';
$user_idErr = $event_idErr  = '';

$reserveObj = new Reserve();
$eventObj = new Event();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $user_id = $_SESSION["account"]["user_id"];
    $event_id = $_POST["event_id"];

    if(empty($user_id)){
        $user_idErr = 'User ID is required.';
    }

    if(empty($event_id)){
        $event_idErr = 'Event ID is required.';
    }

    if(empty($user_idErr) && empty($event_idErr)){
        $reserveObj->user_id = $user_id;
        $reserveObj->event_id = $event_id;

        if($eventObj->addCapacity($event_id)) {
            if($reserveObj->deleteReserve($user_id, $event_id)){
                if($_SESSION["account"]["role"] == "organizer") {
                    header("location: ../staff/events.php");
                } else {
                    header("location: ../user/events.php");
                }
            } else {
                echo 'Something went wrong when you tried to register.';
            }
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
                <h5 class="modal-title" id="staticBackdropLabel">Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="form-register" action="../modals/cancel.php">
                <div class="modal-body">
                    <div id="label" class="mb-2">
                        <label for="event_id"><h4>Do you want to cancel?</h4></label>
                        <input style="display:none;" type="text" value="" id="event_id" name="event_id">
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