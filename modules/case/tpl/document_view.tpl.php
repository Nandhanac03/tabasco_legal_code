<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">

        <div class="d-flex justify-content-between mb-1">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Case</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0 align-items-center">
                            <li class="breadcrumb-item"><a href="javascript:;"><ion-icon
                                        name="home-outline"></ion-icon></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Case Documents</li>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                                false
                            ); // Active tab 
                            ?>


                            <?php
                            echo createNavItem(
                                "case",
                                "Documents",
                                "document-attach-sharp",
                                "document_view",
                                $id,
                                true
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
                        <div class="tab-content py-3">
                            <?php include('common/view_document.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
    <!-- end page content-->
</div>