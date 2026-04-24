<!-- start page content wrapper-->

<div class="page-content-wrapper">

  <!-- start page content-->

  <div class="page-content">



    <!-- Start Breadcrumb -->

    <div class="page-breadcrumb d-flex align-items-center mb-3">

      <div class="breadcrumb-title pe-3 d-none d-sm-block">Dashboard</div>

      <div class="ps-3 d-none d-sm-block">

        <nav aria-label="breadcrumb">

          <ol class="breadcrumb mb-0 p-0 align-items-center">

            <li class="breadcrumb-item">

              <a href="javascript:;" id="home-icon">

                <ion-icon name="home-outline" title="Back to Dashboard"></ion-icon>

              </a>

            </li>

            <li class="breadcrumb-item active" aria-current="page">Active Legal</li>

          </ol>

        </nav>

      </div>



      <!-- Right-Side Buttons (Back + New Client) -->
      <?php if (LEGAL_AUTH_ADD): ?>
        <div class="ms-auto d-flex gap-2">

          <button type="button" class="btn btn-primary"

            onclick="window.location.href='<?= ROOT_DIR ?>activelegal/information.html';">

            <i class="fadeIn animated bx bx-plus"></i>New Legal</button>

        </div>
      <?php endif; ?>
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
                      <option value="">Case No.</option>
                      <?php if (!empty($array_legal_case)): ?>
                        <?php foreach ($array_legal_case as $legalMarketing): ?>
                          <option value="<?= htmlspecialchars($legalMarketing['id']) ?>">
                            <?= htmlspecialchars($legalMarketing['case_number']) ?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>

                  </div>


                  <div class="col-12 col-lg">
                    <select class="form-select select2-bootstrap" id="sort_by_client" name="sort_by_client">
                      <option value="">Client Name</option>
                      <?php if (!empty($array_legal_client_marketing)): ?>
                        <?php foreach ($array_legal_client_marketing as $legalMarketing): ?>
                          <option value="<?= htmlspecialchars($legalMarketing['user_Id']) ?>">
                            <?= htmlspecialchars($legalMarketing['user_name']) ?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>

                  </div>
                  <!-- <div class="col-12 col-lg">
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

                  </div> -->
                  <!-- <div class="col-12 col-lg">
                    <select class="form-select select2-bootstrap" id="sort_by_client" name="sort_by_client">
                      <option value="" selected>Sort By Client</option>
                    </select>
                  </div> -->

                <!-- </div> -->
                <!--end row-->


                <!-- <div class="col-12 col-lg">

                  <input class="form-control" type="text" placeholder="Search by Code" id="search_code">

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

    <!-- end page content-->







    <div class="modal fade" id="shiftingModal" tabindex="-1" aria-labelledby="shiftingModalLabel" aria-hidden="true">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <h5 class="modal-title" id="shiftingModalLabel">Shifting Legal Firm/Party</h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalDelClsBtn"></button>

          </div>

          <div class="modal-body">

            <form>

              <div class="mb-3">

                <input type="hidden" class="form-control" id="legal_id">

              </div>

              <div class="mb-3">

                <label class="form-label">Category <span class="text-danger">*</span></label>

                <select class="form-control" id="category_type">

                  <option value="">- - select - -</option>

                  <option value="third_party">Third Party</option>

                  <option value="debt_collector">Debt Collector</option>

                  <option value="legal_firm">Legal Firm</option>

                  <option value="legal_team">Legal Team</option>

                </select>

              </div>

              <div class="mb-3">

                <label class="form-label"> Firm/Party <span class="text-danger">*</span></label>

                <select class="form-control" id="party_names">

                  <option value="">- - select - -</option>

                </select>

              </div>

              <div class="mb-3">

                <label class="form-label">Shifted Date <span class="text-danger">*</span></label>

                <input type="date" class="form-control" id="shift_date">

              </div>

            </form>

          </div>

          <div class="modal-footer">

            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            <button type="button" class="btn btn-primary" id="proceedShift">Shift</button>

          </div>

        </div>

      </div>

    </div>



    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <h5 class="modal-title" id="deleteModalLabel">Delete Data</h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalDelDataClsBtn"></button>

          </div>

          <div class="modal-body">

            <form>

              <div class="mb-3">

                <label class="form-label">Are you sure want to delete this data?</label>

                <input type="hidden" class="form-control" value="" id="deleteLegalId">

              </div>

            </form>

          </div>

          <div class="modal-footer">

            <button type="button" class="btn btn-danger" id="deleteLegalBtn"><i class="lni lni-trash"></i></button>

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
        legalreson: legalreson,
        module: 'activelegal',
        page: 'list'
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



    $("#deleteModal").on('show.bs.modal', function(event) {

      let eventButton = $(event.relatedTarget)

      let legalId = eventButton.data('legal_id')

      $("#deleteLegalId").val(legalId)

    })





    $("#shiftingModal").on('show.bs.modal', function(event) {

      let button = $(event.relatedTarget);

      let activeLegalId = button.data('legal_id')

      $("#legal_id").val(activeLegalId)

    })


    loadData(1);

    // Pagination code

    $(document).on("click", ".pagination li a", function(e) {

      e.preventDefault();

      var pageId = $(this).attr("id");

      loadData(pageId);

    });


    $("#deleteLegalBtn").click(function() {

      let id = $("#deleteLegalId").val();

      if (!id || id == undefined || id == '') {

        round_error_notify('Unexpected error occured.')

        return;

      }

      $.ajax({

        type: 'post',

        url: "<?= ROOT_DIR ?>modules/activelegal/ajax/manage_active_legal.php",

        data: {

          action: 'deleteActiveLegal',

          id

        },

        success: function(jsonResponse) {

          let response = JSON.parse(jsonResponse)

          if (response.success) {

            $("#modalDelDataClsBtn").click()

            round_success_noti(response.message)

            loadData(1);

          } else {

            round_error_notify(response.message)

          }

        }

      })

    })

    // Search form submission
    document.getElementById('search_form').addEventListener('submit', function(e) {
      e.preventDefault();

      const fromDate = document.getElementById('fromDate').value;
      const search_code = document.getElementById('search_code').value;
      const select_marketing = document.getElementById('sort_by_marketing').value;
      const select_client = document.getElementById('sort_by_client').value;

      // var marketing = $("#sort_by_marketing").val();
      // var client = $("#sort_by_client").val();

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
      url: "<?= ROOT_DIR ?>modules/activelegal/ajax/load_active_legal.php",
      type: "POST",
      cache: false,
      data: Object.assign({
        page_no: page,
        module: 'activelegal',
        page: 'list'
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

  $("#category_type").change(function() {

    const category_type = $(this).val()

    $.ajax({

      type: 'post',

      url: "<?= ROOT_DIR ?>modules/activelegal/ajax/shift_active_legal.php",

      data: {

        action: 'getParty',

        party_type: category_type

      },

      success: function(jsonResponse) {

        let response = JSON.parse(jsonResponse)

        $("#party_names").html(response.html)


      }

    })

  })



  $("#proceedShift").click(function() {

    const category_type = $("#category_type")

    const party_name = $("#party_names")

    const shift_date = $("#shift_date")

    let proceed = true;

    if (category_type.val() == '') {

      proceed = false;

      category_type.addClass('is-invalid').removeClass('is-valid')

    } else {

      category_type.addClass('is-valid').removeClass('is-invalid')

    }

    if (party_name.val() == '') {

      proceed = false;

      party_name.addClass('is-invalid').removeClass('is-valid')

    } else {

      party_name.addClass('is-valid').removeClass('is-invalid')

    }

    if (shift_date.val() == '') {

      proceed = false;

      shift_date.addClass('is-invalid').removeClass('is-valid')

    } else {

      shift_date.addClass('is-valid').removeClass('is-invalid')

    }



    if (proceed) {

      const active_id = $("#legal_id").val()

      $.ajax({

        type: 'post',

        url: "<?= ROOT_DIR ?>modules/activelegal/ajax/shift_active_legal.php",

        data: {

          action: 'saveShift',

          party_type: category_type.val(),

          party_name: party_name.val(),

          shift_date: shift_date.val(),

          active_legal_id: active_id

        },

        success: function(jsonResponse) {

          let response = JSON.parse(jsonResponse)

          if (response.success) {

            category_type.val('').removeClass('is-valid')

            party_name.val('').removeClass('is-valid')

            shift_date.val('').removeClass('is-valid')

            $("#modalDelClsBtn").click();

            round_success_noti(response.message)
            // Reload the page after a short delay (optional)
            setTimeout(function() {
              location.reload();
            }, 1000); // wait 1 second to show the success message
          } else {

            round_error_notify(response.message)

          }

        }

      })

    }

  })



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