<!-- start page content wrapper-->
<div class="page-content-wrapper">
  <!-- start page content-->
  <div class="page-content">
    <!--start breadcrumb-->
    <div class="d-flex justify-content-between">
      <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Action Update</div>
        <div class="ps-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0 align-items-center">
              <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Followup Action </li>
            </ol>
          </nav>
        </div>
      </div>
      <div class="">
        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleExtraLargeModal">
          <i class="fadeIn animated bx bx-plus"></i> Add Action</a>
      </div>
    </div>
    <!--end breadcrumb-->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="col py-2 d-flex justify-content-between">
              <div class="border p-3">
                <table>
                  <tr>
                    <td>Marketing</td>
                    <td>:</td>
                    <td><?= $active_legal[0]['User_Client'] ?></td>
                  </tr>
                  <tr>
                    <td>Client</td>
                    <td>:</td>
                    <td><?= $active_legal[0]['ClientName'] ?></td>
                  </tr>
                  <tr>
                    <td>Present Legal Firm</td>
                    <td>:</td>
                    <td><?= $active_legal[0]['Present_Legal_Firm_Name'] ?></td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="col">
              <a href="javascript:history.back()">Go back<i class="lni lni-arrow-left ms-2"></i></a>
            </div>
            <div class="table-responsive mt-3">
              <style>
                .description-cell {
                  max-width: 270px;
                  /* Adjust this width as needed */
                  overflow-wrap: break-word;
                  /* Breaks long words to wrap */
                  white-space: normal;
                  /* Allows text to wrap to multiple lines */
                  text-align: justify;
                  /* Justifies the text */
                }
              </style>
              <table class="table align-middle mb-0 table-striped">
                <thead class="table-light">
                  <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Document</th>
                    <th>Updated By</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($rootdetails) { ?>
                    <?php foreach ($rootdetails as $data) { ?>
                      <tr>
                        <td><?= $data['date'] ?></td>
                        <td class='description-cell'><?= $data['description'] ?></td>
                        <td>
                          <?php if ($data['document']) {
                            $root_doc = ROOT_DIR . 'uploads/action_documents/' . $data['document'];

                          ?>
                            <a href="<?= htmlspecialchars($root_doc) ?>" target="_blank">
                              <button type="button" class="btn text-success">
                                <i class="fadeIn animated bx bx-file"></i>
                              </button>
                            </a>
                          <?php } else { ?>
                            <button class='btn text-danger'><i class='fadeIn animated bx bx-file'></i></button>
                          <?php } ?>

                        </td>
                        <td><?= $data['case_root_action_user'] ?></td>
                        
                    <?php } ?>

                  <?php } else { ?>
                    <tr>
                      <td colspan="4" class="text-danger" style="text-align: center;">
                        No records available.
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- end page content-->

    <div class="modal fade" id="exampleExtraLargeModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <form class="row g-3" id="floowupform">

            <div class="modal-header">
              <h5 class="modal-title"><i class="lni lni-pencil-alt"></i> New Followup</h5>

            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-xl-12 ">
                  <div class="card">
                    <div class="card-body">
                      <div class=" p-3 rounded">

                        <input type="hidden" id="active_legal_id" value="<?= $active_legal[0]['id'] ?>">
                        <input type="hidden" id="case_id" value="<?= $legal_precase[0]['id'] ?>">

                        <div class="col-12">
                          <label class="form-label">Client</label>
                          <input type="text" id="client" class="form-control" value="<?= $active_legal[0]['ClientName'] ?>" readonly>
                        </div>

                        <div class="col-12">
                          <label class="form-label">Case</label>
                          <input type="text" id="case_number" class="form-control" value="<?= $legal_precase[0]['temp_case_number'] ?>" readonly>
                        </div>

                        <!-- <div class="col-12">
                          <label class="form-label">Case</label>
                          <select type="text" class="form-select" id="case_id">
                            <option value="">--- Select case ---</option>
                            <?php if ($cases) { ?>
                              <?php foreach ($cases as $case) { ?>
                                <option value="<?= $case['id'] ?>"><?= $case['case_number'] ?></option>

                              <?php } ?>
                            <?php } ?>
                          </select>
                          <div class="invalid-feedback"></div>
                        </div> -->

                        <div class="col-12" style="display: none;">
                          <label class="form-label">Category</label>
                          <select type="text" class="form-select" id="category_id">
                            <option value="">--- Select type ---</option>
                            <?php if ($all_category) { ?>
                              <?php foreach ($all_category as $category) { ?>
                                <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>

                              <?php } ?>
                            <?php } ?>
                          </select>
                          <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-12" style="display: none;">
                          <label class="form-label">Sub-category</label>
                          <select type="text" class="form-select" id="sub_category_id">
                            <option value="">--- Select type ---</option>
                            <?php if ($all_sub_category) { ?>
                              <?php foreach ($all_sub_category as $subcategory) { ?>
                                <option value="<?= $subcategory['id'] ?>"><?= $subcategory['title'] ?></option>

                              <?php } ?>
                            <?php } ?>
                          </select>
                          <div class="invalid-feedback"></div>

                        </div>
                        <div class="col-12" style="display: none;">
                          <label class="form-label">Stage</label>
                          <select class="form-select" id="stage">
                            <option value="">--- Select Stage ---</option>
                          </select>

                          <div class="invalid-feedback"></div>

                        </div>
                        <div class="col-12" style="display: none;">
                          <label class="form-label">UAE Pass</label>
                          <select type="text" class="form-select" id="uae_pass">
                            <option value="YES">YES</option>
                            <option value="NO">NO</option>
                          </select>
                          <div class="invalid-feedback"></div>

                        </div>
                        <div class="col-12">
                          <label class="form-label">Date</label>
                          <input type="date" id="date" class="form-control">
                        </div>
                        <div class="col-12">
                          <label class="form-label">Description</label>
                          <textarea id="description" class="form-control"></textarea>
                        </div>
                        <div class="col-12">
                          <label class="form-label">Upload Document</label>
                          <input type="file" class="form-control" id="document_file">
                          <small class="text-muted">Only files in JPG, PNG, or PDF formats are permitted, with a size limit of 1MB</small>
                          <div class="invalid-feedback">Only JPG, PNG, or PDF under 1MB allowed.</div>
                        </div>

                        <div>
                          <input type="hidden" name="client_id" id="client_id" value="<?= $active_legal[0]['client'] ?>">
                          <input type="hidden" name="firm_id" id="firm_id" value="<?= $active_legal[0]['agencies_id'] ?>">
                          <input type="hidden" name="parent_type" id="parent_type" value="<?= $active_legal[0]['legal_firm_type'] ?>">

                        </div>

                        <!-- <div class="col-12">
                          <label class="form-label">Upload cheque</label>
                          <input type="file" class="form-control" id="inputGroupFile01">
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer ">

              <button type="submit" class="btn btn-primary">Save </button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>


<!-- Toast container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
  <div id="liveToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>



<script>
  document.getElementById('category_id').addEventListener('change', function() {
    let categoryId = this.value;
    let case_id = document.getElementById('case_id').value;
    let active_legal_id = document.getElementById('active_legal_id').value;

    if (categoryId) {
      $.ajax({
        url: '<?= ROOT_DIR ?>modules/actionreport/ajax/load_action_stage.php',
        type: 'POST',
        data: {
          categoryId,
          case_id,
          active_legal_id
        },
        success: function(response) {
          $('#stage').html(response); // inject the options into the select
        },
        error: function(xhr, status, error) {
          showToast('danger', 'An error occurred. Please try again.');
        }
      });
    }
  });


  document.getElementById('floowupform').addEventListener('submit', function(e) {
    e.preventDefault();
    const requiredFields = [
      'active_legal_id',
      'client',
      'date',
      'description',
    ];
    let isValid = true;

    function validateField(fieldId) {
      const field = document.getElementById(fieldId);
      field.classList.remove('is-invalid', 'is-valid');
      if (!field.value.trim()) {
        field.classList.add('is-invalid');
        return false;
      } else {
        field.classList.add('is-valid');
        return true;
      }
    }

    // Validate required fields
    requiredFields.forEach(fieldId => {
      if (!validateField(fieldId)) isValid = false;
    });

    // ✅ Validate File
    const fileField = document.getElementById('document_file');
    const document_file = fileField.files[0];
    fileField.classList.remove('is-invalid', 'is-valid');

    if (document_file) {
      const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
      const maxSize = 1 * 1024 * 1024; // 1MB
      if (!allowedTypes.includes(document_file.type) || document_file.size > maxSize) {
        fileField.classList.add('is-invalid');
        isValid = false;
      } else {
        fileField.classList.add('is-valid');
      }
    }
    if (!isValid) return;

    const case_id = document.getElementById('case_id').value;
    const category_id = document.getElementById('category_id').value;
    const sub_category_id = document.getElementById('sub_category_id').value;
    const stage = document.getElementById('stage').value;
    const uae_pass = document.getElementById('uae_pass').value;

    // ✅ Build FormData
    let formData = new FormData();
    formData.append('action', 'new_followaction');
    formData.append('case_type', 'precase');
    formData.append('case_id', case_id);
    formData.append('category_id', category_id);
    formData.append('sub_category_id', sub_category_id);
    formData.append('stage', stage);
    formData.append('uae_pass', uae_pass);

    const client_id = document.getElementById('client_id').value;
    const firm_id = document.getElementById('firm_id').value;
    const parent_type = document.getElementById('parent_type').value;
    formData.append('client_id', client_id);
    formData.append('firm_id', firm_id);
    formData.append('parent_type', parent_type);


    requiredFields.forEach(fieldId => {
      formData.append(fieldId, document.getElementById(fieldId).value);
    });

    if (document_file) {
      formData.append('document_file', document_file); // ✅ Append file correctly
    }



    // ✅ Send via AJAX
    $.ajax({
      url: '<?= ROOT_DIR ?>modules/actionreport/followupview.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',

      success: function(response) {
        if (response.success) {
          showToast('success', response.message);
          setTimeout(() => location.reload(), 1500);
        } else {
          showToast('danger', response.message);
        }
      },
      error: function(xhr, status, error) {
        console.log(xhr);
        
        showToast('danger', 'An error occurred. Please try again.');
      }

    });
    // Close modal immediately
    bootstrap.Modal.getInstance(document.getElementById('exampleExtraLargeModal')).hide();
  });

  function showToast(type, message) {
    const toastEl = document.getElementById('liveToast');
    const toastBody = toastEl.querySelector('.toast-body');

    // Update class for type (success, danger, warning, info)
    toastEl.className = `toast align-items-center text-bg-${type} border-0`;

    toastBody.textContent = message;

    const toast = new bootstrap.Toast(toastEl);
    toast.show();
  }
</script>