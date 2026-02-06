<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Total Legal</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Total Legal Commission</li>
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
                                <a class="nav-link" href="<?= ROOT_DIR ?>totallegal/information.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="information-sharp"
                                                class="me-1"></ion-icon>
                                        </div>
                                        <div class="tab-title">Information</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="<?= ROOT_DIR ?>totallegal/document.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="document-attach-sharp"
                                                class="me-1"></ion-icon>
                                        </div>
                                        <div class="tab-title">Documents</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" href="<?= ROOT_DIR ?>totallegal/commission.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="cash"></ion-icon>
                                        </div>
                                        <div class="tab-title">Commission</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="<?= ROOT_DIR ?>totallegal/contact.html">
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
                                                    <div class="col-lg-12">
                                                        <div class="col">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="mb-0"><i class="lni lni-menu"></i>
                                                                        Commision
                                                                        </h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <form>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Party
                                                                                Name:</label>
                                                                            <input type="text" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Category:</label>
                                                                           <select class="form-control">
                                                                                    <option value="">Third Party</option>
                                                                                    <option value="">Debt Collector</option>
                                                                                    <option value="">Legal Firm</option>
                                                                                <option value="">Legal Team</option>
                                                                                </select>
                                                                        </div>


                                                                        <div class="mb-3">
                                                                            <label class="form-label">Notes:</label>
                                                                            <input type="text" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                        <label class="form-label"><b> Slab:</b></label>
                                                                            <div class="table-responsive mt-3">
                                                                                <table class="table align-middle mb-0">

                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>Above</td>
                                                                                            <td> <input type="number" class="form-control border-info	" placeholder="Days"></td>
                                                                                            <td> <input type="number" class="form-control border-warning" placeholder="Percentage"></td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td>Below</td>
                                                                                            <td> <input type="number" class="form-control border-info	" placeholder="Days"></td>
                                                                                            <td> <input type="number" class="form-control border-warning" placeholder="Percentage"></td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td>Cheque on Hold </td>
                                                                                            <td></td>
                                                                                            <td> <input type="number" class="form-control border-warning" placeholder="Percentage"></td>
                                                                                        </tr>


                                                                                        <tr>
                                                                                            <td>Dishonored Cheques  </td>
                                                                                            <td></td>
                                                                                            <td> <input type="number" class="form-control border-warning" placeholder="Percentage"></td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td>Case already with Legal  </td>
                                                                                            <td></td>
                                                                                            <td> <input type="number" class="form-control border-warning" placeholder="Percentage"></td>
                                                                                        </tr>


                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
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