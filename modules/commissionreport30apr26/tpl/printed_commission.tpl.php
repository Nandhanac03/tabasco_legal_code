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

        <div class="row mb-3">
    <div class="card">
        <div class="card-body">
            
            <div class="row justify-content-end">
                <div class="col-auto">
                    <button class="btn btn-success btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#commissionVoucherModal">
                        Commission Voucher
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
                                             <td><?= $val['status'] ?></td>
                                           
                                           

                                          

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
        <h5 class="modal-title">Commission Voucher Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="commissionVoucherForm" method="POST"  enctype="multipart/form-data">
        <div class="modal-body">

          <div class="row g-3">

            <!-- Voucher ID -->
            <div class="col-md-6">
              <label class="form-label">Commission Voucher ID</label>
              <select name="voucher_no" id="voucher_no" class="form-select" required>
           
                <option value="">Select Voucher</option>
                <!-- Load from DB -->

                <?php foreach ($vouchers as $val) { ?>
                   
                

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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelVoucherBtn" >Cancel</button>
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
    document.getElementById('alertIcon').className            = c.icon;
    document.getElementById('alertTitle').style.color         = c.color;
    document.getElementById('alertTitle').innerText           = title;
    document.getElementById('alertMessage').innerText         = message;

    const btn = document.getElementById('alertOkBtn');
    btn.style.background = c.color;
    btn.style.color      = '#fff';
    btn.style.border     = 'none';
    btn.onclick = function () {
        if (typeof callback === 'function') callback();
    };

    new bootstrap.Modal(document.getElementById('alertModal')).show();
}


$('#cancelVoucherBtn').on('click', function(){
    location.reload();
});

// ✅ STEP 2 - Form submit script
$(document).ready(function () {

$('#commissionVoucherForm').on('submit', function (e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);

    let voucherNo   = $('#voucher_no').val();
    let amountPaid  = $('[name="amount_paid"]').val();
    let paymentDate = $('[name="payment_date"]').val();
    let payMethod   = $('[name="payment_method"]').val();
    let signedDoc   = $('[name="signed_doc"]').val();
    let sigCheck    = $('[name="signature_confirmed"]').is(':checked');

    if (!voucherNo)                    { showAlert('warning','Required!','Please select a voucher'); return; }
    if (!paymentDate)                  { showAlert('warning','Required!','Please enter payment date'); return; }
    if (!payMethod)                    { showAlert('warning','Required!','Please select payment method'); return; }
    if (!amountPaid || amountPaid<=0)  { showAlert('warning','Required!','Please enter amount paid'); return; }
    if (!signedDoc)                    { showAlert('warning','Required!','Please upload signed document'); return; }
    if (!sigCheck)                     { showAlert('warning','Required!','Please confirm recipient signature'); return; }

    $.ajax({
        url: '<?= ROOT_DIR ?>modules/commissionreport/ajax/save_commission_voucher.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {

            let res;
            try {
                res = (typeof response === 'object') ? response : JSON.parse(response);
            } catch (e) {
                console.error(response);
                showAlert('error','Server Error','Invalid server response');
                return;
            }

            if (res.success) {

                let modal = bootstrap.Modal.getInstance(
                    document.getElementById('commissionVoucherModal')
                );
                if (modal) modal.hide();

                form.reset();

                showAlert('success','Payment Saved!', res.message, function () {
                    location.reload();
                });

            } else {
                showAlert('error','Failed!', res.message);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            showAlert('error','Request Failed','Something went wrong.');
        }
    });

});

});

</script>