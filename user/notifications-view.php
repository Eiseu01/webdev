<style>
    th, td {
        text-align: left;
    }
    .page-title {
        text-align: center;
        padding: 15px;
    }
    td a {
        text-decoration: none;
    }
    tr {
        box-shadow: rgba(0, 0, 0, 0.2) 0px 1px 2px 0px;
    }
    th, td {
        font-size: 18px;
        padding: 10px;
        color: #2c2c2c;
    }
</style>
<?php
    session_start();    
    require_once("../classes/notification.class.php");

    $reserveObj = new Notification();
    $array = $reserveObj->fetchNotifications($_SESSION["account"]["user_id"]);
?>
<div class="modal-container"></div>
<div class="page-title">
    <h2>Reservations</h2>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <form class="d-flex me-2">
                <div class="input-group w-100 pb-3">
                    <input type="text" class="form-control form-control-light" id="custom-search" placeholder="Search Events...">
                    <span class="input-group-text bg-primary border-primary text-white brand-bg-color">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
            </form>
            <table id="table-products" class="notifTable table-centered table-nowrap mb-0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th class="text-center">Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        foreach($array as $arr): 
                        $formatted_time = date('Y-m-d h:i A', strtotime($arr["created_at"]));
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td class="text-center"><?php
                            if($arr["notification_type"] == "reservation_update") {
                                echo "Reservation Update";
                            } else if($arr["notification_type"] == "event_update") {
                                echo "Event Update";
                            } else {
                                echo "System Message";
                            }
                        ?></td>
                        <td style="padding-left: 50px;"><?= $arr["message"] ?></td>
                        <td class="text-center"><?= $formatted_time ?></td>
                        <td class="text-center">
                            <a href="" class="trash" data-id="<?= $arr["notification_id"] ?>">
                                <i class="bi bi-trash3 text-danger"></i>
                            </a>
                        </td>
                    </tr>
                    <?php 
                        $i++;
                        endforeach; 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>