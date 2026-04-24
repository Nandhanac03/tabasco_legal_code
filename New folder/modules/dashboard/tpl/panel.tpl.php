<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">

        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Dashboard</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon
                                    name="speedometer-outline"></ion-icon></a>
                        </li>

                    </ol>
                </nav>
            </div>
            <div class="ms-auto d-none">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary">Settings</button>
                    <button type="button"
                        class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                            href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                            link</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->





        <div class="row ">
            <div class="col-12 col-lg-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div
                            class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-3 row-cols-xxl-3 row-cols-xl-4 row-cols-xxl-4 g-3 ">
                            <div class="col " onclick="window.location.href='<?= ROOT_DIR ?>client/list.html';">
                                <a href="javascript:;" class="text-dark">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-tiffany">
                                                    <ion-icon name="person-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2 ">Client</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:;" class="text-dark">
                                    <div class="card radius-10 border shadow-none mb-0 cursor-pointer"
                                        onclick="window.location.href='<?= ROOT_DIR ?>thirdparty/list.html';">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-danger">
                                                    <ion-icon name="keypad-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Third Party</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:;" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0"
                                        onclick="window.location.href='<?= ROOT_DIR ?>legalfirm/list.html';">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-warning">
                                                    <ion-icon name="business-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Legal Firm</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:;" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0"
                                        onclick="window.location.href='<?= ROOT_DIR ?>debtcollector/list.html';">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-success">
                                                    <ion-icon name="bicycle-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Debt Collector</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:;" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0"
                                        onclick="window.location.href='<?= ROOT_DIR ?>activelegal/list.html';">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-primary">
                                                    <ion-icon name="briefcase-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Active Legal</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?= ROOT_DIR ?>actionreport/list.html" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-info">
                                                    <ion-icon name="apps-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Action Update</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?= ROOT_DIR ?>closedlegal/list.html" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-purple">
                                                    <ion-icon name="document-lock-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Closed Legal</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?= ROOT_DIR ?>baddebts/list.html" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-tiffany">
                                                    <ion-icon name="file-tray-full-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Bad Debts Report</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?= ROOT_DIR ?>expensereport/list.html" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-pink">
                                                    <ion-icon name="file-tray-stacked-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Collection & Expense </h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?= ROOT_DIR ?>totallegal/list.html" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-info">
                                                    <ion-icon name="documents-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Total Legal</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            <div class="col">
                                <a href="<?= ROOT_DIR ?>commissionreport/commission.html" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-warning">
                                                    <ion-icon name="wallet-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Commissions</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="#" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0" onclick="window.location.href='<?= ROOT_DIR ?>legalteam/list.html';">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-success">
                                                    <ion-icon name="man-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Legal Team</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col">
                                <a href="#" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0" onclick="window.location.href='<?= ROOT_DIR ?>internalstaff/list.html';">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-primary">
                                                    <i class="fadeIn animated bx bx-user-circle"></i>
                                                </div>
                                                <h6 class="mb-0 mt-2">Internal Staff</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            <div class="col">
                                <a href="<?= ROOT_DIR   ?>notifications/list.html" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-default">
                                                    <i class="fadeIn animated bx bx-bell"></i>
                                                </div>
                                                <h6 class="mb-0 mt-2">Notifications</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>



                            <div class="col">
                                <a href="<?= ROOT_DIR   ?>task/list.html" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-primary">
                                                    <i class="fadeIn animated bx bx-alarm"></i>
                                                </div>
                                                <h6 class="mb-0 mt-2">Task Reminders</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            <div class="col d-none">
                                <a href="#" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0" onclick="window.location.href='<?= ROOT_DIR ?>settings/profile.html';">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-info">
                                                    <i class="fadeIn animated bx bx-edit-alt"></i>
                                                </div>
                                                <h6 class="mb-0 mt-2">Edit Profile</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col">
                                <a href="#" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0" onclick="window.location.href='<?= ROOT_DIR ?>reports/list.html';">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-info">
                                                    <i class="fadeIn animated bx bx-edit-alt"></i>
                                                </div>
                                                <h6 class="mb-0 mt-2">Reports</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- <div class="col">
                                <a href="<?= ROOT_DIR ?>task/list.html" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-warning">
                                                    <ion-icon name="alarm-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Task Reminder</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div> -->






                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end row-->


        <div class="card radius-10 w-100">
            <div class="card-body">
                <ul class="nav nav-tabs nav-primary" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab"
                            aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><ion-icon name="notifications" size="small"></ion-icon>
                                </div>
                                <div class="tab-title">Notifications</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false"
                            tabindex="-1">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><ion-icon name="calendar" size="small"></ion-icon>
                                </div>
                                <div class="tab-title">Task Reminder</div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content py-3">
                    <div class="tab-pane fade active show" id="primaryhome" role="tabpanel">
                        <div class="table-responsive mt-2">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#ID</th>
                                        <th>Hearing Date</th>
                                        <th>Case No.</th>
                                        <th>Client</th>
                                        <th>Firm</th>
                                        <th>Feedback</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($case_notification) { ?>
                                        <?php foreach ($case_notification as $key => $notification) {
                                            if ($key == 5) {
                                                break;
                                            }
                                        ?>
                                            <tr>
                                                <td><?= ++$key ?></td>
                                                <td><?= $notification['hearing_date'] ?></td>
                                                <td>#<?= $notification['case_number'] ?></td>
                                                <td><?= $notification['user_name'] ?></td>
                                                <td><?= $notification['client_name'] ?></td>
                                                <td><?= $notification['case_status'] ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3 fs-6">
                                                        <a href="<?= ROOT_DIR ?>case/hearing/edit/<?= $notification['case_id'] ?>.html" class="text-primary"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                                            data-bs-original-title="View detail" aria-label="Views">
                                                            <ion-icon name="eye-outline"></ion-icon>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td style="color: red;">No data available</td>
                                            <td colspan="3"></td>
                                        </tr>
                                    <?php } ?>



                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-3">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:10%;">#</th>
                                                <th style="width:10%;">Task</th>
                                                <th style="width:60%;">Description</th>
                                                <th style="width:10%;">Date</th>
                                                <th style="width:15%;">Status</th>
                                                <th style="width:15%;">Created</th>
                                                <th style="width:15%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($task_reminders) { ?>
                                                <?php foreach ($task_reminders as $taskkey => $reminder) {
                                                    if ($taskkey > 5) break;
                                                ?>
                                                    <tr id="row_<?= $reminder['id'] ?>">
                                                        <td><?= ++$taskkey ?></td>
                                                        <td><?= $reminder['task_name'] ?></td>
                                                        <td class="text-wrap"><?= $reminder['task_info'] ?></td>
                                                        <td><?= $reminder['task_date'] ?></td>
                                                        <td><?= $reminder['status'] ?></td>
                                                        <td><?= $reminder['created_ago'] ?></td>

                                                        <!-- pass reminder ID to button -->
                                                        <td>
                                                            <button class="btn delete-task" data-id="<?= $reminder['id'] ?>">
                                                                <i class="lni lni-close"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td style="color: red;">No data available</td>
                                                    <td colspan="3"></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end page content-->
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).on("click", ".delete-task", function() {
        let taskId = $(this).data("id");
        let row = $("#row_" + taskId);

        $.ajax({
            url: "<?= ROOT_DIR ?>modules/dashboard/ajax/update_task_reminder.php",
            type: "POST",
            data: {
                id: taskId,
                action: "hide_task"
            },
            success: function(response) {
                console.log(response); 
                if (response.trim() === "success") {   // FIXED
                    row.fadeOut(300, function() {
                        $(this).remove();
                    });
                } else {
                    alert("Error deleting task");
                }
            }
        });
    });
</script>
