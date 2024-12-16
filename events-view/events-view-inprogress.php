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
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        text-align: center;
        margin-bottom: 15px;
    }
    #scheduled {
        box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
    }
    #inprogress {
        box-shadow: rgba(50, 50, 93, 0.1) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.1) 0px 18px 36px -18px inset;
    }
    #finished {
        box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
    }
    .category a {
        text-decoration: none;
        color: #C74145;
        font-weight: 600;
        font-size: 20px;
        padding: 20px;
        border-radius: 10px;
        letter-spacing: 3px;
    }
    @media (max-width: 650px) {
        .category {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .category a{
            padding: 5px 30px;
        }
    }
</style>
<?php
    session_start();
    require_once("../classes/event.class.php");

    $eventObj = new Event;
    $array = $eventObj->fetchEvents('','', "in_progress");
    
?>
<div class="modal-container"></div>
<div>
    <div class="username">
        <h3>Welcome <?= $_SESSION["account"]["role"];?> <?= $_SESSION["account"]["username"];?>!</h3>
    </div>
    <div class="page-title">
        <h2>Events</h2>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="category">
                <a id="scheduled" href="">UPCOMING</a>
                <a id="inprogress" href="">IN PROGRESS</a>
                <a id="finished" href="">FINISHED</a>
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
                        <th>Date</th>
                        <th>Time</th>
                        <th>Capacity</th>
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
                        <td data-cell="organizer"><?= $arr["last_name"] . ', ' . $arr["first_name"] . " " . $arr["middle_name"] ?></td>
                        <td data-cell="description"><?= $arr["event_description"] ?></td>
                        <td data-cell="date"><?= $arr["date"] ?></td>
                        <td data-cell="time"><?= date('g:i A', $startTime) ?> - <?= date('g:i A', $endTime) ?></td>
                        <td data-cell="capacity"><?= $arr["total_capacity"] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>  
</div>