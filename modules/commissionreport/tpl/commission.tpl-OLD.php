<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Commissions</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Commissions</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="card">
                <div class="card-body row">
                    <div class="col-3">
                        <select class="form-select">
                            <option value="">Select Category</option>
                            <option value="">Third Party</option>
                            <option value="">Debt Collector</option>
                            <option value="">Legal Firm</option>
                            <option value="">Legal Team</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" placeholder="Case no. (eg: 112/1985)">
                    </div>
                    <div class="col-3 col-lg">
                        <input type="date" class="form-control" placeholder="From Date" readonly="true" />
                        <span class="small text-muted">From Date</span>
                    </div>
                    <div class="col-3 col-lg">
                        <input type="date" class="form-control" placeholder="To Date" readonly="true" />
                        <span class="small text-muted">To Date</span>
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sl no.</th>
                                    <!-- <th>Category</th>
                                    <th>Firm/Party/Debt</th> -->
                                    <!-- <th>Case no.</th> -->
                                    <th>Client Name</th>
                                    <th>Claim Amount</th>
                                    <th>Received Collection</th>
                                    <!-- <th>Commission (%)</th>
                                    <th>Commission Payable</th> -->
                                    <th>Payment Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($commissions) { ?>
                                    <?php foreach ($commissions as $key => $commission) { ?>
                                        <tr>
                                            <td><?= ++$key ?></td>
                                            <!-- <td>Legal Firm</td>
                                    <td>XYZ Associates</td> -->
                                            <!-- <td>7191/1985</td> -->
                                            <td><?= $commission['client_name'] ?></td>
                                            <td><?= $commission['total_outstanding'] ?></td>
                                            <td><?= $commission['total_collection_amount'] ?></td>
                                            <!-- <td><?= $commission['commission_percentage'] ?></td>
                                            <td><?= number_format($commission['received_amount'], 2)  ?></td> -->
                                            <td>Pending</td>

                                            <td>
                                                <a href="#"
                                                    class="btn btn-sm open-modal"
                                                    data-id="<?= $commission['active_legal_id'] ?>"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleExtraLargeModal">
                                                    <i class="fadeIn animated bx bx-info-circle"></i>
                                                </a>
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
</div>

<div class="modal fade" id="exampleExtraLargeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fadeIn animated bx bx-list-ul"></i> View Case</h5>
            </div>
            <div class="modal-body">
                <p class="text-center">Select a record to view details.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // When modal is about to be shown
        $('#exampleExtraLargeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // The button that triggered the modal
            var activeLegalId = button.data('id'); // Get the data-id value
            var modal = $(this);

            // Optional: show loading message while fetching
            modal.find('.modal-body').html('<p class="text-center">Loading...</p>');

            $.ajax({
                url: '<?= ROOT_DIR ?>modules/commissionreport/ajax/get_commission_details.php',
                type: 'POST',
                data: {
                    active_legal_id: activeLegalId
                },
                dataType: 'html', // ✅ important: tell jQuery this is HTML, not JSON
                success: function(response) {
                    modal.find('.modal-body').html(response);
                },
                error: function(xhr, status, error) {
                    modal.find('.modal-body').html('<p class="text-danger">Error loading data</p>');
                    console.error(error);
                }
            });

        });
        /* ===== CHECK ALL ===== */
        $(document).on('change', '#checkAll', function() {
            $('.row-check').prop('checked', this.checked);
            toggleGenerateBtn();
        });

        /* ===== SINGLE CHECK ===== */
        $(document).on('change', '.row-check', function() {
            toggleGenerateBtn();
        });

        /* ===== TOGGLE BUTTON ===== */
        function toggleGenerateBtn() {
            if ($('.row-check:checked').length > 0) {
                $('#generatePdfBtn').show();
            } else {
                $('#generatePdfBtn').hide();
            }
        }

        $(document).on('click', '#generatePdfBtn', function() {

            let rows = [];

            $('.row-check:checked').each(function() {
                rows.push({
                    party: $(this).data('party'),
                    received: $(this).data('received'),
                    commission: $(this).data('commission'),
                    payable: $(this).data('payable')
                });
            });

            if (rows.length === 0) {
                alert('Please select at least one record');
                return;
            }

            $.ajax({
                url: '<?= ROOT_DIR ?>modules/commissionreport/ajax/generate_commission_pdf.php',
                type: 'POST',
                data: {
                    rows: rows
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(blob) {
                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'Commission_Report.pdf';
                    link.click();
                },
                error: function() {
                    alert('PDF generation failed');
                }
            });
        });
    });
</script>