<div class="sidebar flex-column flex-shrink-0">
    <a href="#" class="logo">
        <img style="border-radius:100%; width: 80px; height: 80px; margin-left: 15px; margin-right: -30px" src="../img/wmsu-logo.png" alt="WMSU-logo">
    </a>
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
                <a href="../staff/reservations.php" class="nav-link reservations-link">
                    <i class="bi bi-calendar-check"></i>
                    <span class="fs-6 ms-2">Reservations</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="../staff/dashboard.php" class="nav-link  dashboard-link">
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