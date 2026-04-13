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
                    <div class="col-2">
                        <select class="form-select">
                            <option value="">Select Category</option>
                            <option value="">Third Party</option>
                            <option value="">Debt Collector</option>
                            <option value="">Legal Firm</option>
                            <option value="">Legal Team</option>
                        </select>
                    </div>
                    <div class="col-2">
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
                    <div class="col-1">
                        <button type="button" class="btn btn-primary">Search</button>
                    </div>

<style>
.btn.btn-primary.btn-sm.commission_vouchers {
  height: 66%;
  background-color: black;
  border-color: black;
}


    </style>

                    <div class="col-2">
                      <button 
  type="button"
  class="btn btn-primary btn-sm commission_vouchers"
  onclick="window.location.href='printedcommission.html'">
Commission Vouchers
</button>   



      <!-- <button class="btn btn-primary btn-sm printed" style="height:37px;"
        data-bs-toggle="modal"
        data-bs-target="#printedCommissionModal">
        Printed Commission
    </button>   -->
</div>





<!-- Printed Commission Modal -->
<div class="modal fade" id="printedCommissionModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Printed Commission</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Sl No</th>
                        <th>Voucher No</th>
                        <th>Voucher Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                <?php if ($voucher_list) { ?>
                    <?php $i=1; foreach ($voucher_list as $val) { ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $val['voucher_no'] ?></td>
                            <td><?= $val['voucher_date'] ?></td>
                            <td><?= $val['total_amount'] ?></td>
                            <td>
<?php if ($val['status'] == 'Paid') { ?>
    <span class="badge bg-success">Paid</span>
<?php } elseif ($val['status'] == 'Printed') { ?>
    <span class="badge bg-warning text-dark">Printed</span>
<?php } else { ?>
    <span class="badge bg-secondary"><?= $val['status'] ?></span>
<?php } ?>
</td>

                        </tr>
                    <?php } ?>
                <?php } else { ?>

                    <tr>
                        <td colspan="5" class="text-center text-danger">
                            No records found
                        </td>
                    </tr>

                <?php } ?>

                </tbody>
            </table>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
            Close
        </button>
      </div>

    </div>
  </div>
</div>



                    <!-- <div class="col-2">
        
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#commissionVoucherModal" style="height:37px;">
                Upload Signed Document
                </button>
      
    </div> -->


                </div>
            </div>
        </div>


        <!-- commission voucher -->


        
  





        <!-- ****************** -->
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
            <button
  type="button"
  class="btn btn-secondary"
  data-bs-dismiss="modal"
  onclick="event.preventDefault()"
>
  Close
</button>
            </div>
        </div>
    </div>
</div>












<!-- Commission Voucher Modal -->
<div class="modal fade" id="commissionVoucherModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title">Upload Signed Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" 
    onclick="location.reload()">  <!-- ✅ reload on click -->
</button>
      </div>

      <form id="commissionVoucherForm" method="POST"  enctype="multipart/form-data">
        <div class="modal-body">

          <div class="row g-3">

            <!-- Voucher ID -->
            <div class="col-md-6">
              <label class="form-label">Commission Voucher ID</label>
              <select name="voucher_no" id="voucher_no" class="form-select" required>
           
                <option value="">Select Voucher</option>
             
                <?php foreach ($voucher_list as $val) { ?>
                   
                

                   <option value=" <?=   $val['voucher_no']; ?>">
                       <?=   $val['voucher_no']; ?>
                   </option>
               <?php } ?>

              </select>
            </div>

            <!-- Signed Document -->
            <div class="col-md-6">
              <label class="form-label">Signed Document</label>
             
              <input type="file" name="signed_doc" class="form-control" accept=".pdf,.jpg,.png" required>
            </div>

            <!-- Payment Date -->
            <div class="col-md-6">
              <label class="form-label">Payment Date</label>
              <input type="date" name="payment_date" class="form-control" required>
            </div>

            <!-- Payment Method -->
            <div class="col-md-6">
              <label class="form-label">Payment Method</label>
              <select name="payment_method" class="form-select" required>
                <option value="">Select Method</option>
                <option value="Cash">Cash</option>
                <option value="Transfer">Transfer</option>
                <option value="Cheque">Cheque</option>
              </select>
            </div>

            <!-- Actual Amount Paid -->
            <div class="col-md-6">
              <label class="form-label">Actual Amount Paid</label>
              <input type="number" step="0.01" name="amount_paid" class="form-control" required>
            </div>

            <!-- Signature Confirmed -->
            <div class="col-md-6 d-flex align-items-end">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="signature_confirmed" value="1" required>
                <label class="form-check-label">
                  Recipient Signature Confirmed
                </label>
              </div>
            </div>

            <!-- Remarks -->
            <div class="col-12">
              <label class="form-label">Remarks</label>
              <textarea name="remarks" class="form-control" rows="3"></textarea>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="cancelVoucherBtn" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Submit Payment</button>
        </div>
      </form>

    </div>
  </div>
</div>









<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
    // Load commission data into modal
    $('#exampleExtraLargeModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var activeLegalId = button.data('id');
        var modal = $(this);

        modal.find('.modal-body').html('<p class="text-center">Loading...</p>');

        $.ajax({
            url: '<?= ROOT_DIR ?>modules/commissionreport/ajax/get_commission_details.php',
            type: 'POST',
            data: { active_legal_id: activeLegalId },
            dataType: 'html',
            success: function(response) {
                modal.find('.modal-body').html(response);
            },
            error: function() {
                modal.find('.modal-body').html('<p class="text-danger">Error loading data</p>');
            }
        });
    });

    // Prevent selecting Paid
// Prevent selecting Paid and handle status
$(document).on('change', '.row-check', function() {
    let status = $(this).data('status');
    if (status === 'Paid') {
        $(this).prop('checked', false);
        alert('This commission is already PAID.');
        return false;
    }
    // 'Printed' items are allowed to be manualy checked for reprinting!
    toggleGenerateBtn();
});

// Check all (skip Paid)
$(document).on('change', '#checkAll', function() {
    let checked = $(this).prop('checked');
    $('.row-check').each(function() {
        let status = $(this).data('status');
        if (status !== 'Paid' && status !== 'Printed') {
            $(this).prop('checked', checked);
        }
    });
    toggleGenerateBtn();
});

    function toggleGenerateBtn() {
        if ($('.row-check:checked').length > 0) {
            $('#generatePdfBtn').show();
        } else {
            $('#generatePdfBtn').hide();
        }
    }

    $(document).on('click', '#generatePdfBtn', function () {

let rows = [];
let hasPending = false;
let hasPrinted = false;

$('.row-check:checked').each(function () {
    let status = $(this).data('status');
    if (status === 'Pending') hasPending = true;
    if (status === 'Printed') hasPrinted = true;

    rows.push({
        id: $(this).data('id'),
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

let ids = rows.map(r => parseInt(r.id));

$.ajax({
    url: '<?= ROOT_DIR ?>modules/commissionreport/ajax/generate_commission_pdf.php',
    type: 'POST',
    data: {
        rows: JSON.stringify(rows),
        ids: ids
    },
    xhrFields: {
        responseType: 'blob'
    },

    success: function (blob) {

        let link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = "Commission_Voucher.pdf";

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        ids.forEach(function (id) {

            let checkbox = $('.row-check[data-id="' + id + '"]');

            // Update status visually
            checkbox.closest('tr').find('.status-badge')
                .removeClass('bg-warning text-dark')
                .addClass('bg-success')
                .text('Printed');

            // ✅ CRITICAL: Uncheck and update status in data to prevent re-selection in "Check All"
            checkbox.prop('checked', false);
            // checkbox.prop('disabled', true); // Let it stay selectable for re-printing if needed
            checkbox.data('status', 'Printed'); // Internal jQuery cache
            checkbox.attr('data-status', 'Printed'); // DOM attribute
        });

        // Uncheck the "Check All" if it was checked
        $('#checkAll').prop('checked', false);

        toggleGenerateBtn();
    },

    error: function (xhr) {

        console.log("Status:", xhr.status);
        console.log("Response:", xhr.responseText);

        alert("PDF generation failed. Check console.");
    }
});

});

});

</script>





<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Alert Modal HTML -->
<div class="modal fade" id="alertModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" style="max-width:380px;">
    <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
      <div id="alertTopBar" style="height:6px;"></div>
      <div class="modal-body text-center px-4 py-4">
        <div id="alertIconWrap" class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
             style="width:70px;height:70px;">
          <i id="alertIcon" style="font-size:32px;"></i>
        </div>
        <h5 id="alertTitle" class="fw-bold mb-1"></h5>
        <p id="alertMessage" class="text-muted mb-4" style="font-size:14px;line-height:1.5;"></p>
        <button type="button" id="alertOkBtn" class="btn rounded-pill px-5 fw-bold" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- CSS -->
<style>
#alertModal .modal-content {
    animation: popIn 0.3s ease;
}
@keyframes popIn {
    0%   { transform: scale(0.8); opacity: 0; }
    100% { transform: scale(1);   opacity: 1; }
}
</style>

<script>
// ✅ STEP 1 - showAlert function
function showAlert(type, title, message, callback) {
    const config = {
        success: { color: '#28a745', bg: '#d4edda', icon: 'fas fa-check' },
        error:   { color: '#dc3545', bg: '#f8d7da', icon: 'fas fa-times' },
        warning: { color: '#ffc107', bg: '#fff3cd', icon: 'fas fa-exclamation' },
        info:    { color: '#17a2b8', bg: '#d1ecf1', icon: 'fas fa-info' }
    };
    const c = config[type] || config.info;

    document.getElementById('alertTopBar').style.background   = c.color;
    document.getElementById('alertIconWrap').style.background = c.bg;
    document.getElementById('alertIcon').style.color          = c.color;
    document.getElementById('alertTitle').style.color         = c.color;
    document.getElementById('alertIcon').className            = c.icon;
    document.getElementById('alertTitle').innerText           = title;
    document.getElementById('alertMessage').innerText         = message;

    const btn = document.getElementById('alertOkBtn');
    btn.className        = 'btn rounded-pill px-5 fw-bold';
    btn.style.background = c.color;
    btn.style.color      = '#fff';
    btn.style.border     = 'none';
    btn.onclick = function() {
        if (typeof callback === 'function') callback();
    };

    new bootstrap.Modal(document.getElementById('alertModal')).show();
}




// ✅ Reload voucher dropdown via AJAX
function reloadVoucherDropdown() {
    $('#voucher_no').html('<option value="">Loading...</option>');
    $.ajax({
        url: '<?= ROOT_DIR ?>modules/commissionreport/ajax/get_voucher_options.php',
        type: 'POST',
        success: function(response) {
            $('#voucher_no').html(response);         // ✅ injects full voucher_no options
        },
        error: function(xhr) {
            console.log("Error loading vouchers:", xhr.responseText);
            $('#voucher_no').html('<option value="">Error loading vouchers</option>');
        }
    });
}

// ✅ Load on page ready
$(document).ready(function() {
    reloadVoucherDropdown();
});

$('#commissionVoucherModal .btn-close').on('click', function() {
    location.reload();
});

// ✅ Reload every time modal opens - always fresh data
$('#commissionVoucherModal').on('show.bs.modal', function() {
    reloadVoucherDropdown();
});


$('#cancelVoucherBtn').on('click', function(){
    location.reload();
});

$(document).on('submit', '#commissionVoucherForm', function(e){
    e.preventDefault();
    let form = this;
    let formData    = new FormData(form);
    let voucherNo   = $('#voucher_no').val();
    let amountPaid  = parseFloat($('[name="amount_paid"]').val());  // ✅ parse float
    let paymentDate = $('[name="payment_date"]').val();
    let payMethod   = $('[name="payment_method"]').val();
    let signedDoc   = $('[name="signed_doc"]')[0].files;            // ✅ check actual files
    let sigCheck    = $('[name="signature_confirmed"]').is(':checked');

    // Validation
    if (!voucherNo){
        showAlert('warning', 'Required!', 'Please select a voucher'); return;
    }
    if (!paymentDate){
        showAlert('warning', 'Required!', 'Please enter payment date'); return;
    }
    if (!payMethod){
        showAlert('warning', 'Required!', 'Please select payment method'); return;
    }
    if (isNaN(amountPaid) || amountPaid <= 0){                      // ✅ isNaN check added
        showAlert('warning', 'Required!', 'Please enter a valid amount paid'); return;
    }
    if (!signedDoc || signedDoc.length === 0){                      // ✅ proper file check
        showAlert('warning', 'Required!', 'Please upload signed document'); return;
    }
    if (!sigCheck){
        showAlert('warning', 'Required!', 'Please confirm recipient signature'); return;
    }

    let ajaxUrl = '<?= ROOT_DIR ?>modules/commissionreport/ajax/save_commission_voucher.php';
console.log("URL:", ajaxUrl);

$.ajax({
    url: ajaxUrl,
    type: 'POST',
    data: formData,
    dataType: 'json',
    processData: false,
    contentType: false,
    cache: false,
        beforeSend: function(){                                      // ✅ disable button while submitting
            $('[type="submit"]', form).prop('disabled', true).text('Saving...');
        },
        success: function(res){
            console.log(res);
            if(res.success){
                let modalEl = document.getElementById('commissionVoucherModal');
                let modal   = bootstrap.Modal.getInstance(modalEl);
                if(modal) modal.hide();
                form.reset();
                showAlert('success', 'Payment Saved!', res.message, function(){
                    location.reload();
                });
            } else {
                showAlert('error', 'Failed!', res.message || 'Something went wrong');
            }
        },
        error: function(xhr){
            console.log("SERVER RESPONSE:", xhr.responseText);
            showAlert('error', 'Server Error!', 'Unexpected server response. Check console.');
        },
        complete: function(){                                        // ✅ re-enable button always
            $('[type="submit"]', form).prop('disabled', false).text('Save');
        }
    });
});
</script>



<script>



$('#openPrintedModal').on('click', function () {

let modal = new bootstrap.Modal(document.getElementById('printedCommissionModal'));
modal.show();

let body = $('#printedCommissionModal .modal-body');
body.html('<p class="text-center">Loading...</p>');

$.ajax({
    url: '<?= ROOT_DIR ?>modules/commissionreport/ajax/get_printed_commission.php',
    type: 'POST',

    success: function (response) {
        body.html(response);
    },

    error: function () {
        body.html('<p class="text-danger text-center">Failed to load</p>');
    }
});

});



</script>



