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
                            <li class="breadcrumb-item active" aria-current="page">Third Party Commission</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Back Button on the Right -->
            <?php include("common/backButton_list.php"); ?>
        </div>

        <div class="row">
            <div class="col col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                            <?php
                            echo createNavItem('thirdparty', "Information", "information-sharp", "information", $edit_id); // Inactive tab
                            echo createNavItem('thirdparty', "Documents", "document-attach-sharp", "document", $edit_id);        // Inactive tab
                            echo createNavItem('thirdparty', "Contact", "person-add-outline", "contact", $edit_id);        // Inactive tab
                            echo createNavItem('thirdparty', "Commission", "cash", "commission", $edit_id, true);        // Active tab
                            ?>
                        </ul>
                        <div class="tab-content py-3">
                            <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                                <!--start shop cart-->
                                <section class="shop-page">
                                    <div class="shop-container">
                                        <div class="shop-cart">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center">
                                                                    <h5 class="mb-0"><i class="lni lni-list"></i> Commission</h5>
                                                                </div>
                                                                <div class="table-responsive mt-3">
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
                                                                                        <td colspan="" class="text-left"><?= $commission['commission'] ?></td>
                                                                                        <td colspan="" class="text-left"><?= $commission['notes'] ?></td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                            <?php } ?>
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

                    <div class="card">

                        <div class="card-body">
                            <form>

                                <div class="mb-3">
                                    <label class="form-label">Name:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contact Number:</label>
                                    <input type="text" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email:</label>
                                    <input type="text" class="form-control">
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">Profession:</label>
                                    <input type="text" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Visiting Card:</label>
                                    <input type="file" class="form-control">
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save </button>
                </div>
            </div>
        </div>
    </div>
</div>