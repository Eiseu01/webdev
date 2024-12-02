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
    }
    .container {
        display: grid;
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
    }
</style>
<?php
    session_start();
    require_once("../classes/account.class.php");

    $reserveObj = new Account();
    $array = $reserveObj->fetchUsers($_SESSION["account"]["user_id"]) //It should not be hardcoded
?>
<div class="modal-container"></div>
<div class="page-title">
    <h2>Users</h2>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="container">
                <?php foreach($array as $arr): ?>
                    <div class="box">
                        <div class="picture">
                            <img src="../img/empty.jpg">
                        </div>
                        <div>
                            <div class="information">
                                <p>Username: <?= $arr["username"] ?></p>
                                <p>Full Name: <?= $arr["last_name"] . ", " . $arr["first_name"] . " " . $arr["middle_name"] ?></p>
                                <p>Course: <?= $arr["course_code"] ?></p>
                                <p>Year Level: <?= $arr["level"] ? $arr["level"] : "NONE" ?> </p>
                                <p>Role: <?= $arr["role"] ?> </p>
                            </div>
                        </div>
                        <div>
                            <a href="" class="manage-user" data-id="<?= $arr["user_id"] ?>">Manage</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>