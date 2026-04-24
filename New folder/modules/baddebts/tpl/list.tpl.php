<!-- start page content wrapper-->

<div class="page-content-wrapper">

  <!-- start page content-->

  <div class="page-content">



    <!-- Start Breadcrumb -->

    <div class="page-breadcrumb d-flex align-items-center mb-3">

      <div class="breadcrumb-title pe-3 d-none d-sm-block">Bad Debts</div>

      <div class="ps-3 d-none d-sm-block">

        <nav aria-label="breadcrumb">

          <ol class="breadcrumb mb-0 p-0 align-items-center">

            <li class="breadcrumb-item">

              <a href="javascript:;" id="home-icon">

                <ion-icon name="home-outline" title="Back to Dashboard"></ion-icon>

              </a>

            </li>

            <li class="breadcrumb-item active" aria-current="page">Bad Debts List</li>

          </ol>

        </nav>

      </div>


    </div>



    <!-- End Breadcrumb -->



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="row">

      <div class="col-12">
        <form id="search_form">

          <div class="card">

            <div class="card-body">

              <div class="row g-3">

                <div class="row g-3">
                  <div class="col-12 col-lg">
                    <select class="form-select select2-bootstrap" id="sort_by_marketing" name="sort_by_marketing">
                      <option value="">Sort By Marketing / Internal Staff</option>
                      <?php if (!empty($array_legal_client_marketing)): ?>
                        <?php foreach ($array_legal_client_marketing as $legalMarketing): ?>
                          <option value="<?= htmlspecialchars($legalMarketing['user_Id']) ?>">
                            <?= htmlspecialchars($legalMarketing['user_name']) ?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>

                  </div>
                  <div class="col-12 col-lg">
                    <select class="form-select select2-bootstrap" id="sort_by_client" name="sort_by_client">
                      <option value="" selected>Sort By Client</option>
                    </select>
                  </div>

                </div><!--end row-->



                <!-- <div class="col-12 col-lg">

<input class="form-control" type="text" placeholder="Search by Firm" id="search_firm">

</div> -->



              </div><!--end row-->


            </div>



            <div class="card-body">

              <div class="row g-3">
                <div class="col-12 col-lg">

                  <input class="form-control" type="text" placeholder="Search by Code" id="search_code">

                </div>

                <div class="col-12 col-lg">

                  <input type="date" class="form-control" placeholder="From Date" id="fromDate" />

                  <span class="small text-muted">Date</span>

                </div>



                <div class="col-12 col-lg">

                  <button type="submit" class="btn btn-primary">Search</button>

                </div>

                <div class="col-12 col-lg">

                </div>

              </div><!--end row-->

            </div>

          </div>

        </form>



        <div class="card">

          <div class="card-body">

            <div class="col text-end py-2">

              <button type="button" class="btn btn-sm btn-outline-primary px-1" id="exportExcel">

                <i class="lni lni-download"></i>

              </button>

            </div>

            <div class="table-responsive mt-3">

              <div id="load_ajax_active_legal"></div>

            </div>

          </div>

        </div>

      </div>

    </div>





  </div>

</div>

<!-- Legal Status Modal -->
<div class="modal fade" id="legalStatusModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          <i class="lni lni-pencil"></i> Change Legal Status
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="legalStatusForm">
        <div class="modal-body">
          <input type="hidden" id="legalStatusId" name="id">

          <div class="mb-3">
            <label for="legalStatusSelect" class="form-label">Select New Legal Status</label>
            <select class="form-select" id="legalStatusSelect" name="legal_status" required>
              <option value="">Select</option>
              <option value="Active">Active</option>
              <option value="Closed">Closed</option>
              <option value="Bad_debts">Bad debts</option>
              <!-- Add more options if needed -->
            </select>
          </div>
          <div class="mb-3">
            <label for="legalStatusSelect" class="form-label">Reason</label>
            <input class="form-control" id="legalreson" name="legalreson" type="text">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
  <div id="statusToast" class="toast align-items-center text-white bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body" id="statusToastBody">
        Status updated successfully!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>


<script>
  function openLegalStatusModal(id, currentStatus) {
    const modal = new bootstrap.Modal(document.getElementById('legalStatusModal'));
    document.getElementById('legalStatusId').value = id;
    document.getElementById('legalStatusSelect').value = currentStatus || '';
    modal.show();
  }

  document.getElementById('legalStatusForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const id = document.getElementById('legalStatusId').value;
    const newStatus = document.getElementById('legalStatusSelect').value;
    const legalresonInput = document.getElementById('legalreson'); // ← This was missing!
    const legalreson = legalresonInput.value.trim();

    legalresonInput.classList.remove('is-invalid');

    if (newStatus !== '' && legalreson === '') {
      legalresonInput.classList.add('is-invalid');

      if (!legalresonInput.nextElementSibling?.classList.contains('invalid-feedback')) {
        const feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        feedback.textContent = 'Please provide a reason for changing the legal status.';
        legalresonInput.parentNode.appendChild(feedback);
      }
      return;
    }
    $.ajax({
      url: "<?= ROOT_DIR ?>modules/activelegal/ajax/changeLegalStatus.php",
      type: "POST",
      dataType: "json",
      data: {
        action: 'change_status',
        id: id,
        newStatus: newStatus,
        legalreson: legalreson
      },
      success: function(response) {
        const toastEl = document.getElementById('statusToast');
        const toastBody = document.getElementById('statusToastBody');
        const toast = new bootstrap.Toast(toastEl);

        if (response.success) {
          toastBody.textContent = response.message || "Status updated successfully!";
          toastEl.classList.remove('bg-danger');
          toastEl.classList.add('bg-success');
        } else {
          toastBody.textContent = response.message || "Update failed.";
          toastEl.classList.remove('bg-success');
          toastEl.classList.add('bg-danger');
        }
        toast.show();
        // Optional: refresh data or reload
        setTimeout(() => location.reload(), 1500);
      },
      error: function(xhr, status, error) {
        const toastEl = document.getElementById('statusToast');
        const toastBody = document.getElementById('statusToastBody');
        const toast = new bootstrap.Toast(toastEl);

        toastBody.textContent = "AJAX error: " + error;
        toastEl.classList.remove('bg-success');
        toastEl.classList.add('bg-danger');
        toast.show();
      }
    });

    // Close modal immediately
    bootstrap.Modal.getInstance(document.getElementById('legalStatusModal')).hide();
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {


    $('#sort_by_marketing').change(function() {
      const marketingId = $(this).val();

      //Load search panel Client List
      $('#sort_by_client').html('<option value="">-- Select Client --</option>');

      if (marketingId) {
        $.ajax({
          url: '<?= ROOT_DIR ?>modules/client/ajax/get_client.php', // Adjust as needed
          type: 'POST',
          data: {
            marketingId: marketingId,
            action: 'client_legal_list'
          },
          dataType: 'json',
          success: function(response) {
            console.log(response);
            if (Array.isArray(response)) {
              response.forEach(item => {
                $('#sort_by_client').append(`<option value="${item.id}">${item.name}</option>`);
              });
            } else {
              $('#sort_by_client').append('<option value="">No Clients found</option>');
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      }
    });

    $(document).on('click', '.dropdown-toggle', function(e) {

      //e.preventDefault();

      //$(this).next('.dropdown-menu').toggle();

    });


    loadData(1);

    // Pagination code

    $(document).on("click", ".pagination li a", function(e) {

      e.preventDefault();

      var pageId = $(this).attr("id");

      loadData(pageId);

    });


    // Search form submission
    document.getElementById('search_form').addEventListener('submit', function(e) {
      e.preventDefault();

      const fromDate = document.getElementById('fromDate').value;
      const search_code = document.getElementById('search_code').value;
      const select_marketing = document.getElementById('sort_by_marketing').value;
      const select_client = document.getElementById('sort_by_client').value;

      // Build filters
      const filters = {
        fromDate: fromDate,
        search_code: search_code,
        select_marketing: select_marketing,
        select_client: select_client,


      };

      // Reset to page 1 when searching
      loadData(1, filters);
    });

    $('#select_marketing').change(function() {

      const marketingId = $(this).val();

      listClient(marketingId);

    });

    $('#category').change(function() {

      const id = $(this).val();

      listcategories(id, '');

    });


  });



  function loadData(page, filters = {}) {
    $.ajax({
      url: "<?= ROOT_DIR ?>modules/baddebts/ajax/load_baddebts_legal.php",
      type: "POST",
      cache: false,
      data: Object.assign({
        page_no: page,
        module: 'baddebts',
        page: 'list',
      }, filters), // merge filters with page number
      success: function(response) {
        $("#load_ajax_active_legal").html(response);
      }
    });
  }


  function listClient(marketingId, clientId) {

    // Clear previous items

    $('#select_client').html('<option value="">-- Select Client --</option>');

    const selectedClientId = clientId; // Replace with the value you want to select

    if (marketingId) {

      $.ajax({

        url: '<?= ROOT_DIR ?>modules/client/ajax/get_client.php', // Adjust as needed

        type: 'POST',

        data: {
          marketingId: marketingId,
          action: 'client_legal_list'
        },

        dataType: 'json',

        success: function(response) {

          // console.log(response);

          // if (Array.isArray(response)) {

          //     response.forEach(item => {

          //         const selected = item.id === selectedClientId ? 'selected="selected"' : '';

          //         $('#select_client').append(`<option value="${item.id}" ${selected}>${item.name}</option>`);

          //     });

          // } else {

          //     $('#select_client').append('<option value="">No items found</option>');

          // }

          var collected_amount = document.getElementById("collected_amount");
          if (Array.isArray(response)) {
            response.forEach(item => {
              const selected = item.id === selectedClientId ? 'selected="selected"' : '';
              $('#select_client').append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
            });

            // Add change event listener to update total_outstanding
            $('#select_client').on('change', function() {
              const selectedId = $(this).val(); // Get the selected client ID
              const selectedItem = response.find(item => item.id == selectedId); // Find the item in response
              $('#total_outstanding').val(selectedItem ? selectedItem.total_outstanding || '0' : '0');
              $('#outstanding_with_cheque').val(selectedItem ? selectedItem.outstanding_cheque || '0' : '0');
              $('#outstanding_without_cheque').val(selectedItem ? selectedItem.outstanding_without_cheque || '0' : '0');
              //$('#claim_amount').val(selectedItem ? selectedItem.total_outstanding || '' : '');
              var claimAmount = selectedItem.total_outstanding;

            });

            // Trigger change event initially to set total_outstanding for the default selected client
            $('#select_client').trigger('change');
          } else {
            $('#select_client').append('<option value="">No items found</option>');
            $('#total_outstanding').val('');
            $('#outstanding_with_cheque').val('');
            $('#outstanding_without_cheque').val('');

          }

        },

        error: function(xhr, status, error) {

          console.error('Error:', error);

        }

      });

    }

  }

  function listcategories(id, agencies_id) {

    // Clear previous items

    $('#agencies_id').html('<option value="">-- Select Category --</option>');



    if (id) {

      $.ajax({

        url: '<?= ROOT_DIR ?>ajax/get_agencies_list.php', // Adjust as needed

        type: 'POST',

        data: {
          action: 'list',
          id: id
        },

        dataType: 'json',

        success: function(response) {

          console.log(response);

          if (Array.isArray(response)) {

            response.forEach(item => {

              const selected = item.id === agencies_id ? 'selected="selected"' : '';

              $('#agencies_id').append(`<option value="${item.id}" ${selected}>${item.code ? item.code + ' - ' : ''}${item.name}</option>`);



            });

          } else {

            $('#agencies_id').append('<option value="">No data found</option>');

          }

        },

        error: function(xhr, status, error) {

          console.error('Error:', error);

        }

      });

    }

  }


  function round_error_notify(msg = '') {

    Lobibox.notify('error', {

      pauseDelayOnHover: true,

      size: 'mini',

      rounded: true,

      delayIndicator: false,

      icon: 'bx bx-x-circle',

      continueDelayOnInactiveTab: false,

      position: 'top right',

      msg: msg

    });

  }



  $("#exportExcel").click(() => {

    // console.log('haielo')



    var marketing = $("#marketing").val().trim();

    var client = $("#client").val().trim();

    var searchFirm = $("#search_firm").val().trim();

    var fromDate = $("#fromDate").val().trim();

    var toDate = $("#toDate").val().trim();

    var actionDate = $("#action_date").val().trim();

    var exportUrl = "<?= ROOT_DIR ?>excel/activelegal.php?type=excel";

    if (marketing.length > 0) {

      exportUrl += "&marketing=" + encodeURIComponent(marketing);

    }

    if (client.length > 0) {

      exportUrl += "&client=" + encodeURIComponent(client);

    }

    if (searchFirm.length > 0) {

      exportUrl += "&searchfirm=" + encodeURIComponent(searchFirm);

    }

    if (fromDate != '') {

      exportUrl += "&fromdate=" + encodeURIComponent(fromDate);

    }

    if (toDate != '') {

      exportUrl += "&todate=" + encodeURIComponent(toDate);

    }

    if (actionDate != '') {

      exportUrl += "&actiondate=" + encodeURIComponent(actionDate);

    }

    window.location.href = exportUrl;

  });
</script>