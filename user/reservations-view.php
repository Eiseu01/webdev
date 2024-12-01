<style>
    th, td {
        text-align: left;
    }
    .page-title {
        text-align: center;
        padding: 15px;
    }
    td a {
        background-color: lightblue;
        border-radius: 5px;
        padding: 5px 15px;
        text-decoration: none;
        color: black;
    }
</style>
<?php
    session_start();    
    require_once("../classes/reserve.class.php");

    $reserveObj = new Reserve();
    $array = $reserveObj->fetchReserve($_SESSION["account"]["user_id"], "approved"); //It should not be hardcoded
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
            <table id="table-products" class="table table-centered table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Event Name</th>
                        <th>Venue</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Capacity</th>
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
                        <td style="width: 150px;"><?= $arr["date"] ?></td>
                        <td style="width: 200px;"><?= date('g:i A', $startTime) ?> - <?= date('g:i A', $endTime) ?></td>
                        <td class="text-center"><?= $arr["capacity"] ?></td>
                        <td><a href="" class="register-btn" data-id="<?= $arr["event_id"] ?>">Pay</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>