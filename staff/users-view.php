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
<div class="container-fluid">
    <h2 class="page-title">Manage Participants</h2>
    <div class="modal-container"></div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex justify-content-center align-items-center">
                            <form class="d-flex me-2">
                                <div class="input-group w-100">
                                    <input type="text" class="form-control form-control-light" id="custom-search"
                                        placeholder="Search products...">
                                    <span class="input-group-text bg-primary border-primary text-white brand-bg-color">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                            </form>
                            <div class="d-flex align-items-center">
                                <label for="category-filter" class="me-2">Category</label>
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
                    <div class="table-responsive">
                        <table id="table-products" class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Course & Level</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Event</th>
                                    <th>Action</th>
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
                                    <td><?= $i ?></td>
                                    <td class="text-start"><?= $arr["last_name"] . ", " . $arr["first_name"] . " " . $arr["middle_name"] ?></td>
                                    <td><?= $arr["course_code"] . ' - ' . $arr["level"] ?></td>
                                    <td><?= $arr["email"] ?></td>
                                    <td><?= $arr["phone_number"] ?></td>
                                    <td><?= $arr["event_name"] ?></td>
                                    <td class="action text-center"> 
                                        <a class="text-success" href="">Approve</a>
                                        <a class="text-danger" href="">Reject</a>
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
        </div>
    </div>
</div>