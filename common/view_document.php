<div class="card">
    <div class="card-header">
        <h6 class="mb-0"><i class="lni lni-menu"></i> Document List</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive mt-3">
            <table class="table align-middle mb-0" id="documentTable">
                <thead class="table-light">
                    <tr>
                        <th>Sl No</th>
                        <th>Document Type</th>
                        <th>Upload Date</th>
                        <th class="text-center">Attachment</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
/* ================= GLOBAL VARIABLES ================= */
const parent_id   = "<?= $_GET['param1']; ?>";
const list_module = "<?= $_GET['module']; ?>";
const list_page   = "<?= $_GET['page']; ?>";

/* ================= FETCH & POPULATE TABLE ================= */
function fetchAndPopulateTable(ID, moduleIs, pageIs) {

    const tbody = document.querySelector('#documentTable tbody');
    tbody.innerHTML = '';

    const url = `<?= ROOT_DIR ?>ajax/case_document_list.php?alphabet=list&parent_id=${ID}&list_module=${moduleIs}&list_page=${pageIs}`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}`);
            }
            return response.json();
        })
        .then(({ success, data }) => {

            console.log('✅ Fetched Data:', data);

            if (!success || !data || data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center">No records found.</td>
                    </tr>`;
                return;
            }

            data.forEach((item, index) => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${item.document_type_name ?? '-'}</td>
                    <td>${item.create_on ?? '-'}</td>
                    <td class="text-center">
                        ${item.name
                            ? `<a href="<?= ROOT_DIR ?>uploads/documents/${item.name}" target="_blank">View</a>`
                            : '-'}
                    </td>
                `;

                tbody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('❌ Fetch Error:', error);
            alert('Failed to load documents.');
        });
}

/* ================= INITIAL LOAD ================= */
document.addEventListener('DOMContentLoaded', () => {
    fetchAndPopulateTable(parent_id, list_module, list_page);
});
</script>
