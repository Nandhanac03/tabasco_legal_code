<!-- start page content wrapper-->
<div class="page-content-wrapper">
  <!-- start page content-->
  <div class="page-content">

    <!--start breadcrumb-->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <!-- Breadcrumb on the Left -->
      <div class="page-breadcrumb d-none d-sm-flex align-items-center">
        <div class="breadcrumb-title pe-3">Dashboard</div>
        <div class="ps-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0 align-items-center">
              <li class="breadcrumb-item">
                <a href="javascript:;" id="home-icon">
                  <ion-icon name="home-outline" title="Back to Dashboard"></ion-icon>
                </a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Client Information</li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- Back Button on the Right -->
      <?php include("common/backButton_list.php"); ?>
    </div>
    <!--end breadcrumb-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="row">
      <div class="col col-lg-12 mx-auto">

        <?php if ($error_msg) { ?>
          <div class="alert alert-dismissible fade show py-2 bg-danger" id="divErrorMsg">
            <div class="d-flex align-items-center">
              <div class="fs-3 text-white"><ion-icon name="close-circle-sharp"></ion-icon></div>
              <div class="ms-3">
                <div class="text-white"><?= $error_msg ?></div>
              </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php } ?>

        <div class="card">
          <div class="card-body">
            <ul class="nav nav-tabs nav-primary" role="tablist">
              <?php
              echo createNavItem('client', "Information", "information-sharp", "information", $edit_id, true);
              echo createNavItem('client', "Documents", "document-attach-sharp", "document", $edit_id);
              echo createNavItem('client', "Contact", "person-add-outline", "contact", $edit_id);
              echo createNavItem('client', "Commission", "cash", "commission", $edit_id);
              echo createNavItem('client', "Plantiff", "briefcase", "plantiff", $edit_id);
              echo createNavItem('client', "Defender", "shield", "defender", $edit_id);
              ?>
            </ul>

            <div class="tab-content py-3">
              <div class="tab-pane fade show active" role="tabpanel">
                <!--start shop cart-->
                <section class="shop-page">
                  <div class="shop-container">
                    <div class="shop-cart">
                      <div class="container">
                        <div class="row">

                          <!-- LEFT COLUMN -->
                          <div class="col-lg-6"6
                            <div class="col">
                              <form action="" method="post" id="frm_client_information" name="frm_client_information" enctype="multipart/form-data">
                                <input type="hidden" id="edit_ID" name="edit_ID" readonly="true" value="<?= $data['id'] ?>" />

                                <div class="card">
                                  <div class="card-header">
                                    <h6 class="mb-0"><i class="lni lni-user"></i> Client Profile</h6>
                                  </div>
                                  <div class="card-body">

                                    <div class="mb-3">
                                      <label class="form-label">Code: <span class="asterisk text-danger">*</span></label>
                                      <input type="text" class="form-control" id="code" name="code" autocomplete="off" value="<?= $data['code'] ?>" readonly="true" required />
                                    </div>

                                    <?php if ($edit_id) { ?>
                                      <div class="mb-3">
                                        <label class="form-label">Type</label><br>

                                        <!-- Marketing -->
                                        <label>
                                          <input type="radio" name="which_type_user" value="M" onchange="toggleDiv()" <?= (empty($data['type']) || $data['type'] == 'M') ? 'checked' : '' ?>>
                                          Marketing
                                        </label>

                                        &nbsp;&nbsp;

                                        <!-- Internal -->
                                        <label>
                                          <input type="radio" name="which_type_user" value="I" onchange="toggleDiv()" <?= ($data['type'] == 'I') ? 'checked' : '' ?>>
                                          Internal Staff
                                        </label>

                                        &nbsp;&nbsp;

                                        <!-- External Client -->
                                        <label>
                                          <input type="radio" name="which_type_user" value="E" onchange="toggleDiv()" <?= ($data['type'] == 'E') ? 'checked' : '' ?>>
                                          External Client
                                        </label>
                                      </div>

                                    <?php } else { ?>
                                      <div class="mb-3">
                                        <label class="form-label">Type</label><br>

                                        <!-- Marketing -->
                                        <label>
                                          <input type="radio" name="which_type_user" value="M" onchange="toggleDiv()" <?php echo (empty($data['type']) || $data['type'] == 'M') ? 'checked' : ''; ?> />
                                          Marketing
                                        </label>

                                        &nbsp;&nbsp;

                                        <!-- Internal -->
                                        <label>
                                          <input type="radio" name="which_type_user" value="I" onchange="toggleDiv()" <?php echo ($data['type'] == 'I') ? 'checked' : ''; ?> />
                                          Internal Staff
                                        </label>

                                        &nbsp;&nbsp;

                                        <!-- External Client -->
                                        <label>
                                          <input type="radio" name="which_type_user" value="E" onchange="toggleDiv()" <?php echo ($data['type'] == 'E') ? 'checked' : ''; ?> />
                                          External Client
                                        </label>
                                      </div>
                                    <?php } ?>

                                    <!-- MARKETING STAFF SECTION -->
                                    <div id="marketingStaff">
                                      <?php if ($edit_id) { ?>
                                        <div class="mb-3">
                                          <label class="form-label">Marketing</label>
                                          <input type="text" class="form-control" value="<?= htmlspecialchars($data['marketing_person']) ?>" readonly>
                                          <input type="hidden" name="select_marketing" value="<?= $data['marketing'] ?>">
                                        </div>
                                      <?php } else { ?>
                                        <div class="mb-3">
                                          <label class="form-label">Marketing: <span class="asterisk text-danger">*</span></label>
                                          <select class="form-select select2-bootstrap" id="select_marketing" name="select_marketing">
                                            <option value="">Select Marketing</option>
                                            <?php
                                            if ($array_marketing) {
                                              foreach ($array_marketing as $marketing) {
                                            ?>
                                                <option value="<?= $marketing['user_Id'] ?>" <?php if ($marketing['user_Id'] == $data['marketing']) { ?> selected="selected" <?php } ?>><?= $marketing['user_name'] ?></option>
                                            <?php
                                              }
                                            }
                                            ?>
                                          </select>
                                        </div>
                                      <?php } ?>

                                      <?php if ($edit_id) { ?>
                                        <div class="mb-3">
                                          <label class="form-label">Client</label>
                                          <input type="text" class="form-control" value="<?= htmlspecialchars($data['name']) ?>" readonly>
                                          <!-- Preserve values -->
                                          <input type="hidden" name="select_client" value="<?= $data['client'] ?>">
                                          <input type="hidden" name="client_name" value="<?= $data['name'] ?>">
                                        </div>
                                      <?php } else { ?>
                                        <div class="mb-3" id="clientSelectWrapper">
                                          <label class="form-label">Client: <span class="asterisk text-danger">*</span></label>
                                          <select class="form-select select2-bootstrap" id="select_client" name="select_client">
                                            <option value="">Select Client</option>
                                          </select>
                                          <a href="javascript:void(0);" id="addClientLink" class="text-primary mt-1 d-inline-block">
                                            + Add Client
                                          </a>
                                        </div>

                                        <!-- Hidden input for adding new client -->
                                        <div class="mb-3 d-none" id="clientInputWrapper">
                                          <label class="form-label">Client: <span class="asterisk text-danger">*</span></label>
                                          <input type="text" class="form-control" id="client_name" name="client_name" autocomplete="off" value="<?= $data['name'] ?>" />
                                          <a href="javascript:void(0);" id="backToSelect" class="text-secondary mt-1 d-inline-block">
                                            ← Select Existing Client
                                          </a>
                                        </div>
                                      <?php } ?>
                                    </div>
                                    <!-- END MARKETING STAFF SECTION -->

                                    <!-- INTERNAL STAFF SECTION -->
                                    <?php if ($edit_id) { ?>
                                      <div id="internalStaff">
                                        <div class="mb-3">
                                          <label class="form-label">Internal Staff</label>
                                          <input type="text" class="form-control" value="<?= htmlspecialchars($data['marketing_person']) ?>" readonly>
                                          <input type="hidden" name="select_internal" value="<?= $data['marketing'] ?>">
                                        </div>

                                        <div class="mb-3">
                                          <label class="form-label">Client</label>
                                          <input type="text" class="form-control" value="<?= htmlspecialchars($data['name']) ?>" readonly>
                                          <input type="hidden" name="name" value="<?= htmlspecialchars($data['name']) ?>">
                                        </div>

                                        <div class="mb-3">
                                          <label class="form-label">Behalf</label>
                                          <input type="text" class="form-control" value="<?= htmlspecialchars($data['behalf_of_person']) ?>" readonly>
                                          <input type="hidden" name="behalf_of" value="<?= $data['behalf_of'] ?>">
                                        </div>
                                      </div>

                                    <?php } else { ?>
                                      <div id="internalStaff" style="display: none;">
                                        <div class="mb-3">
                                          <label class="form-label">Internal Staff: <span class="asterisk text-danger">*</span></label>
                                          <select class="form-select select2-bootstrap" id="select_internal" name="select_internal">
                                            <option value="">Select </option>
                                            <?php
                                            if ($array_internal_staff) {
                                              foreach ($array_internal_staff as $internal_staff_rows) {
                                            ?>
                                                <option value="<?= $internal_staff_rows['user_Id'] ?>" <?php if ($internal_staff_rows['user_Id'] == $data['marketing']) { ?> selected="selected" <?php } ?>>
                                                  <?= $internal_staff_rows['user_name'] ?>
                                                </option>
                                            <?php
                                              }
                                            } ?>
                                          </select>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label">Client :<span class="asterisk text-danger">*</span></label>
                                          <input type="text" class="form-control" id="name" name="name" value="<?= $data['name'] ?>" autocomplete="off" />
                                        </div>

                                        <div class="mb-3">
                                          <label class="form-label">Behalf: <span class="asterisk text-danger">*</span></label>
                                          <select class="form-select select2-bootstrap" id="behalf_of" name="behalf_of">
                                            <option value="">Select </option>
                                            <?php
                                            if ($array_behalf_of_users) {
                                              foreach ($array_behalf_of_users as $behalf_of_users) {
                                            ?>
                                                <option value="<?= $behalf_of_users['user_Id'] ?>" <?php if ($behalf_of_users['user_Id'] == $data['behalf_of']) { ?> selected="selected" <?php } ?>>
                                                  <?= $behalf_of_users['user_name'] ?>-<?= $behalf_of_users['usertype_title'] ?>
                                                </option>
                                            <?php
                                              }
                                            }
                                            ?>
                                          </select>
                                        </div>
                                      </div>
                                    <?php } ?>
                                    <!-- END INTERNAL STAFF SECTION -->

                                    <!-- EXTERNAL CLIENT SECTION -->
                                    <div id="externalClient">

                                      <div class="mb-3" id="extClientNameDiv" style="display: none;">
                                        <label class="form-label">Client Name:<span class="asterisk text-danger">*</span></label>
                                        <input type="text" class="form-control" id="external_client_name" name="external_client_name" value="<?= $data['name'] ?>" autocomplete="off" />
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label">Office Address:</label>
                                        <input type="text" class="form-control" id="office_address" name="office_address" value="<?= $data['office_address'] ?>" autocomplete="off" />
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label">Contact Person:</label>
                                        <input type="text" class="form-control" id="contact_person" name="contact_person" value="<?= $data['contact_person'] ?>" autocomplete="off" />
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label">Designation:</label>
                                        <input type="text" class="form-control" id="designation" name="designation" value="<?= $data['designation'] ?>" autocomplete="off" />
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label">Mobile No:</label>
                                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?= $data['mobile_number'] ?>" autocomplete="off" />
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label">Email ID:</label>
                                        <input type="text" class="form-control" id="email" name="email" value="<?= $data['email'] ?>" autocomplete="off" />
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label">Land No:</label>
                                        <input type="text" class="form-control" id="land_number" name="land_number" value="<?= $data['land_number'] ?>" autocomplete="off" />
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label">PO Box:</label>
                                        <input type="text" class="form-control" id="po_number" name="po_number" value="<?= $data['po_number'] ?>" autocomplete="off" />
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label">Fax No:</label>
                                        <input type="text" class="form-control" id="fax_number" name="fax_number" value="<?= $data['fax_number'] ?>" autocomplete="off" />
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label">Website:</label>
                                        <input type="text" class="form-control" id="website" name="website" value="<?= $data['website'] ?>" autocomplete="off" />
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label">Visiting Card:</label>
                                        <input type="file" class="form-control" id="visiting_card" name="visiting_card" value="">
                                        <small class="text-danger">Allowed types: jpg, jpeg, gif, png, pdf & maximum size allowed 1MB.</small>
                                      </div>

                                      <?php if ($data['visiting_card'] != '' && file_exists('uploads/visiting_card/' . $data['visiting_card'])) { ?>
                                        <div class="mb-3">
                                          <label class="form-label">View Visiting Card:</label>
                                          <a href="<?= ROOT_DIR . 'uploads/visiting_card/' . $data['visiting_card'] ?>" target="_blank"><?= $data['visiting_card'] ?></a>
                                        </div>
                                      <?php } ?>

                                    </div>
                                    <!-- END EXTERNAL CLIENT SECTION -->

                                    <div class="mb-3">
                                      <button type="submit" class="btn btn-primary px-5">Save</button>
                                      <button type="reset" class="btn btn-secondary px-5">Reset</button>
                                    </div>

                                  </div>
                                  <!-- END card-body -->
                                </div>
                                <!-- END card -->
                              </form>
                            </div>
                            <!-- END col -->
                          </div>
                          <!-- END col-lg-6 LEFT COLUMN -->

                          <!-- RIGHT COLUMN -->
                          <div class="col-lg-6">
                            <div class="col">
                              <div class="card">
                                <div class="card-header">
                                  <h6 class="mb-0"><i class="lni lni-text-align-justify"></i> Outstanding</h6>
                                </div>
                                <div class="card-body">
                                  <div id="OutstandingresponseMessage" class="mt-3"></div>

                                  <div class="mb-3">
                                    <label class="form-label">Total Outstanding:</label>
                                    <input type="number" class="form-control" value="<?= $data['total_outstanding'] ?? 0.00 ?>" id="total_outstanding" name="total_outstanding" autocomplete="off" />
                                  </div>

                                  <div class="mb-3">
                                    <label class="form-label">Outstanding with PDC:</label>
                                    <input type="number" class="form-control" value="<?= $data['outstanding_cheque'] ?? 0.00 ?>" id="outstanding_cheque" name="outstanding_cheque" autocomplete="off" />
                                  </div>

                                  <div class="mb-3">
                                    <label class="form-label">Outstanding with Invoices:</label>
                                    <input type="number" class="form-control" value="<?= $data['outstanding_without_cheque'] ?? 0.00 ?>" id="outstanding_without_cheque" name="outstanding_without_cheque" autocomplete="off" />
                                  </div>
                                  
                                  <?php if ($edit_id): ?>
                                  <div class="mb-3 text-end">
                                      <button type="button" class="btn btn-success" id="btn_save_outstanding" onclick="saveOutstandingAmounts('<?= $edit_id ?>')">
                                          <i class="bx bx-save"></i> Save Outstanding Amounts
                                      </button>
                                  </div>
                                  <?php endif; ?>

                                </div>
                                <!-- END card-body -->
                              </div>
                              <!-- END card -->
                              <?php include("common/manage_Cheques.php"); ?>
                            </div>
                            <!-- END col -->
                          </div>
                          <!-- END col-lg-6 RIGHT COLUMN -->

                          

                        </div>
                        <!-- END row -->
                      </div>
                      <!-- END container -->
                    </div>
                    <!-- END shop-cart -->
                  </div>
                  <!-- END shop-container -->
                </section>
                <!-- END shop-page -->
              </div>
              <!-- END tab-pane -->
            </div>
            <!-- END tab-content -->
          </div>
          <!-- END card-body (with tabs) -->
        </div>
        <!-- END card -->
      </div>
      <!-- END col col-lg-12 mx-auto -->
    </div>
    <!-- END row -->
  </div>
  <!-- END page-content -->
</div>
<!-- END page-content-wrapper -->

<script>
  document.getElementById('addClientLink').addEventListener('click', function() {
    // Hide select, disable it
    document.getElementById('clientSelectWrapper').classList.add('d-none');
    document.getElementById('select_client').disabled = true;

    // Show input
    document.getElementById('clientInputWrapper').classList.remove('d-none');
    document.getElementById('client_name').focus();
  });

  document.getElementById('backToSelect').addEventListener('click', function() {
    // Show select again
    document.getElementById('clientSelectWrapper').classList.remove('d-none');
    document.getElementById('select_client').disabled = false;

    // Hide input and clear value
    document.getElementById('clientInputWrapper').classList.add('d-none');
    document.getElementById('client_name').value = '';
  });
</script>


<script>
  $(document).ready(function() {
    /* Load Client list  */
    $('#select_marketing').change(function() {
      const marketingId = $(this).val();
      listClient(marketingId, '');
    });

    /* Load Client Information like phone , email etc  */
    $('#select_client').change(function() {
      const clientId = $(this).val();
      fetchClientInfo(clientId);
    });

  });

  function listClient(marketingId, clientId) {
    // Clear previous items
    $('#select_client').html('<option value="">-- Select Client --</option>');
    const selectedClientId = clientId; // Replace with the value you want to select
    const edit_id = '<?= $edit_id ?>';
    if (marketingId) {
      $.ajax({
        url: '<?= ROOT_DIR ?>modules/client/ajax/get_client.php', // Adjust as needed
        type: 'POST',
        data: {
          marketingId: marketingId,
          selectedClientId: selectedClientId,
          edit_id: edit_id,
          action: 'client_list'
        },
        dataType: 'json',
        success: function(response) {
          console.log(response);
          if (Array.isArray(response)) {
            response.forEach(item => {
              const selected = item.id === selectedClientId ? 'selected="selected"' : '';
              $('#select_client').append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
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
  }

  function fetchClientInfo(clientId) {
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


          $("#office_address").val(response.addr);
          $("#contact_person").val(response.contact_person);
          $("#designation").val(response.contact_desig);
          $("#mobile_number").val(response.mob);
          $("#email").val(response.email);
          $("#land_number").val(response.tel);
          $("#fax_number").val(response.fax);
          $("#po_number").val(response.po_box);
          $("#website").val(response.website);
        },
        error: function(xhr, status, error) {
          console.error('Error:', error);
        }
      });
    }
  }
</script>
<?php
if ($action == 'edit') {
?>
  <script>
    var marketingId = $('#select_marketing').val();
    var clientId = '<?= $data['refer_id'] ?>';
    listClient(marketingId, clientId);
    //fetchClientInfo(clientId);
  </script>
<?php
} else if ($input_data['marketing'] != '') { ?>
  <script>
    var marketingId = '<?= $input_data['marketing'] ?>';
    var clientId = '<?= $input_data['client'] ?>';

    listClient(marketingId, clientId);
  </script>
<?php } ?>





<script>
  function saveOutstandingAmounts(clientId) {
    if (!clientId) {
      if (typeof error_noti === 'function') {
          error_noti("Client Information ID is missing");
      } else {
          alert("Please fill out and save the client profile information before adding outstanding amount details.");
      }
      return false;
    }

    const btn = $('#btn_save_outstanding');
    const oldHtml = btn.html();
    btn.prop('disabled', true).html('<i class="bx bx-loader bx-spin"></i> Saving...');

    // Collect values from input fields
    let totalOutstanding = document.getElementById("total_outstanding").value;
    let outstandingCheque = document.getElementById("outstanding_cheque").value;
    let outstandingWithoutCheque = document.getElementById("outstanding_without_cheque").value;

    let data = {
      param1: clientId,
      total_outstanding: totalOutstanding,
      outstanding_cheque: outstandingCheque,
      outstanding_without_cheque: outstandingWithoutCheque
    };

    fetch("<?= ROOT_DIR ?>ajax/update_outstanding.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(result => {
        btn.prop('disabled', false).html(oldHtml);
        if (result.status === "success") {
          // Update the fields
          document.getElementById("total_outstanding").value = result.total_outstanding;
          document.getElementById("outstanding_cheque").value = result.outstanding_cheque;
          document.getElementById("outstanding_without_cheque").value = result.outstanding_without_cheque;
          
          if (typeof round_success_noti === 'function') {
              round_success_noti("Outstanding amounts updated successfully.");
          } else {
              alert("Outstanding amounts updated successfully.");
          }
        } else {
          if (typeof error_noti === 'function') {
              error_noti(result.message || "Error updating outstanding amounts.");
          } else {
              alert(result.message || "Error updating outstanding amounts.");
          }
        }
      })
      .catch(error => {
        btn.prop('disabled', false).html(oldHtml);
        if (typeof error_noti === 'function') {
            error_noti("A server error occurred while saving.");
        } else {
            alert("A server error occurred while saving.");
        }
        console.error("Error:", error);
      });
  }


  function toggleDiv() {
    var marketingStaff = document.getElementById("marketingStaff");
    var internalStaff = document.getElementById("internalStaff");
    var extClientNameDiv = document.getElementById("extClientNameDiv");

    var type = document.querySelector('input[name="which_type_user"]:checked').value;

    if (type === "M") {
        marketingStaff.style.display = "block";
        internalStaff.style.display = "none";
        if(extClientNameDiv) extClientNameDiv.style.display = "none";
    } 
    else if (type === "I") {
        marketingStaff.style.display = "none";
        internalStaff.style.display = "block";
        if(extClientNameDiv) extClientNameDiv.style.display = "none";
    } 
    else if (type === "E") {
        marketingStaff.style.display = "none";
        internalStaff.style.display = "none";

        if(extClientNameDiv) extClientNameDiv.style.display = "block";

        // show only external fields if you have a div for it
        document.getElementById("externalClient")?.classList.remove("d-none");
    }
}


  // function toggleDiv() {
  //   var marketingStaff = document.getElementById("marketingStaff");
  //   var internalStaff = document.getElementById("internalStaff");
  //   var externalClient = document.getElementById("externalClient");
  //   var which_type_user = document.querySelector('input[name="which_type_user"]:checked').value;

  //   if (which_type_user === "M") {
  //     marketingStaff.style.display = "block";
  //     internalStaff.style.display = "none";
  //     externalClient.style.display = "block";
  //   } else {
  //     marketingStaff.style.display = "none";
  //     internalStaff.style.display = "block";
  //     externalClient.style.display = "none";
  //   }
  // }
</script>
<?php if ($action == 'edit') { ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      toggleDiv();
    });
  </script>
<?php } ?>