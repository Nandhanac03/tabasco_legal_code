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
                    <li class="breadcrumb-item active" aria-current="page">Third Party Contact</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Back Button on the Right -->
<?php include("common/backButton_list.php");?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <div class="row">
            <div class="col col-lg-12 mx-auto">

                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                        <?php
              echo createNavItem('thirdparty', "Information", "information-sharp", "information", $edit_id); // Inactive tab
              echo createNavItem('thirdparty', "Documents", "document-attach-sharp", "document", $edit_id);        // Inactive tab

              echo createNavItem('thirdparty', "Contact", "person-add-outline", "contact", $edit_id,true);        // Active tab

              echo createNavItem('thirdparty', "Commission", "cash", "commission", $edit_id);        // Inactive tab
              ?>

                        </ul>
                        <div class="tab-content py-3">
                        <?php include('common/manage_Contact.php'); ?>
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