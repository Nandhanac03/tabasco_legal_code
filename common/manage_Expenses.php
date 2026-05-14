
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="lni lni-revenue"></i> Paid Court Fees & Expenses</h6>
    </div>
    <div class="card-body">
        <div id="ExpenseResponseMessage" class="mt-3"></div>

        <!-- Expense Form -->
        <form id="frm_expense" enctype="multipart/form-data">
            <input type="hidden" name="parent_id" value="<?= $edit_id ?>">
            <input type="hidden" name="module" value="<?= $_GET['module'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Fee Type <span class="text-danger">*</span></label>
                    <select class="form-select" name="fees_type" id="fees_type" required onchange="toggleOtherExpense()">
                        <option value="">Select Fee Type</option>
                        <option value="Court Filing Case fees">Court Filing Case fees</option>
                        <option value="Expert fee">Expert fee</option>
                        <option value="Announcement fee">Announcement fee</option>
                        <option value="Emirates Judgment Enforcement fee (EJE)">Emirates Judgment Enforcement fee (EJE)</option>
                        <option value="Notary Public Fee">Notary Public Fee</option>
                        <option value="Other">Other expense</option>
                    </select>
                </div>
                <div class="col-md-6" id="div_other_expense" style="display:none;">
                    <label class="form-label">Other Expense Reason <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="other_reason" id="other_reason" placeholder="Enter reason">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Amount <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="amount" step="0.01" required placeholder="0.00">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="expense_date" required value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Attachment (Optional)</label>
                    <input type="file" class="form-control" name="attachment">
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-sm btn-primary" onclick="saveExpense()">Add Expense</button>
                </div>
            </div>
        </form>

        <hr>

        <!-- Expense Table -->
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Type/Reason</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Doc</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="expense_table_body">
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function toggleOtherExpense() {
        const feeType = $('#fees_type').val();
        if (feeType === 'Other') {
            $('#div_other_expense').show();
            $('#other_reason').attr('required', true);
        } else {
            $('#div_other_expense').hide();
            $('#other_reason').attr('required', false);
        }
    }

    function saveExpense() {
        const form = document.getElementById('frm_expense');
        const formData = new FormData(form);
        formData.append('action', 'save');

        // Validation
        const amount = formData.get('amount');
        const feeType = formData.get('fees_type');
        if (!feeType || !amount || amount <= 0) {
            alert("Please select fee type and enter a valid amount.");
            return;
        }

        $('#ExpenseResponseMessage').html('<div class="alert alert-info">Saving...</div>');

        $.ajax({
            url: '<?= ROOT_DIR ?>ajax/manage_expense.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#ExpenseResponseMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                    form.reset();
                    $('#div_other_expense').hide();
                    loadExpenses();
                    setTimeout(() => { $('#ExpenseResponseMessage').html(''); }, 3000);
                } else {
                    $('#ExpenseResponseMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function() {
                $('#ExpenseResponseMessage').html('<div class="alert alert-danger">Error saving expense.</div>');
            }
        });
    }

    function loadExpenses() {
        const parentId = '<?= $edit_id ?>';
        const module = '<?= $_GET['module'] ?>';
        if (!parentId) return;

        $.ajax({
            url: '<?= ROOT_DIR ?>ajax/manage_expense.php',
            type: 'POST',
            data: { action: 'list', parent_id: parentId, module: module },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let html = '';
                    response.data.forEach(item => {
                        const docLink = item.document ? `<a href="<?= ROOT_DIR ?>uploads/expenses/${item.document}" target="_blank"><i class="lni lni-download"></i></a>` : '-';
                        html += `
                            <tr>
                                <td>${item.fees_type_title} ${item.description ? '(' + item.description + ')' : ''}</td>
                                <td>${item.amount}</td>
                                <td>${item.date}</td>
                                <td>${docLink}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="deleteExpense(${item.id})"><i class="lni lni-trash"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                    if (response.data.length === 0) {
                        html = '<tr><td colspan="5" class="text-center">No expenses added yet.</td></tr>';
                    }
                    $('#expense_table_body').html(html);
                }
            }
        });
    }

    function deleteExpense(id) {
        if (!confirm("Are you sure you want to delete this expense?")) return;

        $.ajax({
            url: '<?= ROOT_DIR ?>ajax/manage_expense.php',
            type: 'POST',
            data: { action: 'delete', id: id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    loadExpenses();
                } else {
                    alert(response.message);
                }
            }
        });
    }

    $(document).ready(function() {
        loadExpenses();
    });
</script>
