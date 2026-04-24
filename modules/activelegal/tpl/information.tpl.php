<!-- start page content wrapper-->
<?php $isEdit = !empty($edit_id); ?>
<div class="page-content-wrapper">

    <!-- start page content-->

    <div class="page-content">


        <!--start breadcrumb-->

        <div class="d-flex justify-content-between align-items-center mb-3">

            <!-- Breadcrumb on the Left -->

            <div class="page-breadcrumb d-none d-sm-flex align-items-center">

                <div class="breadcrumb-title pe-3">Dashboard</div>

                <div class="ps-3">

                    <nav aria-label="breadcrumb">

                        <ol class="breadcrumb mb-0 p-0 align-items-center">

                            <li class="breadcrumb-item">

                                <a href="javascript:;" id="home-icon">

                                    <ion-icon name="home-outline" title="Back to Dashboard"></ion-icon>

                                </a>

                            </li>

                            <li class="breadcrumb-item active" aria-current="page">Active Legal Information</li>

                        </ol>

                    </nav>

                </div>

            </div>

            <!-- Back Button on the Right -->

            <?php include "common/backButton_list.php"; ?>

        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <div class="row">

            <div class="col col-lg-12 mx-auto">

                <?php if ($data['error']) { ?>

                    <div class="alert alert-dismissible fade show py-2 bg-danger" id="divErrorMsg">

                        <div class="d-flex align-items-center">

                            <div class="fs-3 text-white"><ion-icon name="close-circle-sharp"></ion-icon>

                            </div>

                            <div class="ms-3">

                                <div class="text-white"><?= $data['error'] ?></div>

                            </div>

                        </div>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    </div>

                <?php } ?>



                <div class="card">

                    <div class="card-body">

                        <ul class="nav nav-tabs nav-primary" role="tablist">

                            <?php

                            echo createNavItem(

                                "activelegal",

                                "Information",

                                "information-sharp",

                                "information",

                                $edit_id,

                                true

                            ); // Active tab

                            echo createNavItem(

                                "activelegal",

                                "Documents",

                                "document-attach-sharp",

                                "document",

                                $edit_id

                            ); // Inactive tab



                            echo createNavItem(

                                "activelegal",

                                "Contact",

                                "person-add-outline",

                                "contact",

                                $edit_id

                            ); // Inactive tab



                            echo createNavItem(

                                "activelegal",

                                "Commission",

                                "cash",

                                "commission",

                                $edit_id

                            );



                            // Inactive tab

                            ?>



                        </ul>

                        <div class="tab-content py-3">

                            <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">

                                <form action="" method="post" id="frm_activelegal_information"

                                    name="frm_activelegal_information" enctype="multipart/form-data">

                                    <!--start shop cart-->

                                    <section class="shop-page">

                                        <div class="shop-container">

                                            <div class="shop-cart">

                                                <div class="container">

                                                    <div class="row">

                                                        <div class="col-lg-6">

                                                            <div class="col">

                                                                <div class="card">

                                                                    <div class="card-header">

                                                                        <h6 class="mb-0"><i class="lni lni-user"></i>

                                                                            Active

                                                                            Legal Profile</h6>

                                                                    </div>

                                                                    <div class="card-body">



                                                                        <input type="hidden" id="edit_ID" name="edit_ID"

                                                                            readonly="true"

                                                                            value="<?= $edit_id ?>" />



                                                                        <div class="mb-3">

                                                                            <label class="form-label">

                                                                                Date:<span

                                                                                    class="asterisk text-danger">*</span>

                                                                            </label>

                                                                            <input type="date" class="form-control"

                                                                                id="dateon" name="dateon"

                                                                                value="<?= $data["dateon"] ?>"

                                                                                autocomplete="off" required />

                                                                        </div>

                                                                        <div class="mb-3">

                                                                            <label class="form-label" for="code">

                                                                                Code:<span

                                                                                    class="asterisk text-danger">*</span>

                                                                            </label>

                                                                            <input type="text" class="form-control"

                                                                                readonly="true" id="code" name="code"

                                                                                value="<?= $data["code"] ?>"

                                                                                autocomplete="off" required />

                                                                        </div>

                                                                        <?php if ($edit_id) { ?>
                                                                            <div class="mb-3">
                                                                                <label>
                                                                                    <input type="radio" name="which_type_user" value="marketing" <?= $data["ClientType"] == 'M' ? 'checked' : '' ?> />
                                                                                    Marketing
                                                                                </label>
                                                                                <label style="margin-left:15px;">
                                                                                    <input type="radio" name="which_type_user" value="internal" <?= $data["ClientType"] == 'I' ? 'checked' : '' ?> />
                                                                                    Internal Staff
                                                                                </label>
                                                                                <label style="margin-left:15px;">
                                                                                    <input type="radio" name="which_type_user" value="tabasco" <?= $data["ClientType"] == 'T' ? 'checked' : '' ?> />
                                                                                    Tabasco Corporate
                                                                                </label>
                                                                            </div>
                                                                        <?php } else { ?>
                                                                            <div class="mb-3">
                                                                                <label>
                                                                                    <input type="radio" name="which_type_user" value="marketing" checked />
                                                                                    Marketing
                                                                                </label>
                                                                                <label style="margin-left:15px;">
                                                                                    <input type="radio" name="which_type_user" value="internal" />
                                                                                    Internal Staff
                                                                                </label>
                                                                                <label style="margin-left:15px;">
                                                                                    <input type="radio" name="which_type_user" value="tabasco" />
                                                                                    Tabasco Corporate
                                                                                </label>
                                                                            </div>
                                                                        <?php } ?>

                                                                        <div id="marketingStaff">
                                                                            <div class="mb-3">
                                                                                <label class="form-label" for="select_marketing"> Marketing:<span class="asterisk text-danger">*</span>
                                                                                </label>
                                                                                <select class="form-select select2-bootstrap" id="select_marketing" name="select_marketing" <?= $isEdit ? 'disabled' : '' ?> required>

                                                                                    <option value="">Select</option>
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

                                                                                <?php if ($isEdit): ?>
                                                                                    <input type="hidden" name="select_marketing" value="<?= $data["user_id"] ?>">
                                                                                <?php endif; ?>

                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label class="form-label" for="select_client"> Client:<span class="asterisk text-danger">*</span>
                                                                                </label>

                                                                                <select
                                                                                    class="form-select select2-bootstrap"
                                                                                    id="select_client"
                                                                                    name="select_client"
                                                                                    <?= $isEdit ? 'disabled' : '' ?>>
                                                                                    <option value="">Select Client</option>
                                                                                </select>

                                                                                <?php if ($isEdit): ?>
                                                                                    <input type="hidden" id="select_client_hidden" name="select_client" value="<?= $data['client'] ?? '' ?>">
                                                                                <?php endif; ?>

                                                                            </div>
                                                                        </div>

                                                                        <div id="internalStaff">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Internal Staff: <span
                                                                                        class="asterisk text-danger">*</span></label>
                                                                                <select class="form-select select2-bootstrap" id="select_internal"
                                                                                    name="select_internal" <?= $isEdit ? 'disabled' : '' ?>>
                                                                                    <option value="">Select </option>
                                                                                    <?php
                                                                                    if ($array_internal_staff) {
                                                                                        foreach ($array_internal_staff as $internal_staff_rows) {
                                                                                            $selected = ($data["user_id"] == $internal_staff_rows["user_Id"]) ? "selected" : "";
                                                                                    ?>
                                                                                            <option value="<?= $internal_staff_rows['user_Id'] ?>" <?= $selected ?>>
                                                                                                <?= $internal_staff_rows['user_name'] ?>
                                                                                            </option>
                                                                                    <?php
                                                                                        }
                                                                                    } ?>
                                                                                </select>
                                                                                <?php if ($isEdit): ?>
                                                                                    <input type="hidden" name="select_internal" value="<?= $data["user_id"] ?>">
                                                                                <?php endif; ?>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label class="form-label" for="select_Internalclient"> Client:<span class="asterisk text-danger">*</span>
                                                                                </label>

                                                                                <select
                                                                                    class="form-select select2-bootstrap"
                                                                                    id="select_Internalclient"
                                                                                    name="select_Internalclient"
                                                                                    <?= $isEdit ? 'disabled' : '' ?>>
                                                                                    <option value="">Select Client</option>
                                                                                </select>

                                                                                <?php if ($isEdit): ?>
                                                                                    <input type="hidden" id="select_client_hidden" name="select_Internalclient" value="<?= $data['client'] ?? '' ?>">
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>


                                                                        <div class="mb-3">

                                                                            <label class="form-label" for="category">

                                                                                Category:<span

                                                                                    class="asterisk text-danger">*</span>

                                                                            </label>

                                                                            <select

                                                                                class="form-select select2-bootstrap"

                                                                                id="category" name="category" required>

                                                                                <option value="">Select</option>

                                                                                <option value="<?= THIRD_PARTY_C_ID ?>">

                                                                                    Third Party</option>

                                                                                <option value="<?= LEGAL_FIRM_C_ID ?>">

                                                                                    Legal Firm</option>

                                                                                <option

                                                                                    value="<?= DEBT_COLLECTOR_C_ID ?>">

                                                                                    Debt Collector</option>

                                                                                <option value="<?= LEGAL_TEAM_C_ID ?>">

                                                                                    Legal Team</option>

                                                                            </select>

                                                                        </div>



                                                                        <div class="mb-3">

                                                                            <label class="form-label" for="agencies_id">

                                                                                Firm/Party/Debt/Legal:<span

                                                                                    class="asterisk text-danger">*</span>

                                                                            </label>

                                                                            <select

                                                                                class="form-select select2-bootstrap"

                                                                                id="agencies_id" name="agencies_id"

                                                                                required>

                                                                                <option value="">Select</option>

                                                                            </select>

                                                                        </div>



                                                                        <div class="mb-3">

                                                                            <label class="form-label"

                                                                                for="notes">Notes:</label>

                                                                            <textarea class="form-control" rows="2"

                                                                                id="notes"

                                                                                name="notes"><?= $data["notes"] ?></textarea>

                                                                        </div>



                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-lg-6">

                                                            <div class="col">

                                                                <!-- Outstanding Card -->

                                                                <div class="card">

                                                                    <div class="card-header">

                                                                        <h6 class="mb-0">

                                                                            <i class="lni lni-text-align-justify"></i> Outstanding

                                                                        </h6>

                                                                    </div>

                                                                    <div class="card-body">

                                                                        <div class="mb-3">

                                                                            <label class="form-label">Total Outstanding:</label>

                                                                            <input type="text" class="form-control"

                                                                                id="total_outstanding"

                                                                                name="total_outstanding"

                                                                                value="<?= $data['total_outstanding'] ?>" required readonly />

                                                                        </div>

                                                                        <div class="mb-3">

                                                                            <label class="form-label">Outstanding with cheque:</label>

                                                                            <input type="text" class="form-control"

                                                                                id="outstanding_with_cheque"

                                                                                name="outstanding_with_cheque"

                                                                                value="<?= $data['outstanding_with_cheque'] ?>" required readonly />

                                                                        </div>

                                                                        <div class="mb-3">

                                                                            <label class="form-label">Outstanding without cheque:</label>

                                                                            <input type="text" class="form-control"

                                                                                id="outstanding_without_cheque"

                                                                                name="outstanding_without_cheque"

                                                                                value="<?= $data['outstanding_without_cheque'] ?>" required readonly />

                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="mb-3">
                                                                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" readonly="true" />
                                                                    <input type="hidden" id="hid_module" name="hid_module" value="<?= $_GET['module']; ?>" readonly="true" />
                                                                    <input type="hidden" id="hid_page" name="hid_page" value="<?= $_GET['page']; ?>" readonly="true" />
                                                                    <input type="hidden" id="active_legal" name="active_legal" value="<?= $_GET['param1']; ?>" readonly="true" />
                                                                    <input type="hidden" name="selected_client_id" id="selected_client_id">

                                                                </div>


                                                                <!-- Claim & Expense Card -->

                                                                <div class="card">

                                                                    <div class="card-header">

                                                                        <h6 class="mb-0">

                                                                            <i class="lni lni-text-align-justify"></i>

                                                                        </h6>

                                                                    </div>

                                                                    <div class="card-body">

                                                                        <div class="mb-3">

                                                                            <label class="form-label">Claim Amount:</label>

                                                                            <input type="text" class="form-control"

                                                                                id="claim_amount"

                                                                                name="claim_amount"

                                                                                value="<?= $data['claim_amount'] ?>" readonly />

                                                                        </div>

                                                                        <div class="mb-3">

                                                                            <label class="form-label">Collected Amount:</label>

                                                                            <input type="text" class="form-control"

                                                                                id="collected_amount"

                                                                                name="collected_amount"

                                                                                value="<?= $data['total_collection'] ?? 0 ?>" readonly />

                                                                        </div>

                                                                        <div class="mb-3">

                                                                            <label class="form-label">Balance to Collect:</label>

                                                                            <input type="text" class="form-control"

                                                                                id="balance_claim"

                                                                                name="balance_claim"

                                                                                value="<?= $data['claim_amount'] - $data['total_collection'] ?>" readonly />

                                                                        </div>

                                                                        <div class="mb-3">

                                                                            <label class="form-label">Expense Amount:</label>

                                                                            <input type="text" class="form-control"

                                                                                id="expense_amount"

                                                                                name="expense_amount"

                                                                                value="<?= $data['total_Expense'] ?? 0 ?>" readonly />

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <!-- list cheque -->

                                                                <div class="col">

                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="mb-0"><i class="lni lni-indent-increase"></i>
                                                                                Cheque List</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <form>
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

                                                                            </form>
                                                                        </div>
                                                                    </div>

                                                                </div>



                                                            </div>

                                                        </div>





                                                        <div class="row justify-content-center">

                                                            <div class="mb-4 d-flex justify-content-center">

                                                                <button type="submit"

                                                                    class="btn btn-primary px-5 mx-2" id="btn_save">Save</button>

                                                                <button type="reset"

                                                                    class="btn btn-secondary px-5 mx-2">Reset</button>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </section>

                                </form>

                            </div>

                        </div>

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

                    <h5 class="modal-title"><i class="lni lni-plus"></i> Add Contacts</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">





                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary">Save changes</button>

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

<script>
    $(document).ready(function() {
        function toggleUserType() {
            const type = $('input[name="which_type_user"]:checked').val();
            if (type === 'marketing') {
                $('#marketingStaff').show();
                $('#internalStaff').hide();
                $('#select_marketing').prop('required', true);
                $('#select_client').prop('required', true);
                $('#select_internal').prop('required', false);
                $('#select_Internalclient').prop('required', false);
            } else if (type === 'internal') {
                $('#marketingStaff').hide();
                $('#internalStaff').show();
                $('#select_marketing').prop('required', false);
                $('#select_client').prop('required', false);
                $('#select_internal').prop('required', true);
                $('#select_Internalclient').prop('required', true);
            } else if (type === 'tabasco') {
                $('#marketingStaff').hide();
                $('#internalStaff').hide();
                $('#select_marketing').prop('required', false);
                $('#select_client').prop('required', false);
                $('#select_internal').prop('required', false);
                $('#select_Internalclient').prop('required', false);
            }
        }

        // Run on page load (IMPORTANT for edit)
        toggleUserType();

        // Run when radio changes
        $('input[name="which_type_user"]').on('change', toggleUserType);

        /* Load Client list  */
        $('#select_marketing').change(function() {

            const marketingId = $(this).val();

            listClient(marketingId);

        });

        $('#select_internal').change(function() {

            const internalId = $(this).val();

            listInternal(internalId);

        });


        $('#category').change(function() {

            const id = $(this).val();

            listcategories(id, '');

        });
    });


    $('#btn_save').click(function(event) {
        event.preventDefault();

        const edit_ID = $('#edit_ID').val();

        const dateon = $('#dateon').val();
        if (!dateon) {
            alert('Please select Date');
            return;
        }

        const whichTypeUser = $('input[name="which_type_user"]:checked').val();

        let ajaxData = {
            edit_ID: edit_ID,
            which_type_user: whichTypeUser
        };


        if (whichTypeUser === 'marketing') {

            const select_marketing = $('#select_marketing').val();
            const selectedClientId = $('#select_client').val();

            if (!select_marketing || !selectedClientId) {
                alert('Please select Marketing and Client');
                return;
            }

            ajaxData.select_marketing = select_marketing;
            ajaxData.selectedClientId = selectedClientId;

        } else if (whichTypeUser === 'internal') {

            const select_internal = $('#select_internal').val();
            const select_Internalclient = $('#select_Internalclient').val();

            if (!select_internal || !select_Internalclient) {
                alert('Please select Internal Staff and Client');
                return;
            }

            ajaxData.select_internal = select_internal;
            ajaxData.select_Internalclient = select_Internalclient;
        }

        $.ajax({
            type: 'post',
            url: '<?= ROOT_DIR ?>modules/activelegal/ajax/check_active_legal.php',
            data: ajaxData,
            success: function(jsonResponse) {
                let response = JSON.parse(jsonResponse);

                if (!response.is_unique) {
                    const toastEl = document.getElementById('statusToast');
                    const toastBody = document.getElementById('statusToastBody');
                    const toast = new bootstrap.Toast(toastEl);

                    toastBody.textContent = response.message;
                    toastEl.classList.remove('bg-success');
                    toastEl.classList.add('bg-danger');
                    toast.show();

                    return;
                }

                $('#frm_activelegal_information')
                    .off('submit')
                    .submit();
            }
        });

    });

    function listInternal(internalId, clientId) {

        // return;


        // Clear previous items

        $('#select_Internalclient').html('<option value="">-- Select Client --</option>');

        const selectedClientId = clientId; // Replace with the value you want to select

        if (internalId) {

            $.ajax({

                url: '<?= ROOT_DIR ?>modules/client/ajax/get_client.php', // Adjust as needed

                type: 'POST',

                data: {
                    marketingId: internalId,
                    action: 'client_legal_list'
                },

                dataType: 'json',

                success: function(response) {


                    $(document).ready(function() {
                        $('#select_Internalclient').empty(); // Clear previous options

                        // Add default option
                        $('#select_Internalclient').append('<option value="">--- Select Client ---</option>');

                        if (Array.isArray(response) && response.length > 0) {
                            // Populate dropdown with client options
                            response.forEach(item => {

                                const selected = String(item.id) === String(selectedClientId) ? 'selected="selected"' : '';
                                $('#select_Internalclient').append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
                            });

                            // Change event listener
                            $('#select_Internalclient').on('change', function() {
                                const selectedId = $(this).val();
                                $('#selected_client_id').val(selectedId);
                                loadCheque();
                                if (!selectedId) {
                                    // Default option selected
                                    $('#total_outstanding').val(0);
                                    $('#outstanding_with_cheque').val(0);
                                    $('#outstanding_without_cheque').val(0);
                                    $('#claim_amount').val(0);
                                    return;
                                }
                                const selectedItem = response.find(item => String(item.id) === selectedId);
                                if (!selectedItem) {
                                    $('#total_outstanding').val(0);
                                    $('#outstanding_with_cheque').val(0);
                                    $('#outstanding_without_cheque').val(0);
                                    $('#claim_amount').val(0);
                                    return;
                                }
                                $('#total_outstanding').val(selectedItem.total_outstanding ?? 0);
                                $('#outstanding_with_cheque').val(selectedItem.outstanding_cheque ?? 0);
                                $('#outstanding_without_cheque').val(selectedItem.outstanding_without_cheque ?? 0);
                                $('#claim_amount').val(selectedItem.total_outstanding ?? 0);
                            });

                            // Set initial selection and trigger change
                            const isValidSelectedId = selectedClientId && response.some(item => String(item.id) === String(selectedClientId));
                            if (isValidSelectedId) {
                                $('#select_Internalclient').val(String(selectedClientId)).trigger('change');
                            } else {
                                $('#select_Internalclient').val(''); // Select default option
                                $('#total_outstanding').val(0);
                                $('#outstanding_with_cheque').val(0);
                                $('#outstanding_without_cheque').val(0);
                                $('#claim_amount').val(0);
                            }
                        } else {
                            $('#total_outstanding').val(0);
                            $('#outstanding_with_cheque').val(0);
                            $('#outstanding_without_cheque').val(0);
                            $('#claim_amount').val(0);
                        }
                    });

                },

                error: function(xhr, status, error) {

                    console.error('Error:', error);

                }

            });

        }

    }


    function loadCheque() {
        let csrf_token = $("#csrf_token").val()
        let hid_module = $("#hid_module").val()
        let hid_page = $("#hid_page").val()
        let active_legal = $("#active_legal").val()
        let selected_client_id = $("#selected_client_id").val()


        $.ajax({
            type: 'post',
            url: '<?= ROOT_DIR ?>modules/case/ajax/load_ajax_cheque.php',
            data: {
                hid_module,
                hid_page,
                csrf_token,
                active_legal,
                selected_client_id
            },
            success: function(jsonResponse) {
                let response = JSON.parse(jsonResponse)
                $("#cheque_table_body").html(response.message)
            },
            error: function(err) {
                console.log(err)
            }
        })
    }

    function listClient(marketingId, clientId) {



        // Clear previous items

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

                    // console.log(response);

                    // if (Array.isArray(response)) {

                    //     response.forEach(item => {

                    //         const selected = item.id === selectedClientId ? 'selected="selected"' : '';

                    //         $('#select_client').append(`<option value="${item.id}" ${selected}>${item.name}</option>`);

                    //     });

                    // } else {

                    //     $('#select_client').append('<option value="">No items found</option>');

                    // }

                    $(document).ready(function() {
                        $('#select_client').empty(); // Clear previous options

                        // Add default option
                        $('#select_client').append('<option value="">--- Select Client ---</option>');

                        if (Array.isArray(response) && response.length > 0) {
                            // Populate dropdown with client options
                            response.forEach(item => {

                                const selected = String(item.id) === String(selectedClientId) ? 'selected="selected"' : '';
                                $('#select_client').append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
                            });

                            // Change event listener
                            $('#select_client').on('change', function() {
                                const selectedId = $(this).val();
                                $('#selected_client_id').val(selectedId);
                                loadCheque();
                                if (!selectedId) {
                                    // Default option selected
                                    $('#total_outstanding').val(0);
                                    $('#outstanding_with_cheque').val(0);
                                    $('#outstanding_without_cheque').val(0);
                                    $('#claim_amount').val(0);
                                    return;
                                }
                                const selectedItem = response.find(item => String(item.id) === selectedId);
                                if (!selectedItem) {
                                    $('#total_outstanding').val(0);
                                    $('#outstanding_with_cheque').val(0);
                                    $('#outstanding_without_cheque').val(0);
                                    $('#claim_amount').val(0);
                                    return;
                                }
                                $('#total_outstanding').val(selectedItem.total_outstanding ?? 0);
                                $('#outstanding_with_cheque').val(selectedItem.outstanding_cheque ?? 0);
                                $('#outstanding_without_cheque').val(selectedItem.outstanding_without_cheque ?? 0);
                                $('#claim_amount').val(selectedItem.total_outstanding ?? 0);
                            });

                            // Set initial selection and trigger change
                            const isValidSelectedId = selectedClientId && response.some(item => String(item.id) === String(selectedClientId));
                            if (isValidSelectedId) {
                                $('#select_client').val(String(selectedClientId)).trigger('change');
                            } else {
                                $('#select_client').val(''); // Select default option
                                $('#total_outstanding').val(0);
                                $('#outstanding_with_cheque').val(0);
                                $('#outstanding_without_cheque').val(0);
                                $('#claim_amount').val(0);
                            }
                        } else {
                            $('#total_outstanding').val(0);
                            $('#outstanding_with_cheque').val(0);
                            $('#outstanding_without_cheque').val(0);
                            $('#claim_amount').val(0);
                        }
                    });

                },

                error: function(xhr, status, error) {

                    console.error('Error:', error);

                }

            });

        }

    }

    function listcategories(id, agencies_id) {

        // Clear previous items

        $('#agencies_id').html('<option value="">-- Select Category --</option>');



        if (id) {

            $.ajax({

                url: '<?= ROOT_DIR ?>ajax/get_agencies_list.php', // Adjust as needed

                type: 'POST',

                data: {
                    action: 'list',
                    id: id
                },

                dataType: 'json',

                success: function(response) {


                    if (Array.isArray(response)) {

                        response.forEach(item => {

                            const selected = item.id === agencies_id ? 'selected="selected"' : '';

                            $('#agencies_id').append(`<option value="${item.id}" ${selected}>${item.code ? item.code + ' - ' : ''}${item.name}</option>`);



                        });

                    } else {

                        $('#agencies_id').append('<option value="">No data found</option>');

                    }

                },

                error: function(xhr, status, error) {

                    console.error('Error:', error);

                }

            });

        }

    }
</script>

<script>
    // Get the input elements
    const claimAmountInput = document.getElementById('claim_amount');
    const collectedAmountInput = document.getElementById('collected_amount');
    const balanceClaimInput = document.getElementById('balance_claim');

    // Add an event listener to the collected_amount input
    collectedAmountInput.addEventListener('input', function() {
        // Get the values and convert to numbers
        const claimAmount = parseFloat(claimAmountInput.value) || 0;
        const collectedAmount = parseFloat(collectedAmountInput.value) || 0;

        // Calculate the balance
        const balance = claimAmount - collectedAmount;

        // Update the balance_claim input field
        balanceClaimInput.value = balance >= 0 ? balance.toFixed(2) : 0;
    });
</script>

<?php if ($action == "edit" && $edit_id > 0 && $data['user_id'] > 0 && $data['category'] > 0) { ?>

    <script>
        $('#select_marketing').val(<?= $data['user_id'] ?>).trigger('change');

        listClient('<?= $data['user_id'] ?>', '<?= $data['client'] ?>');

        $('#select_internal').val(<?= $data['user_id'] ?>).trigger('change');

        listInternal('<?= $data['user_id'] ?>', '<?= $data['client'] ?>');

        $('#category').val('<?= $data['category'] ?>').trigger('change');

        listcategories('<?= $data['category'] ?>', '<?= $data['agencies_id'] ?>');
    </script>

<?php

}

?>