<style>
    a {
        text-decoration: none;
        color: #B22222;
    }
    .page-title {
        text-align: center;
        padding: 15px;
    }
    .picture {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .picture img {
        width: 150px;
        height: 150px;
        border: 2px solid #B22222;
        border-radius: 100px;
    }
    .container {
        display: grid;
        justify-content: center;
        align-items: center;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin: 5px;
    }
    .box {
        display: grid;
        grid-template-columns: 250px 1fr 80px;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        width: 760px;
        padding: 10px;
        border-radius: 10px;
    }
    .information p{
        margin: 10px;
        color: #2c2c2c;
    }
</style>
<?php
    session_start();
    require_once("../classes/account.class.php");

    $reserveObj = new Account();
    $array = $reserveObj->fetchUsers()
?>
<div class="modal-container"></div>
<div class="page-title">
    <h2>Users</h2>
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
                            <option value="choose">Choose...</option>
                            <option value="">All</option>
                            <option value="user">User</option>
                            <option value="organizer">Organizer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <table id="table-products" class="table table-centered table-nowrap mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No.</th>
                        <th>Username</th>
                        <th>Fullname</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($array as $arr) {
                    ?>
                    <tr>
                        <td data-cell="no."><?= $i ?></td>
                        <td data-cell="username"><?= $arr["username"] ?></td>
                        <td data-cell="fullname"><?= $arr["last_name"] . ", " . $arr["first_name"] . " " . $arr["middle_name"] ?></td>
                        <td data-cell="course"><?= $arr["course_code"] ?></td>
                        <td data-cell="year level"><?= $arr["level"] ? $arr["level"] : "NONE" ?></td>
                        <td data-cell="role"><?= $arr["role"] ?></td>
                        <td class="action text-center"> 
                            <a href="" class="manage-user" data-id="<?= $arr["user_id"] ?>">Manage</a>
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