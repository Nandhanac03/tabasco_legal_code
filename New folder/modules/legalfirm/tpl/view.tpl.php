<!-- start page content wrapper-->

<div class="page-content-wrapper">

    <!-- start page content-->

    <div class="page-content">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!--start breadcrumb-->

        <div class="d-flex justify-content-between align-items-center mb-3">

            <!-- Breadcrumb on the Left -->

            <div class="page-breadcrumb d-none d-sm-flex align-items-center">

                <div class="breadcrumb-title pe-3">Legal Firm View</div>

                <div class="ps-3">

                    <nav aria-label="breadcrumb">

                        <ol class="breadcrumb mb-0 p-0 align-items-center">

                            <li class="breadcrumb-item">

                                <a href="javascript:;" id="home-icon">

                                    <ion-icon name="home-outline" title="Back to Dashboard"></ion-icon>

                                </a>

                            </li>



                        </ol>

                    </nav>

                </div>

            </div>

            <!-- Back Button on the Right -->

            <!-- Back & Edit Buttons Container -->

            <div class="d-flex align-items-center gap-2">

                <?php include("common/backButton_list.php"); ?>



                <div class="col">

                    <div class="btn-group">

                        <button type="button" class="btn btn-outline-primary">Actions</button>

                        <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown" aria-expanded="false"> <span class="visually-hidden">Toggle

                                Dropdown</span>

                        </button>

                        <ul class="dropdown-menu">
                            <?php if (LEGAL_AUTH_EDIT): ?>
                                <li><a class="dropdown-item"
                                        href="<?= ROOT_DIR . 'legalfirm/information/edit/' . intval($data['id'] ?? 0) . '.html' ?>"><i
                                            class="fadeIn animated bx bx-edit-alt"></i> Edit</a>

                                </li>
                            <?php endif; ?>
<?php if($_SESSION['LOGIN_SUPER_ADMIN']=='Y'): ?>

                            <li><a class="dropdown-item" href="#" title="Shareable Link" data-bs-toggle="modal"
                                    data-bs-target="#sharelink_Modal"><i class="fadeIn animated bx bx-share-alt"></i>

                                    Shareable Link</a>

                            </li>



                            <li><a class="dropdown-item" href="#"
                                    title="<?= $data['locked_status'] == 'Y' ? 'Unlock' : 'Lock' ?>"
                                    data-bs-toggle="modal" data-bs-target="#lock_unlock_Modal">

                                    <?= $data['locked_status'] == 'Y' ? '<i class="fadeIn animated bx bx-lock-open"></i>' : '<i class="fadeIn animated bx bx-lock"></i>' ?>

                                    <?= $data['locked_status'] == 'Y' ? 'Unlock' : 'Lock' ?>

                                </a>

                            </li>
    <?php endif; ?>
<li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#login_credentials_Modal" title="Login Credentials"><i
                                        class="fadeIn animated bx bx-log-in-circle"></i> Login Credentials</a>

                            </li>
                            <?php if (LEGAL_AUTH_EDIT): ?>

                                <li><a class="dropdown-item" href="#" title="Delete" id="deleteButton"
                                        data-bs-toggle="modal" data-bs-target="#exampleLargeModal"><i
                                            class="fadeIn animated bx bx-trash-alt"></i> Delete</a>



                                </li>
                            <?php endif; ?>
                        </ul>

                    </div>

                </div>

            </div>



        </div>

        <!--end breadcrumb-->





        <!-- Modal -->

        <div class="modal fade" id="exampleLargeModal" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">Delete Confirmation</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>

                    <div class="modal-body">Are you sure you want to delete this record? This action cannot be undone.

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                        <button type="button" class="btn btn-primary"
                            onclick="window.location.href='<?= ROOT_DIR . 'legalfirm/information/delete/' . intval($data['id'] ?? 0) . '.html' ?>'">Yes</button>

                    </div>

                </div>

            </div>

        </div>



        <div class="row">

            <div class="col col-lg-12 mx-auto">

                <?php include("common/manage_LoginCredentials.php"); ?>

                <?php include("common/manage_Sharelink.php"); ?>

                <?php include("common/manage_Lock.php"); ?>



                <!--start stepper three-->



                <div class="card">

                    <div class="card-body">

                        <div id="stepper3" class="bs-stepper gap-4 vertical">

                            <div class="bs-stepper-header" role="tablist">

                                <div class="step" data-target="#test-vl-1">

                                    <div class="step-trigger" role="tab" id="stepper3trigger1" aria-controls="test-vl-1"
                                        onclick="goToStep(1)">

                                        <div class="bs-stepper-circle"><i class='bx bx-user-circle fs-4'></i></div>

                                        <div class="">

                                            <h5 class="mb-0 steper-title">Profile</h5>

                                            <p class="mb-0 steper-sub-title"></p>

                                        </div>

                                    </div>

                                </div>



                                <div class="step" data-target="#test-vl-2">

                                    <div class="step-trigger" role="tab" id="stepper3trigger2" aria-controls="test-vl-2"
                                        onclick="goToStep(2)">

                                        <div class="bs-stepper-circle"><i class='bx bx-file fs-4'></i></div>

                                        <div class="">

                                            <h5 class="mb-0 steper-title">Documents</h5>

                                            <p class="mb-0 steper-sub-title"></p>

                                        </div>

                                    </div>

                                </div>



                                <div class="step" data-target="#test-vl-3">

                                    <div class="step-trigger" role="tab" id="stepper3trigger3" aria-controls="test-vl-3"
                                        onclick="goToStep(3)">

                                        <div class="bs-stepper-circle"><i class='bx bxs-user-plus fs-4'></i></div>

                                        <div class="">

                                            <h5 class="mb-0 steper-title">Contact</h5>

                                            <p class="mb-0 steper-sub-title"></p>

                                        </div>

                                    </div>

                                </div>



                                <div class="step" data-target="#test-vl-4">

                                    <div class="step-trigger" role="tab" id="stepper3trigger4" aria-controls="test-vl-4"
                                        onclick="goToStep(4)">

                                        <div class="bs-stepper-circle"><i class='bx bx-dollar fs-4'></i></div>

                                        <div class="">

                                            <h5 class="mb-0 steper-title">Commission</h5>

                                            <p class="mb-0 steper-sub-title"></p>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            <script>

                                document.addEventListener("DOMContentLoaded", function () {

                                    window.stepper3 = new Stepper(document.querySelector("#stepper3"));

                                });



                                function goToStep(stepNumber) {

                                    stepper3.to(stepNumber);

                                }

                            </script>





                            <div class="bs-stepper-content">

                                <form onSubmit="return false">

                                    <div id="test-vl-1" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger1">

                                        <h5 class="mb-1">Profile <span
                                                class="text-danger"><?= $data['locked_status'] == 'Y' ? ' (<i class="fadeIn animated bx bx-lock"></i>Locked ) ' : '' ?></span>
                                        </h5>

                                        <p class="mb-4"></p>



                                        <div class="row g-3">

                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">Code</label>

                                                <p class="form-control mb-0">

                                                    <?= !empty($data['code']) ? htmlspecialchars($data['code']) : '-' ?>

                                                </p>

                                            </div>



                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">Name</label>

                                                <p class="form-control  mb-0">

                                                    <?= !empty($data['name']) ? htmlspecialchars($data['name']) : '-' ?>

                                                </p>

                                            </div>

                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">Address</label>

                                                <p class="form-control  mb-0">

                                                    <?= !empty($data['address']) ? htmlspecialchars($data['address']) : '-' ?>

                                                </p>

                                            </div>

                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">Contact Number</label>

                                                <p class="form-control  mb-0">

                                                    <?= !empty($data['contact_no']) ? htmlspecialchars($data['contact_no']) : '-' ?>

                                                </p>

                                            </div>

                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">Email</label>

                                                <p class="form-control  mb-0">

                                                    <?= !empty($data['email']) ? htmlspecialchars($data['email']) : '-' ?>

                                                </p>

                                            </div>



                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">Notes</label>

                                                <p class="form-control  mb-0">

                                                    <?= !empty($data['notes']) ? htmlspecialchars($data['notes']) : '-' ?>

                                                </p>

                                            </div>



                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">PO Box</label>

                                                <p class="form-control  mb-0">

                                                    <?= !empty($data['post_box_no']) ? htmlspecialchars($data['post_box_no']) : '-' ?>

                                                </p>

                                            </div>





                                            <?php if ($data['visiting_card'] != '' && file_exists('uploads/visiting_card/' . $data['visiting_card'])) { ?>

                                                <div class="col-12 col-lg-6">

                                                    <label class="form-label">Visiting Card</label>

                                                    <a href="<?= ROOT_DIR . 'uploads/visiting_card/' . $data['visiting_card'] ?>"
                                                        target="_blank"><?= $data['visiting_card'] ?></a>

                                                </div>





                                            <?php }

                                            ?>





                                            <div class="col-12 col-lg-12">

                                                <p>

                                                <h5>Bank Account Details</h5>

                                                </p>

                                            </div>



                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">Account Type</label>



                                                <p class="form-control mb-0">

                                                    <?= !empty($bank_detals['ac_type_name']) ? htmlspecialchars($bank_detals['ac_type_name']) : '-' ?>

                                                </p>



                                            </div>



                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">Account Name</label>

                                                <p class="form-control mb-0">

                                                    <?= !empty($bank_detals['ac_name']) ? htmlspecialchars($bank_detals['ac_name']) : '-' ?>

                                                </p>

                                            </div>



                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">Bank Name</label>

                                                <p class="form-control mb-0">

                                                    <?= !empty($bank_detals['bank_name']) ? htmlspecialchars($bank_detals['bank_name']) : '-' ?>

                                                </p>

                                            </div>



                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">IBAN No</label>

                                                <p class="form-control mb-0">
                                                    <?= !empty($bank_detals['iban_no']) ? htmlspecialchars($bank_detals['iban_no']) : '-' ?>
                                                </p>

                                            </div>



                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">Account No.</label>

                                                <p class="form-control mb-0">
                                                    <?= !empty($bank_detals['ac_number']) ? htmlspecialchars($bank_detals['ac_number']) : '-' ?>
                                                </p>

                                            </div>



                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">Bank Country</label>

                                                <p class="form-control mb-0">
                                                    <?= !empty($bank_detals['bank_country_name']) ? htmlspecialchars($bank_detals['bank_country_name']) : '-' ?>
                                                </p>

                                            </div>



                                            <div class="col-12 col-lg-6">

                                                <label class="form-label">Swift Code</label>

                                                <p class="form-control mb-0">
                                                    <?= !empty($bank_detals['swift_code']) ? htmlspecialchars($bank_detals['swift_code']) : '-' ?>
                                                </p>

                                            </div>



                                            <div class="col-12 col-lg-6">



                                            </div>

                                            <?php if (!empty($array_cheque)): ?>

                                                <div class="col-12 col-lg-12">

                                                    <label class="form-label"><b>Uploaded Cheque</b></label>

                                                    <div class="table-responsive mt-3">

                                                        <table class="table table-striped align-middle">

                                                            <thead class="table-secondary">

                                                                <tr>

                                                                    <th>#</th>

                                                                    <th>Cheque Date</th>

                                                                    <th>Amount</th>

                                                                    <th>Attachment</th>

                                                                </tr>

                                                            </thead>

                                                            <tbody>

                                                                <?php foreach ($array_cheque as $index => $RowChq): ?>

                                                                    <tr>

                                                                        <td><?= $index + 1 ?></td>

                                                                        <td><?= htmlspecialchars($RowChq['upload_date'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                                                                        </td>

                                                                        <td><?= htmlspecialchars($RowChq['amount'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
                                                                        </td>

                                                                        <td>

                                                                            <?php

                                                                            $filePath = 'uploads/all_cheque/' . ($RowChq['cheque_name'] ?? '');

                                                                            if (!empty($RowChq['cheque_name']) && file_exists(ROOT_DIR . $filePath)): ?>

                                                                                <a href="<?= htmlspecialchars(ROOT_DIR . $filePath, ENT_QUOTES, 'UTF-8') ?>"
                                                                                    target="_blank">View</a>

                                                                            <?php else: ?>

                                                                                -

                                                                            <?php endif; ?>

                                                                        </td>

                                                                    </tr>

                                                                <?php endforeach; ?>

                                                            </tbody>

                                                        </table>

                                                    </div>

                                                </div>

                                            <?php endif; ?>



                                            <div class="col-12 col-lg-6">

                                                <button class="btn btn-primary px-4" onclick="stepper3.next()">Next<i
                                                        class='bx bx-right-arrow-alt ms-2'></i></button>

                                            </div>

                                        </div> <!---end row-->





                                    </div>



                                    <div id="test-vl-2" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger2">



                                        <h5 class="mb-1">Documents</h5>

                                        <p class="mb-4"></p>



                                        <div class="row g-3">

                                            <div class="table-responsive mt-3">

                                                <table class="table table-striped align-middle">

                                                    <thead class="table-secondary">

                                                        <tr>

                                                            <th>#</th>

                                                            <th>Document Type</th>

                                                            <th>Upload Date</th>

                                                            <th>Attachment</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        <?php if (!empty($array_document)): ?>

                                                            <?php $dSl = 1; ?>

                                                            <?php foreach ($array_document as $rowsDoc): ?>

                                                                <tr>

                                                                    <td><?= $dSl ?></td>

                                                                    <td><?= htmlspecialchars($rowsDoc['document_type_name']) ?>

                                                                    </td>

                                                                    <td><?= !empty($rowsDoc['create_on']) ? date('d-m-Y h:i A', strtotime($rowsDoc['create_on'])) : '-' ?>

                                                                    </td>



                                                                    <td>

                                                                        <?php

                                                                        $filePath = '';

                                                                        $filePath = "uploads/documents/" . $rowsDoc['name'];

                                                                        if (!empty($rowsDoc['name']) && file_exists($filePath)): ?>

                                                                            <a href="<?= htmlspecialchars(ROOT_DIR . $filePath) ?>"
                                                                                target="_blank">View</a>

                                                                        <?php else: ?>

                                                                            -

                                                                        <?php endif; ?>

                                                                    </td>



                                                                </tr>

                                                                <?php $dSl++; ?>

                                                            <?php endforeach; ?>

                                                        <?php else: ?>

                                                            <tr>

                                                                <td colspan="15" class="text-center">No documents available

                                                                </td>

                                                            </tr>

                                                        <?php endif; ?>

                                                    </tbody>

                                                </table>



                                            </div>

                                            <div class="col-12">

                                                <div class="d-flex align-items-center gap-3">

                                                    <button class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>

                                                    <button class="btn btn-primary px-4"
                                                        onclick="stepper3.next()">Next<i
                                                            class='bx bx-right-arrow-alt ms-2'></i></button>

                                                </div>

                                            </div>

                                        </div><!---end row-->



                                    </div>



                                    <div id="test-vl-3" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger3">

                                        <h5 class="mb-1">Contacts</h5>

                                        <p class="mb-4"></p>



                                        <div class="row g-3">



                                            <div class="table-responsive mt-3">

                                                <table class="table table-striped align-middle">

                                                    <thead class="table-secondary">

                                                        <tr>

                                                            <th>#</th>

                                                            <th>Name</th>

                                                            <th>Contact Number</th>

                                                            <th>Email</th>

                                                            <th>Designation</th>

                                                            <th>Visiting Card</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        <?php if (!empty($array_contact)): ?>

                                                            <?php $dCn = 1; ?>

                                                            <?php foreach ($array_contact as $rowsCont): ?>

                                                                <tr>

                                                                    <td><?= $dCn ?></td>

                                                                    <td><?= htmlspecialchars($rowsCont['name']) ?></td>

                                                                    <td><?= htmlspecialchars($rowsCont['contact_number']) ?>

                                                                    </td>

                                                                    <td><?= htmlspecialchars($rowsCont['email']) ?></td>

                                                                    <td><?= htmlspecialchars($rowsCont['profession']) ?></td>

                                                                    <td>

                                                                        <?php

                                                                        $filePath = '';

                                                                        $filePath = "uploads/visiting_card/" . $rowsCont['visiting_card'];

                                                                        if (!empty($rowsCont['visiting_card']) && file_exists($filePath)): ?>

                                                                            <a href="<?= htmlspecialchars(ROOT_DIR . $filePath) ?>"
                                                                                target="_blank">View</a>

                                                                        <?php else: ?>

                                                                            -

                                                                        <?php endif; ?>

                                                                    </td>



                                                                </tr>

                                                                <?php $dCn++; ?>

                                                            <?php endforeach; ?>

                                                        <?php else: ?>

                                                            <tr>

                                                                <td colspan="15" class="text-center">No documents available

                                                                </td>

                                                            </tr>

                                                        <?php endif; ?>

                                                    </tbody>

                                                </table>



                                            </div>

                                            <div class="col-12">

                                                <div class="d-flex align-items-center gap-3">

                                                    <button class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>

                                                    <button class="btn btn-primary px-4"
                                                        onclick="stepper3.next()">Next<i
                                                            class='bx bx-right-arrow-alt ms-2'></i></button>

                                                </div>

                                            </div>

                                        </div><!---end row-->



                                    </div>



                                    <div id="test-vl-4" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger4">

                                        <h5 class="mb-1">Commission</h5>

                                        <p class="mb-4"></p>



                                        <div class="row g-3">

                                            <table class="table align-middle mb-0">

                                                <thead class="table-light">

                                                    <tr>

                                                        <td>Sl No</td>

                                                        <td>Active Legal</td>

                                                        <td>Commission %</td>

                                                        <td>Notes</td>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    <?php if (empty($commissions)) { ?>

                                                        <tr>

                                                            <td colspan="8" class="text-center">No Records</td>

                                                        </tr>

                                                    <?php } else { ?>

                                                        <?php foreach ($commissions as $key => $commission) { ?>

                                                            <tr>

                                                                <td colspan="" class="text-left"><?= $key + 1 ?>.</td>

                                                                <td colspan="" class="text-left"><?= $commission['code'] ?></td>

                                                                <td colspan="" class="text-left">
                                                                    <?= $commission['commission'] ?></td>

                                                                <td colspan="" class="text-left"><?= $commission['notes'] ?>
                                                                </td>

                                                            </tr>

                                                        <?php } ?>

                                                    <?php } ?>

                                                </tbody>

                                            </table>



                                            <div class="col-12">

                                                <div class="d-flex align-items-center gap-3">

                                                    <button class="btn btn-primary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>



                                                </div>

                                            </div>

                                        </div><!---end row-->



                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

                <!--end stepper three-->



            </div>

        </div>



    </div>

</div>

</div>

<!-- end page content-->



</div>

<script>

    document.addEventListener("DOMContentLoaded", function () {

        window.stepper3 = new Stepper(document.querySelector("#stepper3"));

    });

</script>