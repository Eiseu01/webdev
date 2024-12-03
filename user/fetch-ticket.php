<?php
require_once('../classes/reserve.class.php');

$reserveObj = new Reserve();

$id = $_GET['reservation_id'];
$account = $reserveObj->ticketInfo($id);

header('Content-Type: application/json');
echo json_encode($account);
