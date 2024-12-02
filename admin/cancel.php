<?php

session_start();

require_once('../tools/functions.php');
require_once('../classes/event.class.php');
require_once('../classes/reserve.class.php');

$reviewed_by = $event_id = '';
$reviewed_byErr = $event_idErr  = '';

$eventObj = new Event();
$reserveObj = new Reserve();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $reviewed_by = $_SESSION["account"]["user_id"];
    $event_id = $_POST["event_id"];

    if(empty($reviewed_by)){
        $reviewed_byErr = 'Reviewed by ID is required.';
    }

    if(empty($event_id)){
        $event_idErr = 'Event ID is required.';
    }

    if(empty($user_idErr) && empty($event_idErr)){
        $eventObj->reviewed_by = $reviewed_by;
        $eventObj->event_id = $event_id;
        $eventObj->creation_status = "pending";
        $eventObj->progress_status = "pending";

        if($reserveObj->deleteEvent($event_id)) {
            if($eventObj->changeEventStatus()){
                header("location: ../admin/events.php");
            } else {
                echo 'Something went wrong when you tried to change the status.';
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
                <h5 class="modal-title" id="staticBackdropLabel">Edit Event Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="edit-event-status" action="cancel.php">
                <div class="modal-body">
                    <div id="label" class="mb-2">
                        <label for="event_id"><h4>Are you sure you want to cancel this event?</h4></label>
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