<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Collection & Expense Update</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Collection & Expense  </li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->




        <div class="row">

            <div class="col-12">

                <div class="card">
                    <div class="card-body">


                    <form id="search_form">
                    <div class="row mb-3">

<div class="col-md-4">
    <select class="form-select" id="sort_by_case">
        <option value="">Case No.</option>
        <?php foreach ($array_legal_case as $legalCase): ?>
            <option value="<?= htmlspecialchars($legalCase['id']) ?>"
                    data-client-id="<?= htmlspecialchars($legalCase['client']) ?>">
                <?= htmlspecialchars($legalCase['case_number']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="col-md-4">
    <select class="form-select" id="sort_by_client_name">
        <option value="">Client Name</option>
        <?php foreach ($array_legal_clients as $legalClient): ?>
            <option value="<?= htmlspecialchars($legalClient['id']) ?>">
                <?= htmlspecialchars($legalClient['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="col-md-2">
    <button type="submit"  class="btn btn-primary w-100">Search</button>
</div>



</div>

        </form>



                        <div class="col text-end py-2">


                            <button type="button" class="btn btn-sm btn-outline-primary px-1">
                                <i class="lni lni-download"></i>
                            </button>
                        </div>
                        <div class="table-responsive mt-3">

                            <div id="load_ajax_caseactions"></div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- end page content-->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
$(document).ready(function () {

    let currentFilters = {};

    // Auto select client when case changes
    $('#sort_by_case').change(function () {
        const clientId = $(this).find(':selected').data('client-id');
        if (clientId) {
            $('#sort_by_client_name').val(clientId);
        } else {
            $('#sort_by_client_name').val('');
        }
    });

    // FORM SUBMIT
    $('#search_form').on('submit', function (e) {
        e.preventDefault();

        currentFilters = {
            select_case_id: $('#sort_by_case').val(),
            select_client_id: $('#sort_by_client_name').val()
        };

        loadData(1);
    });

    // LOAD DATA FUNCTION
    function loadData(page) {
        $.ajax({
            url: "<?= ROOT_DIR ?>modules/expensereport/ajax/load_all_clients.php",
            type: "POST",
            data: {
                page_no: page,
                select_case_id: currentFilters.select_case_id || '',
                select_client_id: currentFilters.select_client_id || ''
            },
            success: function (response) {
                $("#load_ajax_caseactions").html(response);
            }
        });
    }

    // Initial load
    loadData(1);

    // Pagination
    $(document).on("click", ".pagination li a", function (e) {
        e.preventDefault();
        var pageId = $(this).attr("id");
        loadData(pageId);
    });

});
</script>
