<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Reports</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">View Reports</li>
                    </ol>
                </nav>
            </div>
            <a href="javascript: history.go(-1);"
                class="btn btn-dark ms-auto">
                <ion-icon name="return-down-back-outline"></ion-icon> BACK
            </a>
        </div>


        <div class="row">
            <!--end breadcrumb-->
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-lg">
                                <input type="text" class="form-control" placeholder="Search by Client">
                            </div>
                            <div class="col-12 col-lg">
                                <input type="text" class="form-control" placeholder="Search by Legal Firm">
                            </div>
                            <div class="col-12 col-lg">
                                <input type="date" class="form-control" id="bsValidation8" placeholder="" readonly="true" />
                                <span class="small text-muted">From Date</span>
                            </div>
                            <div class="col-12 col-lg">
                                <input type="date" class="form-control" id="bsValidation8" placeholder="" readonly="true" />
                                <span class="small text-muted">To Date</span>
                            </div>
                            <div class="col-12 col-lg">
                                <button type="button" class="btn btn-primary">Search</button>
                            </div>
                        </div><!--end row-->
                    </div>
                </div>
                <div class="card radius-10">
                    <div class="card-header">
                        <h6><i class="lni lni-user me-2"></i>Client Base Action Report</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-invoice">
                                <tbody>
                                    <tr>
                                        <th>Client</th>
                                        <td class="text-right" width=""><?= $active_legal[0]['ClientName'] ?></td>
                                        <th>Legal Status</th>
                                        <?php
                                        if ($active_legal[0]['legal_status'] == 'Bad_debts') {
                                            $active_legal[0]['legal_status'] = 'Bad debts';
                                        }
                                        ?>
                                        <td class="text-right" width=""><?= $active_legal[0]['legal_status'] ?></td>
                                    </tr>
                                    <tr>

                                        <th>Code</th>
                                        <td class="text-right" width=""><?= $active_legal[0]['code'] ?></td>


                                        <th>Marketing:</th>


                                        <td class="text-right" width=""><?= $active_legal[0]['User_Client'] ?> - <?= $active_legal[0]['Usertype_Client'] ?></td>


                                    </tr>
                                    <tr>


                                        <th>Present Legal Firm</th>
                                        <td class="text-right" width=""><?= $active_legal[0]['Present_Legal_Firm_Name'] ?></td>
                                        <th></th>
                                        <td class="text-right" width=""></td>


                                    </tr>
                                    <tr>




                                        <th>Case No :</th>


                                        <td class="text-right" width=""><?= $legal_case[0]['case_number'] ?></td>
                                        <th>Case Start</th>


                                        <td class="text-right" width=""><?= $legal_case[0]['register_date'] ?></td>


                                    </tr>







                                    <tr>


                                        <th>Total claim Amount</th>


                                        <td class="text-right" width=""><?= $legal_case[0]['total_outstanding'] ?></td>


                                        <th>Advocate Fee</th>


                                        <td class="text-right" width="">...</td>


                                    </tr>


                                    <tr>


                                        <th></th>


                                        <td class="text-right" width=""></td>


                                        <td class="text-right" width="">Contact No :</td>

                                        <?php
                                        $C_contactno  = '';
                                        if ($active_legal[0]['legal_firm_type'] == 'debt_collector') {
                                            $C_contactno = $active_legal[0]['Deptmobile_number'];
                                        } else if ($active_legal[0]['legal_firm_type'] == 'legal_firm') {
                                            $C_contactno = $active_legal[0]['legalfirmmobile_number'];
                                        } else if ($active_legal[0]['legal_firm_type'] == 'third_party') {
                                            $C_contactno = $active_legal[0]['thirdmobile_number'];
                                        } else if ($active_legal[0]['legal_firm_type'] == 'legal_team') {
                                            $C_contactno = $active_legal[0]['legalteammobile_number'];
                                        } ?>


                                        <td class="text-right" width=""><?= $C_contactno ?></td>


                                    </tr>


                                </tbody>


                            </table>


                        </div>


                    </div>


                </div>


            </div>


            <div class="col-12 col-md-12">


                <div class="card radius-10">


                    <div class="card-header">


                        <h6><i class="fadeIn animated bx bx-file-blank me-2"></i>Report</h6>


                    </div>


                    <div class="card-body">


                        <div class="table-responsive">


                            <table class="table table-invoice">


                                <tbody>


                                    <tr>


                                        <th class="text-right" width="5%">Date</th>

                                        <th class="text-right" width="20%">Description</th>
                                        <th class="text-right" width="10%">Legal Firm</th>
                                        <th class="text-right" width="10%">Status</th>
                                        <th class="text-right" width="10%">Category</th>
                                        <th class="text-right" width="10%">Sub CAtegory</th>
                                        <th class="text-right" width="5%">UAE Pass</th>
                                        <th class="text-right" width="5%">Root Stage</th>
                                        <th class="text-right" width="5%">Number</th>
                                        <th class="text-right" width="5%">Document</th>
                                        <th class="text-end" width="20%">Remark</th>


                                        <!-- <th class="text-end" width="10%">Balance to Claim</th> -->


                                    </tr>

                                    <?php if ($case_actions) { ?>
                                        <?php foreach ($case_actions as $action) { ?>
                                            <tr>
                                                <td class="text-right" width="5%"><?= $action['date'] ?></td>


                                                <td class="text-right" width="30%" style="max-width:380px; min-width:340px; white-space:normal; word-wrap:break-word; overflow-wrap:break-word; text-align: justify;"><?= $action['description'] ?></td>
                                                <td class="text-right" width="10%"><?= $action['Present_Legal_Firm_Name'] ?></td>

                                                <?php
                                                if ($action['created_from'] == 'CA') {
                                                    $status = 'Case Action';
                                                } else if ($action['created_from'] == 'FA') {
                                                    $status = 'Followup Action';
                                                }
                                                ?>
                                                <td class="text-right" width="10%"><?= $status ?></td>
                                                <td class="text-right" width="10%"><?= $action['category_title'] ?></td>
                                                <td class="text-right" width="10%"><?= $action['subcategory_title'] ?></td>


                                                <td class="text-right" width="10%"><?= $action['uae_pass'] ?></td>

                                                <td class="text-right" width="10%"><?= $action['root_stage'] ?></td>

                                                <td class="text-right" width="10%"><?= $action['root_cat_number'] ? $action['root_cat_number'] : '' ?></td>


                                                <?php if ($action['document']) {
                                                    $root_doc = ROOT_DIR . 'uploads/action_documents/' . $action['document'];
                                                    echo '<td>
        <a href="' . htmlspecialchars($root_doc) . '" target="_blank">
            <button type="button" class="btn text-success">
                <i class="fadeIn animated bx bx-file"></i>
            </button>
        </a>
      </td>';
                                                } else {
                                                    echo "<td><button class='btn text-danger'><i class='fadeIn animated bx bx-file'></i></button>";
                                                }
                                                ?>

                                                <td class="text-end" width="20%"></td>
                                            </tr>

                                        <?php } ?>

                                    <?php } else { ?>
                                        <tr>

                                            <td class='text-center' colspan='4'>No data available...</td>

                                        </tr>
                                    <?php } ?>

                                    <!-- <tr>


                                        <th class="text-center" width="10%" colspan="3">Total</th>


                                        <th class="text-end" width="10%">981212.50</th>


                                        <th class="text-end" width="10%">10000.00</th>


                                        <th class="text-end" width="10%">971212.50</th>


                                    </tr> -->


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