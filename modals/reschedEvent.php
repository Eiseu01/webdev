<?php

session_start();

require_once('../tools/functions.php');
require_once('../classes/event.class.php');

$event_id = $_GET['event_id'];
$event_name = $event_venue = $date = $start_time = $end_time = $capacity = '';
$event_nameErr = $event_venueErr = $dateErr = $start_timeErr = $end_timeErr = $capacityErr = '';

$eventObj = new Event();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $date = date('Y-m-d', strtotime($_POST['date']));
    $start_time = clean_input($_POST['start_time']);
    $end_time = clean_input($_POST['end_time']);


    if (empty($date)) {
        $dateErr = "Date is required";
    } else {
        // Compare with today's date
        $today = date('Y-m-d');
        if ($date < $today) {
            $dateErr = "Event date cannot be in the past.";
        }
    }
    if (empty($start_time)) {
        $start_timeErr = "Start time is required";
    }
    if (empty($end_time)) {
        $end_timeErr = "End time is required";
    } else if ($end_time < $start_time) {
        $end_timeErr = "End time must be later than start time.";
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

    $overlappingEvents = $eventObj->fetchEventDates($date);
    foreach ($overlappingEvents as $event) {
        $existingStart = strtotime($event['start_time']);
        $existingEnd = strtotime($event['end_time']);
        $newStart = strtotime($start_time);
        $newEnd = strtotime($end_time);

        if (($newStart < $existingEnd && $newEnd > $existingStart)) {
            echo json_encode(['status' => 'error', 'message' => 'The event time overlaps with an existing event.']);
            exit;
        }
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
