<div class="card">
    <div class="card-header">
        <h6 class="mb-0"><i class="lni lni-radio-button"></i> Upload Document</h6>

    </div>
    <div class="card-body">
        <form action="" id="frm_upload" name="frm_upload" method="post" enctype="multipart/form-data">


            <div class="mb-3">
                <label class="form-label">Document Types: <span class="asterisk text-danger">*</span></label>
                <select class="form-select" id="ddl_type" name="ddl_type">
                    <?= generateSelectOptions($array_document_type, '') ?>

                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Upload File: <span class="asterisk text-danger">*</span></label>
                <input type="file" class="form-control" id="filename" name="filename">
                <small class="text-muted"><?= VALIDATION_UPLOAD_VISITING_CARD ?></small>
            </div>

            <div class="mb-3">

                <div id="response"></div>
                <button type="button" class="btn btn-primary px-5" id="btnUpload" name="btnUpload"><i
                        class="lni lni-upload"></i> Upload</button>
                <button type="reset" class="btn btn-secondary px-5" id="btnReset" name="btnReset">Reset</button>
            </div>


            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
        </form>
    </div>
</div>




<div class="card">
    <div class="card-header">
        <h6 class="mb-0"><i class="lni lni-menu"></i> Document List</h6>

    </div>
    <div class="card-body">
        <form>



            <div class="mb-3">
                <div class="table-responsive mt-3">
                    <table class="table align-middle mb-0" id="documentTable">
                        <thead class="table-light">
                            <tr>
                                <th>Sl No</th>
                                <th>Document Type</th>
                                <th>Upload Date</th>
                                <th class="text-center">Attachment</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>



                    <script>
                        const parent_id = '<?= $_GET['param1']; ?>';
                        const list_module = '<?= $_GET['module']; ?>';
                        const list_page = '<?= $_GET['page']; ?>';


                        // Helper function: format date to dd-mm-yyyy
                        const formatDateDMY = (dateString) => {
                            if (!dateString) return '-';
                            const date = new Date(dateString);
                            return `${String(date.getDate()).padStart(2, '0')}-${String(date.getMonth() + 1).padStart(2, '0')}-${date.getFullYear()}`;
                        };

                        // Function to fetch and populate the table
                        function fetchAndPopulateTable(ID, moduleIs, pageIs) {

                            const tbody = document.querySelector('#documentTable tbody');
                            tbody.innerHTML = '';

                            const url = `<?= ROOT_DIR ?>ajax/document_list.php?alphabet=list&parent_id=${ID}&list_module=${moduleIs}&list_page=${pageIs}`;

                            fetch(url)
                                .then(response => {
                                    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                                    return response.json();
                                })
                                .then(({
                                    success,
                                    data
                                }) => {
                                    console.log('✅ Fetched Data:', data);

                                    if (!success || !data.length) {
                                        tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;">No records found.</td></tr>`;
                                        return;
                                    }

                                    data.forEach((item, index) => {
                                        const row = document.createElement('tr');
                                        row.innerHTML = `
          <td>${index + 1}</td>
          <td>${item.document_type_name ?? '-'}</td>
          <td>${item.create_on ?? '-'}</td>
          <td>${item.name ? `<a href="<?= ROOT_DIR ?>uploads/documents/${item.name}" target="_blank">View</a>` : '-'}</td>
          <td>

            <a href="#" class="delete-link"  style="color: red; text-decoration: none; font-weight: bold;">Delete</a>


          </td>
        `;
                                        row.querySelector('.delete-link').addEventListener('click', () => handleDelete(item.id, row));
                                        tbody.appendChild(row);
                                    });
                                })
                                .catch(err => {
                                    console.error('❌ Error fetching document data:', err);
                                    alert('⚠️ Failed to load data. Check console for details.');
                                });
                        }


                        // Function to handle delete
                        function handleDelete(id, row) {
                            if (!confirm('Are you sure you want to delete this record ?')) return;

                            fetch(`<?= ROOT_DIR ?>ajax/document_list.php?alphabet=delete&id=${id}&parent_id=${<?= $_GET['param1']; ?>}&list_module=${'<?= $_GET['module']; ?>'}&list_page=${'<?= $_GET['page']; ?>'}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id: id
                                    }),
                                })
                                .then(response => response.json())
                                .then(({
                                    success,
                                    message
                                }) => {
                                    if (success) {
                                        console.log(message);
                                        alert('✅ Document deleted successfully.');
                                        fetchAndPopulateTable(parent_id, list_module, list_page); // Refresh table
                                    } else {
                                        alert(`❌ Failed to delete: ${message}`);
                                    }
                                })
                                .catch(err => {
                                    console.error('❌ Delete Error:', err);
                                    alert('⚠️ Error occurred while deleting.');
                                });
                        }

                        // Initial load
                        document.addEventListener('DOMContentLoaded', fetchAndPopulateTable(parent_id, list_module, list_page));
                    </script>




                </div>

            </div>

        </form>
    </div>
</div>
<script>
    // Call the function when the DOM is fully loaded


    $(document).ready(function() {
        $("#btnUpload").click(function() {
            var $btn = $(this); // Cache button reference
            var $form = $("#frm_upload"); // Cache form reference
            var formData = new FormData($form[0]);
            var parent_id = <?= $edit_id ?>; // Or fetch from a variable or element
            <?php
            $moduleMap = [
                'client' => 'C',
                'thirdparty' => 'TP',
                'legalfirm' => 'LF',
                'debtcollector' => 'DC',
                'activelegal' => 'AL',
                'case' => 'CA'
            ];
            $parent_type = isset($_GET['module']) && isset($moduleMap[$_GET['module']])
                ? $moduleMap[$_GET['module']]
                : '';
            ?>
            var parent_type = "<?= $parent_type ?>";

            formData.append('parent_id', parent_id);
            formData.append('parent_type', parent_type);
            // Disable button and show loading text
            $btn.prop("disabled", true).html('<i class="spinner-border spinner-border-sm"></i> Uploading...');

            $.ajax({
                url: '<?= ROOT_DIR ?>/ajax/upload_document.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $("#response").html('Uploading...');
                },
                success: function(response) {
                    const alertClass = response.status === 'success' ? 'bg-success' : 'bg-danger';
                    const iconName = response.status === 'success' ? 'checkmark-circle-sharp' : 'close-circle-sharp';

                    $("#response").html(`
                    <div class="alert alert-dismissible fade show py-2 ${alertClass}">
                        <div class="d-flex align-items-center">
                            <div class="fs-3 text-white">
                                <ion-icon name="${iconName}"></ion-icon>
                            </div>
                            <div class="ms-3">
                                <div class="text-white">${response.message}</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);

                    // ✅ Call fetchAndPopulateTable() to refresh the table after a successful upload
                    if (response.status === 'success') {
                        fetchAndPopulateTable(parent_id, list_module, list_page);
                    }
                    // Hide alert after 5 seconds
                    setTimeout(() => {
                        $(".alert").fadeOut("slow", function() {
                            $(this).remove();
                        });
                    }, 5000);
                },
                error: function() {
                    $("#response").html(`
                    <div class="alert alert-dismissible fade show py-2 bg-danger">
                        <div class="d-flex align-items-center">
                            <div class="fs-3 text-white">
                                <ion-icon name="close-circle-sharp"></ion-icon>
                            </div>
                            <div class="ms-3">
                                <div class="text-white">An error occurred during upload.</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);

                    // Hide alert after 5 seconds
                    setTimeout(() => {
                        $(".alert").fadeOut("slow", function() {
                            $(this).remove();
                        });
                    }, 5000);
                },
                complete: function() {
                    // Re-enable button and reset text
                    $btn.prop("disabled", false).html('<i class="lni lni-upload"></i> Upload');

                    // ✅ Reset the form after processing
                    $form.trigger("reset");
                }
            });
        });
    });
</script>