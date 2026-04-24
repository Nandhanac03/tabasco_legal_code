<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Action Update</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Case Action </li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="col-12">
                <form id="search_form">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 col-lg">
                                    <select class="form-select select2-bootstrap" id="sort_by_case" name="sort_by_case">
                                        <option value="">Case No.</option>
                                        <?php if (!empty($array_legal_case)): ?>
                                            <?php foreach ($array_legal_case as $legalCase): ?>
                                                <option value="<?= htmlspecialchars($legalCase['id']) ?>" data-client-id="<?= htmlspecialchars($legalCase['client']) ?>">
                                                    <?= htmlspecialchars($legalCase['case_number']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-12 col-lg">
                                    <select class="form-select select2-bootstrap" id="sort_by_client_name" name="sort_by_client_name">
                                        <option value="">Client Name</option>
                                        <?php if (!empty($array_legal_clients)): ?>
                                            <?php foreach ($array_legal_clients as $legalClient): ?>
                                                <option value="<?= htmlspecialchars($legalClient['id']) ?>">
                                                    <?= htmlspecialchars($legalClient['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-12 col-lg">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                </form>
                <div class="card">
                    <div class="card-body">
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

<script type="text/javascript">
    $(document).ready(function() {

        $('#sort_by_case').change(function() {
            const clientId = $(this).find(':selected').data('client-id');
            if (clientId) {
                $('#sort_by_client_name').val(clientId).trigger('change');
            } else {
                $('#sort_by_client_name').val('').trigger('change');
            }
        });

        document.getElementById('search_form').addEventListener('submit', function(e) {
            e.preventDefault();
            const select_case_id = document.getElementById('sort_by_case').value;
            const select_client_id = document.getElementById('sort_by_client_name').value;
            const filters = {
                select_case_id: select_case_id,
                select_client_id: select_client_id,
            };
            loadData(1, filters);
        });

        function loadData(page, filters = {}) {
            $.ajax({
                url: "<?= ROOT_DIR ?>modules/actionreport/ajax/load_case_action.php",
                type: "POST",
                cache: false,
                data: Object.assign({
                    page_no: page
                }, filters),
                success: function(response) {
                    $("#load_ajax_caseactions").html(response);
                }
            });
        }
        loadData(1);
        // Pagination code
        $(document).on("click", ".pagination li a", function(e) {
            e.preventDefault();
            var pageId = $(this).attr("id");
            // get current filters
            const select_case_id = document.getElementById('sort_by_case').value;
            const select_client_id = document.getElementById('sort_by_client_name').value;
            const filters = {
                select_case_id: select_case_id,
                select_client_id: select_client_id,
            };
            loadData(pageId, filters);
        });
    });
</script>