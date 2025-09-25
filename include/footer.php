<?php
require_once 'include/modal.php';
?>
<!-- footer area start-->
<footer>
    <div class="footer-area">
        <p>© Copyright <?php echo date('Y') ?>. All right reserved. Template by <a href="https://colorlib.com/wp/">Sysoft</a>.</p>
    </div>
</footer>
<!-- footer area end-->
</div>
<!-- page container area end -->
<!-- offset area start -->

<div class="offset-area">
    <div class="offset-close"><i class="ti-close"></i></div>
    <ul class="nav offset-menu-tab">
        <?php
        if ($passwordStatus == 0) {
            echo '<li><a class="active" data-toggle="tab" href="#activity">Activity</a></li>';
        }
        ?>
        <li><a data-toggle="tab" href="#settings">Settings</a></li>
    </ul>

    <div class="offset-content tab-content">
        <div id="activity" class="tab-pane fade <?= ($passwordStatus == 0) ? 'in show active' : '' ?>">
            <div class="recent-activity">
                <div class="timeline-task">
                    <div class="icon bg-danger">
                        <i class="fa fa-key"></i>
                    </div>
                    <div class="tm-title">
                        <h4>Reset Password</h4>
                        <span class="time">Please peset password for better security</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="settings" class="tab-pane fade <?= ($passwordStatus == 1) ? 'in show active' : '' ?>">
            <div class="offset-settings">
                <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#changePasswordModal" style="color: #782DFF;">
                    <i class="ti-key"></i> Change Password
                </a>
            </div>
        </div>
    </div>
</div>

<!-- offset area end -->
<!-- jquery latest version -->
<script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
<!-- bootstrap 4 js -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/metisMenu.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.slicknav.min.js"></script>

<!-- start chart js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<!-- start highcharts js -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<!-- start zingchart js -->
<!-- <script src="https://cdn.zingchart.com/zingchart.min.js"></script> -->
<script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
</script>
<!-- all line chart activation -->
<script src="assets/js/line-chart.js"></script>
<!-- all pie chart -->
<script src="assets/js/pie-chart.js"></script>
<!-- others plugins -->
<script src="assets/js/plugins.js"></script>
<script src="assets/js/scripts.js"></script>
<script src="include/script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>