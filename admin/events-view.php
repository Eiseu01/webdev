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
    $array = $eventObj->fetchEvents();
    
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
                        <th>Organizer</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Creation Status</th>
                        <th>Progress Status</th>
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
                        <td><?= $arr["last_name"] . ', ' . $arr["first_name"] . " " . $arr["middle_name"] ?></td>
                        <td><?= $arr["event_description"] ?></td>
                        <td style="width: 150px;"><?= $arr["date"] ?></td>
                        <td style="width: 200px;"><?= date('g:i A', $startTime) ?> - <?= date('g:i A', $endTime) ?></td>
                        <td class="text-center"><?= $arr["creation_status"] ?></td>
                        <td class="text-center"><?= $arr["progress_status"] ?></td>
                        <td class="text-center"><?= $arr["capacity"] ?></td>
                        
                        <td class="text-center">
                            <?php if($arr["creation_status"] == "approved"): ?>
                                <a href="" class="cancel text-danger" data-id="<?= $arr["event_id"] ?>">Cancel</a>
                            <?php endif; ?>
                            <?php if($arr["creation_status"] == "pending"): ?>
                                <a href="" class="approve text-success" data-id="<?= $arr["event_id"] ?>">Approve</a>
                                <a href="" class="reject text-danger" data-id="<?= $arr["event_id"] ?>">Reject</a>
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