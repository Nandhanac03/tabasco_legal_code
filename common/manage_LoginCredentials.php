<?php
$login_user_id              = $id;
switch ($module) {
    case 'thirdparty':
        $login_user_type    = 'TP';
    break;
    case 'legalfirm':
        $login_user_type    = 'LF';
    break;
    case 'debtcollector':
        $login_user_type    = 'DC';
    break;
}
?>
<div class="modal fade" id="login_credentials_Modal" tabindex="-1" aria-labelledby="login_credentials_Modal"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="login_credentials_ModalLabel"><i
                        class="fadeIn animated bx bx-log-in-circle"></i> Login Credentials Panel</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div id="login_alert_box" class="alert d-none" role="alert"></div>

                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" id="frm_loginCredentails" name="frm_loginCredentails"
                            enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">User Name: <span class="asterisk text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="" id="login_username"
                                    name="login_username" autocomplete="off" value="" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password: <span class="asterisk text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control " autocomplete="off"
                                        id="login_password" name="login_password" value="" />
                                    <span class="input-group-text" id="basic-addon1"><i class="lni lni-eye"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password: <span
                                        class="asterisk text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control " autocomplete="off"
                                        id="login_confirm_password" name="login_confirm_password" value="" />
                                    <span class="input-group-text" id="basic-addon2"><i class="lni lni-eye"></i></span>
                                </div>
                            </div>
                            <input type="checkbox" id="showPassword"> Show Password

                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal"
                    id="btn_login_close">Close</button>
                <button type="button" class="btn btn-primary" id="btn_login_set">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

    function loadLoginData(){
        $.ajax({
            url: '<?= ROOT_DIR ?>/ajax/save_login_credentials.php',
            type: 'POST',
            dataType: 'json',
            data: {
                mode: 'show',
                user_id: '<?= $login_user_id ?>',
                user_type: '<?= $login_user_type ?>'
            },
            success: function (res) {
                if (res.success) {
                    // Populate the modal fields with user data
                    $('#login_username').val(res.user_data.user_name);
                    $('#login_password').val(res.user_data.password);
                    $('#login_confirm_password').val(res.user_data.password);
                } else {
                    // alert(res.message || 'Unable to fetch user data.');
                }
            },
            error: function () {
                alert('An error occurred while fetching user details.');
            }
        });
    }
    // When modal is shown, load login credentials
    $('#login_credentials_Modal').on('shown.bs.modal', function () {
            loadLoginData();
    });

    // Show password toggle
    document.getElementById('showPassword').addEventListener('change', function () {
        var passwordField = document.getElementById('login_password');
        var confirmPasswordField = document.getElementById('login_confirm_password');

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

    $('#btn_login_set').on('click', function () {
        const username = $('#login_username').val().trim();
        const password = $('#login_password').val().trim();
        const confirmPassword = $('#login_confirm_password').val().trim();
        const alertBox = $('#login_alert_box');

        function showAlert(message, type = 'danger') {
            alertBox
                .removeClass('d-none alert-danger alert-success')
                .addClass('alert alert-' + type)
                .html(message);
        }

        // Basic validation
        if (username === '' || password === '' || confirmPassword === '') {
            showAlert('All fields are required.');
            return;
        }

        if (password !== confirmPassword) {
            showAlert('Passwords do not match.');
            return;
        }

        $.ajax({
            url: '<?= ROOT_DIR ?>/ajax/save_login_credentials.php',
            type: 'POST',
            dataType: 'json',
            data: {
                mode: 'register',
                user_id: '<?= $login_user_id ?>',
                user_type: '<?= $login_user_type ?>',
                login_username: username,
                login_password: password
            },
            success: function (res) {
                // showAlert(res.message, res.success ? 'success' : 'danger');
                if (res.success) {
                    location.reload();
                } else {
                    $('#login_username').val('');
                    $('#login_password').val('');
                    $('#login_confirm_password').val('');
                    loadLoginData();
                    showAlert(res.message || 'Unable to save user data.');
                }
            },
            error: function () {
                showAlert('An error occurred while processing your request.');
            }
        });
    });
});

</script>
