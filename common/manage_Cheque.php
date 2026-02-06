<form class="row g-3" action="" id="frm_addCheque" name="frm_addCheque" method="post" enctype="multipart/form-data">
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0"><i class="lni lni-text-align-justify"></i> Cheque details</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label"></label>
                <input class="form-check-input" type="radio" name="chequeAdd" id="flexRadioDefault1" value="1" checked>
                <label class="form-check-label" for="flexRadioDefault1">With Cheque</label>
                <input class="form-check-input" type="radio" name="chequeAdd" id="flexRadioDefault2" value="2">
                <label class="form-check-label" for="flexRadioDefault2">Without Cheque</label>
            </div>

            <div class="mb-3">
                <label class="form-label">Cheque Date: <span class="asterisk text-danger">*</span></label>
                <input type="date" name="cheque_date" id="cheque_date" class="form-control" autocomplete="off" />
            </div>

            <div class="mb-3">
                <label class="form-label">Cheque Number: <span class="asterisk text-danger">*</span></label>
                <input type="text" name="cheque_number" id="cheque_number" class="form-control" autocomplete="off" />
            </div>

            <div class="mb-3">
                <label class="form-label">Bank: <span class="asterisk text-danger">*</span></label>
                <input type="text" name="cheque_bank" id="cheque_bank" class="form-control" autocomplete="off" />
            </div>

            <div class="mb-3">
                <label class="form-label">Bounced Date: </label>
                <input type="date" name="cheque_bounced_date" id="cheque_bounced_date" class="form-control" autocomplete="off" />
            </div>

            <div class="mb-3">
                <label class="form-label"><span id="span_amount_label">Outstanding</span>: <span class="asterisk text-danger">*</span></label>
                <input type="number" name="cheque_amount" id="cheque_amount" class="form-control" placeholder="Outstanding " min="0" step="0.01" autocomplete="off" />
            </div>

            <div class="mb-3">
                <label class="form-label">Upload cheque: <span class="asterisk text-danger">*</span></label>
                <input type="file" name="cheque_file" id="cheque_file" class="form-control" accept=".jpg,.jpeg,.png,.pdf" />
            </div>

            <div id="response"></div>

            <div class="mb-3">
                <button class="btn btn-primary btn-sm" type="button" id="btn_Cheque" name="btn_Cheque"><i class="fadeIn animated bx bx-plus"></i> Add Cheque details</button>


            </div>

            <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" readonly />
            <input type="hidden" id="hid_module" name="hid_module" value="<?= $_GET['module']; ?>" readonly />
            <input type="hidden" id="hid_page" name="hid_page" value="<?= $_GET['page']; ?>" readonly />
            <input type="hidden" id="hid_parentID" name="hid_parentID" value="<?= $_GET['param1']; ?>" readonly />
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0"><i class="lni lni-indent-increase"></i> <span id="outstanding_cheque_heading"></span></h6>
        </div>
        <div class="card-body">
            <div id="responseMessage" class="mt-3"></div>
            <div class="mb-3">
                <div class="table-responsive mt-3">
                    <table class="table align-middle mb-0" id="chequeTable">
                        <thead class="table-light">
                            <tr>
                                <td class="text-center">Sl No</td>
                                <td class="text-center">Date</td>
                                <td class="text-center">Outstanding</td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="Rwo_nodata_msg" style="display: none;">
                                <td colspan="5" class="text-center">No cheque data available.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    const parent_id = '<?= $_GET['param1']; ?>';
    const list_module = '<?= $_GET['module']; ?>';
    const list_page = '<?= $_GET['page']; ?>';

    const radios = document.querySelectorAll('input[name="chequeAdd"]');
    const button = document.getElementById('btn_Cheque');

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === "1") {
                button.innerHTML = '<i class="fadeIn animated bx bx-plus"></i> Add Cheque details';
            } else {
                button.innerHTML = '<i class="fadeIn animated bx bx-plus"></i> Add Payment details';
            }
        });
    });

    const formatDateDMY = (dateString) => {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return `${String(date.getDate()).padStart(2, '0')}-${String(date.getMonth() + 1).padStart(2, '0')}-${date.getFullYear()}`;
    };

    function fetchAndPopulateChequeTable(ID, moduleIs, pageIs) {
        if (ID != '' && moduleIs != '' && pageIs != '') {
            document.querySelector("#chequeTable tbody").textContent = "";

            const selectedChequeType = $('input[name="chequeAdd"]:checked').val();

            fetch(`<?= ROOT_DIR ?>ajax/load_cheque.php?alphabet=list&parent_id=${ID}&list_module=${moduleIs}&list_page=${pageIs}&selectedChequeType=${selectedChequeType}`)
                .then(res => res.json())
                .then(({
                    success,
                    data
                }) => {
                    const tbody = document.querySelector("#chequeTable tbody");
                    $("#Rwo_nodata_msg").hide();

                    if (!success || !Array.isArray(data) || data.length === 0) {
                        $("#Rwo_nodata_msg").show();
                        return;
                    }

                    tbody.textContent = "";
                    data.forEach((item, index) => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                        <td class="text-center">${index + 1}</td>
                        <td class="text-center">${formatDateDMY(item.upload_date)}</td>
                        <td class="text-center">${item.amount || '-'}</td>
                        <td class="text-center">
                            ${item.cheque_name ? `<a href="<?= ROOT_DIR ?>uploads/all_cheque/${item.cheque_name}" target="_blank">View</a>` : '-'}
                        </td>
                        <td class="text-center">
                            ${item.id ? `<a href="#" class="delete-link" data-id="${item.id}" style="color: red; font-weight: bold;">Delete</a>` : '-'}
                        </td>`;
                        tbody.appendChild(row);
                    });
                })
                .catch(err => {
                    console.error("Error:", err);
                    alert("❌ Failed to load cheque data.");
                });
            loadTotal(ID, moduleIs);
        } else {
            document.querySelector("#chequeTable tbody").innerHTML = '<tr id="Rwo_nodata_msg"><td colspan="5" class="text-center">No cheque data available.</td></tr>';
        }


    }

    document.querySelector("#chequeTable tbody").addEventListener("click", function(e) {
        if (e.target.classList.contains("delete-link")) {
            e.preventDefault();
            const id = e.target.dataset.id;
            if (!confirm("Are you sure you want to delete this cheque?")) return;

            e.target.textContent = "Deleting...";
            e.target.style.pointerEvents = "none";

            fetch(`<?= ROOT_DIR ?>ajax/load_cheque.php?alphabet=delete&id=${id}&parent_id=<?= $_GET['param1']; ?>&list_module=<?= $_GET['module']; ?>&list_page=<?= $_GET['page']; ?>`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id
                    })
                })
                .then(res => res.json())
                .then(({
                    success,
                    message
                }) => {
                    if (success) {
                        e.target.closest("tr")?.remove();
                        alert("✅ Cheque deleted.");
                        fetchAndPopulateChequeTable(parent_id, list_module, list_page);
                    } else {
                        alert("❌ Delete failed: " + message);
                        e.target.textContent = "Delete";
                        e.target.style.pointerEvents = "auto";
                    }
                })
                .catch(() => {
                    alert("❌ Error occurred.");
                    e.target.textContent = "Delete";
                    e.target.style.pointerEvents = "auto";
                });
        }
    });

    function toggleChequeFields() {
        const withCheque = document.getElementById('flexRadioDefault1').checked;
        const chequeDate = document.getElementById('cheque_date');
        const chequeAmount = document.getElementById('cheque_amount');
        const chequeFile = document.getElementById('cheque_file');
        const chequeNnumber = document.getElementById('cheque_number');
        const chequeBank = document.getElementById('cheque_bank');
        const chequeBouncedDate = document.getElementById('cheque_bounced_date');


        //outstanding_cheque_heading 


        if (withCheque == true) {
            document.getElementById('outstanding_cheque_heading').textContent = "Outstanding with cheque List";
        } else if (withCheque == false) {
            document.getElementById('outstanding_cheque_heading').textContent = "Outstanding without cheque List";
        }

        chequeDate.disabled = !withCheque;
        chequeFile.disabled = !withCheque;
        chequeAmount.disabled = false;

        chequeDate.closest('.mb-3').style.display = withCheque ? 'block' : 'none';
        chequeFile.closest('.mb-3').style.display = withCheque ? 'block' : 'none';
        chequeNnumber.closest('.mb-3').style.display = withCheque ? 'block' : 'none';
        chequeBank.closest('.mb-3').style.display = withCheque ? 'block' : 'none';
        chequeBouncedDate.closest('.mb-3').style.display = withCheque ? 'block' : 'none';
        

    }

    document.addEventListener('DOMContentLoaded', function() {
        fetchAndPopulateChequeTable(parent_id, list_module, list_page);
        toggleChequeFields();

        document.querySelectorAll('input[name="chequeAdd"]').forEach(radio => {
            radio.addEventListener("change", function() {
                toggleChequeFields();
                fetchAndPopulateChequeTable(parent_id, list_module, list_page);
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#btn_Cheque').on('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('frm_addCheque');
            const formData = new FormData(form);
            const parent_id = parseInt(formData.get('hid_parentID')) || 0;

            const selectedChequeType = $('input[name="chequeAdd"]:checked').val();
            formData.append('cheque_type', selectedChequeType);

            if (parent_id > 0) {
                $.ajax({
                    url: '<?= ROOT_DIR ?>/ajax/add_cheque.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        const isSuccess = response.status === 'success';
                        const alertClass = isSuccess ? 'bg-success' : 'bg-danger';
                        const icon = isSuccess ? 'checkmark-circle-sharp' : 'close-circle-sharp';

                        $("#response").html(`
                            <div class="alert alert-dismissible fade show py-2 ${alertClass}">
                                <div class="d-flex align-items-center">
                                    <div class="fs-3 text-white"><ion-icon name="${icon}"></ion-icon></div>
                                    <div class="ms-3"><div class="text-white">${response.message}</div></div>
                                </div>
                            </div>
                        `);

                        if (isSuccess) {
                            $('#frm_addCheque')[0].reset();
                            document.getElementById(`flexRadioDefault${selectedChequeType}`).checked = true;
                            toggleChequeFields();
                            fetchAndPopulateChequeTable(parent_id, list_module, list_page);


                        }

                        setTimeout(() => $(".alert").fadeOut("slow", function() {
                            $(this).remove();
                        }), 5000);
                    },
                    error: function(xhr) {
                        console.error("XHR Error:", xhr.responseText);
                        $("#response").html(`
                            <div class="alert alert-dismissible fade show py-2 bg-danger">
                                <div class="d-flex align-items-center">
                                    <div class="fs-3 text-white"><ion-icon name="close-circle-sharp"></ion-icon></div>
                                    <div class="ms-3"><div class="text-white">An error occurred during adding.</div></div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        `);
                        setTimeout(() => $(".alert").fadeOut("slow", function() {
                            $(this).remove();
                        }), 5000);
                    }
                });
            } else {
                $('#responseMessage').html(`
                    <div class="alert alert-danger" id="alertMessage">
                        Please fill out and save the client profile information before adding cheque details.
                    </div>
                `);
                setTimeout(() => $('#alertMessage').fadeOut('slow', function() {
                    $(this).remove();
                }), 10000);
            }
        });
    });

    function loadTotal(parent_id, list_module) {

        $('#outstanding_cheque').val(0.00);
        $('#outstanding_without_cheque').val(0.00);
        $('#total_outstanding').val(0.00);

        if (parent_id !== '') {
            $.ajax({
                url: '<?= ROOT_DIR ?>ajax/load_cheque.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    alphabet: 'loadTotal',
                    parent_id: parent_id,
                    list_module: list_module
                },
                success: function(response) {
                    console.log("Total response:", response);
                    if (response.success) {
                        $('#outstanding_cheque').val(response.Total1);
                        $('#outstanding_without_cheque').val(response.Total2);

                        const cheque = parseFloat(response.Total1) || 0;
                        const withoutCheque = parseFloat(response.Total2) || 0;

                        $('#total_outstanding').val((cheque + withoutCheque).toFixed(2));
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }
    }
</script>