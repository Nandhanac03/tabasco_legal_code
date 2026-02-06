
<div class="modal fade" id="lock_unlock_Modal" tabindex="-1" aria-labelledby="lock_unlock_ModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="lock_unlock_ModalLabel"> <?= $data['locked_status'] == 'Y' ? '<i class="fadeIn animated bx bx-lock-open"></i> Unlock' : '<i class="fadeIn animated bx bx-lock"></i> Lock' ?> Panel  </h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h6 class="text-danger ">Do you want to <?= $data['locked_status'] == 'Y' ? 'Unlock' : 'Lock' ?> this <?= !empty($data['name']) ? htmlspecialchars($data['name']) : '-' ?> [<?= !empty($data['code']) ? htmlspecialchars($data['code']) : '-' ?>]
                                </h6>
                            </div>
                            <div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary" id="btn_lock_unlock"><?= $data['locked_status'] == 'Y' ? 'Unlock' : 'Lock' ?></button>
                            </div>
                        </div>
                    </div>
                </div>
<input type="hidden" id="lock_unlock_id" value="<?= !empty($data['id']) ? htmlspecialchars($data['id']) : '' ?>" readonly/>
<input type="hidden" id="updateValue" value="<?= $data['locked_status'] == 'Y' ? 'N' : 'Y' ?>" readonly/>
<script>

$(document).ready(function () {
  $('#btn_lock_unlock').on('click', function () {
    const id = $('#lock_unlock_id').val();
    const newStatus = $('#updateValue').val();
    const moduleIs = '<?= $module ?>'; // Get the current status from PHP

    if(id>0 && moduleIs!=''){
        $.ajax({
      url: '<?= ROOT_DIR ?>/ajax/lock_unlock.php', // Update with your PHP handler
      type: 'POST',
      dataType: 'json',
      data: {
        id: id,
        locked_status: newStatus,
        moduleIs: moduleIs // Pass the current status to the PHP handler
      },
      success: function (response) {
        if (response.success) {
     // alert(response.message); // e.g., "The status was updated to: Locked"
      location.reload(); // Reload the page to reflect changes
    } else {
      alert('Failed: ' + response.message);
    }
      },
      error: function (xhr, status, error) {
        console.error('AJAX Error:', error);
        alert('An error occurred while updating.');
      }
    });
    }else{
        alert('Invalid ID or module status.');
    }


  });
});

</script>