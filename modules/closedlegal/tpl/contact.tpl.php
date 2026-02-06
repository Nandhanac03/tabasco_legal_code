<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Closed Legal</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Closed Legal Contact</li>
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
                                <a class="nav-link " href="<?= ROOT_DIR ?>closedlegal/information.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="information-sharp"
                                                class="me-1"></ion-icon>
                                        </div>
                                        <div class="tab-title">Information</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="<?= ROOT_DIR ?>closedlegal/document.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="document-attach-sharp"
                                                class="me-1"></ion-icon>
                                        </div>
                                        <div class="tab-title">Documents</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link " href="<?= ROOT_DIR ?>closedlegal/commission.html">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><ion-icon name="cash"></ion-icon>
                                        </div>
                                        <div class="tab-title">Commission</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" href="<?= ROOT_DIR ?>closedlegal/contact.html">
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
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center">
                                                                    <h5 class="mb-0"><i class="lni lni-list"></i>
                                                                        Contact Details</h5>
                                                                    <form class="ms-auto position-relative">
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-sm text-uppercase rounded font-13 fw-500"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#exampleExtraLargeModal"><i
                                                                                class="fadeIn animated bx bx-user-plus"></i>
                                                                            Add New</button>
                                                                    </form>
                                                                </div>
                                                                <div class="table-responsive mt-3">
                                                                    <table class="table align-middle mb-0">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <td>Sl No</td>
                                                                                <td>Name</td>
                                                                                <td>Contact Number</td>
                                                                                <td>Email</td>
                                                                                <td>Profession</td>
                                                                                <td>Visiting Card</td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-center">1</td>
                                                                                <td>Christine M. Lerma </td>
                                                                                <td>04-33565656</td>
                                                                                <td>ChristineMLerma@teleworm.us</td>
                                                                                <td>Manager</td>
                                                                                <td class="text-center">
                                                                                    <h4><i class="lni lni-postcard"></i>
                                                                                    </h4>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">2</td>
                                                                                <td>Beth J. Byerly</td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td>Manager</td>
                                                                                <td class="text-center">
                                                                                    <h4><i class="lni lni-postcard"></i>
                                                                                    </h4>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">3</td>
                                                                                <td>Ana J. Oshiro </td>
                                                                                <td>042536666</td>
                                                                                <td></td>
                                                                                <td>Manager</td>
                                                                                <td class="text-center">
                                                                                    <h4><i class="lni lni-postcard"></i>
                                                                                    </h4>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
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