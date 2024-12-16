<?php
    require_once '../classes/event.class.php';
    require_once '../classes/reserve.class.php';
    session_start();
    $eventObj = new Event;
?>
<style>
    .page-title {
        text-align: center;
        padding: 15px;
    }
    .action a {
        text-decoration: none;
    }
</style>
<h2 class="page-title">Manage Participants</h2>
<div class="modal-container"></div>
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
                            <option value="choose">Choose...</option>
                            <option value="">All</option>
                            <?php
                            $categoryList = $eventObj->fetchEvents($_SESSION["account"]["user_id"], "approved");
                            foreach ($categoryList as $cat) {
                            ?>
                            <option value="<?= $cat['event_name'] ?>"><?= $cat['event_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <table id="table-products" class="table table-centered table-nowrap mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No.</th>
                        <th>Name</th>
                        <th>Course & Level</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Event</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $reserveObj = new Reserve;
                    $array = $reserveObj->fetchEvents($_SESSION["account"]["user_id"]);

                    foreach ($array as $arr) {
                    ?>
                    <tr class="text-center">
                        <td data-cell="no."><?= $i ?></td>
                        <td data-cell="name"><?= $arr["last_name"] . ", " . $arr["first_name"] . " " . $arr["middle_name"] ?></td>
                        <td data-cell="course & level"><?= $arr["course_code"] . ' - ' . $arr["level"] ?></td>
                        <td data-cell="email"><?= $arr["email"] ?></td>
                        <td data-cell="phone number"><?= $arr["phone_number"] ?></td>
                        <td data-cell="event"><?= $arr["event_name"] ?></td>
                        <td data-cell="status"><?= $arr["reservation_status"] ?></td>
                        <td class="action text-center"> 
                            <?php if($arr["reservation_status"] == "pending"): ?>
                                <a class="confirm" href="" data-id="<?= $arr["reservation_id"] ?>" data-user="<?= $arr["user_id"] ?>" data-event="<?= $arr["event_name"] ?>">Confirm</a>
                                <a class="decline" href="" data-id="<?= $arr["reservation_id"] ?>" data-user="<?= $arr["user_id"] ?>" data-event="<?= $arr["event_name"] ?>">Decline</a>
                            <?php endif; ?>
                            <?php if($arr["reservation_status"] == "cancelled"): ?>
                                <a class="delete" href="" data-id="<?= $arr["reservation_id"] ?>">Delete</a>
                            <?php endif; ?>
                            <?php if($arr["reservation_status"] == "confirmed"): ?>
                                <p class="text-success m-0">Confirmed</p>
                            <?php endif; ?>
                        </td>
                        <td class="attendance text-center">
                            <?php if($arr["present"]): ?>
                                <a class="absent text-success" href="" style="text-decoration: none;" data-id="<?= $arr["reservation_id"] ?>">Present</a>
                            <?php endif; ?>
                            <?php if(!$arr["present"]): ?>
                                <a class="present text-danger" href="" style="text-decoration: none;" data-id="<?= $arr["reservation_id"] ?>">Absent</a>
                            <?php endif; ?> 
                        </td>
                    </tr>
                    <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>