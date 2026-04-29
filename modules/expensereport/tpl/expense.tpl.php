<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Expense</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Expense</li>
                    </ol>
                </nav>

            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="col col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" href="<?= ROOT_DIR ?>expensereport/expense/view/<?= $id ?>.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="information-sharp"
                                                class="me-1"></ion-icon>
                                        </div>
                                        <div class="tab-title">Expense</div>
                                    </div>
                                </a>

                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="<?= ROOT_DIR ?>expensereport/claimamount/view/<?= $legal_case[0]['id'] ?>.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="document-attach-sharp"
                                                class="me-1"></ion-icon>
                                        </div>
                                        <div class="tab-title">Claim Amount</div>
                                    </div>
                                </a>
                            </li>

                        </ul>
                        <div class="tab-content py-3">
                            <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                                <!--start shop cart-->
                                <section class="shop-page">
                                    <div class="shop-container">
                                        <div class="shop-cart">
                                            <!-- <div class="container"> -->
                                            <div class="row">
                                                <div class="col">
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-header d-flex justify-content-between">
                                                                <h6 class="mb-0"><i class="lni lni-user"></i>
                                                                    Expense
                                                                    list</h6>
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
                                                                    <a href="<?= ROOT_DIR ?>expensereport/expenselist/view/<?= $active_legal_id ?>.html" class="btn btn-warning"><ion-icon name="return-down-back-outline"></ion-icon>BACK</a>


                                                                </div>

                                                            </div>
                                                            <div class="card-body">
                                                                <div class=" p-3  border">
                                                                    <div class="row">
                                                                        <!-- Left Section -->
                                                                        <div class="col-md-6 col-sm-12">
                                                                            <p><b>Code :</b> <?= $active_legal[0]['code'] ?></p>
                                                                            <p><b>Case No :</b> <?= $legal_case[0]['case_number'] ?></p>
                                                                            <p><b>Case Status :</b> OPEN</p>

                                                                        </div>

                                                                        <!-- Right Section -->
                                                                        <div class="col-md-6 col-sm-12">
                                                                            <p><b>Marketing :</b> <?= $active_legal[0]['User_Client'] ?></p>
                                                                            <p><b>Client :</b> <?= $active_legal[0]['ClientName'] ?> - <?= $active_legal[0]['Usertype_Client'] ?></p>
                                                                            <p><b>Present Legal Firm :</b> <?= $active_legal[0]['Present_Legal_Firm_Name'] ?></p>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="table-responsive mt-3">
                                                                    <style>
                                                                        .description-cell {
                                                                            max-width: 270px;
                                                                            overflow-wrap: break-word;
                                                                            white-space: normal;
                                                                            text-align: justify;
                                                                        }
                                                                    </style>
                                                                    <table class="table align-middle mb-0">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th>Date</th>
                                                                                <th>Description</th>
                                                                                <th>Fees Type</th>
                                                                                <th>Expense</th>
                                                                                <th>Document</th>

                                                                                <th>Remark</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php if ($expense) { ?>
                                                                                <?php foreach ($expense as $data) { ?>
                                                                                    <tr>
                                                                                        <td><?= $data['date'] ?></td>
                                                                                        <td class="description-cell"><?= $data['description'] ?></td>
                                                                                        </td>
                                                                                       <td><?= !empty($data['fees_type_title']) ? $data['fees_type'] : $data['category_type'] ?></td>
                                                                                        <td><?= $data['amount'] ?></td>
                                                                                        <td>
                                                                                            <?php if (!empty($data['document'])): ?>
                                                                                                <?php
                                                                                                $root_doc = ROOT_DIR . 'uploads/expenses/' . $data['document'];
                                                                                                ?>
                                                                                                <a href="<?= htmlspecialchars($root_doc) ?>" target="_blank">
                                                                                                    <button type="button" class="btn text-success">
                                                                                                        <i class="fadeIn animated bx bx-file"></i>
                                                                                                    </button>
                                                                                                </a>
                                                                                            <?php else: ?>
                                                                                                <button type="button" class="btn text-danger" disabled>
                                                                                                    <i class="fadeIn animated bx bx-file"></i>
                                                                                                </button>
                                                                                            <?php endif; ?>
                                                                                        </td>


                                                                                        <td width="25%" style="max-width:250px; min-width:200px; white-space:normal; word-wrap:break-word; overflow-wrap:break-word; text-align: justify;"><?= $data['remark'] ?></td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                            <?php } else { ?>
                                                                                <tr>
                                                                                    <td colspan="6" class="text-center text-danger">No record available</td>
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
                                            <!-- </div> -->
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
    <!-- end page content-->


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

                                    <div class="col-md-6 col-sm-12" style="display: none;">
                                        <div class="mb-3">
                                            <label class="form-label">Marketing:</label>
                                            <input type="text" value="<?= $active_legal[0]['user_id'] ?>" name="coll_select_marketing" class="form-control select-marketing">

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Client:</label>
                                            <input type="text" value="<?= $active_legal[0]['client'] ?>" name="coll_select_client" class="form-control select-client">

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Legal Code:</label>
                                            <input type="text" value="<?= $active_legal[0]['id'] ?>" name="coll_select_active_legal" class="form-control select-active-legal">

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Case:</label>
                                            <input type="text" value="<?= $legal_case[0]['id'] ?>" name="coll_select_active_legal_case" class="form-control select-active-legal-case">


                                        </div>
                                        <!-- <div class="mb-3">
                                            <label class="form-label">Category:</label>
                                            <input type="text" value="<?= $active_legal[0]['legal_firm_type'] ?>" name="coll_category_type" class="form-control select-category-type">


                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Firm:</label>
                                            <input type="text" value="<?= $active_legal[0]['agencies_id'] ?>" name="coll_party_names" class="form-control select-party-names">

                                        </div> -->
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Date:</label>
                                            <input type="date" name="coll_exp_date" class="form-control input-date">
                                        </div>
                                        <!-- <div class="mb-3">
                                            <label class="form-label">Fees Type:</label>
                                            <select class="form-select select-fee-type" name="coll_fee_type">
                                                <option value="">------ Select ------</option>
                                                <?php if ($fees_types) { ?>
                                                    <?php foreach ($fees_types as $fee_type) { ?>
                                                        <option value="<?= $fee_type['id'] ?>"><?= $fee_type['title'] ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div> -->

                                        <div class="mb-3">

                                            <label class="form-label">Category <span class="text-danger">*</span></label>

                                            <select class="form-control select-category-type category_type" id="category_type" name="coll_category_type">

                                                <option value="">- - select - -</option>

                                                <option value="third_party">Third Party</option>

                                                <option value="debt_collector">Debt Collector</option>

                                                <option value="legal_firm">Legal Firm</option>

                                                <option value="legal_team">Legal Team</option>

                                            </select>

                                        </div>

                                        <div class="mb-3">

                                            <label class="form-label"> Firm/Party <span class="text-danger">*</span></label>

                                            <select class="form-control select-party-names party_names" id="party_names" name="coll_party_names">

                                                <option value="">- - select - -</option>

                                            </select>

                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Amount:</label>
                                            <input type="number" name="coll_amount" class="form-control input-amount" step="any" min="0">


                                          
    <div class="form-check mt-2">
 <input type="hidden" name="zero_commission" value="0">
        <input class="form-check-input"type="checkbox"  id="zeroCommissionCheck"  name="zero_commission"       value="1">
        <label class="form-check-label" for="zeroCommissionCheck">
            0% Commission
        </label>
    </div>

<style>
.text-danger{
    color:red!important;
}
</style>
                                            <!-- <small id="commissionMessage" class="text-success mt-2 d-block" style="display:none;"></small> -->
                                            <small id="commissionMessage" class="text-info mt-2 d-block text-danger" style="color:red!important;display:none;"></small>

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
                                        <div class="mb-3">
                                            <label class="form-label">Remark:</label>
                                            <textarea class="form-control input-description" name="remark"></textarea>
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
                                    <div class="col-md-6 col-sm-12" style="display: none;">
                                        <div class="mb-3">
                                            <label class="form-label">Marketing:</label>
                                            <input type="text" value="<?= $active_legal[0]['user_id'] ?>" name="select_marketing" class="form-control select-marketing">

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Client:</label>
                                            <input type="text" value="<?= $active_legal[0]['client'] ?>" name="select_client" class="form-control select-client">

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Legal Code:</label>
                                            <input type="text" value="<?= $active_legal[0]['id'] ?>" name="select_active_legal" class="form-control select-active-legal">

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Case:</label>
                                            <input type="text" value="<?= $legal_case[0]['id'] ?>" name="select_active_legal_case" class="form-control select-active-legal-case">


                                        </div>
                                        <!-- <div class="mb-3">
                                            <label class="form-label">Category:</label>
                                            <input type="text" value="<?= $active_legal[0]['legal_firm_type'] ?>" name="category_type" class="form-control select-category-type">


                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Firm:</label>
                                            <input type="text" value="<?= $active_legal[0]['agencies_id'] ?>" name="party_names" class="form-control select-party-names">

                                        </div> -->
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Date:</label>
                                            <input type="date" name="exp_date" class="form-control input-date">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Fees Type:</label>
                                            <select class="form-select select-fee-type" name="fee_type">
                                                <option value="">------ Select ------</option>
                                                <?php if ($fees_types) { ?>
                                                    <?php foreach ($fees_types as $fee_type) { ?>
                                                        <option value="<?= $fee_type['id'] ?>"><?= $fee_type['title'] ?></option>
                                                    <?php } ?>

                                                <?php } ?>

                                            </select>
                                        </div>


                                        <div class="mb-3">

                                            <label class="form-label">Category <span class="text-danger">*</span></label>

                                            <select class="form-control select-category-type category_type" id="category_type" name="category_type">

                                                <option value="">- - select - -</option>

                                                <option value="third_party">Third Party</option>

                                                <option value="debt_collector">Debt Collector</option>

                                                <option value="legal_firm">Legal Firm</option>

                                                <option value="legal_team">Legal Team</option>

                                            </select>

                                        </div>

                                        <div class="mb-3">

                                            <label class="form-label"> Firm/Party <span class="text-danger">*</span></label>

                                            <select class="form-control select-party-names party_names" id="party_names" name="party_names">

                                                <option value="">- - select - -</option>

                                            </select>

                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label">Amount:</label>
                                            <input type="number" name="amount" class="form-control input-amount" step="any" min="0">
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
                                        <div class="mb-3">
                                            <label class="form-label">Remark:</label>
                                            <textarea class="form-control input-description" name="remark"></textarea>
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

        $('.select2-bootstrap').select2();



        // Form validation and submission
        function handleFormSubmission($form, config) {
            let isValid = true;
            let requiredFields = [
                '.select-marketing',
                '.select-client',
                '.select-active-legal',
                '.select-active-legal-case',
                '.input-date',
                '.input-amount',
                '.select-party-names',
                '.select-category-type'
            ];

            // Conditionally include fee type only for expense forms
            if (config.fieldPrefix === '') {
                requiredFields.push('.select-fee-type');
            }

            const fields = requiredFields.map(selector => $form.find(selector));

            // Validate required fields
            fields.forEach($field => {
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

            // Commission checkbox validation (only for collection forms)
            if (config.formId === '#collection_modal') {
                const $check = $form.find('#zeroCommissionCheck');
                if (!$check.is(':checked')) {
                    $check.addClass('is-invalid');
                    isValid = false;
                    // Optional: Show message
                    $('#commissionMessage').text("You must confirm 0% Commission to save.").addClass('text-danger').show();
                } else {
                    $check.removeClass('is-invalid');
                }
            }

            if (!isValid) return;


const formData = new FormData($form[0]);

$.ajax({
    url: config.ajaxUrl,
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',

    success: function(response) {

        const toastEl = document.getElementById('statusToast');
        const toastBody = document.getElementById('statusToastBody');
        const toast = new bootstrap.Toast(toastEl);

        if (response.c_comment) {
            const isZero = response.c_comment.toLowerCase().includes('zero');

            $('#commissionMessage')
                .text(response.c_comment)
                .css('color', isZero ? 'green' : 'red')
                .fadeIn();
        } else {
            $('#commissionMessage').hide();
        }

  
        if (response.success) {

            toastBody.textContent =
                response.message || 'Status updated successfully';

            toastEl.classList.remove('bg-danger');
            toastEl.classList.add('bg-success');

            toast.show();

            setTimeout(function () {
                location.reload();
            }, 3500);

        } else {

            toastBody.textContent =
                response.message || response.c_comment || 'Update failed';

            toastEl.classList.remove('bg-success');
            toastEl.classList.add('bg-danger');

            toast.show();
        }
    },

    error: function(xhr, status, error) {

        const toastEl = document.getElementById('statusToast');
        const toastBody = document.getElementById('statusToastBody');
        const toast = new bootstrap.Toast(toastEl);


        console.log("Server Response:", xhr.responseText);

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



            // Form submission
            $form.on('submit', function(e) {
                e.preventDefault();
                handleFormSubmission($form, config);
            });
        });

        $(".category_type").change(function() {

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

                    $(".party_names").html(response.html)

                }

            })

        })

        
$('#zeroCommissionCheck').change(function() {

    if ($(this).is(':checked')) {
        $('#commissionMessage')
            .text("Zero Commission selected. The actual amount will be paid to the client.")
            .removeClass('text-danger')
            .addClass('text-success')
            .show();
    } else {
        $('#commissionMessage')
            .text("You must select 0% Commission to continue.")
            .removeClass('text-success')
            .addClass('text-danger')
            .show();
    }

});


    });
</script>