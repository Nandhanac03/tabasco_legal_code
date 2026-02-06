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
<div class="modal fade" id="sharelink_Modal" tabindex="-1" aria-labelledby="sharelink_ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="sharelink_ModalLabel"><i class="lni lni-world"></i>
                    Shareable Link
                    Panel</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="textToCopy" rows="4"><?=SHARE_LINK_FOR_LOGIN?></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="copyTextToClipboard()" >Copy</button>
            </div>
        </div>
    </div>
</div>
<script>
    function showLoginCredentialsModal() {
        // AJAX call to fetch user details for 'show' mode
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
                    let userData    = '<?=SHARE_LINK_FOR_LOGIN?>' + '\n' +'User Name : '+res.user_data.user_name+ '\n' +'Password : '+res.user_data.password;
                    // Populate the modal fields with user data
                    $('#textToCopy').val(userData);

                } else {
                    //alert(res.message || 'Unable to fetch user data.');
                }
            },
            error: function () {
                alert('An error occurred while fetching user details.');
            }
        });
    }

    $(document).ready(function () {

        // Initialize the modal when the document is ready
        $('#sharelink_Modal').on('show.bs.modal', function (event) {
            showLoginCredentialsModal();
        });
    });

function copyTextToClipboard() {
    $("#textToCopy").select();
    document.execCommand('copy');
}

    </script>