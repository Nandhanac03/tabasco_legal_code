<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Task Reminder</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Task List</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto ">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleExtraLargeModal"><i class="fadeIn animated bx bx-plus"></i>Add
                        Task</button>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <form class="ms-auto position-relative">
                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><ion-icon
                                        name="search-sharp"></ion-icon></div>
                                <input class="form-control ps-5" type="text" placeholder="search">
                            </form>
                        </div>

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
                                            if ($taskkey > 5) {
                                                break;
                                            }
                                        ?>
                                            <tr>
                                                <td><?= ++$taskkey ?></td>
                                                <td><?= $reminder['task_name'] ?></td>
                                                <td class="text-wrap"><?= $reminder['task_info'] ?>
                                                </td>
                                                <td><?= $reminder['task_date'] ?></td>
                                                <td><?= $reminder['status'] ?></td>
                                                <td><?= $reminder['created_ago'] ?></td>
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
        <!-- end page content-->

        <div class="modal fade" id="exampleExtraLargeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="lni lni-user"></i> New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3" id="taskreminders">
                            <div class="row">
                                <div class="col-xl-12 ">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class=" p-3 rounded">


                                                <div class="col-12">
                                                    <label class="form-label">Task Name</label>
                                                    <input type="text" name="task_name" id="task_name" class="form-control">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Task Information</label>
                                                    <input type="text" name="task_info" id="task_info" class="form-control">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Task Date</label>
                                                    <input type="date" name="task_date" id="task_date" class="form-control">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Remind from</label>
                                                    <input type="date" name="task_remindfrom" id="task_remindfrom" class="form-control">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" id="status" class="form-select">
                                                        <option value="Pending">Pending</option>
                                                        <option value="Completed">Completed</option>
                                                    </select>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer ">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Task</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $("#taskreminders").on("submit", function(e) {
            e.preventDefault(); 
            let isValid = true;

            $("#taskreminders input, #taskreminders select").each(function() {
                const field = $(this);
                const value = field.val() ? field.val().trim() : "";

                field.removeClass("is-invalid is-valid");

                // Check empty
                if (value === "") {
                    field.addClass("is-invalid");
                    isValid = false;
                } else {
                    field.addClass("is-valid");
                }
            });

            if (!isValid) {
                return; 
            }

            $.ajax({
                type: "POST",
                url: "<?= ROOT_DIR ?>modules/task/ajax/task_reminders.php", // change to your backend URL
                data: {
                    task_name: $("#task_name").val(),
                    task_info: $("#task_info").val(),
                    task_date: $("#task_date").val(),
                    task_remindfrom: $("#task_remindfrom").val(),
                    status: $("#status").val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $("#exampleExtraLargeModal").modal("hide");
                        showToast("success", response.message);

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast("danger", response.message || "Failed to save notification.");
                    }
                },

                error: function(xhr) {
                    console.error(xhr.responseText);
                    showToast("danger", "An error occurred. Please try again.");
                }
            });
        });


        function showToast(type, message) {
            let toastHTML = `
        <div class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
            let toastContainer = $("#toastContainer");
            toastContainer.append(toastHTML);
            let newToast = toastContainer.find(".toast").last();
            let bsToast = new bootstrap.Toast(newToast[0], {
                delay: 3000
            });
            bsToast.show();
        }
    });
</script>