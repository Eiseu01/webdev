<?php
$page_title = "Events - Proposed Events";
session_start();

if (isset($_SESSION['account'])) {
    if ($_SESSION['account']['role'] != "organizer") {
        header('location: ../account/loginwcss.php');
    }
} else {
    header('location: ../account/loginwcss.php');
}

require_once '../includes/_head.php';
?>

<body id="dashboard">
    <div class="wrapper">
        <?php
        require_once '../includes/_topnav.php';
        require_once '../includes/_sidebarStaff.php';
        ?>
        <div class="content-page px-3">
            <!-- dynamic content here -->
        </div>
    </div>
    <?php
    require_once '../includes/_footerStaff.php';
    ?>
</body>

</html>