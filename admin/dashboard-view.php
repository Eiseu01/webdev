<?php 
    session_start();
    require_once("../classes/event.class.php");

    $eventObj = new Event;
    $array = $eventObj->fetchEvents('','','finished');
    $counts = $eventObj->statistics();
    $eventObj->updateEventDateInProgress();
    $eventObj->updateEventDateFinished();
?>
<style>
    .username h3{
        padding: 15px 15px 0 15px;
        margin: 0;
        color: #B22222;
    }
    .body {
        cursor: pointer;
        transition: 0.2s;
    }
    .body:hover {
        background-color: #B22222;
        color: white;
    }
    a {
        text-decoration: none;
        color: #2C2C2C;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div>
            <div class="username">
                <h3>Welcome Admin <?= $_SESSION["account"]["username"] ?>!</h3>
            </div>
        </div>
        <div class="col-12">
            <div>
                <h4 class="page-title text-center m-2">Dashboard</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 d-flex flex-column">
            <div class="row flex-grow-1">
                <div class="col-12 col-sm-6 col-md-6 col-xl-3 pb-4">
                    <div class="card widget-flat mb-0">
                        <a href="events.php">
                            <div class="card-body body">
                                <div class="float-end me-2">
                                    <i class="bi bi-calendar3 fs-1"></i>
                                </div>
                                <h5 class="fw-normal mt-0" title="Number of Customers">Upcoming Events</h5>
                                <h3 class="my-3"><?= $counts["upcoming_events"] ?></h3>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-xl-3 pb-4">
                    <div class="card widget-flat mb-0">
                        <a href="events.php">
                            <div class="card-body body">
                                <div class="float-end me-2">
                                    <i class="bi bi-calendar2-event  fs-1"></i>
                                </div>
                                <h5 class="fw-normal mt-0" title="Number of Orders">In Progress Events</h5>
                                <h3 class="my-3"><?= $counts["in_progress_events"] ?></h3>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-xl-3 pb-4">
                    <div class="card widget-flat mb-0">
                        <a href="events.php">
                            <div class="card-body body">
                                <div class="float-end me-2">
                                    <i class="bi bi-calendar-check fs-1"></i>
                                </div>
                                <h5 class="fw-normal mt-0" title="Average Sales">Finished Events</h5>
                                <h3 class="my-3"><?= $counts["finished_events"] ?></h3>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-6 col-xl-3 pb-4">
                    <div class="card widget-flat mb-0">
                        <a href="users.php">
                            <div class="card-body body">
                                <div class="float-end me-2">
                                    <i class="bi bi-people fs-1"></i>
                                </div>
                                <h5 class="fw-normal mt-0" title="Growth">Users</h5>
                                <h3 class="my-3"><?= $counts["total_users"] ?></h3>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card p-4">
                <div class="d-flex card-header justify-content-between align-items-center w-100 px-2">
                    <h3 class="header-title mb-0">Recent Events</h3>
                </div>
                <div class="card-body p-1 pt-2">
                    <div class="table-responsive">
                        <table id="table-products" class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Event Venue</th>
                                    <th>Description</th>
                                    <th>Organizer</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($array)) { ?>
                                    <tr><td colspan="5" class="text-center">No Recent Events</td></tr>
                                <?php } ?>
                                
                                <?php 
                                    foreach($array as $arr): 
                                    $startTime = strtotime($arr["start_time"]);
                                    $endTime = strtotime($arr["end_time"]);
                                ?>
                                <tr>
                                    <td data-cell="event name"><?= $arr["event_name"] ?></td>
                                    <td data-cell="venue"><?= $arr["location"] ?></td>
                                    <td data-cell="description"><?= $arr["event_description"] ?></td>
                                    <td data-cell="organizer"><?= $arr["last_name"] . ", " . $arr["first_name"] . " " . $arr["middle_name"] ?></td>
                                    <td data-cell="date"><?= $arr["date"] ?></td>
                                    <td data-cell="time"><?= date('g:i A', $startTime) ?> - <?= date('g:i A', $endTime) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>