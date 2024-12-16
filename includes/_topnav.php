<style>
    /* Sliding menu style */
    .sliding-menu {
        position: fixed;
        top: 0;
        left: -250px; /* Initially off-screen */
        width: 250px;
        height: 100%;
        background-color: #B22222;
        transition: 0.3s ease; /* Smooth transition */
        padding-top: 60px;
        z-index: 9999;
    }

    .sliding-menu ul {
        list-style-type: none;
        padding: 0;
    }

    .sliding-menu ul li {
        padding: 8px 16px;
        text-align: left;
    }

    .sliding-menu ul li a {
        color: #d6d6d6;
        text-decoration: none;
        font-size: 18px;
        display: block;
        transition: 0.2s;
    }

    .sliding-menu ul li a:hover {
        color: #FFFFFF;
    }

    /* When the menu is open */
    .sliding-menu.open {
        left: 0;
    }

    /* Close button inside the sliding menu */
    .close-menu-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 30px;
        color: white;
        background: transparent;
        border: none;
        cursor: pointer;
    }

    .close-menu-btn:hover {
        color: #ddd;
    }
    #burger-button {
        margin-right: 20px;
    }
    @media screen and (min-width: 768px) {
        #burger {
            display: none;
        }
    }
</style>
<div class="navbar-custom">
    <header class="px-1 shadow-sm">
        <div class="container-fluid d-flex justify-content-between">
            <button class="btn btn-toggle" id="burger-button">
                <i class="bi bi-list" id="burger"></i>
            </button>
            <div style="display: flex; align-items: center;">
                <h1 style="color: #B22222;" id="wmsu">WMSU Campus Event and Reservation System</h1>
            </div>
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-end">
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../img/empty.jpg" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li>
                            <?php if($_SESSION["account"]["role"] == "organizer"): ?>
                                <a class="dropdown-item" href="../staff/profile.php">Profile</a>
                            <?php endif; ?>
                            <?php if($_SESSION["account"]["role"] != "organizer"): ?>
                                <a class="dropdown-item" href="../<?= $_SESSION["account"]["role"] ?>/profile.php">Profile</a>
                            <?php endif; ?>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../account/logout.php">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Sliding Menu -->
    <div id="sliding-menu" class="sliding-menu">
        <button id="close-menu" class="close-menu-btn">&times;</button> <!-- Close button -->
        <?php if($_SESSION["account"]["role"] == "admin"): ?>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="../admin/dashboard.php" class="nav-link dashboard-link">
                        <i class="bi bi-speedometer2"></i>
                        <span class="fs-6 ms-2">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/proposedeventss.php"  class="nav-link proposedevents-link">
                        <i class="bi bi-calendar-week"></i>
                        <span class="fs-6 ms-2">Proposed Events</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/events.php" id="manage-link" class="nav-link manage-link">
                        <i class="bi bi-calendar-check"></i>
                        <span class="fs-6 ms-2">Manage Events</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/participants.php" class="nav-link participants-link">
                        <i class="bi bi-person-gear"></i>
                        <span class="fs-6 ms-2">Manage Participants</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/users.php" class="nav-link users-link">
                        <i class="bi bi-people"></i>
                        <span class="fs-6 ms-2">Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/profile.php" class="nav-link profile-link">
                        <i class="bi bi-person"></i>
                        <span class="fs-6 ms-2">Profile</span>
                    </a>
                </li>
            </ul>
        <?php endif; ?>
        <?php if($_SESSION["account"]["role"] == "organizer"): ?>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="../staff/events.php" class="nav-link events-link">
                        <i class="bi bi-calendar-week"></i>
                        <span class="fs-6 ms-2">Events</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../staff/reservations.php" class="nav-link dashboard-link">
                        <i class="bi bi-calendar-check"></i>
                        <span class="fs-6 ms-2">Reservations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../staff/dashboard.php" class="nav-link">
                        <i class="bi bi-calendar-event"></i>
                        <span class="fs-6 ms-2">Proposed Events</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../staff/users.php" class="nav-link users-link">
                        <i class="bi bi-person-gear"></i>
                        <span class="fs-6 ms-2">Manage Participants</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../staff/notifications.php" class="nav-link notifications-link">
                        <i class="bi bi-calendar-check"></i>
                        <span class="fs-6 ms-2">Notifications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../staff/profile.php" class="nav-link profile-link">
                        <i class="bi bi-person"></i>
                        <span class="fs-6 ms-2">Profile</span>
                    </a>
                </li>
            </ul>
        <?php endif; ?>
        <?php if($_SESSION["account"]["role"] == "user"): ?>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="../user/events.php" class="nav-link events-link">
                        <i class="bi bi-house"></i>
                        <span class="fs-6 ms-2">Events</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../user/reservations.php" class="nav-link reservations-link">
                        <i class="bi bi-calendar-check"></i>
                        <span class="fs-6 ms-2">Reservations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../user/notifications.php" class="nav-link notifications-link">
                        <i class="bi bi-calendar-check"></i>
                        <span class="fs-6 ms-2">Notifications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../user/profile.php" class="nav-link profile-link">
                        <i class="bi bi-person"></i>
                        <span class="fs-6 ms-2">Profile</span>
                    </a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const burgerButton = document.getElementById('burger-button');
        const closeButton = document.getElementById('close-menu');
        const slidingMenu = document.getElementById('sliding-menu');
        const body = document.querySelector('.content-page')

        burgerButton.addEventListener('click', function() {
            slidingMenu.classList.toggle('open');
        });

        closeButton.addEventListener('click', function() {
            slidingMenu.classList.remove('open');
        });

        body.addEventListener('click', function() {
            slidingMenu.classList.remove('open');
        });
    });
</script>