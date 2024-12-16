<?php
require_once('../classes/account.class.php');

$accountObj = new Account();

$id = $_GET['user_id'];
$account = $accountObj->fetchRecord($id);

header('Content-Type: application/json');
echo json_encode($account);
