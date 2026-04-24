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

        function loadData(page) {
            $.ajax({
                url: "<?= ROOT_DIR ?>modules/reports/ajax/load_ajax_expense_report_list.php",
                type: "POST",
                cache: false,
                data: {
                    page_no: page
                },
                success: function(response) {
                    $("#load_ajax_expense_report_list").html(response);
                }
            });
        }
        loadData(1);
        // Pagination code
        $(document).on("click", ".pagination li a", function(e) {
            e.preventDefault();
            var pageId = $(this).attr("id");
            loadData(pageId);
        });
    });
</script>