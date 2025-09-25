<?php
require_once 'include/header.php';
?>

<!-- page title area end -->
<div class="main-content-inner">
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <h4 class="header-title mb-3">Staff Record</h4>
                            <div class="mt-3 mt-md-0">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <div class="d-flex align-items-center">
                                        <i class="ti-plus text-white me-2"></i>
                                        <span class="text-white mb-0">Add User</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="market-status-table mt-4">
                            <div class="table-responsive dbkit-table" id="displayUser">
                                <h3 class="text-center text-secondary">Please wait...</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- main content area end -->
<?php
require_once 'include/footer.php';
?>