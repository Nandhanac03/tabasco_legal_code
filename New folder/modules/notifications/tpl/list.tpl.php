<!-- start page content wrapper-->

<div class="page-content-wrapper">

    <!-- start page content-->

    <div class="page-content">



        <!-- Start Breadcrumb -->

        <div class="page-breadcrumb d-flex align-items-center mb-3">

            <div class="breadcrumb-title pe-3 d-none d-sm-block">Dashboard</div>

            <div class="ps-3 d-none d-sm-block">

                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb mb-0 p-0 align-items-center">

                        <li class="breadcrumb-item">

                            <a href="javascript:;" id="home-icon">

                                <ion-icon name="home-outline" title="Back to Dashboard"></ion-icon>

                            </a>

                        </li>

                        <li class="breadcrumb-item active" aria-current="page">Notifications</li>

                    </ol>

                </nav>

            </div>


            <!-- Right-Side Buttons (Back + New Client) -->

        </div>



        <!-- End Breadcrumb -->



        <div class="row">


            <div class="col-12">


                <div class="card">

                    <div class="card-body">

                        <div class="col text-end py-2">



                        </div>

                        <div class="table-responsive mt-3">


                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#ID</th>
                                        <th>Hearing Date</th>
                                        <th>Case No.</th>
                                        <th>Client</th>
                                        <th>Firm</th>
                                        <th>Feedback</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($case_notification) { ?>
                                        <?php foreach ($case_notification as $key => $notification) {

                                        ?>
                                            <tr>
                                                <td><?= ++$key ?></td>
                                                <td><?= $notification['hearing_date'] ?></td>
                                                <td>#<?= $notification['case_number'] ?></td>
                                                <td><?= $notification['user_name'] ?></td>
                                                <td><?= $notification['client_name'] ?></td>
                                                <td><?= $notification['case_status'] ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3 fs-6">
                                                        <a href="<?= ROOT_DIR ?>case/hearing/edit/<?= $notification['case_id'] ?>.html" class="text-primary"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                                            data-bs-original-title="View detail" aria-label="Views">
                                                            <ion-icon name="eye-outline"></ion-icon>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td style="color: red;">No records found </td>
                                            <td colspan="4"></td>

                                        </tr>
                                    <?php } ?>



                                </tbody>
                            </table>


                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- end page content-->




    </div>

</div>