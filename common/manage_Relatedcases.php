<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="lni lni-menu"></i> Related Cases List</h6>
        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#quickAddCaseForm">
            <i class="lni lni-plus"></i> Quick Add Case
        </button>
    </div>
    <div class="card-body">
        <!-- Quick Add Case Form -->
        <div class="collapse mb-4" id="quickAddCaseForm">
            <div class="card card-body bg-light">
                <form id="addRelatedCaseForm">
                    <input type="hidden" name="active_legal_id" value="<?= $edit_id ?>">
                    <div class="row g-3">
                    <div class="col-md-3">
      <label class="form-label">Case No.</label>
      <select class="form-select select2-bootstrap" id="sort_by_case" name="sort_by_case">
        <option value="">Select Case</option>
        <?php foreach ($array_legal_case as $legalCase): ?>
          <option value="<?= $legalCase['id'] ?>" data-client-id="<?= $legalCase['client'] ?>">
            <?= $legalCase['case_number'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
                        <div class="col-md-3">
                            <label class="form-label">Client</label>
                            <select class="form-select" name="clie" required>
                                <option value="">Select</option>
                                <?php foreach ($array_legal_clients as $cat) { echo "<option value='{$cat['id']}'>{$cat['name']}</option>"; } ?>
                            </select>
                        </div>
                     
                        <div class="col-md-3">
                            <label class="form-label">Register Date</label>
                            <input type="date" class="form-control" name="register_date" required>
                        </div>
                      
                   
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100">Save Case</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive mt-3">
            <table class="table align-middle mb-0" id="relatedCasesTable">
                <thead class="table-light">
                    <tr>
                        <th>Sl No</th>
                        <th>Case ID</th>
                        <th>Case Number</th>
                        <th>Client</th>
                        <th>Active Legal Code</th>
                        <th>Case Mode</th>
                        <th>Register Date</th>
                        <th>Created By</th>
                        <th>Linked To</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="10" class="text-center">Loading related cases...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const active_legal_id = '<?= $edit_id ?>';
        
        function fetchRelatedCasesList() {
            const tbody = $('#relatedCasesTable tbody');
            const url = `<?= ROOT_DIR ?>modules/activelegal/ajax/get_related_cases_list.php?active_legal_id=${active_legal_id}`;

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Related cases response:', response);
                    tbody.empty();
                    if (response.success && response.data && response.data.length > 0) {
                        response.data.forEach((item, index) => {
                            const creator = item.creator_name ? item.creator_name : '-';
                            const related = item.related_case_number ? '<span class="badge bg-info">' + item.related_case_number + '</span>' : '-';
                            const editUrl = `<?= ROOT_DIR ?>case/information/edit/${item.id}.html`;
                            const row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.id}</td>
                                    <td>${item.case_number}</td>
                                    <td>${item.client_name}</td>
                                    <td>${item.active_legal_code}</td>
                                    <td>${item.case_mode_title}</td>
                                    <td>${item.register_date}</td>
                                    <td>${creator}</td>
                                    <td>${related}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger delete-case-btn" data-id="${item.id}" title="Delete Case">
                                            <i class="lni lni-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                    } else {
                        tbody.append('<tr><td colspan="10" class="text-center">No related cases found.</td></tr>');
                    }
                },
                error: function() {
                    tbody.empty().append('<tr><td colspan="10" class="text-center text-danger">Error loading related cases.</td></tr>');
                }
            });
        }

        if (active_legal_id) {
            fetchRelatedCasesList();
        }

        $(document).on('click', '.delete-case-btn', function() {
            const caseId = $(this).data('id');
            if (confirm('Are you sure you want to delete this case?')) {
                $.ajax({
                    url: '<?= ROOT_DIR ?>modules/activelegal/ajax/delete_case.php',
                    type: 'POST',
                    data: { case_id: caseId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            round_success_noti(response.message);
                            fetchRelatedCasesList();
                        } else {
                            round_error_notify(response.message);
                        }
                    },
                    error: function() {
                        round_error_notify('Error connecting to server');
                    }
                });
            }
        });

        $('#addRelatedCaseForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const btn = $(this).find('button[type="submit"]');
            
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');
            
            $.ajax({
                url: '<?= ROOT_DIR ?>modules/activelegal/ajax/quick_add_case.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    btn.prop('disabled', false).text('Save Case');
                    if (response.success) {
                        round_success_noti(response.message);
                        $('#addRelatedCaseForm')[0].reset();
                        $('#quickAddCaseForm').collapse('hide');
                        fetchRelatedCasesList();
                    } else {
                        round_error_notify(response.message);
                    }
                },
                error: function() {
                    btn.prop('disabled', false).text('Save Case');
                    round_error_notify('Error connecting to server');
                }
            });
        });
    });
</script>