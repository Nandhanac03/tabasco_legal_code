

<div class="card">
    <div class="card-header">
        <h6 class="mb-0"><i class="fadeIn animated bx bx-plus"></i> Add Defender</h6>

    </div>
    <div class="card-body">
        <form class="row g-3" action="" id="frm_addDefender" name="frm_addDefender" method="post"
            enctype="multipart/form-data">

            <div class="col-6">
                <label class="form-label">Name <span class="asterisk text-danger">*</span></label>
                <input type="text" class="form-control" id="DefenderName" name="DefenderName" value=""
                    autocomplete="off" />
            </div>
            <div class="col-6">
                <label class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="DefenderNo" name="DefenderNo" value="" autocomplete="off" />
            </div>

            <div class="col-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="DefenderEmail" name="DefenderEmail" value=""
                    autocomplete="off" />
            </div>
           
            <div class="mb-3">

                <div id="response"></div>
                <button type="button" class="btn btn-primary px-5" id="btnAdd" name="btnAdd"><i
                        class="fadeIn animated bx bx-plus"></i> Add</button>
                <button type="reset" class="btn btn-secondary px-5" id="btnReset" name="btnReset">Reset</button>
            </div>
            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>"
                readonly="true" />
            <input type="hidden" id="hid_module" name="hid_module" value="<?= $_GET['module']; ?>" readonly="true" />
            <input type="hidden" id="hid_page" name="hid_page" value="<?= $_GET['page']; ?>" readonly="true" />
            <input type="hidden" id="hid_parentID" name="hid_parentID" value="<?= $_GET['param1']; ?>"
                readonly="true" />
        </form>


    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="mb-0"><i class="lni lni-menu"></i> View Defender</h6>

    </div>
    <div class="card-body">
        <div class="mb-3">

        <div class="table-responsive mt-3">
    <table class="table align-middle mb-0" id="DefenderTable">
        <thead class="table-light">
            <tr>
                <th>Sl No</th>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Email</th>
               
                <th></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<!-- This is listin Scrip -->
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
    function fetchAndPopulateTable(ID,moduleIs,pageIs) {
        const tbody = document.querySelector('#DefenderTable tbody');
        tbody.innerHTML = '';

        const url = `<?= ROOT_DIR ?>ajax/load_defender.php?alphabet=list&parent_id=${ID}&list_module=${moduleIs}&list_page=${pageIs}`;

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(({ success, data }) => {
                console.log('✅ Fetched Data:', data);

                if (!success || !data.length) {
                    tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;">No records found.</td></tr>`;
                    return;
                }

                data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
          <td>${index + 1}</td>
          <td>${item.name ?? '-'}</td>
          <td>${item.contact_number ?? '-'}</td>
          <td>${item.email ?? '-'}</td>
        
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
        if (!confirm('Are you sure you want to delete this record?')) return;

        fetch(`<?= ROOT_DIR ?>ajax/load_defender.php?alphabet=delete&id=${id}&parent_id=${<?= $_GET['param1']; ?>}&list_module=${'<?= $_GET['module']; ?>'}&list_page=${'<?= $_GET['page']; ?>'}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id }),
        })
            .then(response => response.json())
            .then(({ success, message }) => {
                if (success) {
                    console.log(message);
                    alert('✅ Defender deleted successfully.');
                    fetchAndPopulateTable(parent_id,list_module,list_page); // Refresh table
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
    document.addEventListener('DOMContentLoaded', fetchAndPopulateTable(parent_id,list_module,list_page));
</script>

        </div>
    </div>
</div>


<!-- This is Adding Script -->
<script>
$(document).ready(function () {
    $("#btnAdd").click(function (e) {
        e.preventDefault(); // Prevent accidental form submisson

        var $btn = $(this);
        var $form = $("#frm_addDefender"); 
        var formData = new FormData($form[0]);

        // Get values for the table refresh function later
        var parent_id = $form.find("input[name='hid_parentID']").val();
        var list_module = $form.find("input[name='hid_module']").val();
        var list_page = $form.find("input[name='hid_page']").val();

        // Update button UI
        $btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');

        $.ajax({
            url: '<?= ROOT_DIR ?>/ajax/add_defender.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                $("#response").html('<div class="text-info">Processing...</div>');
            },
            success: function (response) {
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
                    </div>
                `);

                if (response.status === 'success') {
                    // Reset form only on success
                    $form.trigger("reset");
                    // Refresh table
                    if (typeof fetchAndPopulateTable === "function") {
                        fetchAndPopulateTable(parent_id, list_module, list_page);
                    }
                }

                setTimeout(() => {
                    $(".alert").fadeOut("slow", function () { $(this).remove(); });
                }, 3000);
            },
            error: function (xhr) {
                console.error(xhr.responseText); // Check console if JSON fails
                $("#response").html(`
                    <div class="alert alert-danger py-2">
                        <div class="text-white">A server error occurred. Please check console for details.</div>
                    </div>
                `);
            },
            complete: function () {
                // Re-enable button
                $btn.prop("disabled", false).html('<i class="fadeIn animated bx bx-plus"></i> Add');
            }
        });
    });
});
</script>