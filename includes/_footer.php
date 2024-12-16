<footer style="position: absolute; bottom: 0; left: 500px; right: 500px; margin-top: 500px;" class="text-center">&copy; Copyright: WMSU Campus Event and Reservation System</footer>
<script src="../vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
<script src="../vendor/datatable-2.1.8/datatables.min.js"></script>
<?php if (isset($_SESSION["account"])): ?>
    <?php if ($_SESSION["account"]["role"] == "organizer"): ?>
        <script src="../js/staff.js"></script>
    <?php elseif ($_SESSION["account"]["role"] == "admin"): ?>
        <script src="../js/admin.js"></script>
    <?php elseif ($_SESSION["account"]["role"] == "user"): ?>
        <script src="../js/user.js"></script>
    <?php endif; ?>
<?php endif; ?>
