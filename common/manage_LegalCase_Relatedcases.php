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
                    <input type="hidden" name="main_case_id" value="<?= $edit_id ?>">
                    <div class="row g-3">
                        <!-- LEGAL CASE SELECT -->
                        <div class="col-md-6">
                            <label class="form-label">Search Case Number *</label>
                            <input type="text" class="form-control" id="searchCaseKeyword" placeholder="Type case number to search...">
                            <select class="form-select mt-2" id="caseSelect" name="selected_case" required>
                                <option value="">-- Search and Select Case --</option>
                            </select>
                        </div>

                        <!-- SUBMIT -->
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100">
                                Save Relation
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- TABLE: shows saved relations -->
        <div class="table-responsive mt-3">
            <table class="table align-middle mb-0" id="relatedCasesTable">
                <thead class="table-light">
                    <tr>
                        <th>Sl No</th>
                        <th>Case Number</th>
                        <th>Client</th>
                        <th>Created By</th>
                        <th>Created On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const main_case_id = '<?= $edit_id ?>';

    /* ───────── 1. FETCH & DISPLAY related cases ───────── */
    function fetchRelatedCasesList() {
        const tbody = $('#relatedCasesTable tbody');
        $.ajax({
            url: '<?= ROOT_DIR ?>modules/case/ajax/get_legal_case_relations.php',
            type: 'GET',
            dataType: 'json',
            data: { main_case_id: main_case_id },
            success: function(response) {
                tbody.empty();
                if (response.success && response.data && response.data.length > 0) {
                    response.data.forEach(function(item, index) {
                        var caseNumber = item.related_case_number || '-';
                        var clientName = item.related_client_name || '-';
                        
                        var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><span class="badge bg-info">' + caseNumber + '</span></td>' +
                            '<td>' + clientName + '</td>' +
                            '<td>' + (item.creator_name || '-') + '</td>' +
                            '<td>' + (item.created_on   || '-') + '</td>' +
                            '<td>' +
                                '<button class="btn btn-sm btn-outline-danger delete-case-btn" ' +
                                    'data-id="' + item.relation_id + '" title="Remove">' +
                                    '<i class="lni lni-trash"></i>' +
                                '</button>' +
                            '</td>' +
                        '</tr>';
                        tbody.append(row);
                    });
                } else {
                    tbody.append('<tr><td colspan="6" class="text-center">No related cases found.</td></tr>');
                }
            },
            error: function() {
                tbody.empty().append('<tr><td colspan="6" class="text-center text-danger">Error loading related cases.</td></tr>');
            }
        });
    }

    if (main_case_id) {
        fetchRelatedCasesList();
    }

    /* ───────── 2. SEARCH CASES ───────── */
    $('#searchCaseKeyword').on('keyup', function() {
        let keyword = $(this).val();
        if (keyword.length >= 2) {
            $.ajax({
                url: '<?= ROOT_DIR ?>modules/case/ajax/search_legal_cases.php',
                type: 'GET',
                dataType: 'json',
                data: { keyword: keyword, exclude_id: main_case_id },
                success: function(res) {
                    let select = $('#caseSelect');
                    select.empty();
                    select.append('<option value="">-- Select Case --</option>');
                    if (res.success && res.data) {
                        res.data.forEach(function(c) {
                            select.append('<option value="' + c.id + '">' + c.case_number + ' (Client: ' + c.client_name + ')</option>');
                        });
                    }
                }
            });
        }
    });

    /* ───────── 3. DELETE a relation ───────── */
    $(document).on('click', '.delete-case-btn', function() {
        var relationId = $(this).data('id');
        if (!confirm('Remove this case relation?')) return;

        $.ajax({
            url:  '<?= ROOT_DIR ?>modules/case/ajax/delete_legal_case_relation.php',
            type: 'POST',
            dataType: 'json',
            data: { relation_id: relationId },
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
    });

    /* ───────── 4. SAVE new relation ───────── */
    $('#addRelatedCaseForm').on('submit', function(e) {
        e.preventDefault();
        var selected_case = $('#caseSelect').val();
        if (!selected_case) { alert('Please select a case to link'); return; }

        $.ajax({
            url:  '<?= ROOT_DIR ?>modules/case/ajax/add_legal_case_relation.php',
            type: 'POST',
            dataType: 'json',
            data: {
                main_case_id: main_case_id,
                related_case_id: selected_case
            },
            success: function(res) {
                if (res.success) {
                    round_success_noti('Relation saved successfully');
                    $('#addRelatedCaseForm')[0].reset();
                    $('#caseSelect').empty().append('<option value="">-- Search and Select Case --</option>');
                    fetchRelatedCasesList();
                } else {
                    round_error_notify(res.message || 'Failed to save');
                }
            },
            error: function() {
                round_error_notify('Server error');
            }
        });
    });
});
</script>
