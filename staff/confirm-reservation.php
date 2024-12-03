<?php

session_start();

require_once('../tools/functions.php');
require_once('../classes/reserve.class.php');

$reservation_status = $reservation_id = '';

$reserveObj = new Reserve();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $reservation_id = $_POST["reservation_id"];
    $reservation_status = "confirmed";

    if(empty($reservation_id)){
        $reservation_idErr = 'Reservation ID is required.';
    }

    if(empty($reservation_status)){
        $reservation_statusErr = 'Reservation Status is required.';
    }

    if(empty($reservation_idErr) && empty($reservation_statusErr)){
        $reserveObj->reservation_status = $reservation_status;

        if($reserveObj->fetchReservation($reservation_id)) {
            header("location: ../staff/users.php");
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
            <form method="post" id="form-reservation" action="confirm-reservation.php">
                <div class="modal-body">
                    <div id="label" class="mb-2">
                        <label for="reservation_id"><h4>Do you want to confirm this?</h4></label>
                        <input style="display:none;" type="text" value="" id="reservation_id" name="reservation_id">
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