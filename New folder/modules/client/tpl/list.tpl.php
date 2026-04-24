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
            <li class="breadcrumb-item active" aria-current="page">Client</li>
          </ol>
        </nav>
      </div>

      <!-- Right-Side Buttons (Back + New Client) -->
      <div class="ms-auto d-flex gap-2">
        <?php if (LEGAL_AUTH_ADD): ?>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal">
            <i class="fadeIn animated bx bx-plus"></i> New Client
          </button>
        <?php endif; ?>
      </div>
    </div>

    <!-- End Breadcrumb -->



    <form action="" id="form_client" name="form_client" enctype="multipart/form-data">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">
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

            </div>
            <div class="card-body">
              <div class="row g-3">

                <div class="col-12 col-lg">
                  <input type="text" class="form-control" id="text_keyword" placeholder="Search By Client Name, Email , Contact Name & Numbers" value="" />
                </div>
                <div class="col-12 col-lg ">
                  <button type="button" class="btn btn-primary" id="btn_search_client">Search</button>
                  <button type="reset" class="btn btn-secondary ms-2" id="btn_clear_client">Clear</button>
                  <input type="hidden" class="form-control" id="sort_by_fromDate" placeholder="From Date" value="" />
                  <input type="hidden" class="form-control" id="sort_by_toDate" placeholder="To Date" value="" />

                </div>

              </div><!--end row-->
            </div>
          </div>

          <div class="card">
            <div class="card-body">


              <div class="table-responsive mt-3">
                <div id="load_ajax_client"></div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <!-- end page content-->

      <div class="modal fade" id="exampleExtraLargeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="lni lni-user"></i> New Client</h5>
              <button type="button" class="btn btn-sm btn-primary px-5"
                onclick="window.location.href='<?= ROOT_DIR ?>client/information.html';"><i
                  class="fadeIn animated bx bx-plus"></i>Create
                Client</button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-xl-12 ">
                  <div class="card">
                    <div class="card-body">
                      <div class=" p-3 rounded">
                        <div class="row g-3">


                          <div class="col-12">
                            <label class="form-label" for="single-select-field">Marketing <span
                                class="asterisk text-danger">*</span></label>
                            <select class="form-select select2-bootstrap" id="select_marketing" name="select_marketing">
                              <option value="">Select Marketing </option>
                              <?php
                              if ($array_marketing) {
                                foreach ($array_marketing as $marketing) {
                              ?>
                                  <option value="<?= $marketing['user_Id'] ?>"><?= $marketing['user_name'] ?></option>
                              <?php
                                }
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-12">
                            <label class="form-label">Client <span class="asterisk text-danger">*</span></label>

                            <select class="form-select select2-bootstrap" id="select_client" name="select_client">
                              <option value="">Select Client</option>
                            </select>

                          </div>
                          <div class="col-12">
                            <label class="form-label">Contact number</label>
                            <input type="text" class="form-control" id="client_contact_number"
                              name="client_contact_number" value="" autocomplete="off" />
                          </div>
                          <div class="col-12 d-none">
                            <label class="form-label">Total outstanding</label>
                            <input type="number" class="form-control" id="client_total_outstanding"
                              name="client_total_outstanding" value="0.00" autocomplete="off" />
                          </div>
                          <div class="col-12 d-none">
                            <label class="form-label">Outstanding cheque</label>
                            <input type="number" class="form-control" id="client_outstanding_cheque"
                              name="client_outstanding_cheque" value="0.00" autocomplete="off" />
                          </div>
                          <div class="col-12 d-none">
                            <label class="form-label">Outstanding without cheque</label>
                            <input type="number" class="form-control" id="client_outstanding_without_cheque"
                              name="client_outstanding_without_cheque" value="0.00" autocomplete="off" />
                          </div>
                          <div id="response"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

            <div class="modal-footer">
              <button type="reset" class="btn btn-secondary" id="btn_client_close" name="btn_client_close"
                data-bs-dismiss="modal">Close</button>
              <button type="button" id="btn_client_save" name="btn_client_save" class="btn btn-primary">Save
                Client</button>
            </div>
          </div>
        </div>
      </div>
    </form>

  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    /* Load Client list  : This used in client creation Pop UP*/
    $('#select_marketing').change(function() {
      const marketingId = $(this).val();

      // Clear previous items
      $('#select_client').html('<option value="">-- Select Client --</option>');

      if (marketingId) {
        $.ajax({
          url: '<?= ROOT_DIR ?>modules/client/ajax/get_client.php', // Adjust as needed
          type: 'POST',
          data: {
            marketingId: marketingId,
            action: 'client_list'
          },
          dataType: 'json',
          success: function(response) {
            console.log(response);
            if (Array.isArray(response)) {
              response.forEach(item => {
                $('#select_client').append(`<option value="${item.id}">${item.name}</option>`);
              });
            } else {
              $('#select_client').append('<option value="">No items found</option>');
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      }
    });






    /* Load Client Information like phone , email etc  */
    $('#select_client').change(function() {
      const clientId = $(this).val();




      if (clientId) {
        $.ajax({
          url: '<?= ROOT_DIR ?>modules/client/ajax/get_client.php', // Adjust as needed
          type: 'POST',
          data: {
            clientId: clientId,
            action: 'client_information'
          },
          dataType: 'json',
          success: function(response) {
            // console.log(response.customer_mob);
            $("#client_contact_number").val('');
            if (response.mob)
              $("#client_contact_number").val(response.mob);

          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      }
    });


    function showResponseAlert(message, type = "danger") {
      const alertClass = type === "success" ? "bg-success" : "bg-danger";
      const iconName = type === "success" ? "checkmark-circle-sharp" : "close-circle-sharp";

      $("#response").html(`
    <div class="alert alert-dismissible fade show py-2 ${alertClass}">
      <div class="d-flex align-items-center">
        <div class="fs-3 text-white">
          <ion-icon name="${iconName}"></ion-icon>
        </div>
        <div class="ms-3">
          <div class="text-white">${message}</div>
        </div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  `);

      // Auto-hide after 5 seconds
      setTimeout(() => {
        $(".alert").fadeOut("slow", function() {
          $(this).remove();
        });
      }, 5000);
    }

    function validateClient(callback) {
      let client_id = $("#select_client").val();

      if (client_id !== '') {
        $.ajax({
          url: '<?= ROOT_DIR ?>modules/client/ajax/validate_client.php',
          type: 'POST',
          data: {
            client_id: client_id,
            action: 'client_exist'
          },
          dataType: 'json',
          success: function(response) {
            console.log(response); // ✅ Debug

            if (response.exists) {
              // ✅ Client already exists → Show Bootstrap alert
              showResponseAlert("This client already exists! ", "danger");
              if (typeof callback === "function") callback(false); // Stop saving
            } else {
              // ✅ Client NOT found → allow saving
              if (typeof callback === "function") callback(true);
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            showResponseAlert("Could not validate client. Please try again.", "danger");
            if (typeof callback === "function") callback(false);
          }
        });
      } else {
        showResponseAlert("Please select a client before saving!", "danger");
        if (typeof callback === "function") callback(false);
      }
    }

    $("#btn_client_save").click(function(e) {
      e.preventDefault();

      // ✅ First validate before saving
      validateClient(function(canSave) {
        if (!canSave) return; // Stop if client already exists

        let selectedmarketing_Text = $("#select_marketing option:selected").text();
        let selectedclient_Text = $("#select_client option:selected").text();

        // Collecting form data
        let formData = {
          marketing_id: $("#select_marketing").val(),
          client_id: $("#select_client").val(),
          marketing_Text: selectedmarketing_Text,
          client_Text: selectedclient_Text,
          contact_number: $("#client_contact_number").val(),
          total_outstanding: $("#client_total_outstanding").val(),
          outstanding_cheque: $("#client_outstanding_cheque").val(),
          outstanding_without_cheque: $("#client_outstanding_without_cheque").val(),
          csrf_token: $("#csrf_token").val() // Optional CSRF protection
        };

        $.ajax({
          url: "<?= ROOT_DIR ?>ajax/save_client.php",
          type: "POST",
          data: formData,
          dataType: "json",
          beforeSend: function() {
            $("#btn_client_save").prop("disabled", true).text("Saving...");
          },
          success: function(response) {
            if (response.status === "success" && response.id > 0) {
              window.location.href = "<?= ROOT_DIR ?>client/information/edit/" + response.id + ".html";
            } else {
              // ✅ Show Bootstrap alert for server-side errors
              showResponseAlert(response.message || "Something went wrong.", response.status === "success" ? "success" : "danger");
            }
          },
          error: function() {
            showResponseAlert("An error occurred during adding.", "danger");
          },
          complete: function() {
            $("#btn_client_save").prop("disabled", false).text("Save Client");
          }
        });
      });
    });


  });
</script>



<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', '.dropdown-toggle', function(e) {
      //e.preventDefault();
      //$(this).next('.dropdown-menu').toggle();

    });
    document.getElementById("btn_search_client").addEventListener("click", function() {
      loadData(1);
    });
    document.getElementById("btn_clear_client").addEventListener("click", function() {
      location.reload(); // Reloads the current page
    });


    function loadData(page) {

      var marketing = $("#sort_by_marketing").val();
      var client = $("#sort_by_client").val();
      var fromDate = $("#sort_by_fromDate").val();
      var toDate = $("#sort_by_toDate").val();
      var keyword = $("#text_keyword").val();

      $.ajax({
        url: "<?= ROOT_DIR ?>modules/client/ajax/load_client.php",
        type: "POST",
        cache: false,
        data: {
          marketing: marketing,
          client: client,
          fromDate: fromDate,
          toDate: toDate,
          keyword: keyword,
          page_no: page
        },
        success: function(response) {
          $("#load_ajax_client").html(response);


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

    /* $("#txt_item_search").keyup(function () {
         console.log($(this).val());
         const item_search = document.getElementById("txt_item_search").value;

             loadData(1);

     });*/


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
  });
</script>