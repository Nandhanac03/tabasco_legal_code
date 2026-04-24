        <!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
       
        <!--end breadcrumb-->
        <?php if ($error_msg) { ?>
            <div class="alert alert-dismissible fade show py-2 bg-danger" id="divErrorMsg">
                <div class="d-flex align-items-center">
                    <div class="fs-3 text-white"><ion-icon name="close-circle-sharp"></ion-icon>
                    </div>
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
                        <?php
                            echo createNavItem(
                                "case",
                                "Case Root",
                                "git-pull-request",
                                "view",
                                $id,
                                true
                            ); // Active tab 
                            ?>
                            <?php
                            echo createNavItem(
                                "case",
                                "Information",
                                "information-sharp",
                                "list",
                                $id,
                                false
                            ); // Active tab 
                            ?>
                           
                            <?php
                            echo createNavItem(
                                "case",
                                "Documents",
                                "document-attach-sharp",
                                "document_view",
                                $id,
                                false
                            ); // Active tab 
                            ?>
                            <?php
                            echo createNavItem(
                                "case",
                                "Hearing Date & Feedback",
                                "calendar",
                                "case_hearing",
                                $id,
                                false
                            ); // Active tab 
                            ?>
                            <?php
                            echo createNavItem(
                                "case",
                                "Expense",
                                "cash",
                                "expense",
                                $id,
                                false
                            ); // Active tab 
                            ?>
                            <?php
                            echo createNavItem(
                                "case",
                                "Actions",
                                "git-pull-request",
                                "actions",
                                $id,
                                false
                            ); // Active tab 
                            ?>
                            
                        </ul>
     

<!-- start page content wrapper-->

<div class="">

    <!-- start page content-->

    <div class="page-content">

        <!--start breadcrumb-->

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <div class="breadcrumb-title pe-3">Case</div>

            <div class="ps-3">

                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb mb-0 p-0 align-items-center">

                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>

                        </li>

                        <li class="breadcrumb-item active" aria-current="page">View Case</li>

                        

                    </ol>

                </nav>

            </div>

        </div>

        <div class="row">

            <!--end breadcrumb-->

            <div class="col-12">

                <div class="card radius-10">

                    <div class="card-header py-3">

                        <div class="col">

                            <div class="d-flex justify-content-between align-items-center">

                                <!-- LEFT -->
                                <div>
                                    <a class="btn btn-warning"
                                        href="<?= ROOT_DIR . "activelegal/view/view/$active_legal_id.html" ?>">
                                        <i class="lni lni-arrow-left"></i> Active Legal
                                    </a>
                                </div>

                                <!-- RIGHT -->
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addRootsModal">
                                        <ion-icon name="add-outline"></ion-icon> Add Roots
                                    </button>

                                    <!-- Add Notification Button -->
                                    <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addNotificationModal">
                                        <ion-icon name="add-outline"></ion-icon> Add Notification
                                    </a>

                                    <a href="javascript: history.go(-1);" class="btn btn-secondary">
                                        <ion-icon name="return-down-back-outline"></ion-icon> Back
                                    </a>

                                </div>

                            </div>


                        </div>

                    </div>

                    <div class="card-header py-2">
                        

                        <div class="row row-cols-1 row-cols-lg-112">
                            <div class="p-3 border rounded">
                                <div class="row">
                                    <!-- Left Section -->
                                    <div class="col-md-6 col-sm-12">
                                        <p><b>Code :</b> <?= $active_legal[0]['code'] ? $active_legal[0]['code'] : '' ?></p>
                                        <p><b>Marketing :</b> <?= $active_legal[0]['User_Client'] ? $active_legal[0]['User_Client'] : '' ?></p>
                                        <p><b>Client :</b> <?= isset($active_legal[0]['ClientName']) ? $active_legal[0]['ClientName'] : '' ?></p>
                                        <p><b>Present Legal Firm :</b> <?= isset($active_legal[0]['Present_Legal_Firm_Name']) ? $active_legal[0]['Present_Legal_Firm_Name'] : '' ?></p>
                                    </div>

                                    <!-- Right Section -->
                                    <div class="col-md-6 col-sm-12">
                                        <p><b>Case No :</b> <?= isset($current_case[0]['case_number']) ? $current_case[0]['case_number'] : '' ?></p>
                                        <p><b>Case Mode :</b> <?= isset($current_case[0]['case_mode_title']) ? $current_case[0]['case_mode_title'] : '' ?></p>
                                        <p><b>Case Category :</b> <?= isset($current_case[0]['category_name']) ? $current_case[0]['category_name'] : '' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive">



                            <table class="table align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <td>Sl No.</td>

                                        <td>Number</td>

                                        <td>Category</td>

                                        <td>Court</td>

                                        <td>Stage</td>

                                        <td>Plaintiff</td>

                                        <td>Defendant</td>

                                        <td>Register Date</td>

                                        <td>Last Action</td>

                                        <td>Last Action Date</td>

                                        <td></td>

                                    </tr>

                                </thead>

                                <tbody id="dataTableBody">

                                    <tr>

                                        <td colspan="9" class="text-center">Loading Data...</td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- end page content-->

</div>



<div class="modal fade" id="addRootsModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title"><i class="fadeIn animated bx bx-layer-plus"></i>Add Roots</h5>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-xl-12 ">

                        <div class="card">

                            <div class="card-body">

                                <div class=" p-3 rounded">

                                    <form class="row g-3">

                                        <div class="col-12">

                                            <label class="form-label">Case No. <span class="text-danger">*</span></label>

                                            <input type="text" class="form-control modal-form " value="<?= $current_case[0]['case_number'] ?>" readonly id="add_roots_case_number">

                                        </div>

                                        <!-- <div class="col-12">

                                            <label class="form-label">Lawyer <span class="text-danger">*</span></label>

                                            <input type="text" class="form-control modal-form " value="<?= $current_case[0]['lawyer'] ?>" id="add_roots_lawyer">

                                        </div> -->

                                        <div class="col-12">
                                            <label class="form-label">Lawyer <span class="text-danger">*</span></label>
                                            <select class="form-control modal-form" id="add_roots_lawyer" name="lawyer" required>
                                                <option value="">-- Select Lawyer --</option>
                                                <?php
                                                $selectedLawyer = $current_case[0]['lawyer'];       // raw stored value (id or text)
                                                $selectedLawyerName = $current_case[0]['lawyer_name']; // resolved display name

                                                foreach ($lawyerusersList as $lawyer) {
                                                    $selected = ($selectedLawyer == $lawyer['user_Id']) ? "selected" : "";
                                                    echo "<option value='{$lawyer['user_Id']}' $selected>{$lawyer['user_name']}</option>";
                                                }

                                                // If lawyer is non-numeric (a free-text name not in users list), keep it as an option
                                                if (!is_numeric($selectedLawyer) && !empty($selectedLawyer)) {
                                                    echo "<option value='{$selectedLawyer}' selected>{$selectedLawyerName}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>


                                        <div class="col-12">

                                            <label class="form-label">Court <span class="text-danger">*</span></label>

                                            <select type="text" class="form-select modal-form format_data" id="add_roots_court">

                                                <option value="">--- Select court ---</option>

                                                <?php if ($courts) { ?>

                                                    <?php foreach ($courts as $court) { ?>

                                                        <option value="<?= $court['id'] ?>" <?= $current_case[0]['court'] == $court['id'] ? 'selected' : '' ?>><?= $court['title'] ?></option>

                                                    <?php } ?>

                                                <?php } ?>

                                            </select>

                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Stage <span class="text-danger">*</span></label>
                                            <select class="form-select modal-form format_data" id="add_roots_stage">
                                                <option value="">--- Select Stage ---</option>
                                              
                                                <?php for ($i = 1; $i <= 100; $i++): ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>



                                        <div class="col-12">
                                            <label class="form-label">Plantiff <span class="text-danger">*</span></label>
                                            <select class="form-select modal-form format_data" id="add_roots_plantiff" >
    <option value="">--- Select Plantiff ---</option>
    <option value="Tabasco Tech" >Tabasco Tech</option>
    <?php if (!empty($case_plantiffs)) { ?>
        <?php foreach ($case_plantiffs as $p) { ?>
            <option value="<?= $p['plantiff'] ?>">
                <?= htmlspecialchars($p['plantiff']) ?>
            </option>
        <?php } ?>
    <?php } ?>
</select>
</div>



                                        <div class="col-12">
                                            <label class="form-label">Defender <span class="text-danger">*</span></label>
                                            <select class="form-select modal-form format_data" id="add_roots_defendant" >
    <option value="">--- Select Defender ---</option>

    <?php if (!empty($case_defender)) { ?>
        <?php foreach ($case_defender as $p) { ?>
            <option value="<?= $p['defendant'] ?>">
                <?= htmlspecialchars($p['defendant']) ?>
            </option>
        <?php } ?>
    <?php } ?>
</select>
                                        </div>




                                        <div class="col-12">

                                            <label class="form-label">Category <span class="text-danger">*</span></label>

                                            <select type="text" class="form-select modal-form format_data" id="add_roots_category">

                                                <option value="">--- Select Category ---</option>

                                                <?php if ($categories) { ?>

                                                    <?php foreach ($categories as $category) { ?>

                                                        <option value="<?= $category['id'] ?>" <?= $current_case[0]['category'] == $category['id'] ? 'selected' : '' ?>><?= $category['title'] ?></option>

                                                    <?php } ?>

                                                <?php } ?>

                                            </select>

                                        </div>

                                        <div class="col-12">

                                            <label class="form-label">Number <span class="text-danger">*</span></label>

                                            <input type="text" class="form-control modal-form " id="root_cat_number">

                                        </div>

                                        <div class="col-12">

                                            <label class="form-label">Register Date <span class="text-danger">*</span></label>

                                            <input type="date" class="form-control modal-form format_data" id="add_roots_register_date">

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer ">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalDelClsBtn">Close</button>

                <button type="button" class="btn btn-primary" id="saveRootButton">Save</button>

            </div>

        </div>

    </div>

</div>



<div class="modal fade" id="editRootsModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title"><i class="fadeIn animated bx bx-layer-plus"></i>Update Roots</h5>

            </div>
            <form class="row g-3">
                <div class="modal-body">

                    <div class="row">

                        <div class="col-xl-12 ">

                            <div class="card">

                                <div class="card-body">

                                    <div class=" p-3 rounded">


                                        <input type="hidden" class="form-control modal-form " value="" readonly id="edit_roots_id">

                                        <div class="col-12">

                                            <label class="form-label">Case No. <span class="text-danger">*</span></label>

                                            <input type="text" class="form-control modal-form " value="<?= $current_case[0]['case_number'] ?>" readonly id="edit_roots_case_number">

                                        </div>

                                        <!-- <div class="col-12">

                                            <label class="form-label">Lawyer <span class="text-danger">*</span></label>

                                            <input type="text" class="form-control modal-form " value="" id="edit_roots_lawyer">

                                        </div> -->

                                        <div class="col-12">
                                            <label class="form-label">Lawyer <span class="text-danger">*</span></label>
                                            <select class="form-control modal-form" id="edit_roots_lawyer" name="lawyer" required>
                                                <option value="">-- Select Lawyer --</option>
                                                <?php
                                                $selectedLawyer = $current_case[0]['lawyer'];        // raw stored value (id or text)
                                                $selectedLawyerName = $current_case[0]['lawyer_name']; // resolved display name

                                                foreach ($lawyerusersList as $lawyer) {
                                                    $selected = ($selectedLawyer == $lawyer['user_Id']) ? "selected" : "";
                                                    echo "<option value='{$lawyer['user_Id']}' $selected>{$lawyer['user_name']}</option>";
                                                }

                                                // If the lawyer is free text (not numeric, not in the users list), keep it selectable
                                                if (!is_numeric($selectedLawyer) && !empty($selectedLawyer)) {
                                                    echo "<option value='{$selectedLawyer}' selected>{$selectedLawyerName}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>


                                        <div class="col-12">

                                            <label class="form-label">Court <span class="text-danger">*</span></label>

                                            <select type="text" class="form-select modal-form format_data" id="edit_roots_court">

                                                <option value="">--- Select court ---</option>

                                                <?php if ($courts) { ?>

                                                    <?php foreach ($courts as $court) { ?>

                                                        <option value="<?= $court['id'] ?>"><?= $court['title'] ?></option>

                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>



                                        <div class="col-12">
                                            <label class="form-label">Stage <span class="text-danger">*</span></label>
                                            <select class="form-select modal-form format_data" id="edit_roots_stage">
                                                <option value="">--- Select Stage ---</option>
                                                <!-- Options 1 to 100 -->
                                                <?php for ($i = 1; $i <= 100; $i++): ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>


                                        <div class="col-12">
    <label class="form-label">Plaintiff <span class="text-danger"></span></label>
    <select class="form-select modal-form format_data" id="edit_roots_plantiff">
        <option value="">--- Select Plaintiff ---</option>
        <option value="Tabasco Tech">Tabasco Tech</option>
        <?php if (!empty($case_plantiffs)) { ?>
            <?php foreach ($case_plantiffs as $d) { ?>
                <option
                value="<?= htmlspecialchars($d['plantiff']) ?>"
                <?= ($d['plantiff_id'] == $selected_plantiff) ? 'selected' : '' ?>
            >
                <?= htmlspecialchars($d['plantiff']) ?>
            </option>
            <?php } ?>
        <?php } ?>
    </select>
  
</div>

<div class="col-12">
    <label class="form-label">Defendant <span class="text-danger"></span></label>
    <select class="form-select modal-form format_data" id="edit_roots_defendant">
        <option value="">--- Select Defendant ---</option>
        <?php if (!empty($case_defender)) { ?>
            <?php foreach ($case_defender as $d) { ?>
                <option
                value="<?= htmlspecialchars($d['defendant']) ?>"
                <?= ($d['defendant'] == $selected_defendant) ? 'selected' : '' ?>
            >
                <?= htmlspecialchars($d['defendant']) ?>
            </option>
            <?php } ?>
        <?php } ?>
    </select>
  
</div>



                                        <input type="hidden" id="previous_stage">

                                        <div class="col-12">

                                            <label class="form-label">Category <span class="text-danger">*</span></label>

                                            <select type="text" class="form-select modal-form format_data" id="edit_roots_category">

                                                <option value="">--- Select Category ---</option>

                                                <?php if ($categories) { ?>

                                                    <?php foreach ($categories as $category) { ?>

                                                        <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>

                                                    <?php } ?>

                                                <?php } ?>

                                            </select>

                                        </div>
                                        <div class="col-12">

                                            <label class="form-label">Number </label>

                                            <input type="text" class="form-control modal-form" id="edit_root_cat_number"   >


                                        </div>

                                        <div class="col-12">

                                            <label class="form-label">Register Date <span class="text-danger">*</span></label>

                                            <input type="date" class="form-control modal-form format_data" id="edit_roots_register_date">

                                        </div>



                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer ">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="editModalDelClsBtn">Close</button>

                    <button type="button" class="btn btn-primary" id="updateRootButton">Save</button>

                </div>
            </form>
        </div>

    </div>

</div>


<div class="modal fade" id="addNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="lni lni-pencil"></i> Add Notification
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="notificationForm">
                <div class="modal-body">
                    <input type="hidden" id="marketing" value="<?= $active_legal[0]['user_id'] ?>">
                    <input type="hidden" id="client" value="<?= $active_legal[0]['client'] ?>">
                    <input type="hidden" id="active_legal_id" value="<?= $active_legal[0]['id'] ?>">
                    <input type="hidden" id="caseSelect" name="case" value="<?= $current_case[0]['id'] ?>">

                    <!-- Case Dropdown -->
                    <div class="mb-3">
                        <label for="caseSelect" class="form-label">Case</label>
                        <input type="text" class="form-control mt-2" value="<?= $current_case[0]['case_number'] ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="stage" class="form-label">Case Stage</label>
                        <select class="form-select" id="stage" name="stage" required>
                            <option value="">Select Case Stage</option>
                            <?php if ($current_case_root) { ?>
                                <?php foreach ($current_case_root as $case_root) { ?>
                                    <option value="<?= $case_root['id'] ?>"><?= $case_root['stage'] ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Hearing Date -->
                    <div class="mb-3">
                        <label for="hearingDate" class="form-label">Hearing Date</label>
                        <input type="date" class="form-control" id="hearingDate" name="hearing_date" required>
                    </div>

                    <!-- Remind Date -->
                    <div class="mb-3">
                        <label for="remindDate" class="form-label">Remind From Date</label>
                        <input type="date" class="form-control" id="remind_date" name="remind_date" required>
                    </div>

                    <!-- Status Dropdown -->
                    <div class="mb-3">
                        <label for="statusSelect" class="form-label">Status</label>
                        <select class="form-select" id="statusSelect" name="status" required>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Notification</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {

        loadData();

        $("#editRootsModal").on('show.bs.modal', function(event) {

            let button = $(event.relatedTarget);

            let currentData = button.data('jsonvalues');



            let current_id = currentData.id

            let current_lawyer = currentData.lawyer

            let current_court = currentData.court

            let current_stage = currentData.stage

            let current_category = currentData.category

            let current_plantiff = currentData.plantiff; 
            let current_defendant = currentData.defendant;

            
            let current_register_date = currentData.register_date


            let root_cat_number = currentData.root_cat_number

            let editModal = $(this)

            editModal.find("#edit_roots_id").val(current_id)
            editModal.find("#edit_roots_lawyer").val(current_lawyer)
            editModal.find("#edit_roots_court").val(current_court)
            editModal.find("#edit_roots_stage").val(current_stage)
            editModal.find("#edit_roots_plantiff").val(current_plantiff)
            editModal.find("#edit_roots_defendant").val(current_defendant)
            editModal.find("#previous_stage").val(current_stage)
            editModal.find("#edit_roots_category").val(current_category)
            editModal.find("#edit_roots_register_date").val(current_register_date)
            editModal.find("#edit_root_cat_number").val(root_cat_number)


           

        })

        $("#notificationForm").on("submit", function(e) {
            e.preventDefault(); // prevent normal form submit

            $.ajax({
                type: "POST",
                url: "<?= ROOT_DIR ?>modules/activelegal/ajax/case_notification.php", // change to your save route
                data: {
                    marketing: $("#marketing").val(),
                    client: $("#client").val(),
                    case: $("#caseSelect").val(),
                    hearing_date: $("#hearingDate").val(),
                    remind_date: $("#remind_date").val(),
                    status: $("#statusSelect").val(),
                    active_legal_id: $("#active_legal_id").val(),
                    stage: $("#stage").val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $("#addNotificationModal").modal("hide");
                        showToast("success", response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
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

    })


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


    $("#saveRootButton").click(function() {

        let case_number = $("#add_roots_case_number")

        let lawyer = $("#add_roots_lawyer")

        let court = $("#add_roots_court")

        let stage = $("#add_roots_stage")

        let plantiff = $("#add_roots_plantiff")

        let defendant = $("#add_roots_defendant")

        let category = $("#add_roots_category")

        let register_date = $("#add_roots_register_date")

        let root_cat_number = $("#root_cat_number")

     


        let goForward = validateForm(case_number, lawyer, court, stage,category,plantiff,defendant, register_date,root_cat_number);

        if (goForward) {

            let case_id = '<?= $current_case[0]['id'] ?>'

            let active_legal_id = '<?= $current_case[0]['active_legal_id'] ?>'

            let csrf_token = '<?= $_SESSION['csrf_token']; ?>'



            // console.log(active_legal_id);

            // return

            $.ajax({

                type: 'post',

                url: '<?= ROOT_DIR ?>modules/case/ajax/roots_handling.php',

                data: {

                    action: 'save',

                    csrf_token,

                    case_id,

                    active_legal_id,

                    lawyer: lawyer.val(),

                    court: court.val(),

                    stage: stage.val(),

                    plantiff: plantiff.val(),

                    defendant: defendant.val(),

                    category: category.val(),

                    register_date: register_date.val(),

                    root_cat_number: root_cat_number.val(),

                },

                success: function(response) {


                    if (response.success) {

                        $(".modal-form").removeClass('is-valid').removeClass('is-invalid')

                        round_success_noti(response.message)

                        $("#modalDelClsBtn").click();

                        $(".format_data").val('');

                        loadData();

                    } else {

                        round_error_notify(response.message)

                    }

                }

            })

        }



    })



    $("#updateRootButton").click(function() {

    let case_number_el = $("#edit_roots_case_number");
    let lawyer_el      = $("#edit_roots_lawyer");
    let court_el       = $("#edit_roots_court");
    let stage_el       = $("#edit_roots_stage");
    let plantiff_id    = $("#edit_roots_plantiff");
    let defendant_id   = $("#edit_roots_defendant");
    let category_el    = $("#edit_roots_category");
    let register_el    = $("#edit_roots_register_date");
    let root_number_el = $("#edit_root_cat_number"); 

    
    let goForward = validateForm(case_number_el, lawyer_el, court_el, stage_el,  category_el, register_el,root_number_el);

    if (goForward) {
   
        let roots_id        = $("#edit_roots_id").val();
        let previous_stage  = $("#previous_stage").val();
        let case_id         = '<?= $current_case[0]['id'] ?>';
        let active_legal_id = '<?= $current_case[0]['active_legal_id'] ?>';
        let csrf_token      = '<?= $_SESSION['csrf_token']; ?>';

        $.ajax({
            type: 'post',
            url: '<?= ROOT_DIR ?>modules/case/ajax/roots_handling.php',
            data: {
                action: 'save',
                csrf_token: csrf_token,
                case_id: case_id,
                active_legal_id: active_legal_id,
                id: roots_id,
                lawyer: lawyer_el.val(),
                court: court_el.val(),
                stage: stage_el.val(),
                plantiff: plantiff_id.val(),
                defendant: defendant_id.val(),
                category: category_el.val(),
                register_date: register_el.val(),
                previous_stage: previous_stage,
                root_cat_number: root_number_el.val() 
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $(".modal-form").removeClass('is-valid').removeClass('is-invalid');
                    round_success_noti(response.message);
                   
                    $("#editRootsModal").modal('hide'); 
                    
                    $(".format_data").val('');
                    loadData();
                } else {
                    round_error_notify(response.message);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }
})



    function loadData() {

        let case_id = '<?= $current_case[0]['id'] ?>'

        let active_legal_id = '<?= $current_case[0]['active_legal_id'] ?>'

        let csrf_token = '<?= $_SESSION['csrf_token']; ?>'


        // console.log(active_legal_id);

        // return

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/case/ajax/roots_handling.php',

            data: {

                action: 'get_data',

                csrf_token,

                case_id,

                active_legal_id,

            },

            success: function(response) {

                $("#dataTableBody").html(response.message)

            }

        })

    }





    function validateForm(case_number, lawyer, court, stage, category, register_date) {

        let proceed = true

        if (case_number.val() == '') {

            proceed = false;

            case_number.addClass('is-invalid').removeClass('is-valid')

        } else {

            case_number.addClass('is-valid').removeClass('is-invalid')

        }

        if (lawyer.val() == '') {

            proceed = false;

            lawyer.addClass('is-invalid').removeClass('is-valid')

        } else {

            lawyer.addClass('is-valid').removeClass('is-invalid')

        }

        if (court.val() == '') {

            proceed = false;

            court.addClass('is-invalid').removeClass('is-valid')

        } else {

            court.addClass('is-valid').removeClass('is-invalid')

        }

        if (stage.val() == '') {

            proceed = false;

            stage.addClass('is-invalid').removeClass('is-valid')

        } else {

            stage.addClass('is-valid').removeClass('is-invalid')

        }


       



        if (category.val() == '') {

            proceed = false;

            category.addClass('is-invalid').removeClass('is-valid')

        } else {

            category.addClass('is-valid').removeClass('is-invalid')

        }

        if (register_date.val() == '') {

            proceed = false;

            register_date.addClass('is-invalid').removeClass('is-valid')

        } else {

            register_date.addClass('is-valid').removeClass('is-invalid')

        }

        return proceed;

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


