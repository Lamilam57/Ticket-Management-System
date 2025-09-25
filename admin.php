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
                            <h4 class="header-title mb-3">Ticket Record</h4>
                            <form action="#" class="form-inline d-flex flex-wrap gap-2" id="dateForm">
                                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2">
                                    <label for="fromDate" class="text-dark mt-2 mt-md-0">From Date</label>
                                    <input type="date" name="fromDate" id="fromDate" class="form-control" required>
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2">
                                    <label for="toDate" class="text-dark mt-2 mt-md-0">To Date</label>
                                    <input type="date" name="toDate" id="toDate" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                            <div id="getUser" class="mt-3 mt-md-0">
                                <p class="text-dark">Please wait...</p>
                            </div>
                        </div>
                        <div class="market-status-table mt-4">
                            <div class="table-responsive dbkit-table" id="displayTicket">
                                <h3 class="text-center text-secondary">Please Select Parameter</h3>
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