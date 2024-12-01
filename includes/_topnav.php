<div class="navbar-custom">
    <header class="px-1 shadow-sm">
        <div class="container-fluid d-flex justify-content-between">
            <!-- <button class="btn btn-toggle">
                <i style="display:none;" class="bi bi-list"></i>
            </button> -->
            <div class="wmsu-logo">
                <img style="display:none; width: 80px; height: 80px; margin-left: 15px; margin-right: -30px" src="../img/wmsu-logo.png" alt="WMSU-logo">
            </div>
            <div style="display: flex; align-items: center;">
                <h1 style="color: #B22222;">WMSU Campus Event and Reservation System</h1>
            </div>
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-end">
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../img/empty.jpg" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li>
                            <a class="dropdown-item" href="../<?= $_SESSION["account"]["role"] ?>/profile.php">Profile</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../account/logout.php">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</div>