<?php
require_once('../classes/event.class.php');

$eventObj = new Event();

$id = $_GET['event_id'];
$event = $eventObj->fetchRecord($id);

header('Content-Type: application/json');
echo json_encode($event);
