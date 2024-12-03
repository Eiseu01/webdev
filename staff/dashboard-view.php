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
        position: absolute;
        right: 100px;
        bottom: 100px;
        width: 80px;
        height: 80px;
        border-radius: 100px;
        z-index: 100;
    }
    #addEvent {
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
    #addEvent:hover {
        background-color: #EE4C51;
    }
</style>
<?php
    session_start();
    require_once("../classes/event.class.php");

    $eventObj = new Event;
    $array = $eventObj->fetchEvents($_SESSION["account"]["user_id"]);
    
?>
<div class="modal-container"></div>
<div>
    <div class="username">
        <h3>Welcome staff <?= $_SESSION["account"]["username"] ?>!</h3>
    </div>
    <div class="page-title">
        <h2>Proposed Event List</h2>
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
                        <th>Creation Status</th>
                        <th>Progress Status</th>
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
                        <td style="width: 150px;" class="text-center"><?= $arr["date"] ?></td>
                        <td style="width: 200px;" class="text-center"><?= date('g:i A', $startTime) ?> - <?= date('g:i A', $endTime) ?></td>
                        <td class="text-center"><?= $arr["creation_status"] ?></td>
                        <td class="text-center"><?= $arr["progress_status"] ?></td>
                        <td class="text-center"><?= $arr["total_capacity"] ?></td>
                        <td class="text-center"><?= $arr["available_capacity"] ?></td>
                        <td style="text-align: center;">
                            <?php if($arr["creation_status"] == "pending"): ?>
                                <a href="" class="edit text-success" data-id="<?= $arr["event_id"] ?>">Edit</a>
                                <a href="" class="delete text-danger" data-id="<?= $arr["event_id"] ?>">Delete</a>  
                            <?php endif; ?>
                            <?php if($arr["creation_status"] == "approved"): ?>
                                <a href="" class="cancel text-danger" data-id="<?= $arr["event_id"] ?>">Cancel</a>
                            <?php endif; ?>
                            <?php if($arr["creation_status"] == "denied"): ?>
                                <a href="" class="delete text-danger" data-id="<?= $arr["event_id"] ?>">Delete</a>
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
    <button id="addEvent">+</button>
</div>