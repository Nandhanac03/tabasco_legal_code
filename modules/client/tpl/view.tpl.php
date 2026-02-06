<!-- start page content wrapper-->
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
                            <li class="breadcrumb-item active" aria-current="page">Client View</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Back Button on the Right -->
            <!-- Back & Edit Buttons Container -->
            <div class="d-flex align-items-center gap-2">
                <?php include("common/backButton_list.php"); ?>



<?php if (LEGAL_AUTH_EDIT): ?>
                <!-- Edit Button -->
                <button class="btn btn-primary px-4" type="button"
                    onclick="window.location.href='<?= ROOT_DIR . 'client/information/edit/' . intval($data['id'] ?? 0) . '.html' ?>'"
                    id="editButton">
                    <i class='bx bx-edit-alt me-1'></i>Edit
                </button>
<?php endif; ?>
<?php if (LEGAL_AUTH_DELETE): ?>
                <button class="btn btn-danger px-4" type="button" id="deleteButton" data-bs-toggle="modal"
                    data-bs-target="#exampleLargeModal">
                    <i class='bx bx-trash-alt me-1'></i>Delete
                </button>

<?php endif; ?>


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
                    <div class="modal-body">Are you sure you want to delete this record? This action cannot be undone.</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" onclick="window.location.href='<?= ROOT_DIR . 'client/information/delete/' . intval($data['id'] ?? 0) . '.html' ?>'">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-12 mx-auto">



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


                            <div class="step" data-target="#test-vl-5">
                                <div class="step-trigger" role="tab" id="stepper3trigger5" aria-controls="test-vl-5"
                                    onclick="goToStep(5)">
                                    <div class="bs-stepper-circle"><i class='bx bxs-user-detail fs-4'></i></div>
                                    <div class="">
                                        <h5 class="mb-0 steper-title">Plantiff</h5>
                                        <p class="mb-0 steper-sub-title"></p>
                                    </div>
                                </div>
                            </div>



                            
                            <div class="step" data-target="#test-vl-6">
                                <div class="step-trigger" role="tab" id="stepper3trigger6" aria-controls="test-vl-6"
                                    onclick="goToStep(6)">
                                    <div class="bs-stepper-circle"><i class='bx bxs-shield fs-4'></i></div>
                                    <div class="">
                                        <h5 class="mb-0 steper-title">Defender</h5>
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
                                    <h5 class="mb-1">Profile</h5>
                                    <p class="mb-4"></p>

                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Code</label>
                                            <p class="form-control mb-0">
                                                <?= !empty($data['code']) ? htmlspecialchars($data['code']) : '-' ?>
                                            </p>
                                        </div>

                                        <?php $data['type'] == 'I' ?>
                                        <div class="col-12 col-lg-6">
                                            <label
                                                class="form-label"><?= $type = $data['type'] == 'I' ? 'Internal staff' : ($data['type'] == 'M' ? 'Marketing' : 'unknown'); ?></label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['marketing_person']) ? htmlspecialchars($data['marketing_person']) : '-' ?>
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Client</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['name']) ? htmlspecialchars($data['name']) : '-' ?>
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Office Address</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['office_address']) ? htmlspecialchars($data['office_address']) : '-' ?>
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Contact Person</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['contact_person']) ? htmlspecialchars($data['contact_person']) : '-' ?>
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Designation</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['designation']) ? htmlspecialchars($data['designation']) : '-' ?>
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Mobile No</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['mobile_number']) ? htmlspecialchars($data['mobile_number']) : '-' ?>
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Email</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['email']) ? htmlspecialchars($data['email']) : '-' ?>
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Land No</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['land_number']) ? htmlspecialchars($data['land_number']) : '-' ?>
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">PO Box</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['po_number']) ? htmlspecialchars($data['po_number']) : '-' ?>
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Fax No</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['fax_number']) ? htmlspecialchars($data['fax_number']) : '-' ?>
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Website</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['website']) ? htmlspecialchars($data['website']) : '-' ?>
                                            </p>
                                        </div>

                                        <?php if ($data['visiting_card'] != '' && file_exists('uploads/visiting_card/' . $data['visiting_card'])) { ?>
                                            <div class="col-12 col-lg-6">
                                                <label class="form-label">Visiting Card</label>
                                                <a href="<?= ROOT_DIR . 'uploads/visiting_card/' . $data['visiting_card'] ?>"
                                                    target="_blank"><?= $data['visiting_card'] ?></a>
                                            </div>

                                            <div class="col-12 col-lg-6">


                                            </div>
                                        <?php }
                                        ?>

                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Total Outstanding</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['total_outstanding']) ? htmlspecialchars($data['total_outstanding']) : '-' ?>
                                            </p>
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Outstanding with cheque</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['outstanding_cheque']) ? htmlspecialchars($data['outstanding_cheque']) : '-' ?>
                                            </p>
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Outstanding without cheque</label>
                                            <p class="form-control  mb-0">
                                                <?= !empty($data['outstanding_without_cheque']) ? htmlspecialchars($data['outstanding_without_cheque']) : '-' ?>
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
                                                <button class="btn btn-primary px-4" onclick="stepper3.next()">Next<i
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
                                                        <th>Sl No</th>
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
                                                <button class="btn btn-primary px-4" onclick="stepper3.next()">Next<i
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
                                        <table class="table table-striped align-middle">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <td>Sl No</td>
                                                    <td>Marketing</td>
                                                    <td>Client</td>
                                                    <td>Party Name</td>
                                                    <td>Category</td>
                                                    <td>Commision %</td>
                                                    <td>Notes</td>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="15" class="text-center">No Records</td>
                                                </tr>


                                            </tbody>
                                        </table>

                                        <div class="col-12">
                                            <div class="d-flex align-items-center gap-3">
                                                <button class="btn btn-outline-secondary px-4"
                                                    onclick="stepper3.previous()"><i
                                                        class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                                <button class="btn btn-primary px-4" onclick="stepper3.next()">Next<i
                                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                                            </div>
                                        </div>
                                    </div><!---end row-->

                                </div>


                       <!-- plantiff -->


                         <div id="test-vl-5" role="tabpane3" class="bs-stepper-pane content fade"
                                    aria-labelledby="stepper3trigger5">
                                    <h5 class="mb-1">Plantiff</h5>
                                    <p class="mb-4"></p>

                                    <div class="row g-3">

                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped align-middle">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th>SI No</th>
                                                        <th>Name</th>
                                                        <th>Contact Number</th>
                                                        <th>Email</th>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($array_plantiff)): ?>
                                                        <?php $dCn = 1; ?>
                                                        <?php foreach ($array_plantiff as $rowsCont): ?>
                                                            <tr>
                                                                <td><?= $dCn ?></td>
                                                                <td><?= htmlspecialchars($rowsCont['name']) ?></td>
                                                                <td><?= htmlspecialchars($rowsCont['contact_number']) ?>
                                                                </td>
                                                                <td><?= htmlspecialchars($rowsCont['email']) ?></td>
                                                            
                                                          

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
                                                <button class="btn btn-primary px-4" onclick="stepper3.next()">Next<i
                                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                                            </div>
                                        </div>
                                    </div><!---end row-->

                                </div>

<!-- ************ -->









<!-- Defender -->


<div id="test-vl-6" role="tabpane3" class="bs-stepper-pane content fade"
                                    aria-labelledby="stepper3trigger6">
                                    <h5 class="mb-1">Defender</h5>
                                    <p class="mb-4"></p>

                                    <div class="row g-3">

                                        <div class="table-responsive mt-3">
                                            <table class="table table-striped align-middle">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th>SI No</th>
                                                        <th>Name</th>
                                                        <th>Contact Number</th>
                                                        <th>Email</th>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($array_defender)): ?>
                                                        <?php $dCn = 1; ?>
                                                        <?php foreach ($array_defender as $rowsCont): ?>
                                                            <tr>
                                                                <td><?= $dCn ?></td>
                                                                <td><?= htmlspecialchars($rowsCont['name']) ?></td>
                                                                <td><?= htmlspecialchars($rowsCont['contact_number']) ?>
                                                                </td>
                                                                <td><?= htmlspecialchars($rowsCont['email']) ?></td>
                                                            
                                                          

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
                                              
                                            </div>
                                        </div>
                                    </div><!---end row-->

                                </div>

<!-- ************ -->



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