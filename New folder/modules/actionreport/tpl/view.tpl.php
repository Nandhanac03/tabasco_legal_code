<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="d-flex justify-content-between">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Action Update</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0 align-items-center">
                            <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Case Action </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="">
                <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addActionmodal">
                    <i class="fadeIn animated bx bx-plus"></i> Add Action</a>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col py-2 d-flex justify-content-between">
                            <div class="border p-3">
                                <table>
                                    <tr>
                                        <td>Marketing</td>
                                        <td>:</td>
                                        <td><?= $active_legal[0]['User_Client'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Client</td>
                                        <td>:</td>
                                        <td><?= $active_legal[0]['ClientName'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Case No.</td>
                                        <td>:</td>
                                        <td><?= $legal_case[0]['case_number'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Case Mode</td>
                                        <td>:</td>
                                        <td><?= $legal_case[0]['case_mode_title'] ?></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- <div class="">
                                <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addActionmodal">
                                    <i class="fadeIn animated bx bx-plus"></i> Add Action</a>
                            </div> -->
                        </div>
                        <div class="col">
                            <a href="javascript:history.back()">Go back<i class="lni lni-arrow-left ms-2"></i></a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Case No.</th>
                                        <th>Category</th>
                                        <th>Court</th>
                                        <th>Stage</th>
                                        <th>Register Date</th>
                                        <th>Last Action</th>
                                        <th>Last Action Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($all_roots) { ?>
                                        <div class="accordion" id="accordionExample">
                                            <?php foreach (array_reverse($all_roots) as $key => $root) { ?>
                                                <tr>
                                                    <td><?= ++$key ?>.</td>
                                                    <td>
                                                        <?= $legal_case[0]['case_number'] ?>
                                                    </td>
                                                    <td><?= $root['category_name'] ?></td>
                                                    <td><?= $root['court_name'] ?></td>
                                                    <td><?= $root['stage'] ?></td>
                                                    <td><?= $root['register_date'] ?></td>
                                                    <td style="max-width:380px; min-width:340px; white-space:normal; word-wrap:break-word; overflow-wrap:break-word; text-align: justify;"><?= $root['last_case_action'] ? $root['last_case_action'] : '...' ?></td>
                                                    <td><?= $root['last_case_date'] ? $root['last_case_date'] : '...' ?></td>
                                                    <td>

                                                        <button
                                                            class="accordion-button load-details" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?= $root['id'] ?>" aria-expanded="false" aria-controls="collapseOne<?= $root['id'] ?>" data-id="<?= $root['id'] ?>">
                                                            <i class="fadeIn animated bx bx-info-circle"></i>
                                                        </button>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="9">
                                                        <!-- <div id="collapseOne<?= $root['id'] ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                            <div class="accordion-body">
                                                                <table class="table align-middle mb-0 table-borderless">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>Date</th>
                                                                            <th>Action</th>
                                                                            <th>Sub-category</th>
                                                                            <th>Document</th>
                                                                            <th>Email Link</th>
                                                                            <th>Updated By</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>25/05/2022</td>
                                                                            <td>Documents Submitted to Al Kabban & Associates for Filing case</td>
                                                                            <td>Appeal Judgement</td>
                                                                            <td> <button class="btn"><i class="fadeIn animated bx bx-file"></i></button>
                                                                            </td>
                                                                            <td>
                                                                                <a href="" class="btn btn-outline-dark ps-3 rounded">
                                                                                    <ion-icon name="mail-outline"></ion-icon>
                                                                                </a>
                                                                            </td>
                                                                            <td>Al Kabban & Associate</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>25/05/2022</td>
                                                                            <td>Documents Submitted to Al Kabban & Associates for Filing case</td>
                                                                            <td>Appeal Judgement</td>
                                                                            <td><button class="btn"><i class="fadeIn animated bx bx-file"></i></button></td>
                                                                            <td>
                                                                                <a href="" class="btn btn-outline-dark ps-3 rounded">
                                                                                    <ion-icon name="mail-outline"></ion-icon>
                                                                                </a>
                                                                            </td>
                                                                            <td>Al Kabban & Associate</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>25/05/2022</td>
                                                                            <td>Documents Submitted to Al Kabban & Associates for Filing case</td>
                                                                            <td>Appeal Judgement</td>
                                                                            <td>
                                                                                <button class="btn"><i class="fadeIn animated bx bx-file"></i></button>
                                                                            </td>
                                                                            <td>
                                                                                <a href="" class="btn btn-outline-dark ps-3 rounded">
                                                                                    <ion-icon name="mail-outline"></ion-icon>
                                                                                </a>
                                                                            </td>
                                                                            <td>Al Kabban & Associate</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div> -->
                                                        <div id="collapseOne<?= $root['id'] ?>"
                                                            class="accordion-collapse collapse"
                                                            aria-labelledby="headingOne"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="table-container" id="table-<?= $root['id'] ?>">
                                                                    <!-- Data will be loaded here via AJAX -->
                                                                    <div class="text-center p-3">Loading...</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </div>
                                    <?php } else { ?>
                                        <div>
                                            <tr>
                                                <td colspan="9" style="text-align: center;">No records available.</td>
                                            </tr>
                                        </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page content-->
        <div class="modal fade" id="addActionmodal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="lni lni-comments-alt"></i> New Action</h5>
                    </div>
                    <form class="row g-3" id="addactionForm">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-12 ">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class=" p-3 rounded">
                                                <input type="hidden" id="case_id" value="<?= $id ?>">
                                                <input type="hidden" id="active_legal_id" value="<?= $active_legal[0]['id'] ?>">

                                                <div class="col-12">
                                                    <label class="form-label">Client</label>
                                                    <input type="text" id="client" class="form-control" value="<?= $active_legal[0]['ClientName'] ?>" readonly>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Case</label>
                                                    <input type="text" class="form-control" id="case_number" value="<?= $legal_case[0]['case_number'] ?>" readonly>
                                                </div>
                                                <!-- <div class="col-12">
                                                    <label class="form-label">Email Link</label>
                                                    <input type="text" class="form-control" id="email">
                                                </div> -->
                                                <div class="col-12">
                                                    <label class="form-label">Category</label>
                                                    <select class="form-select" id="category_id" name="category_id">
    <option value="">--- Select type ---</option>

    <?php if ($all_category) { ?>
        <?php foreach ($all_category as $category) { ?>

            <option value="<?= $category['id'] ?>"
    <?= ($category['id'] == $selected_category_id) ? 'selected' : '' ?>>
    <?= $category['title'] ?>
</option>


        <?php } ?>
    <?php } ?>
</select>

                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Sub-category</label>
                                                    <select type="text" class="form-select" id="sub_category_id">
                                                        <option value="">--- Select type ---</option>
                                                        <?php if ($all_sub_category) { ?>
                                                            <?php foreach ($all_sub_category as $subcategory) { ?>
                                                                <option value="<?= $subcategory['id'] ?>"><?= $subcategory['title'] ?></option>

                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback"></div>

                                                </div>
                                                <!-- <div class="col-12">
                                                    <label class="form-label">Stage</label>
                                                    <select class="form-select" id="stage">
                                                        <option value="">--- Select Stage ---</option>
                                                    </select>

                                                    <div class="invalid-feedback"></div>

                                                </div> -->
                                                <!-- <div class="col-12">
                                                    <label class="form-label">UAE Pass</label>
                                                    <select type="text" class="form-select" id="uae_pass">
                                                        <option value="YES">YES</option>
                                                        <option value="NO">NO</option>
                                                    </select>
                                                    <div class="invalid-feedback"></div>

                                                </div> -->
                                                <div class="col-12">
                                                    <label class="form-label">Date</label>
                                                    <input type="date" class="form-control" id="date">
                                                    <div class="invalid-feedback"></div>

                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Description</label>
                                                    <textarea class="form-control" id="description"></textarea>
                                                    <small id="descriptionError" class="text-danger d-none"></small>
                                                    <div class="invalid-feedback"></div>

                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Upload Document</label>
                                                    <input type="file" class="form-control" id="document_file">
                                                    <small class="text-muted">Only files in JPG, PNG, or PDF formats are permitted, with a size limit of 1MB</small>
                                                    <div class="invalid-feedback">Only JPG, PNG, or PDF under 1MB allowed.</div>
                                                </div>
                                                <div>
                                                    <input type="hidden" name="client_id" id="client_id" value="<?= $active_legal[0]['client'] ?>">
                                                    <input type="hidden" name="firm_id" id="firm_id" value="<?= $active_legal[0]['agencies_id'] ?>">
                                                    <input type="hidden" name="parent_type" id="parent_type" value="<?= $active_legal[0]['legal_firm_type'] ?>">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer ">
                            <button type="submit" class="btn btn-primary">Save </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="modal fade" id="actionsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fadeIn animated bx bx-layer-plus"></i>Action Report</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 ">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive mt-3">
                                            <table class="table align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                        <th>Sub-category</th>
                                                        <th>Document</th>
                                                        <th>Email Link</th>
                                                        <th>Updated By</th>
                                                        <!-- <th></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>25/05/2022</td>
                                                        <td>Documents Submitted to Al Kabban & Associates for Filing case</td>
                                                        <td>Appeal Judgement</td>
                                                        <td> <button class="btn"><i class="fadeIn animated bx bx-file"></i></button>
                                                        </td>
                                                        <td>
                                                            <a href="" class="btn btn-outline-dark ps-3 rounded">
                                                                <ion-icon name="mail-outline"></ion-icon>
                                                            </a>
                                                        </td>
                                                        <td>Al Kabban & Associate</td>
                                                        <!-- <td>
                                            <button type="button" class="btn btn-success" title="Shareable Link"><i
                                                    class="lni lni-eye"></i>
                                            </button>
                                        </td> -->
                                                    </tr>
                                                    <tr>
                                                        <td>25/05/2022</td>
                                                        <td>Documents Submitted to Al Kabban & Associates for Filing case</td>
                                                        <td>Appeal Judgement</td>
                                                        <td><button class="btn"><i class="fadeIn animated bx bx-file"></i></button></td>
                                                        <td>
                                                            <a href="" class="btn btn-outline-dark ps-3 rounded">
                                                                <ion-icon name="mail-outline"></ion-icon>
                                                            </a>
                                                        </td>
                                                        <td>Al Kabban & Associate</td>
                                                        <!-- <td>
                                            <button type="button" class="btn btn-success" title="Shareable Link"><i
                                                    class="lni lni-eye"></i>
                                            </button>
                                        </td> -->
                                                    </tr>
                                                    <tr>
                                                        <td>25/05/2022</td>
                                                        <td>Documents Submitted to Al Kabban & Associates for Filing case</td>
                                                        <td>Appeal Judgement</td>
                                                        <td>
                                                            <button class="btn"><i class="fadeIn animated bx bx-file"></i></button>
                                                        </td>
                                                        <td>
                                                            <a href="" class="btn btn-outline-dark ps-3 rounded">
                                                                <ion-icon name="mail-outline"></ion-icon>
                                                            </a>
                                                        </td>
                                                        <td>Al Kabban & Associate</td>
                                                        <!-- <td>
                                            <button type="button" class="btn btn-success" title="Shareable Link"><i
                                                    class="lni lni-eye"></i>
                                            </button>
                                        </td> -->
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary">Save Client</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
    <div id="liveToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    document.getElementById('category_id').addEventListener('change', function() {
        let categoryId = this.value;
        let case_id = document.getElementById('case_id').value;
        let active_legal_id = document.getElementById('active_legal_id').value;


        if (categoryId) {
            $.ajax({
                url: '<?= ROOT_DIR ?>modules/actionreport/ajax/load_action_stage.php',
                type: 'POST',
                data: {
                    categoryId,
                    case_id,
                    active_legal_id
                },
                success: function(response) {
                    $('#stage').html(response); // inject the options into the select
                },
                error: function(xhr, status, error) {
                    showToast('danger', 'An error occurred. Please try again.');
                }
            });
        }
    });



    document.getElementById('addactionForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const requiredFields = [
            'case_id',
            'active_legal_id',
            'client', // Assumes this is the ID of #select_client
            'case_number',
            'category_id',
            'sub_category_id',
            'stage',
            'date',
            'description',
            'uae_pass'
        ];
        let isValid = true;

        function validateField(fieldId) {
            const field = document.getElementById(fieldId);
            field.classList.remove('is-invalid', 'is-valid');
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                return false;
            } else {
                field.classList.add('is-valid');
                return true;
            }
        }

        // Validate required fields
        requiredFields.forEach(fieldId => {
            if (!validateField(fieldId)) isValid = false;
        });

        // Validate File (unchanged)
        const fileField = document.getElementById('document_file');
        const document_file = fileField.files[0];
        fileField.classList.remove('is-invalid', 'is-valid');

        if (document_file) {
            const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
            const maxSize = 1 * 1024 * 1024; // 1MB
            if (!allowedTypes.includes(document_file.type) || document_file.size > maxSize) {
                fileField.classList.add('is-invalid');
                isValid = false;
            } else {
                fileField.classList.add('is-valid');
            }
        }

        if (!isValid) {
            return;
        }

        // Build FormData
        let formData = new FormData();
        formData.append('action', 'new_action');

        // Handle email (optional, no pattern validation)
        const email = document.getElementById('email').value.trim();
        formData.append('email', email); // Always append, even if empty

        const client_id = document.getElementById('client_id').value;
        const firm_id = document.getElementById('firm_id').value;
        const parent_type = document.getElementById('parent_type').value;
        formData.append('client_id', client_id);
        formData.append('firm_id', firm_id);
        formData.append('parent_type', parent_type);
        // Append required fields
        requiredFields.forEach(fieldId => {
            const value = document.getElementById(fieldId).value.trim();
            formData.append(fieldId, value);
        });

        // Append file if present
        if (document_file) {
            formData.append('document_file', document_file);
        }

        // Send via AJAX
        $.ajax({
            url: '<?= ROOT_DIR ?>modules/actionreport/view.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showToast('success', response.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast('danger', response.message || 'Form submission failed.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error, xhr.responseText); // Debug error
                showToast('danger', 'An error occurred. Please try again.');
            }
        });

        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('addActionmodal')).hide();
    });

    function showToast(type, message) {
        const toastEl = document.getElementById('liveToast');
        const toastBody = toastEl.querySelector('.toast-body');

        // Update class for type (success, danger, warning, info)
        toastEl.className = `toast align-items-center text-bg-${type} border-0`;

        toastBody.textContent = message;

        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
</script>

<script>
    $(document).on('click', '.load-details', function() {
        let btn = $(this);
        let recordId = btn.data('id');
        let targetDiv = $("#table-" + recordId);

        // Prevent multiple requests if already loaded
        if (!targetDiv.data('loaded')) {
            $.ajax({
                url: "<?= ROOT_DIR ?>modules/actionreport/ajax/load_action_root_data.php",
                type: "POST",
                data: {
                    id: recordId
                },
                beforeSend: function() {
                    targetDiv.html('<div class="text-center p-3">Loading...</div>');
                },
                success: function(response) {
                    targetDiv.html(response);
                    targetDiv.data('loaded', true); // mark as loaded
                },
                error: function() {
                    targetDiv.html('<div class="text-danger p-3">Error loading data.</div>');
                }
            });
        }
    });
</script>