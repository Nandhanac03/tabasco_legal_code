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

                            <li class="breadcrumb-item active" aria-current="page">Active Legal Commission</li>

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

                            echo createNavItem('activelegal', "Information", "information-sharp", "information", $edit_id); // Active tab

                            echo createNavItem('activelegal', "Documents", "document-attach-sharp", "document", $edit_id);        // Inactive tab

                            echo createNavItem('activelegal', "Contact", "person-add-outline", "contact", $edit_id);        // Inactive tab

                            echo createNavItem('activelegal', "Commission", "cash", "commission", $edit_id, true);  
                              
                            echo createNavItem('activelegal', "RelatedCases", "person-add-outline", "relatedcases", $edit_id);    // Inactive tab

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

                                                    <div class="col-lg-12">

                                                        <div class="col">

                                                            <div class="card">

                                                                <div class="card-header">

                                                                    <h6 class="mb-0"><i class="lni lni-menu"></i>

                                                                        Commision

                                                                    </h6>

                                                                </div>

                                                                <div class="card-body">

                                                                    <form method="post" id="commissionForm">

                                                                        <div class="mb-3">

                                                                            <label class="form-label">Category <span class="text-danger">*</span></label>

                                                                            <select class="form-control" id="category_select" name="category_select">

                                                                                <option value="">- - select category - -</option>

                                                                                <option value="TP">Third Party</option>

                                                                                <option value="DC">Debt Collector</option>

                                                                                <option value="LF">Legal Firm</option>

                                                                                <option value="LT">Legal Team</option>

                                                                            </select>

                                                                        </div>

                                                                        <div class="mb-3">

                                                                            <label class="form-label">Party Name <span class="text-danger">*</span></label>

                                                                            <select class="form-control" id="party_select" name="party_select">

                                                                                <option value="">- - select party - -</option>

                                                                            </select>

                                                                        </div>

                                                                        <div class="mb-3">

                                                                            <label class="form-label">Commision % <span class="text-danger">*</span></label>

                                                                            <input type="number" class="form-control" value="10" id="commission_percent" name="commission_percent">

                                                                        </div>

                                                                        <div class="mb-3">

                                                                            <label class="form-label">Notes:</label>

                                                                            <input type="text" class="form-control" id="notes" name="notes">

                                                                        </div>

                                                                        <div class="mb-3">

                                                                            <button type="button"

                                                                                class="btn btn-primary px-5" id="commission_save_button">Save</button>

                                                                            <button type="reset"

                                                                                class="btn btn-secondary px-5">Reset</button>

                                                                        </div>

                                                                    </form>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>


                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="mb-0"><i class="lni lni-menu"></i> View Commisssion</h6>

                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">

                                                            <div class="table-responsive mt-3">
                                                                <table class="table align-middle mb-0" id="contactTable">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>Sl No</th>
                                                                            <th>Category</th>
                                                                            <th>Party Name</th>
                                                                            <th>Commision %</th>
                                                                            <th>Notes</th>
                                                                            <th>Date</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php if ($commision_details) { ?>
                                                                            <?php foreach ($commision_details as $key => $data) {
                                                                                $cat_name = '';
                                                                                if ($data['parent_type'] == 'TP') {
                                                                                    $cat_name = 'Third Party';
                                                                                } else if ($data['parent_type'] == 'DC') {
                                                                                    $cat_name = 'Debt Collector';
                                                                                } else if ($data['parent_type'] == 'LF') {
                                                                                    $cat_name = 'Legal Firm';
                                                                                } else if ($data['parent_type'] == 'LT') {
                                                                                    $cat_name = 'Legal Team';
                                                                                }

                                                                            ?>
                                                                                <tr>
                                                                                    <td><?= ++$key ?></td>
                                                                                    <td><?= $cat_name ?></td>
                                                                                    <td><?= $data['party_name'] ?></td>
                                                                                    <td><?= $data['commission'] ?></td>
                                                                                    <td><?= $data['notes'] ?> </td>
                                                                                    <td><?= $data['created_at'] ?> </td>

                                                                                </tr>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <tr>
                                                                            <td colspan="7" style="text-align:center;">No records found.</td>
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





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    // --------------------------------------------------------------- get party names

    $("#category_select").change(function() {

        let category_type = $("#category_select").val();

        $.ajax({

            type: 'post',
            url: '<?= ROOT_DIR ?>modules/activelegal/ajax/manage_commission.php',
            data: {

                action: 'get_party',

                category_type

            },

            success: function(jsonResponse) {

                let response = JSON.parse(jsonResponse)

                if (response.success) {

                    $("#party_select").html(response.message)

                }

            }

        })

    })



    // --------------------------------------------------------------- submit form

    $("#commission_save_button").click(function() {

        let category_select = $("#category_select")

        let party_select = $("#party_select")

        let commission_percent = $("#commission_percent")

        let notes = $("#notes")

        let validForm = validateForm(category_select, party_select, commission_percent);

        let edit_id = '<?= trim($_GET['param1']) ?>';



        if (validForm) {

            $("#commissionForm").submit();

            // $.ajax({

            //     type: 'post',

            //     url: '<?= ROOT_DIR ?>modules/activelegal/ajax/manage_commission.php',

            //     data: {

            //         action: 'save_commission',

            //         edit_id: edit_id,

            //         category_select: category_select.val(),

            //         party_select: party_select.val(),

            //         commission_percent: commission_percent.val(),

            //         notes: notes.val()

            //     },

            //     success: function(jsonResponse) {



            //     }

            // })

        }

    })





    // --------------------------------------------------------------- validate form

    function validateForm(category, party, commission) {

        let proceed = true;

        if (category.val() == '') {

            proceed = false;

            category.addClass('is-invalid').removeClass('is-valid')

        } else {

            category.addClass('is-valid').removeClass('is-invalid')

        }

        if (party.val() == '') {

            proceed = false;

            party.addClass('is-invalid').removeClass('is-valid')

        } else {

            party.addClass('is-valid').removeClass('is-invalid')

        }

        if (commission.val() == '') {

            proceed = false;

            commission.addClass('is-invalid').removeClass('is-valid')

        } else {

            commission.addClass('is-valid').removeClass('is-invalid')

        }

        return proceed;

    }
</script>