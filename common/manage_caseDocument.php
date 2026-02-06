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
                                <th>Attachment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>



                    <script>
                        const parent_id = '<?= $_GET['param1']; ?>';
                        const list_module = '<?= $_GET['module']; ?>';
                        const list_page = '<?= $_GET['page']; ?>';

                        function fetchAndPopulateTable(ID, moduleIs, pageIs) {

                            const tbody = document.querySelector('#documentTable tbody');
                            tbody.innerHTML = '';

                            fetch(`<?= ROOT_DIR ?>ajax/document_case_list.php?alphabet=list&parent_id=${ID}&list_module=${moduleIs}&list_page=${pageIs}`)
                                .then(res => res.json())
                                .then(({
                                    success,
                                    data
                                }) => {

                                    if (!success) {
                                        tbody.innerHTML = `<tr><td colspan="5" class="text-center">No records</td></tr>`;
                                        return;
                                    }

                                    const caseDocs = data.case_docs || [];
                                    const clientDocs = data.client_docs || [];
                                    let sl = 1;

                                    /* ===== Case Docs (Deletable) ===== */
                                    caseDocs.forEach(doc => {
                                        const row = document.createElement('tr');
                                        row.innerHTML = `
                    <td>${sl++}</td>
                    <td>${doc.document_type_name}</td>
                    <td>${doc.create_on}</td>
                    <td><a href="<?= ROOT_DIR ?>uploads/documents/${doc.name}" target="_blank">View</a></td>
                    <td>
                        <a href="#" class="delete-link text-danger fw-bold">Delete</a>
                    </td>
                `;
                                        row.querySelector('.delete-link')
                                            .addEventListener('click', () => handleDelete(doc.id));
                                        tbody.appendChild(row);
                                    });

                                    /* ===== Client Docs (Read Only) ===== */
                                    clientDocs.forEach(doc => {
                                        const row = document.createElement('tr');
                                        row.classList.add('table-secondary');
                                        row.innerHTML = `
                    <td>${sl++}</td>
                    <td>${doc.document_type_name} <small class="text-muted">(Client)</small></td>
                    <td>${doc.create_on}</td>
                    <td><a href="<?= ROOT_DIR ?>uploads/documents/${doc.name}" target="_blank">View</a></td>
                    <td class="text-muted ">—</td>
                `;
                                        tbody.appendChild(row);
                                    });

                                    if (!sl) {
                                        tbody.innerHTML = `<tr><td colspan="5" class="text-center">No records found</td></tr>`;
                                    }
                                });
                        }

                        /* ===== Delete ===== */
                        function handleDelete(id) {
                            if (!confirm('Delete this document?')) return;

                            fetch(`<?= ROOT_DIR ?>ajax/document_case_list.php?alphabet=delete&id=${id}&parent_id=${parent_id}&list_module=${list_module}&list_page=${list_page}`, {
                                    method: 'POST'
                                })
                                .then(res => res.json())
                                .then(resp => {
                                    if (resp.success) {
                                        alert('Deleted successfully');
                                        fetchAndPopulateTable(parent_id, list_module, list_page);
                                    } else {
                                        alert(resp.message);
                                    }
                                });
                        }

                        document.addEventListener('DOMContentLoaded', () => {
                            fetchAndPopulateTable(parent_id, list_module, list_page);
                        });
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