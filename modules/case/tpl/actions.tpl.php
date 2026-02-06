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
                            <li class="breadcrumb-item active" aria-current="page">Case Action</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <a class="btn btn-warning "
                href="<?= ROOT_DIR . "activelegal/view/view/$active_legal_id.html" ?>">
                <i class="lni lni-arrow-left"></i> Active Legal
            </a>


        </div>

        <!--end breadcrumb-->



        <div class="row">

            <div class="col col-lg-12 mx-auto">

                <div class="card">

                    <div class="card-body">

                        <ul class="nav nav-tabs nav-primary" role="tablist">

                            <ul class="nav nav-tabs nav-primary" role="tablist">
                            <?php
                                echo createNavItem(
                                    "case",
                                    "Case Root",
                                    "git-pull-request",
                                    "view",
                                    $edit_id,
                                    false
                                ); // Active tab 
                                ?>
                                <?php
                                echo createNavItem(
                                    "case",
                                    "Information",
                                    "information-sharp",
                                    "list",
                                    $edit_id,
                                    false
                                ); // Active tab 
                                ?>
                                
                                <?php
                                echo createNavItem(
                                    "case",
                                    "Documents",
                                    "document-attach-sharp",
                                    "document_view",
                                    $edit_id,
                                    false
                                ); // Active tab 
                                ?>
                                <?php
                                echo createNavItem(
                                    "case",
                                    "Hearing Date & Feedback",
                                    "calendar",
                                    "case_hearing",
                                    $edit_id,
                                    false
                                ); // Active tab 
                                ?>
                                <?php
                                echo createNavItem(
                                    "case",
                                    "Expense",
                                    "cash",
                                    "expense",
                                    $edit_id,
                                    false
                                ); // Active tab 
                                ?>
                                <?php
                                echo createNavItem(
                                    "case",
                                    "Actions",
                                    "git-pull-request",
                                    "actions",
                                    $edit_id,
                                    true
                                ); // Active tab 
                                ?>
                               
                            </ul>

                            <!-- <li class="nav-item" role="presentation">

                                <a class="nav-link active" href="<?= ROOT_DIR ?>case/information.html">

                                    <div class="d-flex align-items-center">

                                        <div class="tab-icon"><ion-icon name="information-sharp"

                                                class="me-1"></ion-icon>

                                        </div>

                                        <div class="tab-title">Information</div>

                                    </div>

                                </a>

                            </li>

                            <li class="nav-item" role="presentation">

                                <a class="nav-link" href="<?= ROOT_DIR ?>case/document.html">

                                    <div class="d-flex align-items-center">

                                        <div class="tab-icon"><ion-icon name="document-attach-sharp"

                                                class="me-1"></ion-icon>

                                        </div>

                                        <div class="tab-title">Documents</div>

                                    </div>

                                </a>

                            </li>

                            <li class="nav-item" role="presentation">

                                <a class="nav-link " href="<?= ROOT_DIR ?>case/hearing.html">

                                    <div class="d-flex align-items-center">

                                        <div class="tab-icon"><i class="fadeIn animated bx bx-calendar-star"></i>

                                        </div>

                                        <div class="tab-title">Hearing Date & Feedback</div>

                                    </div>

                                </a>

                            </li>

                            <li class="nav-item" role="presentation">

                                <a class="nav-link" href="<?= ROOT_DIR ?>case/expense.html">

                                    <div class="d-flex align-items-center">

                                        <div class="tab-icon"><i class="fadeIn animated bx bx-money"></i>

                                        </div>

                                        <div class="tab-title">Expense</div>

                                    </div>

                                </a>

                            </li>

                            <li class="nav-item" role="presentation">

                                <a class="nav-link" href="<?= ROOT_DIR ?>case/actions.html">

                                    <div class="d-flex align-items-center">

                                        <div class="tab-icon"><i class="fadeIn animated bx bx-dialpad"></i>

                                        </div>

                                        <div class="tab-title">Actions</div>

                                    </div>

                                </a>

                            </li> -->

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

                                                        <div class="card">

                                                            <div class="card-header">

                                                                <h6 class="mb-0"><i class="lni lni-radio-button"></i> Case Action</h6>

                                                            </div>

                                                            <div class="card-body">

                                                                <form>

                                                                    <div class="mb-3">

                                                                        <div class="table-responsive mt-3">

                                                                            <table class="table align-middle mb-0">

                                                                                <thead class="table-light">

                                                                                    <tr>

                                                                                        <td>Date</td>

                                                                                        <td>Action</td>

                                                                                        <td>Email Link</td>

                                                                                        <td>Updated by</td>


                                                                                    </tr>

                                                                                </thead>

                                                                                <tbody>
                                                                                    <?php if ($case_roots) { ?>
                                                                                        <?php foreach ($case_roots as $case_roots) { ?>
                                                                                            <tr>

                                                                                                <td><?= $case_roots['date'] ?></td>

                                                                                                <td style="max-width:380px; min-width:340px; white-space:normal; word-wrap:break-word; overflow-wrap:break-word; text-align: justify;"><?= $case_roots['description'] ?></td>


                                                                                                <?php if (!empty($case_roots['email'])) {
                                                                                                    // Has email → make send link
                                                                                                    echo "<td>
                                                                                                        <a href='" . htmlspecialchars($case_roots['email']) . "' class='btn btn-outline-dark ps-3 rounded' target='_blank'>
                                                                                                            <ion-icon name='mail-outline'></ion-icon>
                                                                                                        </a>
                                                                                                    </td>
                                                                                                    ";
                                                                                                } else {
                                                                                                    // No email → placeholder
                                                                                                    echo "<td>
                                                                                                    <button class='btn btn-outline-secondary ps-3 rounded' disabled>
                                                                                                        <ion-icon name='mail-outline'></ion-icon>
                                                                                                    </button>
                                                                                                </td>
                                                                                                ";
                                                                                                } ?>

                                                                                                <td><?= $case_roots['case_root_action_user'] ?></td>


                                                                                            </tr>

                                                                                        <?php } ?>
                                                                                    <?php } else { ?>
                                                                                        <tr>
                                                                                            <td colspan="2"></td>
                                                                                            <td style="color: red;">No data available</td>
                                                                                            <td colspan="3"></td>
                                                                                        </tr>
                                                                                    <?php } ?>

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







</div>