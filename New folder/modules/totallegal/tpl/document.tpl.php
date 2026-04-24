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
                        <li class="breadcrumb-item active" aria-current="page">Total Legal Documents</li>
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
                                <a class="nav-link " href="<?= ROOT_DIR ?>totallegal/information.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="information-sharp"></ion-icon>
                                        </div>
                                        <div class="tab-title">Information</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" href="<?= ROOT_DIR ?>totallegal/document.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="document-attach-sharp"
                                                class="me-1"></ion-icon>
                                        </div>
                                        <div class="tab-title">Documents</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link " href="<?= ROOT_DIR ?>totallegal/commission.html">
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
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="lni lni-radio-button"></i> Upload Document</h6>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="mb-3">
                                            <label class="form-label">Document Types:</label>
                                            <select class="form-select">
                                                <option selected>Select</option>
                                                <option>Trading License</option>
                                                <option>Agreement</option>
                                                <option>LPO</option>
                                                <option>Invoice</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Upload File:</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-primary px-4 mb-2"><i
                                                    class="lni lni-upload"></i> Upload</button>
                                            <button type="reset" class="btn btn-secondary px-5 mb-2">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="lni lni-menu"></i> Document List</h6>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="mb-3">
                                            <div class="table-responsive mt-3">
                                                <table class="table align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <td>Sl No</td>
                                                            <td>Document Type</td>
                                                            <td class="text-center">Attachment</td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Trading License</td>
                                                            <td class="text-center"><i
                                                                    class="lni lni-eye text-info"></i></td>
                                                            <td class="text-center"><i
                                                                    class="lni lni-trash text-danger"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Agreement</td>
                                                            <td class="text-center"><i
                                                                    class="lni lni-eye text-info"></i></td>
                                                            <td class="text-center"><i
                                                                    class="lni lni-trash text-danger"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>Bank Passbook</td>
                                                            <td class="text-center"><i
                                                                    class="lni lni-eye text-info"></i></td>
                                                            <td class="text-center"><i
                                                                    class="lni lni-trash text-danger"></i></td>
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
        <!--end row-->
    </div>
    <!-- end page content-->
</div>