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
                        <li class="breadcrumb-item active" aria-current="page">Commissions Vouchers</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row mb-3">
    <div class="card">
        <div class="card-body">
            
            <div class="row justify-content-end">
                <div class="col-auto">
                <a href="<?= ROOT_DIR?>commissionreport/commission.html" class="btn btn-secondary"><ion-icon name="return-down-back-outline" role="img" class="md hydrated" aria-label="return down back outline"></ion-icon>Back</a>


                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#commissionVoucherModal" style="height:37px;">
                Upload Signed Document
                </button>
                </div>
            </div>

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
                                  
                                    <th>Voucher No</th>
                                    <th>Voucher Date</th>
                                    <th>Total Amount</th>
                                 <th>Status</th>
                                 <th>Print</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($voucher_list) { ?>
                                    <?php foreach ($voucher_list as $val) { ?>
                                        <tr>
                                            <td><?= ++$key ?></td>
                                           
                                            <td><?= $val['voucher_no'] ?></td>
                                            <td><?= $val['voucher_date'] ?></td>
                                            <td><?= $val['total_amount'] ?></td>
                                            <td>
<?php 
$status = $val['status'];

if ($status == 'Paid') {
    echo '<span class="badge bg-success">Paid</span>';
} elseif ($status == 'Printed') {
    echo '<span class="badge bg-warning text-dark">Printed</span>';
} else {
    echo '<span class="badge bg-secondary">'.$status.'</span>';
}
?>
</td>
            <!-- ✅ PRINT BUTTON -->
            <td>
<?php if ($val['status'] == 'Printed' && !empty($val['commission_pdf'])) { ?>
    
    <a href="<?= ROOT_DIR . 'uploads/expenses/' . $val['commission_pdf']; ?>" 
       target="_blank" 
       class="btn btn-sm btn-primary">
       <i class="lni lni-download"></i>
    </a>

<?php } elseif ($val['status'] == 'Paid' && !empty($val['signed_doc'])) { ?>

    <a href="<?= ROOT_DIR . 'uploads/expenses/' . $val['signed_doc']; ?>" 
       target="_blank" 
       class="btn btn-sm btn-success">
       <i class="lni lni-download"></i>
    </a>

<?php } else { ?>

    <span class="text-muted">No File</span>

<?php } ?>
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

    <?php foreach ($voucher_data as $val) { ?>
        <!-- ✅ FIXED (NO SPACE) -->
        <option value="<?= trim($val['voucher_no']); ?>">
            <?= $val['voucher_no']; ?>
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

<style>
#alertModal .modal-content {
    animation: popIn 0.3s ease;
}
@keyframes popIn {
    0%   { transform: scale(0.8); opacity: 0; }
    100% { transform: scale(1);   opacity: 1; }
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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


$(document).ready(function() {
    reloadVoucherDropdown();
});

$(document).on('click', '#commissionVoucherModal .btn-close', function() {
    location.reload();
});


$(document).on('show.bs.modal', '#commissionVoucherModal', function() {
    reloadVoucherDropdown();
});


$(document).on('click', '#cancelVoucherBtn', function(){
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
    if (isNaN(amountPaid) || amountPaid <= 0){                      
        showAlert('warning', 'Required!', 'Please enter a valid amount paid'); return;
    }
    if (!signedDoc || signedDoc.length === 0){                      
        showAlert('warning', 'Required!', 'Please upload signed document'); return;
    }
    if (!sigCheck){
        showAlert('warning', 'Required!', 'Please confirm recipient signature'); return;
    }

    // formData was already declared above, no need to declare it again here

    $.ajax({
        url: '<?= ROOT_DIR ?>modules/commissionreport/ajax/save_commission_voucher.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',

        cache: false,
        beforeSend: function(){
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
        complete: function(){
            $('[type="submit"]', form).prop('disabled', false).text('Submit Payment');
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

