<?php

session_start();

require_once('../tools/functions.php');
require_once('../classes/event.class.php');

$event_id = $_GET['event_id'];
$event_name = $event_venue = $event_description = $date = $start_time = $end_time = $capacity = '';
$event_nameErr = $event_venueErr = $dateErr = $start_timeErr = $end_timeErr = $capacityErr = '';

$eventObj = new Event();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $date = clean_input($_POST['date']);
    $start_time = clean_input($_POST['start_time']);
    $end_time = clean_input($_POST['end_time']);


    if (empty($date)) {
        $dateErr = "Date is required";
    }
    if (empty($start_time)) {
        $start_timeErr = "Start time is required";
    }
    if (empty($end_time)) {
        $end_timeErr = "End time is required";
    } 

    if (!empty($dateErr) || !empty($start_timeErr) || !empty($end_timeErr)) {
        echo json_encode([
            'status' => 'error',
            'dateErr' => $dateErr,
            'start_timeErr' => $start_timeErr,
            'end_timeErr' => $end_timeErr,
        ]);
        exit;
    }

    if (empty($dateErr) && empty($start_timeErr) && empty($end_timeErr)) {
        
        $eventObj->event_id = $event_id;
        $eventObj->date = $date;
        $eventObj->start_time = $start_time;
        $eventObj->end_time = $end_time;

        if ($eventObj->reschedEvent()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong when adding the new product.']);
        }
        exit;
    }
}   
?>
