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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex justify-content-center align-items-center">
                    <form class="d-flex me-2">
                        <div class="input-group w-100">
                            <input type="text" class="form-control form-control-light" id="custom-search" placeholder="Search">
                            <span class="input-group-text bg-primary border-primary text-white brand-bg-color">
                                <i class="bi bi-search"></i>
                            </span>
                        </div>
                    </form>
                    <div class="d-flex align-items-center">
                        <label for="category-filter" class="me-2" id="label-category">Category</label>
                        <select id="category-filter" class="form-select">
                            <option value="choose">Select Status</option>
                            <option value="">All</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                </div>
            </div>
            <table id="table-products" class="table table-centered table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Event Name</th>
                        <th>Venue</th>
                        <th>Description</th>
                        <th class="text-center">Date</th>
                        <th>Time</th>
                        <th>Status</th>
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
                        <td data-cell="event name"><?= $arr["event_name"] ?></td>
                        <td data-cell="venue"><?= $arr["location"] ?></td>
                        <td data-cell="description"><?= $arr["event_description"] ?></td>
                        <td data-cell="date"><?= $arr["date"] ?></td>
                        <td data-cell="time"><?= date('g:i A', $startTime) ?> - <?= date('g:i A', $endTime) ?></td>
                        <td data-cell="status"><?= $arr["reservation_status"] ?></td>
                        <td class="text-center fst-italic">
                            <?php if($arr["reservation_status"] == "confirmed"): ?>
                                <a class="view-ticket" href="" data-id="<?= $arr["reservation_id"] ?>">View Ticket</a>
                            <?php endif; ?>
                            <?php if($arr["reservation_status"] == "pending"): ?>
                                <?php 
                                    $date = new DateTime($arr["date"]);
                                    $date->modify('-1 day'); // Subtract 1 day
                                ?>
                                Payment due: <?= $date->format('Y-m-d') ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>