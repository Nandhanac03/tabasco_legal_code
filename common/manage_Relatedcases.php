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

    <!-- ACTIVE LEGAL SELECT -->
    <div class="col-md-4">
        <label class="form-label">Active Legal *</label>
        <select class="form-select" id="caseSelect" name="selected_case" required>
            <option value="">Select Active Legal</option>
            <?php 
            if (!empty($array_active_legals)) {
                foreach ($array_active_legals as $ca) { 
                    if ($ca['id'] == $edit_id) continue;
            ?>
                <option 
                    value="<?= $ca['id'] ?>"
                    data-client-id="<?= $ca['client'] ?? '' ?>"
                    data-client-name="<?= htmlspecialchars($ca['client_name'] ?? '') ?>"
                >
                    <?= htmlspecialchars($ca['case_number']) ?>
                </option>
            <?php 
                }
            } 
            ?>
        </select>
    </div>

    <!-- CLIENT (auto-filled on case select) -->
    <div class="col-md-4">
        <label class="form-label">Client *</label>
        <select class="form-select" id="client" name="client_id" required>
            <option value="">Select Client</option>
            <?php if (!empty($array_legal_clients)) { foreach ($array_legal_clients as $cli) { ?>
                <option value="<?= $cli['id'] ?>">
                    <?= htmlspecialchars($cli['name']) ?>
                </option>
            <?php } } ?>
        </select>
    </div>

    <!-- SUBMIT -->
    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-success w-100">
            Save Relation
        </button>
    </div>

    <!-- OPTIONAL: other cases for same client -->
    <div class="col-md-12" id="relatedCasesBox" style="display:none;">
        <label class="form-label">Link Related Cases (Optional)</label>
        <div id="relatedCasesList" class="border p-3"></div>
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
                        <th>Case Num,ber</th>
                        <!-- <th>Main Case</th> -->
                        <th>Related Case</th>
                        <th>Related Client</th>
                        <th>Created By</th>
                        <th>Created On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" class="text-center">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
$(document).ready(function() {

    const active_legal_id = '<?= $edit_id ?>';

    /* ───────── 1. FETCH & DISPLAY related cases ───────── */
    function fetchRelatedCasesList() {
        const tbody = $('#relatedCasesTable tbody');

        $.ajax({
            url: '<?= ROOT_DIR ?>modules/activelegal/ajax/get_related_cases_list.php',
            type: 'GET',
            dataType: 'json',
            data: { active_legal_id: active_legal_id },
            success: function(response) {
                console.log('Related cases response:', response);
                tbody.empty();

                if (response.success && response.data && response.data.length > 0) {

                    response.data.forEach(function(item, index) {

                        // Figure out which side is "this" active legal
                        var mainCode, mainClient, relCode, relClient, caseNumber;

                        if (parseInt(item.case_id) === parseInt(active_legal_id)) {
                            mainCode    = item.main_code      || item.case_id;
                            mainClient  = item.main_client_name || '-';
                            relCode     = item.related_code   || item.related_case_id;
                            relClient   = item.related_client_name || '-';
                            caseNumber  = item.related_case_number || '-';
                        } else {
                            mainCode    = item.related_code   || item.related_case_id;
                            mainClient  = item.related_client_name || '-';
                            relCode     = item.main_code      || item.case_id;
                            relClient   = item.main_client_name || '-';
                            caseNumber  = item.main_case_number || '-';
                        }

                        var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + caseNumber + '</td>' +
                           
                            '<td><span class="badge bg-info">' + relCode + '</span></td>' +
                            '<td>' + relClient + '</td>' +
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
                    tbody.append('<tr><td colspan="8" class="text-center">No related cases found.</td></tr>');
                }
            },
            error: function() {
                tbody.empty().append('<tr><td colspan="8" class="text-center text-danger">Error loading related cases.</td></tr>');
            }
        });
    }

    // Initial load
    if (active_legal_id) {
        fetchRelatedCasesList();
    }

    /* ───────── 2. DELETE a relation ───────── */
    $(document).on('click', '.delete-case-btn', function() {
        var relationId = $(this).data('id');

        if (!confirm('Remove this case relation?')) return;

        $.ajax({
            url:  '<?= ROOT_DIR ?>modules/activelegal/ajax/delete_case.php',
            type: 'POST',
            dataType: 'json',
            data: { case_id: relationId },          // backend reads case_id OR relation_id
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

    /* ───────── 3. SAVE new relation ───────── */
    $('#addRelatedCaseForm').on('submit', function(e) {
        e.preventDefault();

        var case_id       = $('input[name="active_legal_id"]').val();   // current active legal
        var selected_case = $('#caseSelect').val();                      // chosen active legal

        if (!case_id) { alert('Main case missing'); return; }
        if (!selected_case) { alert('Please select a case to link'); return; }

        // Collect IDs to link
        var related_ids = [];

        // Always include the dropdown selection
        related_ids.push(selected_case);

        // Include any optional checkboxes
        $('.relCase:checked').each(function() {
            related_ids.push($(this).val());
        });

        $.ajax({
            url:  '<?= ROOT_DIR ?>modules/activelegal/ajax/quick_add_case.php',
            type: 'POST',
            dataType: 'json',
            data: {
                case_id:          case_id,
                related_case_ids: related_ids
            },
            success: function(res) {
                console.log('Save response:', res);
                if (res.success) {
                    round_success_noti('Relation saved successfully');
                    $('#addRelatedCaseForm')[0].reset();
                    $('#relatedCasesBox').hide();
                    fetchRelatedCasesList();                 // refresh table
                } else {
                    round_error_notify(res.message || 'Failed to save');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                round_error_notify('Server error');
            }
        });
    });

    /* ───────── 4. AUTO-FILL client on case select ───────── */
    $('#caseSelect').on('change', function() {

        var selected = $(this).find(':selected');
        var clientId = selected.data('client-id');
        var caseId   = $(this).val();

        // Auto-select the matching client in dropdown
        if (clientId) {
            $('#client').val(clientId);
        }

        $('#relatedCasesBox').hide();
        if (!caseId) return;

        // Optionally load other active legals for the same client
        $.ajax({
            url:  '<?= ROOT_DIR ?>modules/activelegal/ajax/get_cases_by_client.php',
            type: 'GET',
            dataType: 'json',
            data: {
                client_id:       clientId,
                current_case_id: caseId,
                exclude_id:      active_legal_id        // also exclude current page
            },
            success: function(res) {
                var container = $('#relatedCasesList');
                container.empty();

                if (res.success && res.data && res.data.length > 0) {
                    res.data.forEach(function(c) {
                        container.append(
                            '<div class="form-check">' +
                                '<input type="checkbox" class="form-check-input relCase" value="' + c.id + '">' +
                                '<label class="form-check-label">' + c.case_number + '</label>' +
                            '</div>'
                        );
                    });
                    $('#relatedCasesBox').show();
                }
            }
        });
    });

});
</script>