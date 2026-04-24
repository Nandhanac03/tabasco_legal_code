
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
                            <li class="breadcrumb-item active" aria-current="page">Set Permission</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Back Button on the Right -->
            <!-- Back Button on the Right -->
            <div>
                <button id="permission-permission-back-button-client" class="btn btn-secondary">
                    <ion-icon name="arrow-back-outline"></ion-icon> Back
                </button>

                <script>
                    document.getElementById('permission-permission-back-button-client').addEventListener('click', function () {
                        window.history.back();
                    });
                </script>
            </div>
        </div>

        <!--end breadcrumb-->



        <div class="row">
            <div class="col col-lg-12 mx-auto">

                <div class="card-header py-2">
                    <div class="d-flex justify-content-end">
                        <address class="m-0">
                            <h5>User : <?= $array_UserData['user_name'] ?> (<?= $array_UserData['usertype_title'] ?>)</h5>
                        </address>
                    </div>
                </div>



                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive mt-3">
<form id="permissionsForm">
   <table class="table table-bordered align-middle text-center">
<thead class="table-secondary align-middle">
    <!-- Check/Uncheck All Row -->
    <tr>
        <th colspan="2" class="text-end pe-3">
            <span class="fw-semibold text-dark">Check / Uncheck All</span>
        </th>
        <th colspan="6" class="text-center">
            <div class="form-check form-switch d-inline-flex align-items-center gap-2">
                <input class="form-check-input fs-5" type="checkbox" id="checkAllPermissions">
                <label class="form-check-label fw-semibold" for="checkAllPermissions">All Permissions</label>
            </div>
        </th>
    </tr>

    <!-- Column Headers -->
    <tr class="text-center">
        <th style="width:5%">#</th>
        <th class="text-start" style="width:25%">Menu</th>
        <th style="width:10%">View</th>
        <th style="width:10%">Add</th>
        <th style="width:15%">Edit / Update</th>
        <th style="width:10%">Delete</th>
        <th style="width:10%">Print</th>
        <th style="width:10%">Email</th>
    </tr>
</thead>

<style>
    /* Default unchecked = red */
    #checkAllPermissions.form-check-input {
        background-color: #dc3545 !important;  /* red */
        border-color: #dc3545 !important;
    }
    /* Checked = green */
    #checkAllPermissions.form-check-input:checked {
        background-color: #28a745 !important;  /* green */
        border-color: #28a745 !important;
    }
</style>

    <tbody>
        <?php if (!empty($array_legal_menu) && is_array($array_legal_menu)): ?>
            <?php $i = 1; foreach ($array_legal_menu as $menu): ?>
                <?php
                    $menu_id = $menu['id'];
                    $grantedActions = $menu_permissions[$menu_id] ?? [];
//                     echo"<pre>";
// print_r($array_legal_menu);
// exit;

                    
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td class="text-start"><?= htmlspecialchars($menu['name']) ?></td>

                    <?php
                    $permissionsMap = [
                        'view' => 'V',
                        'add' => 'A',
                        'edit' => 'E',
                        'delete' => 'D',
                        'print' => 'P',
                        'email' => 'M'
                    ];

                    foreach ($permissionsMap as $perm => $letter):
                        $inputId = "{$perm}_{$menu_id}";
                        $isChecked = in_array($letter, $grantedActions);
                    ?>
                        <td>
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input class="form-check-input permission-checkbox"
                                       type="checkbox"
                                       id="<?= htmlspecialchars($inputId) ?>"
                                       data-user-id="<?= htmlspecialchars($edit_id) ?>"
                                       data-menu-id="<?= htmlspecialchars($menu_id) ?>"
                                       data-permission="<?= htmlspecialchars($letter) ?>"
                                       <?= $isChecked ? 'checked' : '' ?>>
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php $i++; endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>


</form>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page content-->
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    // ✅ Single checkbox change (existing logic + sync master checkbox)
    $('.permission-checkbox').on('change', function () {
        const menuId = $(this).data('menu-id');
        const userId = $(this).data('user-id');
        const permission = $(this).data('permission');
        const isChecked = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: '<?= ROOT_DIR ?>modules/permission/ajax/save_permissions.php',
            method: 'POST',
            data: {
                menu_id: menuId,
                user_id: userId,
                permission: permission,
                value: isChecked
            },
            success: function (response) {
                console.log('Saved:', response);
            },
            error: function (xhr) {
                console.error('Error saving:', xhr.responseText);
            }
        });

        // 🔹 Sync master checkbox
        if ($('.permission-checkbox:checked').length === $('.permission-checkbox').length) {
            $('#checkAllPermissions').prop('checked', true);
        } else {
            $('#checkAllPermissions').prop('checked', false);
        }
    });

    // ✅ Master bulk check/uncheck
    $('#checkAllPermissions').on('change', function () {
        const isChecked = $(this).is(':checked') ? 1 : 0;
        $('.permission-checkbox').prop('checked', isChecked);

        // Collect all permissions in one array
        let bulkData = [];
        $('.permission-checkbox').each(function () {
            bulkData.push({
                menu_id: $(this).data('menu-id'),
                user_id: $(this).data('user-id'),
                permission: $(this).data('permission'),
                value: isChecked
            });
        });

        // Show status
        const $status = $('<div id="bulk-status" style="color:red; font-weight:bold; margin:10px 0;">Saving, please wait...</div>');
        if ($('#bulk-status').length === 0) {
            $('.table-responsive').prepend($status);
        } else {
            $('#bulk-status').text("Saving, please wait...");
        }

        // Send bulk AJAX
        $.ajax({
            url: '<?= ROOT_DIR ?>modules/permission/ajax/save_permissions_bulk.php',
            method: 'POST',
            data: { bulk: JSON.stringify(bulkData) },
            success: function (response) {
                console.log('Bulk saved:', response);

                let countdown = 2;
                $('#bulk-status')
                  .css("color", "green")
                  .html("✅ Permissions saved successfully! <br> 🔄 Page will reload in <span id='reload-timer'>" + countdown + "</span> seconds...");

                // Countdown + reload
                let timer = setInterval(() => {
                    countdown--;
                    $('#reload-timer').text(countdown);
                    if (countdown <= 0) {
                        clearInterval(timer);
                        location.reload();
                    }
                }, 1000);
            },
            error: function (xhr) {
                $('#bulk-status').css("color", "red").text("❌ Error saving permissions!");
                console.error('Bulk error:', xhr.responseText);
            }
        });
    });

    // ✅ On page load, set master checkbox state correctly
    if ($('.permission-checkbox:checked').length === $('.permission-checkbox').length) {
        $('#checkAllPermissions').prop('checked', true);
    } else {
        $('#checkAllPermissions').prop('checked', false);
    }
  });
</script>
