

<div class="card">
    <div class="card-header">
        <h6 class="mb-0"><i class="fadeIn animated bx bx-plus"></i> Add Contact</h6>

    </div>
    <div class="card-body">
        <form class="row g-3" action="" id="frm_addContact" name="frm_addContact" method="post"
            enctype="multipart/form-data">

            <div class="col-6">
                <label class="form-label">Name <span class="asterisk text-danger">*</span></label>
                <input type="text" class="form-control" id="contactName" name="contactName" value=""
                    autocomplete="off" />
            </div>
            <div class="col-6">
                <label class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contactNo" name="contactNo" value="" autocomplete="off" />
            </div>

            <div class="col-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="contactEmail" name="contactEmail" value=""
                    autocomplete="off" />
            </div>
            <div class="col-6">
                <label class="form-label">Designation</label>
                <input type="email" class="form-control" id="contactDesignation" name="contactDesignation" value=""
                    autocomplete="off" />
            </div>

            <div class="col-12">
                <label class="form-label">Visiting Card</label>
                <input type="file" class="form-control" id="contactVisitingCard" name="contactVisitingCard" value=""
                    autocomplete="off" />
                <small class="text-muted"><?= VALIDATION_UPLOAD_VISITING_CARD ?></small>
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
        <h6 class="mb-0"><i class="lni lni-menu"></i> View Contact</h6>

    </div>
    <div class="card-body">
        <div class="mb-3">

        <div class="table-responsive mt-3">
    <table class="table align-middle mb-0" id="contactTable">
        <thead class="table-light">
            <tr>
                <th>Sl No</th>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Designation</th>
                <th>Visiting Card</th>
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
        const tbody = document.querySelector('#contactTable tbody');
        tbody.innerHTML = '';

        const url = `<?= ROOT_DIR ?>ajax/load_contact.php?alphabet=list&parent_id=${ID}&list_module=${moduleIs}&list_page=${pageIs}`;

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
          <td>${item.profession ?? '-'}</td>
          <td>${item.visiting_card ? `<a href="<?=ROOT_DIR?>uploads/visiting_card/${item.visiting_card}" target="_blank">View Card</a>` : '-'}</td>
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

        fetch(`<?= ROOT_DIR ?>ajax/load_contact.php?alphabet=delete&id=${id}&parent_id=${<?= $_GET['param1']; ?>}&list_module=${'<?= $_GET['module']; ?>'}&list_page=${'<?= $_GET['page']; ?>'}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id }),
        })
            .then(response => response.json())
            .then(({ success, message }) => {
                if (success) {
                    console.log(message);
                    alert('✅ Contact deleted successfully.');
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
            // Call the function when the DOM is fully loaded
            $(document).ready(function () {
                $("#btnAdd").click(function () {
                    var $btn = $(this); // Cache button reference
                    var $form = $("#frm_addContact"); // Cache form reference
                    var formData = new FormData($form[0]);
                    $btn.prop("disabled", true).html('<i class="spinner-border spinner-border-sm"></i> Saving...');

                    $.ajax({
                        url: '<?= ROOT_DIR ?>/ajax/add_contact.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function () {
                            $("#response").html('Saving...');
                        },
                        success: function (response) {
                            console.log(response);
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
                            // <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            // ✅ Call fetchAndPopulateTable() to refresh the table after a successful upload
                            if (response.status === 'success') {
                                fetchAndPopulateTable(parent_id,list_module,list_page);
                            }
                            // Hide alert after 3 seconds
                            setTimeout(() => {
                                $(".alert").fadeOut("slow", function () {

                                    //location.reload();
                                    $(this).remove();

                                });
                            }, 3000);
                        },
                        error: function (xhr) {
                            console.log(response);

                            $("#response").html(`
                <div class="alert alert-dismissible fade show py-2 bg-danger">
                    <div class="d-flex align-items-center">
                        <div class="fs-3 text-white">
                            <ion-icon name="close-circle-sharp"></ion-icon>
                        </div>
                        <div class="ms-3">
                            <div class="text-white">An error occurred during adding.</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);

                            // Hide alert after 5 seconds
                            setTimeout(() => {
                                $(".alert").fadeOut("slow", function () {
                                    $(this).remove();
                                });
                            }, 5000);
                        },
                        complete: function () {
                            // Re-enable button and reset text
                            $btn.prop("disabled", false).html('<i class="fadeIn animated bx bx-plus"></i> Add');

                            // ✅ Reset the form after processing
                            $form.trigger("reset");
                        }
                    });

                });
            });



            document.getElementById('contactVisitingCard').addEventListener('change', function () {
  const file = this.files[0];
  const maxSize = 1 * 1024 * 1024; // 1MB
  const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
  const alertClass = 'bg-danger';
  const alertMsg = '❌ Upload failed: File size exceeds 1MB or file type is not allowed (JPG, PNG, PDF).';

  if (file) {
    // ✅ Check file size
    if (file.size > maxSize) {
      alert('❌ File size exceeds 1MB. Please select a smaller file.');
      this.value = ''; // Clear the input
      return;
    }

    // ✅ Check file type using MIME type
    if (!allowedTypes.includes(file.type)) {
      alert('❌ Invalid file type. Only JPG, PNG, and PDF files are allowed.');
      this.value = ''; // Clear the input
      return;
    }

    // 🎉 If both checks pass
    console.log('✅ File is valid:', file.name);
  }
});

        </script>