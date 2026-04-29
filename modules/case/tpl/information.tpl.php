<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="d-flex justify-content-between mb-1">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Case</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0 align-items-center">
                            <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Case Information</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <a class="btn btn-warning" href="<?= ROOT_DIR . "activelegal/view/view/$activeLegalId.html" ?>">
                <i class="lni lni-arrow-left"></i> Active Legal
            </a>
        </div>
        <!--end breadcrumb-->

        <?php if ($error_msg) { ?>
            <div class="alert alert-dismissible fade show py-2 bg-danger" id="divErrorMsg">
                <div class="d-flex align-items-center">
                    <div class="fs-3 text-white"><ion-icon name="close-circle-sharp"></ion-icon></div>
                    <div class="ms-3">
                        <div class="text-white"><?= $error_msg ?></div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                            <?php echo createNavItem("case", "Information", "information-sharp", "information", $edit_id, true); ?>
                            <?php echo createNavItem("case", "Documents", "document-attach-sharp", "document", $edit_id, false); ?>
                            <?php echo createNavItem("case", "Hearing Date & Feedback", "calendar", "hearing", $edit_id, false); ?>
                        </ul>

                        <div class="tab-content py-3">
                            <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                                <section class="shop-page">
                                    <div class="shop-container">
                                        <div class="shop-cart">
                                            <div class="container">

                                                <!-- CHANGE 1: All fields including Total Claim Amount are now inside ONE single form -->
                                                <form method="post" id="saveInfoForm">

                                                    <div class="row">
                                                        <!-- LEFT COLUMN -->
                                                        <div class="col-lg-6">
                                                            <div class="col">
                                                                <div class="card">
                                                                    <div class="card-body">

                                                                        <div class="mb-3">
                                                                            <label class="form-label">Client: </label>
                                                                            <input type="text" class="form-control" name="ClientName" id="ClientName"
                                                                                value="<?= isset($activeLegal[0]['ClientName']) && $activeLegal[0]['ClientName'] != '' ? $activeLegal[0]['ClientName'] : $_POST['ClientName'] ?>" readonly>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label">Marketing: </label>
                                                                            <input type="text" class="form-control" name="User_Client" id="User_Client"
                                                                                value="<?= isset($activeLegal[0]['User_Client']) && $activeLegal[0]['User_Client'] != '' ? $activeLegal[0]['User_Client'] : $_POST['User_Client'] ?>" readonly>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label">Present Legal Firm : </label>
                                                                            <input type="text" class="form-control" name="Present_Legal_Firm_Name" id="Present_Legal_Firm_Name"
                                                                                value="<?= isset($activeLegal[0]['Present_Legal_Firm_Name']) && $activeLegal[0]['Present_Legal_Firm_Name'] != '' ? $activeLegal[0]['Present_Legal_Firm_Name'] : $_POST['Present_Legal_Firm_Name'] ?>" readonly>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label">Active legal: <span class="text-danger">*</span></label>
                                                                            <select class="form-select" name="code_disabled" id="code" disabled>
                                                                                <option value="">- - select - -</option>
                                                                                <?php if (isset($active_legals) && !empty($active_legals)) { ?>
                                                                                    <?php foreach ($active_legals as $legal) { ?>
                                                                                        <option value="<?= $legal['id'] ?>"
                                                                                            <?= ($current_legal_case[0]['active_legal_id'] == $legal['id'] || $activeLegal[0]['id'] == $legal['id']) ? 'selected' : '' ?>>
                                                                                            <?= $legal['code'] ?>
                                                                                        </option>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </select>
                                                                            <input type="hidden" name="code" value="<?= $current_legal_case[0]['active_legal_id'] ?? $activeLegal[0]['id'] ?>">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label">Case No: <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" name="case_number" id="case_number"
                                                                                value="<?= isset($current_legal_case[0]['case_number']) && $current_legal_case[0]['case_number'] != '' ? $current_legal_case[0]['case_number'] : $_POST['case_number'] ?>">
                                                                        </div>
                                                                         
                                                                         <div class="mb-3">
                                                                             <label class="form-label">Related Case (Optional):</label>
                                                                             <select class="form-select" name="related_case_id" id="related_case_id">
                                                                                 <option value="">-- None --</option>
                                                                             </select>
                                                                         </div>



                                                                        <div class="mb-3">
                                                                            <label class="form-label">Cases: <span class="text-danger">*</span></label>
                                                                            <select class="form-select" name="category" id="category">
                                                                                <option value="">- - select - -</option>
                                                                                <?php if ($categories) { ?>
                                                                                    <?php foreach ($categories as $category) { ?>
                                                                                        <option value="<?= $category['id'] ?>" <?= $current_legal_case[0]['category'] == $category['id'] ? 'selected' : '' ?>><?= $category['title'] ?></option>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>





                                                                        <div class="mb-3">
                                                                            <label class="form-label">Category: <span class="text-danger">*</span></label>
                                                                            <select class="form-select" name="category" id="category">
                                                                                <option value="">- - select - -</option>
                                                                                <?php if ($categories) { ?>
                                                                                    <?php foreach ($categories as $category) { ?>
                                                                                        <option value="<?= $category['id'] ?>" <?= $current_legal_case[0]['category'] == $category['id'] ? 'selected' : '' ?>><?= $category['title'] ?></option>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label">Court: <span class="text-danger">*</span></label>
                                                                            <select class="form-select" name="court" id="court">
                                                                                <option value="">- - select - -</option>
                                                                                <?php if ($courts) { ?>
                                                                                    <?php foreach ($courts as $court) { ?>
                                                                                        <option value="<?= $court['id'] ?>" <?= $current_legal_case[0]['court'] == $court['id'] ? 'selected' : '' ?>><?= $court['title'] ?></option>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>

                                                                        <?php $selected_plaintiff = $current_legal_case[0]['plaintiff'] ?? ''; ?>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Plaintiff <span class="text-danger">*</span></label>
                                                                            <select class="form-select" name="plaintiff" id="plaintiff">
                                                                                <option value="">--- Select Plaintiff ---</option>
                                                                                <option value="Tabasco Tech" <?= ($selected_plaintiff == "Tabasco Tech") ? 'selected' : '' ?>>Tabasco Tech</option>
                                                                                <?php foreach ($plantiffs as $p): ?>
                                                                                    <option value="<?= $p['name']; ?>" <?= ($selected_plaintiff == $p['name']) ? 'selected' : '' ?>>
                                                                                        <?= htmlspecialchars($p['name']); ?>
                                                                                    </option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>

                                                                        <?php $selected_defendant = $current_legal_case[0]['defendant'] ?? ''; ?>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Defendant <span class="text-danger">*</span></label>
                                                                            <select class="form-select" name="defendant" id="defendant">
                                                                                <option value="">--- Select Defendant ---</option>
                                                                                <?php foreach ($defendant as $p): ?>
                                                                                    <option value="<?= $p['name']; ?>" <?= ($selected_defendant == $p['name']) ? 'selected' : '' ?>>
                                                                                        <?= htmlspecialchars($p['name']); ?>
                                                                                    </option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label">Register Day: <span class="text-danger">*</span></label>
                                                                            <input type="date" class="form-control" id="register_date" name="register_date"
                                                                                value="<?= isset($current_legal_case[0]['register_date']) && $current_legal_case[0]['register_date'] != '' ? $current_legal_case[0]['register_date'] : $_POST['register_date'] ?>">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label">Case Mode: <span class="text-danger">*</span></label>
                                                                            <select class="form-select" name="case_mode" id="case_mode">
                                                                                <option value="">- - select - -</option>
                                                                                <?php if ($case_modes) { ?>
                                                                                    <?php foreach ($case_modes as $case_mode) { ?>
                                                                                        <option value="<?= $case_mode['id'] ?>" <?= $current_legal_case[0]['case_mode'] == $case_mode['id'] ? 'selected' : '' ?>><?= $case_mode['title'] ?></option>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>

                                                                        <?php $selectedLawyer = $current_legal_case[0]['lawyer'] ?? ''; ?>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Lawyer <span class="text-danger">*</span></label>
                                                                            <select class="form-select" name="lawyer" id="lawyer">
                                                                                <option value="">--- Select Lawyer ---</option>
                                                                                <?php foreach ($lawyerusersList as $p): ?>
                                                                                    <option value="<?= $p['user_Id']; ?>" <?= ($selectedLawyer == $p['user_name']) ? 'selected' : '' ?>>
                                                                                        <?= htmlspecialchars($p['user_name']); ?>
                                                                                    </option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label">Location: <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" name="location" id="location"
                                                                                value="<?= isset($current_legal_case[0]['location']) && $current_legal_case[0]['location'] != '' ? $current_legal_case[0]['location'] : $_POST['location'] ?>">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="form-label">Notes:</label>
                                                                            <textarea class="form-control" name="note" rows="3"><?= isset($current_legal_case[0]['note']) && $current_legal_case[0]['note'] != '' ? $current_legal_case[0]['note'] : $_POST['note'] ?></textarea>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <button type="button" class="btn btn-primary px-5 mb-1" id="saveCaseInfoSubBtn">Save</button>
                                                                            <button type="reset" class="btn btn-secondary px-5 mb-1">Reset</button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- RIGHT COLUMN -->
                                                        <div class="col-lg-6">
                                                            <div class="col">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="mb-0">
                                                                            <i class="lni lni-text-align-justify"></i> Total Claim Amount
                                                                        </h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <!-- CHANGE 2: Removed inner <form> tag, replaced with <div> so fields are part of #saveInfoForm -->
                                                                        <div>
                <div class="mb-3">
                    <label class="form-label">Total Outstanding:</label>
                    <!-- CHANGE: Removed readonly — user can manually edit and it will be saved -->
                    <input type="text" class="form-control"
                        name="total_outstanding"
                        id="total_outstanding"
                        value="<?= isset($current_legal_case[0]['total_outstanding']) && $current_legal_case[0]['total_outstanding'] != '' ? $current_legal_case[0]['total_outstanding'] : '0' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Outstanding with cheque:</label>
                    <!-- CHANGE: Removed readonly — user can manually edit and it will be saved -->
                    <input type="text" class="form-control"
                        name="outstanding_with_cheque"
                        id="outstanding_with_cheque"
                        value="<?= isset($current_legal_case[0]['outstanding_with_cheque']) && $current_legal_case[0]['outstanding_with_cheque'] != '' ? $current_legal_case[0]['outstanding_with_cheque'] : '0' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Outstanding without cheque:</label>
                    <!-- CHANGE: Removed readonly — user can manually edit and it will be saved -->
                    <input type="text" class="form-control"
                        name="outstanding_without_cheque"
                        id="outstanding_without_cheque"
                        value="<?= isset($current_legal_case[0]['outstanding_without_cheque']) && $current_legal_case[0]['outstanding_without_cheque'] != '' ? $current_legal_case[0]['outstanding_without_cheque'] : '0' ?>">
                </div>

                <!-- <div class="mb-3">
                    <label class="form-label">Active Legal Claim Amount:</label>
                    <input type="text" class="form-control"
                        id="active_legal_claim_amount"
                        value="<?= isset($activeLegal[0]['claim_amount']) ? $activeLegal[0]['claim_amount'] : '0' ?>" readonly>
                </div> -->

                <div class="mb-3">
                    <label class="form-label">Claimed Amount: <span class="text-danger">*</span></label>
                    <input type="number" class="form-control"
                        name="claim_amount"
                        id="claim_amount"
                        step="any"
                        value="<?= isset($current_legal_case[0]['claim_amount']) && $current_legal_case[0]['claim_amount'] != '' ? $current_legal_case[0]['claim_amount'] : (isset($activeLegal[0]['claim_amount']) ? $activeLegal[0]['claim_amount'] : '0') ?>" required>
                </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Cheque Details -->
                                                            <div class="col">
                                                                <div class="card" style="display: none;">
                                                                    <div class="card-header">
                                                                        <h6 class="mb-0"><i class="lni lni-text-align-justify"></i> Cheque details</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div id="response_span"></div>
                                                                        <div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Cheque Date:</label>
                                                                                <input type="date" class="form-control cheq_inputs" <?= $disabled_field ?> id="cheque_date">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Cheque Amount:</label>
                                                                                <input type="text" class="form-control cheq_inputs" placeholder="Cheque Amount" <?= $disabled_field ?> id="cheque_amount">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Upload cheque:</label>
                                                                                <input type="file" class="form-control cheq_inputs" <?= $disabled_field ?> id="cheque_file">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" readonly="true" />
                                                                                <input type="hidden" id="hid_module" name="hid_module" value="<?= $_GET['module']; ?>" readonly="true" />
                                                                                <input type="hidden" id="hid_page" name="hid_page" value="<?= $_GET['page']; ?>" readonly="true" />
                                                                                <input type="hidden" id="hid_parentID" name="hid_parentID" value="<?= $_GET['param1']; ?>" readonly="true" />
                                                                            </div>
                                                                            <?php if (!$disabled_field) { ?>
                                                                                <div class="mb-3">
                                                                                    <button type="button" class="btn btn-primary px-5 mb-1" id="save_cheque">Add Cheque</button>
                                                                                    <button type="reset" class="btn btn-secondary px-5 mb-1" id="reset_cheque_form">Reset</button>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            Cheque List
                                                            <div class="col">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="mb-0"><i class="lni lni-indent-increase"></i> Cheque List</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="mb-3">
                                                                            <div class="table-responsive mt-3">
                                                                                <table class="table align-middle mb-0">
                                                                                    <thead class="table-light">
                                                                                        <tr>
                                                                                            <td>Sl No</td>
                                                                                            <td>Cheque date</td>
                                                                                            <td>Amount</td>
                                                                                            <td>Documents</td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody id="cheque_table_body">
                                                                                        <tr>
                                                                                            <td class='text-center' colspan='4'>Loading cheques ...</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- END RIGHT COLUMN -->

                                                    </div>
                                                </form>
                                                <!-- CHANGE 1: End of single unified form -->

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


<!-- Modals -->
<div class="modal fade" id="exampleExtraLargeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="lni lni-plus"></i> Add Contacts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalDelClsBtn"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Are you sure want to delete this cheque?</label>
                    <input type="hidden" class="form-control" value="" id="deleteChequeId">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deleteChequeConfirmButton"><i class="lni lni-trash"></i></button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    loadCheque();

    $(document).ready(function() {
        <?php if ($edit_id) { ?>
            loadCheque();
            $("#deleteModal").on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let chequeId = button.data('ch_id');
                $(this).find("#deleteChequeId").val(chequeId);
            });
        <?php } ?>

        // function fetchActiveLegalInfo(legalId) {
        //     if (!legalId) return;
        //     $.ajax({
        //         type: 'POST',
        //         url: '<?= ROOT_DIR ?>modules/case/ajax/case_autopopulate.php',
        //         data: { Active_legal_id: legalId },
        //         success: function(jsonResponse) {
        //             console.log('Response:', jsonResponse);
        //             if (jsonResponse && typeof jsonResponse === 'object') {
        //                 $('#total_outstanding').val(jsonResponse.total_outstanding || '0');
        //                 $('#outstanding_with_cheque').val(jsonResponse.outstanding_cheque || '0');
        //                 $('#outstanding_without_cheque').val(jsonResponse.outstanding_without_cheque || '0');
        //                 $('#active_legal_claim_amount').val(jsonResponse.active_legal_claim_amount || '0');
        //                 // Only auto-fill if not in edit mode
        //                 <?php// if (!$edit_id) { ?>
        //                 $('#claim_amount').val(jsonResponse.active_legal_claim_amount || jsonResponse.total_outstanding || '0');
        //                 <?php //} ?>
        //             } else {
        //                 $('#total_outstanding').val('0');
        //                 $('#outstanding_with_cheque').val('0');
        //                 $('#outstanding_without_cheque').val('0');
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('AJAX Error:', status, error);
        //         }
        //     });
        // }

        fetchActiveLegalInfo($('#code').val());

        $('#code').on('change', function() {
            fetchActiveLegalInfo(this.value);
        });
    });

    // CHANGE 4: New function — recalculates the three totals by reading the cheque table rows
    // Each <tr> in #cheque_table_body must have:
    //   data-amount="123"         (the cheque amount)
    //   data-has-doc="1" or "0"   (1 = has document/file, 0 = no document)



    // function recalculateTotals() {
    //     let totalOutstanding = 0;
    //     let withCheque = 0;
    //     let withoutCheque = 0;

    //     $('#cheque_table_body tr[data-amount]').each(function() {
    //         let amount = parseFloat($(this).data('amount')) || 0;
    //         let hasDoc  = parseInt($(this).data('has-doc')) || 0;

    //         totalOutstanding += amount;

    //         if (hasDoc === 1) {
    //             withCheque += amount;
    //         } else {
    //             withoutCheque += amount;
    //         }
    //     });

    //     $('#total_outstanding').val(totalOutstanding.toFixed(2));
    //     $('#outstanding_with_cheque').val(withCheque.toFixed(2));
    //     $('#outstanding_without_cheque').val(withoutCheque.toFixed(2));
    // }

    $("#save_cheque").click(function() {
        let chequeDate   = $("#cheque_date");
        let chequeAmount = $("#cheque_amount");
        let chequeFile   = $("#cheque_file");
        let isValid = true;

        if (chequeDate.val() == '') {
            chequeDate.removeClass('is-valid').addClass('is-invalid');
            isValid = false;
        } else {
            chequeDate.removeClass('is-invalid').addClass('is-valid');
        }
        if (chequeAmount.val() == '') {
            chequeAmount.removeClass('is-valid').addClass('is-invalid');
            isValid = false;
        } else {
            chequeAmount.removeClass('is-invalid').addClass('is-valid');
        }
        if (chequeFile.val() == '') {
            chequeFile.removeClass('is-valid').addClass('is-invalid');
            isValid = false;
        } else {
            chequeFile.removeClass('is-invalid').addClass('is-valid');
        }

        let csrf_token  = $("#csrf_token").val();
        let hid_module  = $("#hid_module").val();
        let hid_page    = $("#hid_page").val();
        let hid_parentID = $("#hid_parentID").val();

        if (isValid) {
            var formData = new FormData();
            let cheque_file = chequeFile[0].files[0];
            formData.append('cheque_date',   chequeDate.val());
            formData.append('cheque_amount', chequeAmount.val());
            formData.append('cheque_file',   cheque_file);
            formData.append('csrf_token',    csrf_token);
            formData.append('hid_module',    hid_module);
            formData.append('hid_page',      hid_page);
            formData.append('cheque_type',   '1');
            formData.append('hid_parentID',  hid_parentID);

            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Uploading ...');
            $(this).prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: '<?= ROOT_DIR ?>ajax/add_cheque.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#save_cheque").html('Add Cheque');
                    $("#save_cheque").prop('disabled', false);

                    const alertClass = response.status === 'success' ? 'bg-success' : 'bg-danger';
                    const iconName   = response.status === 'success' ? 'checkmark-circle-sharp' : 'close-circle-sharp';

                    let response_alert = `<div class="alert alert-dismissible fade show py-2 ${alertClass}">
                        <div class="d-flex align-items-center">
                            <div class="fs-3 text-white"><ion-icon name="${iconName}"></ion-icon></div>
                            <div class="ms-3"><div class="text-white">${response.message}</div></div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    $("#response_span").html(response_alert);

                    if (response.status == 'success') {
                        $(".cheq_inputs").val('');
                        $(".cheq_inputs").removeClass('is-valid').removeClass('is-invalid');
                        // CHANGE 4: Reload cheque list then recalculate totals
                        loadCheque();
                    }
                    setTimeout(function() { location.reload(); }, 1000);
                }
            });
        }
    });

    $("#deleteChequeConfirmButton").click(function() {
        let chequeId     = $("#deleteChequeId").val();
        let csrf_token   = $("#csrf_token").val();
        let hid_module   = $("#hid_module").val();
        let hid_page     = $("#hid_page").val();
        let hid_parentID = $("#hid_parentID").val();

        if (chequeId) {
            $.ajax({
                type: 'post',
                url: '<?= ROOT_DIR ?>modules/case/ajax/delete_cheque.php',
                data: { 'cheque_id': chequeId, csrf_token, hid_module, hid_page, hid_parentID },
                success: function(jsonResponse) {
                    let response = JSON.parse(jsonResponse);
                    if (response.success) {
                        round_success_noti(response.message);
                    } else {
                        round_error_notify(response.message);
                    }
                    $("#modalDelClsBtn").click();
                    // CHANGE 4: Reload cheque list then recalculate totals
                    loadCheque();
                    setTimeout(function() { location.reload(); }, 1000);
                }
            });
        } else {
            alert('Failed to delete');
        }
    });

    $("#saveCaseInfoSubBtn").click(function() {
        let code_input            = $("#code");
        let case_number_input     = $("#case_number");
        let category_input        = $("#category");
        let court_input           = $("#court");
        let register_date_input   = $("#register_date");
        let case_mode_input       = $("#case_mode");
        let lawyer_input          = $("#lawyer");
        let location_input        = $("#location");

        let validForm = true;

        if (code_input.val() == '') {
            validForm = false;
            code_input.addClass('is-invalid').removeClass('is-valid');
        } else {
            code_input.addClass('is-valid').removeClass('is-invalid');
        }
        if (case_number_input.val() == '') {
            validForm = false;
            case_number_input.addClass('is-invalid').removeClass('is-valid');
        } else {
            case_number_input.addClass('is-valid').removeClass('is-invalid');
        }
        if (category_input.val() == '') {
            validForm = false;
            category_input.addClass('is-invalid').removeClass('is-valid');
        } else {
            category_input.addClass('is-valid').removeClass('is-invalid');
        }
        if (court_input.val() == '') {
            validForm = false;
            court_input.addClass('is-invalid').removeClass('is-valid');
        } else {
            court_input.addClass('is-valid').removeClass('is-invalid');
        }
        if (register_date_input.val() == '') {
            validForm = false;
            register_date_input.addClass('is-invalid').removeClass('is-valid');
        } else {
            register_date_input.addClass('is-valid').removeClass('is-invalid');
        }
        if (case_mode_input.val() == '') {
            validForm = false;
            case_mode_input.addClass('is-invalid').removeClass('is-valid');
        } else {
            case_mode_input.addClass('is-valid').removeClass('is-invalid');
        }
        if (lawyer_input.val() == '') {
            validForm = false;
            lawyer_input.addClass('is-invalid').removeClass('is-valid');
        } else {
            lawyer_input.addClass('is-valid').removeClass('is-invalid');
        }
        if (location_input.val() == '') {
            validForm = false;
            location_input.addClass('is-invalid').removeClass('is-valid');
        } else {
            location_input.addClass('is-valid').removeClass('is-invalid');
        }

        if (validForm) {
            $("#saveInfoForm").submit();
        }
    });

    function loadCheque() {
        let csrf_token   = $("#csrf_token").val();
        let hid_module   = $("#hid_module").val();
        let hid_page     = $("#hid_page").val();
        let hid_parentID = $("#hid_parentID").val();
        let active_legal = $("#code").val();

        $("#code").off("change.cheque").on("change.cheque", function() {
            active_legal = $(this).val();
            fetchCheques(csrf_token, hid_module, hid_page, hid_parentID, active_legal);
        });

        fetchCheques(csrf_token, hid_module, hid_page, hid_parentID, active_legal);
        fetchRelatedCases(active_legal);
        
        $("#code").on("change", function() {
            fetchRelatedCases($(this).val());
        });
    }

    function fetchRelatedCases(activeLegalId) {
        if (!activeLegalId) return;
        $.ajax({
            type: 'POST',
            url: '<?= ROOT_DIR ?>modules/case/ajax/get_related_cases.php',
            data: { 
                active_legal_id: activeLegalId,
                exclude_case_id: '<?= $edit_id ?>'
            },
            success: function(jsonResponse) {
                try {
                    let response = JSON.parse(jsonResponse);
                    if (response.success) {
                        $('#related_case_id').html(response.html);
                        // Set current selection if editing
                        let selectedRelated = '<?= $current_legal_case[0]['related_case_id'] ?? '' ?>';
                        if (selectedRelated) {
                            $('#related_case_id').val(selectedRelated);
                        }
                    }
                } catch(e) { console.error("Error parsing related cases", e); }
            }
        });
    }

    // CHANGE 5: Extracted AJAX call into its own function to avoid duplication
    // and to always call recalculateTotals() after the table is updated
    function fetchCheques(csrf_token, hid_module, hid_page, hid_parentID, active_legal) {
        $.ajax({
            type: 'post',
            url: '<?= ROOT_DIR ?>modules/case/ajax/load_ajax_cheque.php',
            data: { hid_parentID, hid_module, hid_page, csrf_token, active_legal },
            success: function(jsonResponse) {
                let response = JSON.parse(jsonResponse);
                $("#cheque_table_body").html(response.message);
                // CHANGE 4: After table is rendered, recalculate the totals
                recalculateTotals();
            },
            error: function(err) {
                console.log(err);
            }
        });
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