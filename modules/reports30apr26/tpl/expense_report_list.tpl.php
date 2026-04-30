<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Expense report Update</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Expense report  </li>
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
                            <div class="row g-2 mb-3 align-items-end">

                                <!-- Case No. dropdown -->
                                <div class="col-12 col-lg">
                                    <label class="form-label mb-1">Case No.</label>
                                    <select class="form-select" id="sort_by_case" name="sort_by_case">
                                        <option value="">-- All Cases --</option>
                                        <?php if (!empty($array_legal_case)): ?>
                                            <?php foreach ($array_legal_case as $legalCase): ?>
                                                <option value="<?= htmlspecialchars($legalCase['id']) ?>"
                                                    data-client-id="<?= htmlspecialchars($legalCase['client']) ?>">
                                                    <?= htmlspecialchars($legalCase['case_number']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <!-- Client Name dropdown -->
                                <div class="col-12 col-lg">
                                    <label class="form-label mb-1">Client Name</label>
                                    <select class="form-select" id="sort_by_client_name" name="sort_by_client_name">
                                        <option value="">-- All Clients --</option>
                                        <?php if (!empty($array_legal_clients)): ?>
                                            <?php foreach ($array_legal_clients as $legalClient): ?>
                                                <option value="<?= htmlspecialchars($legalClient['id']) ?>">
                                                    <?= htmlspecialchars($legalClient['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-12 col-lg-auto d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                      Search
                                    </button>
                                </div>

                            </div>
                        </form>

                        <div class="col text-end py-2">

                            <button type="button" class="btn btn-sm btn-outline-primary px-1">
                                <i class="lni lni-download"></i>
                            </button>
                        </div>
                        <div class="table-responsive mt-3">

                            <div id="load_ajax_expense_report_list"></div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- end page content-->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var currentFilters = {
            case_id:   '',
            client_id: ''
        };

        function loadData(page, filters) {
            filters = filters || currentFilters;
            $.ajax({
                url: "<?= ROOT_DIR ?>modules/reports/ajax/load_ajax_expense_report_list.php",
                type: "POST",
                cache: false,
                data: {
                    page_no:   page,
                    case_id:   filters.case_id,
                    client_id: filters.client_id
                },
                success: function(response) {
                    $("#load_ajax_expense_report_list").html(response);
                }
            });
        }
        loadData(1, currentFilters);

        $('#sort_by_case').on('change', function() {
            var clientId = $(this).find(':selected').data('client-id');
            $('#sort_by_client_name').val(clientId || '');
        });

        $('#search_form').on('submit', function(e) {
            e.preventDefault();
            currentFilters = {
                case_id:   $('#sort_by_case').val(),
                client_id: $('#sort_by_client_name').val()
            };
            loadData(1, currentFilters);
        });

        // Pagination code
        $(document).on("click", ".pagination li a", function(e) {
            e.preventDefault();
            var pageId = $(this).attr("id");
            loadData(pageId, currentFilters);
        });
    });
</script>