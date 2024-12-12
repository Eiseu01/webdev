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
    .category {
        display: flex;
        justify-content: space-around;
    }
    .scheduled {
       box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
    }
    .inProgress {
        box-shadow: rgba(50, 50, 93, 0.1) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.1) 0px 18px 36px -18px inset;
    }
    .ended {
        box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
    }
    .category div {
        margin: 0 0 20px 0;
        border-radius: 5px;
        cursor: pointer;
        padding: 15px 0 15px 0;
    }
    .category div a {
        text-decoration: none;
        padding: 15px 200px;
        color: black;
        font-weight: 500;
        font-size: 20px;
    }
</style>
<?php
    session_start();
    require_once("../classes/event.class.php");

    $eventObj = new Event;
    $eventObj->updateEventDateInProgress();
    $array = $eventObj->fetchEvents('','', "in_progress");
    
?>
<div class="modal-container"></div>
<div>
    <div class="username">
        <h3>Welcome Admin <?= $_SESSION["account"]["username"] ?>!</h3>
    </div>
    <div class="page-title">
        <h2>Manage Events</h2>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="category">
                <div class="scheduled">
                    <a id="scheduled" href="events-view.php">Scheduled</a>
                </div>
                <div class="inProgress">
                     <a id="inprogress" href="events-view-inprogress.php">In Progress</a>
                </div>
                <div class="ended">
                     <a id="finished" href="events-view-ended.php">Finished</a>
                </div>
            </div>
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
                </div>
            </div>
            <table id="table-products" class="table table-centered table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Event Name</th>
                        <th>Venue</th>
                        <th>Organizer</th>
                        <th>Description</th>
                        <th class="text-center">Date</th>
                        <th>Time</th>
                        <th class="text-center">Capacity</th>
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
                        <td><?= $arr["last_name"] . ', ' . $arr["first_name"] . " " . $arr["middle_name"] ?></td>
                        <td><?= $arr["event_description"] ?></td>
                        <td class="text-center" style="width: 150px;"><?= $arr["date"] ?></td>
                        <td class="text-center" style="width: 100px;"><?= date('g:i A', $startTime) ?> - <?= date('g:i A', $endTime) ?></td>
                        <td class="text-center"><?= $arr["total_capacity"] ?></td>
                        
                        <td class="text-center" style="width: 200px">
                            <?php if($arr["creation_status"] == "approved" && $arr["progress_status"] == "scheduled"): ?>
                                <a href="" class="cancel" data-id="<?= $arr["event_id"] ?>">Delete</a>
                            <?php endif; ?>
                            <?php if($arr["creation_status"] == "approved" && $arr["progress_status"] == "rescheduled"): ?>
                                <a href="" class="approve" data-id="<?= $arr["event_id"] ?>">Approve</a>
                                <a href="" class="reject" data-id="<?= $arr["event_id"] ?>">Reject</a>
                            <?php endif; ?>
                            <?php if($arr["creation_status"] == "pending"): ?>
                                <a href="" class="approve" data-id="<?= $arr["event_id"] ?>">Approve</a>
                                <a href="" class="reject" data-id="<?= $arr["event_id"] ?>">Reject</a>
                            <?php endif; ?>
                            <?php if($arr["creation_status"] == "denied"): ?>
                                
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>  
</div>