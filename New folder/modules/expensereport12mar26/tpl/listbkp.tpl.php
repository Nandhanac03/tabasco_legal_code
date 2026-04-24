<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Expense Report</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Expense List</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto ">
                <div class="btn-group d-none">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleExtraLargeModal"><i class="fadeIn animated bx bx-plus"></i>Add
                        new</button>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0"><i class="lni lni-list"></i></h5>
                            <div class="">
                                <button class="btn btn-outline-dark me-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addExpenseModal">
                                    Add Expense
                                </button>
                                <button class="btn btn-outline-dark me-2" data-bs-toggle="modal"
                                    data-bs-target="#addClaimModal">
                                    Add Collection
                                </button>
                                <button class="btn btn-outline-primary ms-auto mb-0">
                                    <i class="lni lni-download"></i>
                                </button>
                            </div>

                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Marketing</th>
                                        <th>Client</th>
                                        <th>Present Legal Firm</th>
                                        <th>Case Status</th>
                                        <th>Claim Amount</th>
                                        <th>Recieved Collection</th>
                                        <th>Balance to Claim</th>
                                        <th>Expense</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($array_expenses || $array_collection) { ?>
                                        <?php foreach ($array_expenses as $expense) { ?>
                                            <tr>
                                                <td><?= $expense['date'] ?></td>
                                                <td><?= $expense['marketing_person'] ?></td>
                                                <td><?= $expense['client_name'] ?></td>
                                                <td><?= $expense['Present_Legal_Firm_Name'] ?>
                                                <td>Open </td>
                                                <td>...</td>
                                                <td>...</td>
                                                <td>...</td>
                                                <td><?= $expense['amount'] ?></td>
                                                <td>
                                                    <a href="<?= ROOT_DIR ?>expensereport/expense/view/<?= $expense['id'] ?>.html" class="text-dark btn"><i
                                                            class="lni lni-eye"></i></a>
                                                </td>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php foreach ($array_collection as $collection) { ?>
                                            <tr>
                                                <td><?= $collection['date'] ?></td>
                                                <td><?= $collection['marketing_person'] ?></td>
                                                <td><?= $collection['client_name'] ?></td>
                                                <td><?= $collection['Present_Legal_Firm_Name'] ?>
                                                <td>Open </td>
                                                <td>...</td>
                                                <td><?= $collection['amount'] ?></td>
                                                <td>...</td>
                                                <td>...</td>
                                                <td>
                                                    <a href="<?= ROOT_DIR ?>expensereport/claimamount/view/<?= $collection['id'] ?>.html" class="text-dark btn"><i
                                                            class="lni lni-eye"></i></a>
                                                </td>
                                                </td>
                                            </tr>

                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="9" style="text-align: center;">No records available</td>
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
                        <h5 class="modal-title"><i class="lni lni-plus"></i> Add Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 ">
                                <div class="card">
                                    <div class="card-body">
                                        <div class=" p-3 rounded">
                                            <form class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label">Marketing</label>
                                                    <select class="form-select">
                                                        <option selected="selected">Select marketing</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Client</label>
                                                    <select class="form-select">
                                                        <option selected="selected">Select client</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Contact number</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Total outstanding</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Outstanding cheque</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Outstanding without cheque</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Upload cheque</label>
                                                    <input type="file" class="form-control" id="inputGroupFile01">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save Client</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Collection Modal -->
        <div class="modal fade" id="addClaimModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="lni lni-plus"></i> Add Collection</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" id="collection_modal" class="modal-form" data-form-type="collection">
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Marketing:</label>
                                                <select class="form-select select2-bootstrap select-marketing" name="coll_select_marketing">
                                                    <option value="">Select Marketing</option>
                                                    <?php if ($array_users): ?>
                                                        <?php foreach ($array_users as $user):
                                                            $selected = ($data["user_id"] == $user["user_Id"]) ? "selected" : "";
                                                        ?>
                                                            <option value="<?= $user["user_Id"] ?>" <?= $selected ?>>
                                                                <?= $user["user_name"] ?> - <?= $user["usertype_title"] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Client:</label>
                                                <select class="form-select select2-bootstrap select-client" name="coll_select_client">
                                                    <option value="">Select Client</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Legal Code:</label>
                                                <select class="form-select select2-bootstrap select-active-legal" name="coll_select_active_legal">
                                                    <option value="">Select Legal Code</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Case:</label>
                                                <select class="form-select select2-bootstrap select-active-legal-case" name="coll_select_active_legal_case">
                                                    <option value="">Select Case</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Category:</label>
                                                <select class="form-control select-category-type" name="coll_category_type">
                                                    <option value="">- - select - -</option>
                                                    <option value="third_party">Third Party</option>
                                                    <option value="debt_collector">Debt Collector</option>
                                                    <option value="legal_firm">Legal Firm</option>
                                                    <option value="legal_team">Legal Team</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Firm:</label>
                                                <select class="form-control select-party-names" name="coll_party_names">
                                                    <option value="">- - select - -</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Date:</label>
                                                <input type="date" name="coll_exp_date" class="form-control input-date">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Fees Type:</label>
                                                <select class="form-select select-fee-type" name="coll_fee_type">
                                                    <option value="Court Fee">Court Fee</option>
                                                    <option value="Translation Fee">Translation Fee</option>
                                                    <option value="Legal Notice">Legal Notice</option>
                                                    <option value="Expert Fee">Expert Fee</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Amount:</label>
                                                <input type="text" name="coll_amount" class="form-control input-amount">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Attachment:</label>
                                                <input type="file" name="coll_attachment_file" class="form-control input-attachment">
                                                <span class="invalid-feedback">Allowed: JPG, PNG, PDF up to 1MB.</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description:</label>
                                                <textarea class="form-control input-description" name="coll_description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary submit-btn">Save Collection</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Expense Modal -->
        <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="lni lni-plus"></i> Add Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" id="expense_modal" class="modal-form" data-form-type="expense">
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Marketing:</label>
                                                <select class="form-select select2-bootstrap select-marketing" name="select_marketing">
                                                    <option value="">Select Marketing</option>
                                                    <?php if ($array_users): ?>
                                                        <?php foreach ($array_users as $user):
                                                            $selected = ($data["user_id"] == $user["user_Id"]) ? "selected" : "";
                                                        ?>
                                                            <option value="<?= $user["user_Id"] ?>" <?= $selected ?>>
                                                                <?= $user["user_name"] ?> - <?= $user["usertype_title"] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Client:</label>
                                                <select class="form-select select2-bootstrap select-client" name="select_client">
                                                    <option value="">Select Client</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Legal Code:</label>
                                                <select class="form-select select2-bootstrap select-active-legal" name="select_active_legal">
                                                    <option value="">Select Legal Code</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Case:</label>
                                                <select class="form-select select2-bootstrap select-active-legal-case" name="select_active_legal_case">
                                                    <option value="">Select Case</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Category:</label>
                                                <select class="form-control select-category-type" name="category_type">
                                                    <option value="">- - select - -</option>
                                                    <option value="third_party">Third Party</option>
                                                    <option value="debt_collector">Debt Collector</option>
                                                    <option value="legal_firm">Legal Firm</option>
                                                    <option value="legal_team">Legal Team</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Firm:</label>
                                                <select class="form-control select-party-names" name="party_names">
                                                    <option value="">- - select - -</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Date:</label>
                                                <input type="date" name="exp_date" class="form-control input-date">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Fees Type:</label>
                                                <select class="form-select select-fee-type" name="fee_type">
                                                    <option value="Court Fee">Court Fee</option>
                                                    <option value="Translation Fee">Translation Fee</option>
                                                    <option value="Legal Notice">Legal Notice</option>
                                                    <option value="Expert Fee">Expert Fee</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Amount:</label>
                                                <input type="text" name="amount" class="form-control input-amount">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Attachment:</label>
                                                <input type="file" name="attachment_file" class="form-control input-attachment">
                                                <span class="invalid-feedback">Allowed: JPG, PNG, PDF up to 1MB.</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description:</label>
                                                <textarea class="form-control input-description" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary submit-btn">Save Expense</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="statusToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="statusToastBody">
                Status updated successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script>
    $(document).ready(function() {
        $('#select_marketing').change(function() {

            const marketingId = $(this).val();

            listClient(marketingId);

        });

        $('#coll_select_marketing').change(function() {

            const marketingId = $(this).val();

            listClients(marketingId);

        });


        $('#select_client').on('change', function() {
            const selectedValue = $(this).val();

            if (selectedValue) {
                $.ajax({
                    url: '<?= ROOT_DIR ?>modules/expensereport/ajax/get_active_legal.php',
                    type: 'POST',
                    data: {
                        client_id: selectedValue,
                        action: 'find_active_legal'

                    },
                    success: function(activeLegalArray) {
                        // Clear existing options
                        $('#select_active_legal').empty();

                        // Add default placeholder option
                        $('#select_active_legal').append('<option value="">Select legal code</option>');

                        if (Array.isArray(activeLegalArray) && activeLegalArray.length > 0) {
                            activeLegalArray.forEach(item => {
                                $('#select_active_legal').append(
                                    `<option value="${item.id}">${item.code}</option>`
                                );
                            });
                        } else {
                            $('#select_active_legal').append('<option value="">No active legal found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            }
        });

        $('#coll_select_client').on('change', function() {
            const selectedValue = $(this).val();

            if (selectedValue) {
                $.ajax({
                    url: '<?= ROOT_DIR ?>modules/expensereport/ajax/get_active_legal.php',
                    type: 'POST',
                    data: {
                        client_id: selectedValue,
                        action: 'find_active_legal'

                    },
                    success: function(activeLegalArray) {
                        // Clear existing options
                        $('#coll_select_active_legal').empty();

                        // Add default placeholder option
                        $('#coll_select_active_legal').append('<option value="">Select legal code</option>');

                        if (Array.isArray(activeLegalArray) && activeLegalArray.length > 0) {
                            activeLegalArray.forEach(item => {
                                $('#coll_select_active_legal').append(
                                    `<option value="${item.id}">${item.code}</option>`
                                );
                            });
                        } else {
                            $('#coll_select_active_legal').append('<option value="">No active legal found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            }
        });



        $('#select_active_legal').on('change', function() {
            const activeLegalId = $(this).val();

            if (activeLegalId) {
                $.ajax({
                    url: '<?= ROOT_DIR ?>modules/expensereport/ajax/get_active_legal.php',
                    type: 'POST',
                    data: {
                        activeLegalId: activeLegalId,
                        action: 'find_active_legal_cases'

                    },
                    success: function(caseArray) {
                        // // Clear existing options
                        $('#select_active_legal_case').empty();

                        // Add default placeholder option
                        $('#select_active_legal_case').append('<option value="">Select Case</option>');

                        if (Array.isArray(caseArray) && caseArray.length > 0) {
                            caseArray.forEach(item => {
                                $('#select_active_legal_case').append(
                                    `<option value="${item.id}">${item.case_number}</option>`
                                );
                            });
                        } else {
                            $('#select_active_legal_case').append('<option value="">No case found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            }
        });

        $('#coll_select_active_legal').on('change', function() {
            const activeLegalId = $(this).val();

            if (activeLegalId) {
                $.ajax({
                    url: '<?= ROOT_DIR ?>modules/expensereport/ajax/get_active_legal.php',
                    type: 'POST',
                    data: {
                        activeLegalId: activeLegalId,
                        action: 'find_active_legal_cases'

                    },
                    success: function(caseArray) {
                        // // Clear existing options
                        $('#coll_select_active_legal_case').empty();

                        // Add default placeholder option
                        $('#coll_select_active_legal_case').append('<option value="">Select Case</option>');

                        if (Array.isArray(caseArray) && caseArray.length > 0) {
                            caseArray.forEach(item => {
                                $('#coll_select_active_legal_case').append(
                                    `<option value="${item.id}">${item.case_number}</option>`
                                );
                            });
                        } else {
                            $('#coll_select_active_legal_case').append('<option value="">No case found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            }
        });

        $("#category_type").change(function() {
            const category_type = $(this).val()
            $.ajax({
                type: 'post',
                url: "<?= ROOT_DIR ?>modules/activelegal/ajax/shift_active_legal.php",
                data: {
                    action: 'getParty',
                    party_type: category_type

                },

                success: function(jsonResponse) {

                    let response = JSON.parse(jsonResponse)

                    $("#party_names").html(response.html)


                }

            })

        })

        $("#coll_category_type").change(function() {
            const category_type = $(this).val()
            $.ajax({
                type: 'post',
                url: "<?= ROOT_DIR ?>modules/activelegal/ajax/shift_active_legal.php",
                data: {
                    action: 'getParty',
                    party_type: category_type

                },

                success: function(jsonResponse) {

                    let response = JSON.parse(jsonResponse)

                    $("#coll_party_names").html(response.html)


                }

            })

        })


        $('#form_submit_btn').on('click', function(e) {
            e.preventDefault(); // stop normal form submit

            let isValid = true;

            // Required field validation
            const requiredFields = [
                '#select_marketing',
                '#select_client',
                '#select_active_legal',
                '#select_active_legal_case',
                'select[name="fee_type"]',
                'input[name="exp_date"]',
                'input[name="amount"]'
            ];

            requiredFields.forEach(selector => {
                const field = $(selector);
                if (!field.val()) {
                    field.addClass('is-invalid').removeClass('is-valid');
                    isValid = false;
                } else {
                    field.removeClass('is-invalid').addClass('is-valid');
                }
            });

            // File validation (Warning only, does not block submit)
            const fileField = $('input[name="attachment_file"]')[0];
            if (fileField && fileField.files.length > 0) {
                const document_file = fileField.files[0];
                const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                const maxSize = 1 * 1024 * 1024; // 1MB

                if (!allowedTypes.includes(document_file.type) || document_file.size > maxSize) {
                    $(fileField).addClass('is-invalid').removeClass('is-valid');
                    $(fileField).siblings('.invalid-feedback').text("Allowed: JPG, PNG, PDF up to 1MB.");
                } else {
                    $(fileField).removeClass('is-invalid').addClass('is-valid');
                    $(fileField).siblings('.invalid-feedback').text(""); // clear message
                }
            }

            if (!isValid) return; // stop if required fields fail

            // Use FormData for AJAX (supports files)
            const formElement = document.getElementById('expense_modal');
            const formData = new FormData(formElement);

            $.ajax({
                url: '<?= ROOT_DIR ?>modules/expensereport/ajax/save_expense.php',
                type: 'POST',
                data: formData,
                processData: false, // important for FormData
                contentType: false, // important for FormData
                success: function(response) {
                    const toastEl = document.getElementById('statusToast');
                    const toastBody = document.getElementById('statusToastBody');
                    const toast = new bootstrap.Toast(toastEl);

                    if (response.success) {
                        toastBody.textContent = response.message || "Expense saved successfully!";
                        toastEl.classList.remove('bg-danger');
                        toastEl.classList.add('bg-success');
                    } else {
                        toastBody.textContent = response.message || "Update failed.";
                        toastEl.classList.remove('bg-success');
                        toastEl.classList.add('bg-danger');
                    }
                    toast.show();
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr, status, error) {
                    const toastEl = document.getElementById('statusToast');
                    const toastBody = document.getElementById('statusToastBody');
                    const toast = new bootstrap.Toast(toastEl);

                    toastBody.textContent = "AJAX error: " + error;
                    toastEl.classList.remove('bg-success');
                    toastEl.classList.add('bg-danger');
                    toast.show();
                }
            });
        });

        $('#coll_form_submit_btn').on('click', function(e) {
            e.preventDefault(); // stop normal form submit

            let isValid = true;
            // Required field validation
            const requiredFields = [
                '#coll_select_marketing',
                '#coll_select_client',
                '#coll_select_active_legal',
                '#coll_select_active_legal_case',
                'select[name="coll_fee_type"]',
                'input[name="coll_exp_date"]',
                'input[name="coll_amount"]'
            ];

            requiredFields.forEach(selector => {
                const field = $(selector);
                if (!field.val()) {
                    field.addClass('is-invalid').removeClass('is-valid');
                    isValid = false;
                } else {
                    field.removeClass('is-invalid').addClass('is-valid');
                }
            });

            // File validation (Warning only, does not block submit)
            const fileField = $('input[name="coll_attachment_file"]')[0];
            if (fileField && fileField.files.length > 0) {
                const document_file = fileField.files[0];
                const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                const maxSize = 1 * 1024 * 1024; // 1MB

                if (!allowedTypes.includes(document_file.type) || document_file.size > maxSize) {
                    $(fileField).addClass('is-invalid').removeClass('is-valid');
                    $(fileField).siblings('.invalid-feedback').text("Allowed: JPG, PNG, PDF up to 1MB.");
                } else {
                    $(fileField).removeClass('is-invalid').addClass('is-valid');
                    $(fileField).siblings('.invalid-feedback').text(""); // clear message
                }
            }

            if (!isValid) return; // stop if required fields fail

            // Use FormData for AJAX (supports files)
            const formElement = document.getElementById('collection_modal');
            const formData = new FormData(formElement);

            $.ajax({
                url: '<?= ROOT_DIR ?>modules/expensereport/ajax/save_collection.php',
                type: 'POST',
                data: formData,
                processData: false, // important for FormData
                contentType: false, // important for FormData
                success: function(response) {
                    const toastEl = document.getElementById('statusToast');
                    const toastBody = document.getElementById('statusToastBody');
                    const toast = new bootstrap.Toast(toastEl);

                    if (response.success) {
                        toastBody.textContent = response.message || "Collection Saved successfully!";
                        toastEl.classList.remove('bg-danger');
                        toastEl.classList.add('bg-success');
                    } else {
                        toastBody.textContent = response.message || "Update failed.";
                        toastEl.classList.remove('bg-success');
                        toastEl.classList.add('bg-danger');
                    }
                    toast.show();
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr, status, error) {
                    const toastEl = document.getElementById('statusToast');
                    const toastBody = document.getElementById('statusToastBody');
                    const toast = new bootstrap.Toast(toastEl);

                    toastBody.textContent = "AJAX error: " + error;
                    toastEl.classList.remove('bg-success');
                    toastEl.classList.add('bg-danger');
                    toast.show();
                }
            });
        });



    });

    function listClient(marketingId, clientId) {


        $('#select_client').html('<option value="">-- Select Client --</option>');

        const selectedClientId = clientId; // Replace with the value you want to select
        if (marketingId) {

            $.ajax({
                url: '<?= ROOT_DIR ?>modules/client/ajax/get_client.php', // Adjust as needed
                type: 'POST',
                data: {
                    marketingId: marketingId,
                    action: 'client_legal_list'
                },

                dataType: 'json',
                success: function(response) {

                    if (Array.isArray(response)) {
                        response.forEach(item => {
                            const selected = item.id === selectedClientId ? 'selected="selected"' : '';
                            $('#select_client').append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
                        });

                    } else {
                        $('#select_client').append('<option value="">No items found</option>');
                    }

                },

                error: function(xhr, status, error) {

                    console.error('Error:', error);

                }

            });

        }

    }

    function listClients(marketingId, clientId) {


        $('#coll_select_client').html('<option value="">-- Select Client --</option>');

        const selectedClientId = clientId; // Replace with the value you want to select
        if (marketingId) {

            $.ajax({
                url: '<?= ROOT_DIR ?>modules/client/ajax/get_client.php', // Adjust as needed
                type: 'POST',
                data: {
                    marketingId: marketingId,
                    action: 'client_legal_list'
                },

                dataType: 'json',
                success: function(response) {

                    if (Array.isArray(response)) {
                        response.forEach(item => {
                            const selected = item.id === selectedClientId ? 'selected="selected"' : '';
                            $('#coll_select_client').append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
                        });

                    } else {
                        $('#coll_select_client').append('<option value="">No items found</option>');
                    }

                },

                error: function(xhr, status, error) {

                    console.error('Error:', error);

                }

            });

        }

    }
</script> -->

<script>
    $(document).ready(function() {
        // Configuration object for modal-specific settings
        const formConfig = {
            collection: {
                formId: '#collection_modal',
                ajaxUrl: '<?= ROOT_DIR ?>modules/expensereport/ajax/save_collection.php',
                successMessage: 'Collection saved successfully!',
                fieldPrefix: 'coll_'
            },
            expense: {
                formId: '#expense_modal',
                ajaxUrl: '<?= ROOT_DIR ?>modules/expensereport/ajax/save_expense.php',
                successMessage: 'Expense saved successfully!',
                fieldPrefix: ''
            }
        };

        // Initialize Select2 for all select2-bootstrap elements
        $('.select2-bootstrap').select2();

        // Populate clients based on marketing selection
        function listClients($selectClient, marketingId, selectedClientId = null) {
            $selectClient.html('<option value="">-- Select Client --</option>');

            if (marketingId) {
                $.ajax({
                    url: '<?= ROOT_DIR ?>modules/client/ajax/get_client.php',
                    type: 'POST',
                    data: {
                        marketingId: marketingId,
                        action: 'client_legal_list'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (Array.isArray(response) && response.length > 0) {
                            response.forEach(item => {
                                const selected = item.id === selectedClientId ? 'selected="selected"' : '';
                                $selectClient.append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
                            });
                        } else {
                            $selectClient.append('<option value="">No items found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }

        // Populate legal codes based on client selection
        function listLegalCodes($selectLegal, clientId) {
            $selectLegal.html('<option value="">Select legal code</option>');

            if (clientId) {
                $.ajax({
                    url: '<?= ROOT_DIR ?>modules/expensereport/ajax/get_active_legal.php',
                    type: 'POST',
                    data: {
                        client_id: clientId,
                        action: 'find_active_legal'
                    },
                    success: function(activeLegalArray) {
                        if (Array.isArray(activeLegalArray) && activeLegalArray.length > 0) {
                            activeLegalArray.forEach(item => {
                                $selectLegal.append(`<option value="${item.id}">${item.code}</option>`);
                            });
                        } else {
                            $selectLegal.append('<option value="">No active legal found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }

        // Populate cases based on legal code selection
        function listCases($selectCase, activeLegalId) {
            $selectCase.html('<option value="">Select Case</option>');

            if (activeLegalId) {
                $.ajax({
                    url: '<?= ROOT_DIR ?>modules/expensereport/ajax/get_active_legal.php',
                    type: 'POST',
                    data: {
                        activeLegalId: activeLegalId,
                        action: 'find_active_legal_cases'
                    },
                    success: function(caseArray) {
                        if (Array.isArray(caseArray) && caseArray.length > 0) {
                            caseArray.forEach(item => {
                                $selectCase.append(`<option value="${item.id}">${item.case_number}</option>`);
                            });
                        } else {
                            $selectCase.append('<option value="">No case found</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }

        // Populate firms based on category selection
        function listFirms($selectFirm, categoryType) {
            if (categoryType) {
                $.ajax({
                    type: 'POST',
                    url: '<?= ROOT_DIR ?>modules/activelegal/ajax/shift_active_legal.php',
                    data: {
                        action: 'getParty',
                        party_type: categoryType
                    },
                    success: function(jsonResponse) {
                        let response = JSON.parse(jsonResponse);
                        $selectFirm.html(response.html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }

        // Form validation and submission
        function handleFormSubmission($form, config) {
            let isValid = true;
            const requiredFields = [
                '.select-marketing',
                '.select-client',
                '.select-active-legal',
                '.select-active-legal-case',
                '.select-fee-type',
                '.input-date',
                '.input-amount'
            ].map(selector => $form.find(selector));

            // Validate required fields
            requiredFields.forEach($field => {
                if (!$field.val()) {
                    $field.addClass('is-invalid').removeClass('is-valid');
                    isValid = false;
                } else {
                    $field.removeClass('is-invalid').addClass('is-valid');
                }
            });

            // File validation (warning only)
            const $fileField = $form.find('.input-attachment');
            if ($fileField[0] && $fileField[0].files.length > 0) {
                const document_file = $fileField[0].files[0];
                const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                const maxSize = 1 * 1024 * 1024; // 1MB

                if (!allowedTypes.includes(document_file.type) || document_file.size > maxSize) {
                    $fileField.addClass('is-invalid').removeClass('is-valid');
                    $fileField.siblings('.invalid-feedback').text('Allowed: JPG, PNG, PDF up to 1MB.');
                } else {
                    $fileField.removeClass('is-invalid').addClass('is-valid');
                    $fileField.siblings('.invalid-feedback').text('');
                }
            }

            if (!isValid) return;

            // Submit form via AJAX
            const formData = new FormData($form[0]);
            $.ajax({
                url: config.ajaxUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const toastEl = document.getElementById('statusToast');
                    const toastBody = document.getElementById('statusToastBody');
                    const toast = new bootstrap.Toast(toastEl);

                    if (response.success) {
                        toastBody.textContent = response.message || config.successMessage;
                        toastEl.classList.remove('bg-danger');
                        toastEl.classList.add('bg-success');
                    } else {
                        toastBody.textContent = response.message || 'Update failed.';
                        toastEl.classList.remove('bg-success');
                        toastEl.classList.add('bg-danger');
                    }
                    toast.show();
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr, status, error) {
                    const toastEl = document.getElementById('statusToast');
                    const toastBody = document.getElementById('statusToastBody');
                    const toast = new bootstrap.Toast(toastEl);

                    toastBody.textContent = 'AJAX error: ' + error;
                    toastEl.classList.remove('bg-success');
                    toastEl.classList.add('bg-danger');
                    toast.show();
                }
            });
        }

        // Event handlers for each modal
        $('.modal-form').each(function() {
            const $form = $(this);
            const formType = $form.data('form-type');
            const config = formConfig[formType];

            // Marketing change event
            $form.find('.select-marketing').on('change', function() {
                listClients($form.find('.select-client'), $(this).val());
            });

            // Client change event
            $form.find('.select-client').on('change', function() {
                listLegalCodes($form.find('.select-active-legal'), $(this).val());
            });

            // Legal code change event
            $form.find('.select-active-legal').on('change', function() {
                listCases($form.find('.select-active-legal-case'), $(this).val());
            });

            // Category change event
            $form.find('.select-category-type').on('change', function() {
                listFirms($form.find('.select-party-names'), $(this).val());
            });

            // Form submission
            $form.on('submit', function(e) {
                e.preventDefault();
                handleFormSubmission($form, config);
            });
        });
    });
</script>