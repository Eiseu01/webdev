<style>
    th, td {
        text-align: left;
    }
    .page-title {
        text-align: center;
        padding: 0 0 10px 0;
    }
    .username h3{
        padding: 15px 15px 0 15px;
        margin: 0;
        color: #B22222;
    }
    td a { 
        border-radius: 5px;
        padding: 5px 10px;
        text-decoration: none;
        color: black;
        text-align: center;
    }
</style>
<?php
    session_start();
    require_once("../classes/event.class.php");

    $eventObj = new Event;
    $array = $eventObj->fetchAvailableEvents($_SESSION["account"]["user_id"]);

?>
<div class="modal-container"></div>
<div>
    <div class="username">
        <h3>Welcome <?= $_SESSION["account"]["username"] ?>!</h3>
    </div>
    <div class="page-title">
        <h2>Upcoming Events</h2>
    </div>
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
            <table id="table-products" class="table table-centered table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Event Name</th>
                        <th>Venue</th>
                        <th>Description</th>
                        <th class="text-center">Date</th>
                        <th>Time</th>
                        <th class="text-center">Total Capacity</th>
                        <th class="text-center">Available Capacity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($array as $arr): 
                        $startTime = strtotime($arr["start_time"]);
                        $endTime = strtotime($arr["end_time"]); 
                    ?>
                    <tr>
                        <td><?= $arr["event_name"] ?></td>
                        <td><?= $arr["location"] ?></td>
                        <td><?= $arr["event_description"] ?></td>
                        <td class="text-center" style="width: 150px;"><?= $arr["date"] ?></td>
                        <td class="text-center" style="width: 200px;"><?= date('g:i A', $startTime) ?> - <?= date('g:i A', $endTime) ?></td>
                        <td class="text-center"><?= $arr["total_capacity"] ?></td>
                        <td class="text-center"><?= $arr["available_capacity"] ?></td>
                        <td class="text-center">
                            <?php if($arr["available_capacity"] > 0): ?>
                                <?php if($arr["event_id"] == $arr["revent_id"] && $arr["reservation_status"] == "pending"): ?>
                                    <a href="" class="cancel-btn text-danger" data-id="<?= $arr["event_id"] ?>">Cancel</a>
                                <?php endif; ?>
                                <?php if($arr["event_id"] != $arr["revent_id"]): ?>
                                    <a href="" class="register-btn text-success" data-id="<?= $arr["event_id"] ?>">Register</a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($arr["available_capacity"] == 0): ?>
                                <a class="text-muted" data-id="<?= $arr["event_id"] ?>">Unavailable</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>