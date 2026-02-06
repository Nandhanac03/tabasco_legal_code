<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Bad Debts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Bad Debts Information</li>
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
                                <a class="nav-link active" href="<?= ROOT_DIR ?>baddebts/information.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="information-sharp"
                                                class="me-1"></ion-icon>
                                        </div>
                                        <div class="tab-title">Information</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="<?= ROOT_DIR ?>baddebts/document.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="document-attach-sharp"
                                                class="me-1"></ion-icon>
                                        </div>
                                        <div class="tab-title">Documents</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link " href="<?= ROOT_DIR ?>baddebts/commission.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="cash"></ion-icon>
                                        </div>
                                        <div class="tab-title">Commission</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link " href="<?= ROOT_DIR ?>baddebts/contact.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class="fadeIn animated bx bx-user-plus"></i>
                                        </div>
                                        <div class="tab-title">Contact</div>
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
                                            <div class="container">
                                                <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="mb-0"><i class="lni lni-user"></i> Client
                                                                    Profile</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <form>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Code:</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Marketing:</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Client:</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Category:</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label
                                                                            class="form-label">Firm/Party/Debt</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Notes:</label>
                                                                        <textarea class="form-control"></textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Status</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <button type="button"
                                                                            class="btn btn-primary px-5">Save</button>
                                                                        <button type="reset"
                                                                            class="btn btn-secondary px-5">Reset</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="mb-0"><i
                                                                        class="lni lni-text-align-justify"></i>
                                                                    Outstanding</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <form>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Total
                                                                            Outstanding:</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Outstanding with
                                                                            cheque:</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Outstanding without
                                                                            cheque:</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="mb-0"><i
                                                                        class="lni lni-text-align-justify"></i>
                                                                    Claim Amount</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <form>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Claim Amount:</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Balance Claim:</label>
                                                                        <input type="text" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Expense
                                                                            Amount:</label>
                                                                        <input type="text" class="form-control">
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