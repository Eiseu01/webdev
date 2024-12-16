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
    .addBtn {
        position: sticky;
        bottom: 30px;
        margin-left: 240px;
        width: 80px;
        height: 80px;
        border-radius: 100px;
        z-index: 100;
    }
    #addEventBtn {
        background-color: #B22222;
        width: 100%;
        height: 100%;
        border: none;
        color: white;
        font-weight: bold;
        font-size: 32px;
        padding: 0;
        text-align: center;
        border-radius: 100px;
        transition: 0.2s;
    }
    #addEventBtn:hover, .addProductBtn:hover {
        background-color: #d13e3e;
    }
    .top-divider {
        display: flex;
        justify-content: space-between;
    }
    .addProductBtn {
        margin: 10px 10px 10px 0;
        background-color: #B22222;
        text-align: center;
        padding: 5px 10px;
        border-radius: 5px;
        transition: 0.2s;
    }
    .addProductBtn a{
        color: white;
        font-weight: bold;
        text-decoration: none;
    }
    @media only screen and (min-width: 650px) {
        .addBtn {
            display: none;
        }
    }
    @media (max-width: 650px) {
        .addProductBtn {
            display: none;
        }
    }
</style>
<?php
    session_start();
    require_once("../classes/event.class.php");

    $eventObj = new Event;
    $eventObj->updateEventDateInProgress();
    $eventObj->updateEventDateFinished();
    $array = $eventObj->fetchEvents($_SESSION["account"]["user_id"]);
    
?>
<div class="modal-container"></div>
<div>
    <div class="username">
        <h3>Welcome<?= $_SESSION["account"]["username"] ?>!</h3>
    </div>
    <div class="page-title">
        <h2>Proposed Event List</h2>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="top-divider">
                <form class="d-flex me-2">
                    <div class="input-group w-100 pb-3">
                        <input type="text" class="form-control form-control-light" id="custom-search" placeholder="Search Events...">
                        <span class="input-group-text bg-primary border-primary text-white brand-bg-color">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </form>
                <div class="addProductBtn">
                    <a class="addEvent" href="addproduct.php">Create an Event</a>
                </div>
            </div>
            <table id="table-products" class="table table-centered table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Event Name</th>
                        <th>Venue</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Creation Status</th>
                        <th>Progress Status</th>
                        <th>Status</th>
                        <th>Total Capacity</th>
                        <th>Available Capacity</th>
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
                        <td data-cell="creaton status"><?= $arr["creation_status"] ?></td>
                        <td data-cell="progress status"><?= $arr["progress_status"] ?></td>
                        <td data-cell="status">
                            <?php
                                if($arr["completion_status"] == "not_started") {
                                    echo "Not started";
                                } else if($arr["completion_status"] == "in_progress") {
                                    echo "In Progress";
                                } else {
                                    echo "Finished";
                                }
                            ?>
                        </td>
                        <td data-cell="total capacity"><?= $arr["total_capacity"] ?></td>
                        <td data-cell="available capacity"><?= $arr["available_capacity"] ?></td>
                        <td class="text-center">
                            <?php if($arr["creation_status"] == "pending"): ?>
                                <a href="" class="edit" data-id="<?= $arr["event_id"] ?>">Edit</a>
                                <a href="" class="delete" data-id="<?= $arr["event_id"] ?>">Delete</a>  
                            <?php endif; ?>
                            <?php if($arr["creation_status"] == "approved" && $arr["completion_status"] == "not_started"): ?>
                                <a href="" class="resched" data-id="<?= $arr["event_id"] ?>">Reschedule</a>
                            <?php endif; ?>
                            <?php if($arr["creation_status"] == "denied"): ?>
                                <a href="" class="delete" data-id="<?= $arr["event_id"] ?>">Delete</a>
                            <?php endif; ?>
                            <?php if($arr["completion_status"] == "in_progress"): ?>
                                
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="addBtn">
    <button id="addEventBtn" class="addEvent">+</button>
</div>