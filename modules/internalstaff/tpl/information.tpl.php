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
              <li class="breadcrumb-item active" aria-current="page">Internal Staff</li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- Back Button on the Right -->
      <?php include("common/backButton_list.php"); ?>
    </div>

    <div class="row">
      <div class="col-lg-8 mx-auto">
        <div class="card radius-10">
          <div class="card-body">
          <form id="staffProfileForm" method="post" enctype="multipart/form-data" autocomplete="off">

          <input type="hidden" id="edit_ID" name="edit_ID" readonly="true"
          value="<?= $data['user_Id'] ?>" />
              <!-- Profile Photo Upload -->
              <div class="mb-4 d-flex flex-column gap-3 align-items-center justify-content-center  d-none">
                <div class="user-change-photo shadow d-none">
                  <img id="profilePreview" src="<?= ROOT_DIR ?>assets/images/06.png" alt="Profile Photo" width="120" class="rounded-circle">
                </div>
                <input type="file" id="profilePhoto" name="profilePhoto" accept="image/*" class="d-none">

                <button type="button" class="btn btn-outline-primary btn-sm radius-30 px-4" onclick="document.getElementById('profilePhoto').click();">
                  <ion-icon name="image-sharp"></ion-icon> Change Photo
                </button>
                <small id="fileError" class="text-danger"></small> <!-- Error Message -->
              </div>

              <h5 class="mb-0 mt-4">User Information</h5>
              <hr>
              <div class="row g-3">
                <div class="col-6">
  <label class="form-label">Full Name <span class="asterisk text-danger">*</span></label>
  <input type="text" class="form-control" id="user_name" name="user_name" value="<?=$data['user_name']?>" autocomplete="off" required/>
  </div>
  <div class="col-6">
  <label class="form-label">Email</label>
    <input type="email" class="form-control" id="user_emailId" name="user_emailId" value="<?=$data['user_emailId']?>" autocomplete="new-email" />
    <span id="load_results_email"> </span>
  </div>
  <div class="col-6">
  <label class="form-label">Land Number</label>
  <input type="text" class="form-control" id="user_tel" name="user_tel" value="<?=$data['user_tel']?>" autocomplete="off" />
  </div>
  <div class="col-6">
  <label class="form-label">Mobile Number</label>
  <input type="text" class="form-control" id="user_mob" name="user_mob" value="<?=$data['user_mob']?>" autocomplete="off" />
                </div>
                <div class="col-12">
                  <label class="form-label">Address</label>
                  <textarea class="form-control" id="user_address" name="user_address" rows="4" ><?=$data['user_address']?></textarea>
                </div>
              </div>



              <div class="text-start mt-3">
  <button type="submit" class="btn btn-success px-4" id="btnSave" name="btnSave">Save Changes</button>
  <button type="reset" class="btn btn-primary px-4" id="btnreset" name="btnSave">Reset</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div><!--end row-->

  </div>
  <!-- end page content-->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

  $("#user_emailId").on("change", function () {
    const email = $(this).val().trim();
    const edit_ID = $("#edit_ID").val(); // Get value dynamically if not already declared

    if (email === "") return;

    $.ajax({
      url: "<?= ROOT_DIR ?>modules/legalteam/ajax/validateDuplicate.php",
      type: "POST",
      data: {
        email: email,
        edit_ID: edit_ID,
        action: "validateEmail"
      },
      success: function (response) {
        if(response.includes("Email ID already exists")) {
          $("#user_emailId").val("");
        }
        $("#load_results_email").html(response);
      },
      error: function () {
        $("#load_results_email").html('<span class="text-danger">Server error occurred.</span>');
      }
    });
  });



});

</script>

<!-- JavaScript for Validation and Photo Upload -->
<script>
  document.getElementById("profilePhoto").addEventListener("change", function (event) {
    const file = event.target.files[0];
    const errorMsg = document.getElementById("fileError");

    if (!file) return; // If no file selected, do nothing

    // Validate file type
    const allowedTypes = ["image/jpeg", "image/png", "image/gif"];
    if (!allowedTypes.includes(file.type)) {
      errorMsg.textContent = "Invalid file format! Only JPG, PNG, and GIF are allowed.";
      event.target.value = ""; // Clear file input
      return;
    }

    // Validate file size (max 1MB)
    const maxSize = 1 * 1024 * 1024; // 1MB in bytes
    if (file.size > maxSize) {
      errorMsg.textContent = "File size must be less than 1MB!";
      event.target.value = ""; // Clear file input
      return;
    }

    // Clear error message if validation passes
    errorMsg.textContent = "";

    // Preview image
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById("profilePreview").src = e.target.result;
    };
    reader.readAsDataURL(file);
  });

  // Form Validation

</script>
