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
                        <li class="breadcrumb-item active" aria-current="page">Reports</li>
                    </ol>
                </nav>
            </div>


            <div class="ms-auto ">
                <div class="btn-group d-none">
                    <button type="button" class="btn btn-primary"
                        onclick="window.location.href='<?= ROOT_DIR ?>closedlegal/information.html';"><i
                            class="fadeIn animated bx bx-plus"></i>Reports</button>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div
                            class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-3 row-cols-xxl-3 row-cols-xl-4 row-cols-xxl-4 g-3 ">
                            <div class="col " onclick="window.location.href='<?= ROOT_DIR ?>reports/bad_debts.html';">
                                <a href="javascript:;" class="text-dark">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-tiffany">
                                                <ion-icon name="alert-circle-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2 ">Bad Debts Report</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:;" class="text-dark">
                                    <div class="card radius-10 border shadow-none mb-0 cursor-pointer"
                                        onclick="window.location.href='<?= ROOT_DIR ?>reports/closed_legal_report.html';">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-danger">
                                                <ion-icon name="lock-closed-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Closed Legal Report</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:;" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0"
                                        onclick="window.location.href='<?= ROOT_DIR ?>reports/total_legal_report.html';">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-warning">
                                                <ion-icon name="document-text-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Total Legal Statement</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:;" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0"
                                        onclick="window.location.href='<?= ROOT_DIR ?>reports/client_base_action_report_list.html';">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-success">
                                                <ion-icon name="people-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Client Base Action Report</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:;" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0"
                                        onclick="window.location.href='<?= ROOT_DIR ?>reports/statementbase_report_list.html';">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-primary">
                                                <ion-icon name="clipboard-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Statement Base Report</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?= ROOT_DIR ?>reports/expense_report_list.html" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-info">
                                                <ion-icon name="cash-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Expense Report</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?= ROOT_DIR ?>reports/action_report_list.html" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-purple">
                                                <ion-icon name="flash-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">Action Report</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>




                            <div class="col">
                                <a href="<?= ROOT_DIR ?>reports/case_report_list.html" class="text-dark cursor-pointer">
                                    <div class="card radius-10 border shadow-none mb-0">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="fs-3 text-purple">
                                                <ion-icon name="shield-checkmark-outline"></ion-icon>
                                                </div>
                                                <h6 class="mb-0 mt-2">UAE Pass Report</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
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


                        <h5 class="modal-title"><i class="lni lni-user"></i> New Client</h5>


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


    </div>


</div>