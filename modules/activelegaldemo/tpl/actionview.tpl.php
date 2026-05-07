<!-- start page content wrapper-->

<div class="page-content-wrapper">

    <!-- start page content-->

    <div class="page-content">

        <!--start breadcrumb-->

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <div class="breadcrumb-title pe-3">Actions</div>

            <div class="ps-3">

                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb mb-0 p-0 align-items-center">

                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>

                        </li>

                        <li class="breadcrumb-item active" aria-current="page">View Action</li>

                    </ol>

                </nav>

            </div>

        </div>

        <div class="row">

            <!--end breadcrumb-->

            <div class="col-12">

                <div class="card radius-10">

                    <div class="card-header py-3">



                    </div>

                    <div class="card-header py-2">

                        <div class="row row-cols-1 row-cols-lg-3">

                            <div class="col">

                                <div class="">

                                    <address class="m-t-5 m-b-5">

                                        <p><b>Marketing.</b>: <?= $active_legal[0]['User_Client']; ?></p>

                                        <p><b>Client</b>: <?= $active_legal[0]['ClientName']; ?></p>

                                    </address>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-invoice">

                                <tbody>

                                    <tr>

                                        <th>Firm/Third Party/Debt</th>

                                        <?php

                                        $label_array = [

                                            'third_party' => 'Third Party',

                                            'legal_firm' => 'Legal Firm',

                                            'debt_collector' => 'Debt Collector',

                                            'legal_team' => 'Legal Team'

                                        ];
                                        $category = $shifted_records[0]['legal_type'];
                                        $legal_type = isset($label_array[$category]) ? $label_array[$category] : null;

                                        ?>

                                        <td class="text-right" width="80%"><?= $legal_type ?></td>

                                    </tr>

                                    <tr>

                                        <th>Case Status</th>

                                        <td class="text-right" width="80%">Open</td>

                                    </tr>

                                    <tr>

                                        <th>Start Date</th>

                                        <td class="text-right text-wrap" width="80%"><?= $shifted_records[0]['start_date'] ?></td>

                                    </tr>

                                    <tr>

                                        <th>Shift Date</th>

                                        <td class="text-right text-wrap" width="80%"><?= $shifted_records[0]['shifted_date'] ?></td>

                                    </tr>

                                    

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- end page content-->

</div>