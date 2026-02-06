<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="d-flex justify-content-between">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Action Update</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0 align-items-center">
                            <li class="breadcrumb-item"><a href="javascript:;"><ion-icon
                                        name="home-outline"></ion-icon></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Case Action </li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col py-2 d-flex justify-content-between">
                            <div class="border p-3">
                                <table>
                                    <tr>
                                        <td>Marketing</td>
                                        <td>:</td>
                                        <td><?= $active_legal[0]['User_Client'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Client</td>
                                        <td>:</td>
                                        <td><?= $active_legal[0]['ClientName'] ?></td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="col">
                            <a href="<?= ROOT_DIR ?>actionreport/caseactions.html">Go back<i
                                    class="lni lni-arrow-left ms-2"></i></a>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Case No.</th>
                                        <th>Case Mode</th>
                                        <th>Start Date</th>
                                        <th>Hearing Date</th>
                                        <th>Claim amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($legal_case) { ?>
                                        <?php foreach ($legal_case as $case) { ?>
                                            <tr>
                                                <td><?= $case['case_number'] ?></td>
                                                <td><?= $case['case_mode_title'] ?></td>
                                                <td><?= $case['register_date'] ?></td>
                                                <td><?= $case['hearing_date'] ? $case['hearing_date'] : '.....' ?></td>
                                                <td><?= $active_legal[0]['total_outstanding']  ?></td>
                                                <td>
                                                    <button
                                                        onclick="window.location.href='<?= ROOT_DIR ?>actionreport/view/view/<?= $case['id'] ?>.html'"
                                                        type="button" class="btn btn-outline-success" title="View Case"><i
                                                            class="lni lni-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="6" class="text-danger" style="text-align: center;">
                                                No records available.
                                            </td>
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