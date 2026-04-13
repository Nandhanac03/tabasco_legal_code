<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="d-flex justify-content-between mb-1">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Case</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0 align-items-center">
                            <li class="breadcrumb-item"><a href="javascript:;"><ion-icon
                                        name="home-outline"></ion-icon></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Case Information</li>
                        </ol>
                    </nav>
                </div>


            </div>
           
            <a class="btn btn-warning "
                href="<?= ROOT_DIR . "activelegal/view/view/$activeLegalId.html" ?>">
                <i class="lni lni-arrow-left"></i> Active Legal
            </a>
        </div>
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
                                false
                            ); // Active tab 
                            ?>
                            <?php
                            echo createNavItem(
                                "case",
                                "Information",
                                "information-sharp",
                                "list",
                                $id,
                                true
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

<!-- view -->













                        <!-- **************** -->


                        <div class="tab-content py-3">
                            <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                                <!--start shop cart-->
                                <section class="shop-page">
                                    <div class="shop-container">
                                        <div class="shop-cart">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="col">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Client: </label>
                                                                        <input type="text" class="form-control" name="ClientName" id="ClientName" value="<?= $activeLegal[0]['ClientName'] ?>" disabled>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">Marketing: </label>
                                                                        <input type="text" class="form-control" name="User_Client" id="User_Client" value="<?= $activeLegal[0]['User_Client'] ?>" disabled>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">Present Legal Firm : </label>
                                                                        <input type="text" class="form-control" name="Present_Legal_Firm_Name" id="Present_Legal_Firm_Name" value="<?= $activeLegal[0]['Present_Legal_Firm_Name'] ?>" disabled>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">Active legal: </label>
                                                                        <input type="text" class="form-control" name="code" id="code" value="<?= $activeLegal[0]['code'] ?>" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Case No: </label>
                                                                        <input type="text" class="form-control" name="case_number" id="case_number" value="<?= $legal_case[0]['case_number'] ?>" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Category: </label>
                                                                        <input type="text" class="form-control" name="category" id="category" value="<?= $legal_case[0]['category_name'] ?>" disabled>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">Plaintiff: </label>
                                                                        <input type="text" name="plaintiff" id="plaintiff" value="<?= $legal_case[0]['plaintiff']  ?>" disabled class="form-control">

                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">Defendant: </label>
                                                                        <input type="text" name="defendant" id="defendant" value="<?= $legal_case[0]['defendant']  ?>" disabled class="form-control">

                                                                    </div>



                                                                    <div class="mb-3">
                                                                        <label class="form-label">Register Day: </label>
                                                                        <input type="date" class="form-control" id="register_date" name="register_date" value="<?= $legal_case[0]['register_date'] ?>" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Case Mode: </label>
                                                                        <input type="text" class="form-control" id="case_mode" name="case_mode" value="<?= $legal_case[0]['case_mode_title'] ?>" disabled>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">Lawyer: </label>
                                                                        <input type="text" class="form-control" id="lawyer_name" name="lawyer_name" value="<?= $legal_case[0]['lawyer_name'] ?>" disabled>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">Location: </label>
                                                                        <input type="text" class="form-control" name="location" id="location" value="<?= $legal_case[0]['location'] ?>" disabled>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label">Notes:</label>
                                                                        <textarea class="form-control" name="note" rows="3" disabled><?= $legal_case[0]['note'] ?></textarea>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="col">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="mb-0"><i class="lni lni-text-align-justify"></i>
                                                                        Total Claim Amount
                                                                    </h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <form>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Total Outstanding:</label>
                                                                            <input type="text" class="form-control" name="total_outstanding" id="total_outstanding" value="<?= $activeLegal[0]['final_total_outstanding'] ?>" disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Outstanding with cheque:</label>
                                                                            <input type="text" class="form-control" name="outstanding_with_cheque" id="outstanding_with_cheque" value="<?= $activeLegal[0]['final_outstanding_cheque'] ?>" disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Outstanding without cheque:</label>
                                                                            <input type="text" class="form-control" name="outstanding_without_cheque" id="outstanding_without_cheque" value="<?= $activeLegal[0]['final_outstanding_without_cheque'] ?>" disabled>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- add cheque -->
                                                        <div class="col">
                                                            <div class="card" style="display: none;">
                                                                <div class="card-header">
                                                                    <h6 class="mb-0">
                                                                        <i class="lni lni-text-align-justify"></i>
                                                                        Cheque details
                                                                    </h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="" id="response_span">

                                                                    </div>
                                                                    <form enctype="multipart/form-data">
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
                                                                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" disabled="true" />
                                                                            <input type="hidden" id="hid_module" name="hid_module" value="<?= $_GET['module']; ?>" disabled="true" />
                                                                            <input type="hidden" id="hid_page" name="hid_page" value="<?= $_GET['page']; ?>" disabled="true" />
                                                                            <input type="hidden" id="hid_parentID" name="hid_parentID" value="<?= $_GET['param1']; ?>" disabled="true" />
                                                                        </div>

                                                                        <?php if (!$disabled_field) { ?>
                                                                            <div class="mb-3">
                                                                                <button type="button" class="btn btn-primary px-5 mb-1" id="save_cheque">Add Cheque</button>
                                                                                <button type="reset" class="btn btn-secondary px-5 mb-1" id="reset_cheque_form">Reset</button>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </form>
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
<!-- end page content-->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        loadCheque();
    })

    function loadCheque() {
        let csrf_token = $("#csrf_token").val()
        let hid_module = $("#hid_module").val()
        let hid_page = $("#hid_page").val()
        let hid_parentID = $("#hid_parentID").val()
        let active_legal = $("#code").val()
        $("#code").on("change", function() {
            active_legal = $(this).val();
            $.ajax({
                type: 'post',
                url: '<?= ROOT_DIR ?>modules/case/ajax/load_ajax_cheque.php',
                data: {
                    hid_parentID,
                    hid_module,
                    hid_page,
                    csrf_token,
                    active_legal
                },
                success: function(jsonResponse) {
                    let response = JSON.parse(jsonResponse)
                    $("#cheque_table_body").html(response.message)
                },
                error: function(err) {
                    console.log(err)
                }
            })
        });

        $.ajax({
            type: 'post',
            url: '<?= ROOT_DIR ?>modules/case/ajax/load_ajax_cheque.php',
            data: {
                hid_parentID,
                hid_module,
                hid_page,
                csrf_token,
                active_legal
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
</script>



