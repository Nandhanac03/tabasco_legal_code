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
              <li class="breadcrumb-item active" aria-current="page">Legal Team</li>
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
              <div class="mb-4 d-flex flex-column gap-3 align-items-center justify-content-center d-none">
                <div class="user-change-photo shadow">
                  <img id="profilePreview" src="<?= ROOT_DIR ?>assets/images/06.png" alt="Profile Photo" width="120" class="rounded-circle">
                </div>
                <input type="file" id="profilePhoto" accept="image/*" class="d-none">
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
                  <input type="email" class="form-control" id="user_emailId" name="user_emailId" value="<?=$data['user_emailId']?>" autocomplete="off" />
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

              <h5 class="mb-0 mt-4">Login Information</h5>
              <hr>
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label">Username</label>
                  <input type="text" class="form-control" id="user_loginname" name="user_loginname" value="<?=$data['user_loginname']?>" autocomplete="new-username" required/>
                  <span id="load_results_loginname"> </span>
                </div>
                <div class="col-6">
                  <label class="form-label">Password</label>
                  <input type="password" class="form-control" id="user_password" name="user_password"  minlength="6" value="<?=$data['user_password']?>" autocomplete="new-password" required/>
                </div>
                <div class="col-6">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"  minlength="6" value="<?=$data['user_password']?>" autocomplete="new-password" required/>
                </div>
              </div>
<input type="checkbox" id="showPassword"> Show Password
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


  $("#user_loginname").on("change", function () {
    const loginName = $(this).val().trim();
    const edit_ID = $("#edit_ID").val(); // Get value dynamically if not already declared

    if (loginName === "") return;

    $.ajax({
      url: "<?= ROOT_DIR ?>modules/legalteam/ajax/validateDuplicate.php",
      type: "POST",
      data: {
        loginName: loginName,
        edit_ID: edit_ID,
        action: "validateLoginName"
      },
      success: function (response) {
        if(response.includes("Username already exists")) {
          $("#user_loginname").val("");
        }
        $("#load_results_loginname").html(response);
      },
      error: function () {
        $("#load_results_loginname").html('<span class="text-danger">Server error occurred.</span>');
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

    if (!file) return;

    const allowedTypes = ["image/jpeg", "image/png", "image/gif"];
    if (!allowedTypes.includes(file.type)) {
      errorMsg.textContent = "Invalid file format! Only JPG, PNG, and GIF are allowed.";
      event.target.value = "";
      return;
    }

    const maxSize = 1 * 1024 * 1024; // 1MB
    if (file.size > maxSize) {
      errorMsg.textContent = "File size must be less than 1MB!";
      event.target.value = "";
      return;
    }

    errorMsg.textContent = "";

    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById("profilePreview").src = e.target.result;
    };
    reader.readAsDataURL(file);
  });

  document.getElementById("staffProfileForm").addEventListener("submit", function (event) {
    const password = document.getElementById("user_password").value.trim();
    const confirmPassword = document.getElementById("confirmPassword").value.trim();

    if (password !== confirmPassword) {
      alert("Passwords do not match!");
      event.preventDefault(); // <-- This line prevents form submission
    }
  });

    // Show password toggle
    document.getElementById('showPassword').addEventListener('change', function () {
        var passwordField = document.getElementById('user_password');
        var confirmPasswordField = document.getElementById('confirmPassword');

        if (this.checked) {
            // If the checkbox is checked, show the password
            passwordField.type = 'text';
            confirmPasswordField.type = 'text';
        } else {
            // If the checkbox is unchecked, hide the password
            passwordField.type = 'password';
            confirmPasswordField.type = 'password';
        }
    });
</script>
