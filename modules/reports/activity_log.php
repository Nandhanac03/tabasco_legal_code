<?php
ob_start();
session_start();
include_once('../../lib/config.php');
include_once('../../lib/class/class.dbcon.php');

// Guard: only logged-in staff/admin can view
if (empty($_SESSION['LOGIN_LEGAL_ID']) && empty($_SESSION['LOGIN_SUPERADMIN_ID'])) {
    header('Location: ' . ROOT_DIR . 'login.php');
    exit;
}

// Fetch distinct modules for filter dropdown
$dbObj = new dbcon();
$modules = $dbObj->Query("SELECT DISTINCT log_menu FROM legal_activity_log ORDER BY log_menu ASC")->fetchAll(PDO::FETCH_COLUMN);

$actve_sub_menu = 'activity_log';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Activity Log — <?= SITE_NAME ?></title>
    <link href="<?= ROOT_DIR ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= ROOT_DIR ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= ROOT_DIR ?>assets/css/icons.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .filter-bar { background: #f8f9fa; border-radius: 8px; padding: 14px 18px; margin-bottom: 18px; }
        .badge { font-size: 0.72rem; }
        .table td { vertical-align: middle; font-size: 0.84rem; }
        .log-action-LOGIN  { background: #0d6efd; }
        .log-action-CREATE { background: #198754; }
        .log-action-UPDATE { background: #ffc107; color:#000; }
        .log-action-DELETE { background: #dc3545; }
        .log-action-VIEW   { background: #0dcaf0; color:#000; }
        #diff-pre { background:#1e1e1e; color:#d4d4d4; font-size:0.78rem; border-radius:6px; padding:12px; max-height:420px; overflow-y:auto; white-space:pre-wrap; word-break:break-all; }
        .added   { color:#4ec9b0; }
        .removed { color:#f44747; }
    </style>
</head>
<body>

<div class="page-wrapper">
<div class="page-content">
<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h5 class="mb-0"><i class="bx bx-list-check me-2 text-primary"></i>Activity Log</h5>
            <small class="text-muted">Every admin &amp; user action tracked in real-time</small>
        </div>
        <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i>Back
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="form-label mb-1 small fw-semibold">From Date</label>
                <input type="date" id="filter_from" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <label class="form-label mb-1 small fw-semibold">To Date</label>
                <input type="date" id="filter_to" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <label class="form-label mb-1 small fw-semibold">User Type</label>
                <select id="filter_utype" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <option value="A">Admin</option>
                    <option value="S">Staff</option>
                    <option value="C">Client</option>
                    <option value="U">Unknown</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label mb-1 small fw-semibold">Action</label>
                <select id="filter_action" class="form-select form-select-sm">
                    <option value="">All Actions</option>
                    <option value="LOGIN">LOGIN</option>
                    <option value="CREATE">CREATE</option>
                    <option value="UPDATE">UPDATE</option>
                    <option value="DELETE">DELETE</option>
                    <option value="VIEW">VIEW</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label mb-1 small fw-semibold">Module</label>
                <select id="filter_module" class="form-select form-select-sm">
                    <option value="">All Modules</option>
                    <?php foreach ($modules as $mod): ?>
                        <option value="<?= htmlspecialchars($mod) ?>"><?= htmlspecialchars($mod) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button id="btn_apply" class="btn btn-primary btn-sm w-100">
                    <i class="bx bx-filter-alt me-1"></i>Apply
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between py-2">
            <span class="fw-semibold small"><i class="bx bx-data me-1 text-primary"></i>Log Entries</span>
            <button id="btn_export" class="btn btn-sm btn-outline-success">
                <i class="bx bx-download me-1"></i>Export CSV
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="activityLogTable" class="table table-hover table-sm mb-0 w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date / Time</th>
                            <th>User ID</th>
                            <th>Type</th>
                            <th>Module</th>
                            <th>Action</th>
                            <th>Message</th>
                            <th>IP</th>
                            <th>Record ID</th>
                            <th>Diff</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div><!-- /container -->
</div><!-- /page-content -->
</div><!-- /page-wrapper -->

<!-- Diff Modal -->
<div class="modal fade" id="diffModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title"><i class="bx bx-code-alt me-2"></i>Before / After Diff — Log #<span id="diff_log_id"></span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="small fw-semibold text-danger mb-1"><i class="bx bx-minus-circle me-1"></i>BEFORE</div>
                        <pre id="diff-before" class="diff-pre" style="background:#1e1e1e;color:#f44747;font-size:.78rem;border-radius:6px;padding:10px;max-height:360px;overflow-y:auto;white-space:pre-wrap;word-break:break-all;"></pre>
                    </div>
                    <div class="col-md-6">
                        <div class="small fw-semibold text-success mb-1"><i class="bx bx-plus-circle me-1"></i>AFTER</div>
                        <pre id="diff-after" class="diff-pre" style="background:#1e1e1e;color:#4ec9b0;font-size:.78rem;border-radius:6px;padding:10px;max-height:360px;overflow-y:auto;white-space:pre-wrap;word-break:break-all;"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= ROOT_DIR ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function () {
    var table = $('#activityLogTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'ajax/get_activity_log.php',
            type: 'GET',
            data: function (d) {
                d.date_from = $('#filter_from').val();
                d.date_to   = $('#filter_to').val();
                d.utype     = $('#filter_utype').val();
                d.action    = $('#filter_action').val();
                d.module    = $('#filter_module').val();
            }
        },
        columns: [
            { data: 'log_id',      width: '50px' },
            { data: 'log_datetime' },
            { data: 'log_user',    width: '75px' },
            { data: 'log_utype',   width: '80px' },
            { data: 'log_menu' },
            { data: 'log_action',  width: '90px' },
            { data: 'log_message' },
            { data: 'log_ip',      width: '110px' },
            { data: 'log_refr_id', width: '80px' },
            { data: 'diff_btn',    orderable: false, width: '70px' }
        ],
        pageLength: 25,
        order: [[0, 'desc']],
        language: { processing: '<div class="spinner-border spinner-border-sm text-primary me-2"></div>Loading…' }
    });

    // Apply filters
    $('#btn_apply').on('click', function () {
        table.ajax.reload();
    });

    // Diff modal
    $(document).on('click', '.view-diff-btn', function () {
        var id     = $(this).data('id');
        var before = $(this).data('before');
        var after  = $(this).data('after');

        function prettyJson(raw) {
            try { return JSON.stringify(JSON.parse(raw), null, 2); }
            catch(e) { return raw || '—'; }
        }

        $('#diff_log_id').text(id);
        $('#diff-before').text(prettyJson(before));
        $('#diff-after').text(prettyJson(after));
        new bootstrap.Modal(document.getElementById('diffModal')).show();
    });

    // Export CSV
    $('#btn_export').on('click', function () {
        var params = new URLSearchParams({
            date_from : $('#filter_from').val(),
            date_to   : $('#filter_to').val(),
            utype     : $('#filter_utype').val(),
            action    : $('#filter_action').val(),
            module    : $('#filter_module').val(),
            export    : 'csv',
            length    : 99999,
            start     : 0
        });
        window.location.href = 'ajax/get_activity_log.php?' + params.toString();
    });
});
</script>
</body>
</html>
