    <!-- start page content wrapper-->
    <div class="page-content-wrapper">
        <!-- start page content-->
        <div class="page-content">
            <!--start breadcrumb-->
            <div class="d-flex justify-content-between mb-1">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Case</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0 align-items-center">
                                <li class="breadcrumb-item"><a href="javascript:;"><ion-icon
                                            name="home-outline"></ion-icon></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Case Hearing</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <a class="btn btn-warning "
                    href="<?= ROOT_DIR . "activelegal/view/view/$activeLegalId.html" ?>">
                    <i class="lni lni-arrow-left"></i> Active Legal
                </a>
            </div>
            <!--end breadcrumb-->

            <div class="row">
                <div class="col col-lg-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-primary" role="tablist">
                            <?php
                                echo createNavItem(
                                    "case",
                                    "Case Root",
                                    "git-pull-request",
                                    "view",
                                    $edit_id,
                                    false
                                ); // Active tab 
                                ?>
                                <?php
                                echo createNavItem(
                                    "case",
                                    "Information",
                                    "information-sharp",
                                    "list",
                                    $edit_id,
                                    false
                                ); // Active tab 
                                ?>
                                
                                <?php
                                echo createNavItem(
                                    "case",
                                    "Documents",
                                    "document-attach-sharp",
                                    "document_view",
                                    $edit_id,
                                    false
                                ); // Active tab 
                                ?>
                                <?php
                                echo createNavItem(
                                    "case",
                                    "Hearing Date & Feedback",
                                    "calendar",
                                    "case_hearing",
                                    $edit_id,
                                    true
                                ); // Active tab 
                                ?>
                                <?php
                                echo createNavItem(
                                    "case",
                                    "Expense",
                                    "cash",
                                    "expense",
                                    $edit_id,
                                    false
                                ); // Active tab 
                                ?>
                                <?php
                                echo createNavItem(
                                    "case",
                                    "Actions",
                                    "git-pull-request",
                                    "actions",
                                    $edit_id,
                                    false
                                ); // Active tab 
                                ?>
                               
                            </ul>
                            <div class="tab-content py-3">
                                <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                                    <!--start shop cart-->
                                    <section class="shop-page">
                                        <div class="shop-container">
                                            <div class="shop-cart">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="col">
                                                                <div class="card">

                                                                </div>
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="mb-0"><i
                                                                                class="lni lni-indent-increase"></i> Case Hearing
                                                                        </h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <form>
                                                                            <div class="mb-3">
                                                                                <div class="table-responsive mt-3">
                                                                                    <table class="table align-middle mb-0">
                                                                                        <thead class="table-light">
                                                                                            <tr>
                                                                                                <td>Sl No.</td>
                                                                                                <td>Hearing Date</td>
                                                                                                <td>Hearing Feedback Date</td>
                                                                                                <td>Hearing Feedback </td>
                                                                                                <td><i class='fadeIn animated bx bx-file fs-5'></i></td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody id="hearing_data_div">
                                                                                            <tr>
                                                                                                <td class='text-center' colspan='5'>Loading data...</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page content-->

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalDelClsBtn"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Are you sure want to delete this case hearing?</label>
                            <input type="hidden" class="form-control" value="" id="deleteId">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="deleteConfirmButton"><i class="lni lni-trash"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editHearingModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Case Hearing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="editHearingForm" enctype="multipart/form-data">
                        <input type="hidden" id="edit_hearing_id">

                        <div class="mb-3">
                            <label class="form-label">Hearing Date</label>
                            <input type="date" class="form-control" id="edit_hearing_date">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hearing Feedback Date</label>
                            <input type="date" class="form-control" id="edit_hearing_feedback_date">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload New File (optional)</label>
                            <input type="file" class="form-control" id="edit_hearing_file">
                            <small id="existing_file"></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <input type="text" class="form-control" id="edit_remarks">
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="updateHearingBtn">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            <?php if ($edit_id) { ?>
                load_hearing_data();
                $("#deleteModal").on('show.bs.modal', function(event) {
                    let button = $(event.relatedTarget);
                    let chequeId = button.data('hear_id');

                    let deleteModal = $(this)
                    deleteModal.find("#deleteId").val(chequeId)
                })
            <?php } ?>
        })

        $(document).on('click', '.ajax-edit', function() {
            let hearId = $(this).data('hear_id');

            $.ajax({
                type: 'POST',
                url: '<?= ROOT_DIR ?>modules/case/ajax/case_hearing_date.php',
                data: {
                    duty: 'get_hearing',
                    id: hearId,
                    csrf_token: '<?= $_SESSION['csrf_token'] ?>'
                },
                success: function(response) {
                    if (response.success) {
                        let d = response.data;

                        $("#edit_hearing_id").val(d.id);
                        $("#edit_hearing_date").val(d.hearing_date);
                        $("#edit_hearing_feedback_date").val(d.hearing_feedback_date);
                        $("#edit_remarks").val(d.hearing_feedback);

                        if (d.file) {
                            $("#existing_file").html(
                                `<a href="<?= ROOT_DIR ?>uploads/hearing_files/${d.file}" target="_blank">View existing file</a>`
                            );
                        } else {
                            $("#existing_file").html('');
                        }

                        $("#editHearingModal").modal('show');
                    } else {
                        round_error_notify(response.message);
                    }
                }
            });
        });

        $("#updateHearingBtn").click(function() {
            let formData = new FormData();

            formData.append('duty', 'update_hearing');
            formData.append('id', $("#edit_hearing_id").val());
            formData.append('hearing_date', $("#edit_hearing_date").val());
            formData.append('hearing_feedback_date', $("#edit_hearing_feedback_date").val());
            formData.append('hearing_feedback', $("#edit_remarks").val());
            formData.append('hearing_file', $("#edit_hearing_file")[0].files[0]);
            formData.append('csrf_token', '<?= $_SESSION['csrf_token'] ?>');

            $.ajax({
                type: 'POST',
                url: '<?= ROOT_DIR ?>modules/case/ajax/case_hearing_date.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        round_success_noti(response.message);
                        $("#editHearingModal").modal('hide');
                        load_hearing_data();
                    } else {
                        round_error_notify(response.message);
                    }
                }
            });
        });



        $("#save_hearing_btn").click(function() {
            let hearing_date = $("#hearing_date")
            let hearing_feedback_date = $("#hearing_feedback_date")
            let hearing_file = $("#hearing_file")
            let remarks = $("#remarks")

            let validForm = validateForm(hearing_date, hearing_feedback_date, remarks);


            if (validForm) {
                let formData = new FormData();
                let uploaded_file = hearing_file[0].files[0]
                let csrf_token = '<?= $_SESSION['csrf_token'] ?>'
                let case_id = '<?= $edit_id ?>'

                formData.append('hearing_date', hearing_date.val());
                formData.append('hearing_feedback_date', hearing_feedback_date.val());
                formData.append('hearing_file', uploaded_file);
                formData.append('hearing_feedback', remarks.val());
                formData.append('csrf_token', csrf_token);
                formData.append('case_id', case_id);
                formData.append('duty', 'save');
                $.ajax({
                    type: 'post',
                    url: '<?= ROOT_DIR ?>modules/case/ajax/case_hearing_date.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $(".form-control").removeClass('is-invalid').removeClass('is-valid');
                            $(".form-control").val('');
                            round_success_noti(response.message)
                        } else {
                            round_error_notify(response.message);
                            if (response.file_error) {
                                hearing_file.addClass('is-invalid').removeClass('is-valid');
                                hearing_file.val('');
                            }
                        }
                        load_hearing_data();
                    }
                })
            }
        })

        $("#deleteConfirmButton").click(function() {
            let delete_id = $("#deleteId").val();
            let case_id = '<?= $edit_id ?>'
            let csrf_token = '<?= $_SESSION['csrf_token'] ?>'

            if (!deleteId || deleteId == '' || deleteId == undefined) {
                round_error_notify('ID not found');
                return;
            }

            $.ajax({
                type: 'post',
                url: '<?= ROOT_DIR ?>modules/case/ajax/case_hearing_date.php',
                data: {
                    duty: 'delete_hearing',
                    delete_id,
                    case_id,
                    csrf_token
                },
                success: function(response) {
                    if (response.success) {
                        round_success_noti(response.message)
                    } else {
                        round_error_notify(response.message);
                    }
                    $("#modalDelClsBtn").click();
                    load_hearing_data();
                }
            })

        })

        function load_hearing_data() {
            let csrf_token = '<?= $_SESSION['csrf_token'] ?>'
            let case_id = '<?= $edit_id ?>'
            $.ajax({
                type: 'post',
                url: '<?= ROOT_DIR ?>modules/case/ajax/case_hearing_date.php',
                data: {
                    duty: 'load_hearing',
                    csrf_token,
                    case_id
                },
                success: function(response) {
                    $("#hearing_data_div").html(response.message)
                }
            })
        }

        function validateForm(hearing_date, hearing_feedback_date, remarks) {
            let noError = true
            if (hearing_date.val() == '') {
                hearing_date.addClass('is-invalid').removeClass('is-valid')
                noError = false;
            } else {
                hearing_date.addClass('is-valid').removeClass('is-invalid')
            }
            if (hearing_feedback_date.val() == '') {
                hearing_feedback_date.addClass('is-invalid').removeClass('is-valid')
                noError = false;
            } else {
                hearing_feedback_date.addClass('is-valid').removeClass('is-invalid')
            }
            // if (hearing_file.val() == '') {
            //     hearing_file.addClass('is-invalid').removeClass('is-valid')
            //     noError = false;
            // } else {
            //     hearing_file.addClass('is-valid').removeClass('is-invalid')
            // }
            if (remarks.val() == '') {
                remarks.addClass('is-invalid').removeClass('is-valid')
                noError = false;
            } else {
                remarks.addClass('is-valid').removeClass('is-invalid')
            }
            return noError
        }

        function round_error_notify(msg = '') {
            Lobibox.notify('error', {
                pauseDelayOnHover: true,
                size: 'mini',
                rounded: true,
                delayIndicator: false,
                icon: 'bx bx-x-circle',
                continueDelayOnInactiveTab: false,
                position: 'top right',
                msg: msg
            });
        }
    </script>