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


                                <input type="text" class="form-control" placeholder="Search by Status">


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


                        <h6><i class="lni lni-user me-2"></i>Statement Base Report</h6>


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


                                        <td class="text-right" width="">...</td>


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
                                        <th class="text-right" width="50%">Description</th>
                                        <th class="text-right" width="10%">Status</th>
                                        <th class="text-end" width="8%">Recieved Collection</th>
                                        <th class="text-end" width="8%">Expense</th>
                                        <th class="text-end" width="8%">Document</th>
                                        <th class="text-end" width="18%">Remark</th>
                                    </tr>


                                    <?php if ($mergedData) { ?>
                                        <?php foreach ($mergedData as $datacoll) { 
                                            $coll_amount += $datacoll['collection_amount'];
                                            $exp_amount += $datacoll['expense_amount'];

                                            
                                            ?>
                                            <tr>
                                                <td class="text-right" width="5%"><?= $datacoll['date'] ?></td>
                                                <td class="text-right" width="50%" style="max-width:280px; min-width:240px; white-space:normal; word-wrap:break-word; overflow-wrap:break-word; text-align: justify;"><?= $datacoll['description'] ?></td>
                                                <td class="text-right" width="10%"><?= $datacoll['fees_type_title'] ? $datacoll['fees_type_title'] : '...' ?></td>
                                                <td class="text-end" width="8%"><?= $datacoll['collection_amount'] ? $datacoll['collection_amount'] : '...' ?></td>
                                                <td class="text-end" width="8%"><?= $datacoll['expense_amount'] ? $datacoll['expense_amount'] : '...' ?></td>
                                                <?php if ($datacoll['document']) {
                                                   $f_name = $datacoll['fees_type_title']  == 'Claim' ? 'collection':'expenses';
                                                    $root_doc = ROOT_DIR . 'uploads/' .$f_name .'/'. $datacoll['document'];
                                                    echo '<td class="text-end" width="15%">
        <a href="' . htmlspecialchars($root_doc) . '" target="_blank">
            <button type="button" class="btn text-success">
                <i class="fadeIn animated bx bx-file"></i>
            </button>
        </a>
      </td>';
                                                } else {
                                                    echo "<td  class='text-end' width='15%'><button class='btn text-danger'><i class='fadeIn animated bx bx-file'></i></button>";
                                                }
                                                ?>
                                                <td class="text-end" width="19%">....</td>
                                            </tr>
                                        <?php }
                                        ?>
                                        <!-- TOTAL ROW -->
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Total:</td>
                                            <td class="text-end fw-bold"><?= number_format($coll_amount, 2) ?></td>
                                            <td class="text-end fw-bold"><?= number_format($exp_amount, 2) ?></td>

                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td style="text-align: center;  color: #ff0000;" colspan="6">

                                                No records found

                                            </td>
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


    <!-- end page content-->


</div>