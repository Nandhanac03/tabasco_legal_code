<!-- start page content wrapper-->

<div class="page-content-wrapper">

    <!-- start page content-->

    <div class="page-content">



        <!--start breadcrumb-->

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <div class="breadcrumb-title pe-3">Master</div>

            <div class="ps-3">

                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb mb-0 p-0 align-items-center">

                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>

                        </li>

                        <li class="breadcrumb-item active" aria-current="page">Bank</li>

                    </ol>

                </nav>

            </div>

            <div class="ms-auto ">

                <div class="btn-group">
                    <?php if (LEGAL_AUTH_ADD): ?>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><i class="fadeIn animated bx bx-plus"></i>New Bank</button>
                    <?php endif; ?>
                </div>

            </div>

        </div>

        <!--end breadcrumb-->



        <div class="mb-3" id="alertDiv">



        </div>

        <div class="card">

            <div class="card-body">

                <div class="d-flex align-items-center">

                    <h5 class="mb-0"><i class="lni lni-menu"></i></h5>

                    <form class="ms-auto position-relative">

                        <div class="position-absolute top-50 translate-middle-y search-icon px-3" id="searchIcon"><ion-icon

                                name="search-sharp"></ion-icon></div>

                        <input class="form-control ps-5" type="text" placeholder="search" id="searchBankInput">

                    </form>

                </div>

                <div class="table-responsive mt-3">

                    <table class="table align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>Sl No.</th>

                                <th>Title</th>

                                <th></th>

                            </tr>

                        </thead>

                        <tbody id="listingBankData">

                            <tr>

                                <td colspan='3' style='text-align:center;'>

                                    <p><span class="spinner-border spinner-border" style="width: 1.2rem; height: 1.2rem;" role="status" aria-hidden="true"></span>

                                        Loading Data...</p>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                    <div class="mt-5">

                        <nav class="d-flex justify-content-end align-items-center" aria-label="Page navigation example">

                            <ul class="pagination" id="pagination">



                            </ul>

                        </nav>

                        <input type="hidden" id="curPage" value="1">

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- end page content-->



    <!-- Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel"><i class="fadeIn animated bx bx-plus"></i> Create</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <form>

                        <div class="mb-3">

                            <label class="form-label">Bank name <span class="text-danger">*</span></label>

                            <input type="text" class="form-control" name="title" id="bankTitle">

                            <span class="small text-danger erospan" id="bankTitleError"></span>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" id="mdalClsBtn" data-bs-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary" id="saveBankBtn">Save </button>

                </div>

            </div>

        </div>

    </div>



    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">Update Bank</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <form>

                        <div class="mb-3">

                            <label class="form-label">Bank name<span class="text-danger">*</span></label>

                            <input type="text" class="form-control" value="" id="editBankTitle">

                            <span class="small text-danger erospan" id="bankEditTitleError"></span>

                            <input type="hidden" class="form-control" value="" id="editBankId">

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="mdalEditClsBtn">Close</button>

                    <button type="button" class="btn btn-primary" id="updateBankBtn">Update</button>

                </div>

            </div>

        </div>

    </div>



    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="deleteModalLabel">Delete Bank</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalDelClsBtn"></button>

                </div>

                <div class="modal-body">

                    <form>

                        <div class="mb-3">

                            <label class="form-label">Are you sure want to delete <span id="deleteBankTitle"></span>?</label>

                            <input type="hidden" class="form-control" value="" id="deleteBankId">

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" id="deleteBankBtn"><i class="lni lni-trash"></i></button>

                </div>

            </div>

        </div>

    </div>

</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    $(document).ready(function() {

        loadBank();

        $("#editModal").on('show.bs.modal', function(event) {

            let button = $(event.relatedTarget);

            let bankId = button.data('bank_id');

            let bankTitle = button.data('bank_name');



            let editModal = $(this)

            editModal.find("#editBankId").val(bankId)

            editModal.find("#editBankTitle").val(bankTitle)

        })



        $("#deleteModal").on('show.bs.modal', function(event) {

            let button = $(event.relatedTarget);

            let bankId = button.data('bank_id');

            let bankTitle = button.data('bank_name');



            let deleteModal = $(this)

            deleteModal.find("#deleteBankId").val(bankId)

            deleteModal.find("#deleteBankTitle").html(`<b>${bankTitle}</b>`)

        })

    })





    function loadBank(search = '', pageNo = 1) {

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/master/ajax/bank.php',

            data: {
                module: 'master',
                page: 'bank',
                method: 'bankListing',

                search,

                pageNo

            },

            success: function(response) {

                if (response != '') {

                    $("#listingBankData").html(response.html);

                    loadPagination(response.bank_count);

                }

            }

        })

    }





    function checkDuplicate(title = '', id = '', notId = '', inputField, closeBtn, errorSpanField) {

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/master/ajax/bank.php',

            data: {
                module: 'master',
                page: 'bank',
                method: 'checkDuplicate',

                bank: title,

                id,

                notId

            },

            success: function(jsonResponse) {

                let response = typeof jsonResponse === 'string' ? JSON.parse(jsonResponse) : jsonResponse

                if (response.success) {

                    inputField.removeClass('is-invalid').addClass('is-valid')

                    if (notId != '') {

                        id = notId

                    }

                    saveBank(title, id, inputField, closeBtn, errorSpanField);

                } else {

                    inputField.addClass('is-invalid')

                    errorSpanField.html(response.msg)

                }

            }

        })

    }



    $("#saveBankBtn").click(function() {

        $("#bankTitleError").html('')

        let bankInput = $("#bankTitle")

        let closeBtn = $("#mdalClsBtn")

        let errorSpanField = $("#bankTitleError")

        if ($.trim(bankInput.val()) == '') {

            bankInput.addClass('is-invalid')

        } else {

            let title = $.trim(bankInput.val())

            checkDuplicate(title, '', '', bankInput, closeBtn, errorSpanField);

        }

    })



    $("#updateBankBtn").click(function() {

        let bankIdField = $("#editBankId")

        let bankTitleField = $("#editBankTitle")

        let editCloseBtn = $("#mdalEditClsBtn")

        let errorSpanField = $("#bankEditTitleError")

        // checkDuplicate(title, '', '', areaInput, closeBtn, errorSpanField);

        if ($.trim(bankTitleField.val()) == '') {

            bankTitleField.addClass('is-invalid')

        } else {

            checkDuplicate(bankTitleField.val(), '', bankIdField.val(), bankTitleField, editCloseBtn, errorSpanField);

        }

    })



    $("#deleteBankBtn").click(function() {

        let deleteId = $("#deleteBankId").val();

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/master/ajax/bank.php',

            data: {
                module: 'master',
                page: 'bank',
                method: 'deleteBank',

                id: deleteId

            },

            success: function(response) {

                if (response) {

                    $("#modalDelClsBtn").click();

                    $("#alertDiv").html(response.msg)

                    if (response.success) {

                        loadBank();

                    }

                }

            }

        })

    })









    function saveBank(bankTitle, bankId = '', bankInputField = '', modalCloseBtn = '', errorSpan = '', notInId = '') {

        // let areaInput = $("#bankTitle")

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/master/ajax/bank.php',

            data: {
                module: 'master',
                page: 'bank',
                method: 'saveBank',

                bank: bankTitle,

                id: bankId,

                not_id: notInId

            },

            success: function(jsonResponse) {

                let response = typeof jsonResponse === 'string' ? JSON.parse(jsonResponse) : jsonResponse

                if (response.success) {

                    bankInputField.removeClass('is-invalid').addClass('is-valid')

                    clearForm();

                    $("#alertDiv").html(response.response_xml)

                    modalCloseBtn.click()

                    loadBank();

                } else {

                    bankInputField.removeClass('is-valid').addClass('is-invalid')

                    errorSpan.html(response.msg)

                }

            }

        })

    }







    function clearForm() {

        $(".form-control").val('')

        $(".form-control").removeClass('is-invalid')

        $(".form-control").removeClass('is-valid')

        $(".erospan").html('')

    }



    $("#searchBankInput").keyup(function(event) {

        let searchBank = event.target.value;

        if (searchBank.length > 2) {

            loadBank(searchBank);

        }

    })



    $("#searchIcon").click(function() {

        let searchBank = $("#searchBankInput").val();

        loadBank(searchBank);

    })



    function loadPagination(dataCount = 0) {

        let paginationCount = 10; //change pagination listing count here also in backend

        let noOfPages = Math.ceil(dataCount / paginationCount)

        let selectedPageNumber = $("#curPage").val()



        if (noOfPages > 0) {

            let pagination = `<li class="page-item ${noOfPages<2 ||selectedPageNumber<2 ? 'disabled' : ''}">

                                <a class="page-link" href="javascript:;" aria-label="Previous" onclick="selectedPage('prev')"> <span aria-hidden="true">«</span>

                                </a>

                            </li>`

            for (let currentPage = 1; currentPage <= noOfPages; currentPage++) {

                pagination += ` <li class="page-item ${currentPage==selectedPageNumber ? 'active' : ''}"><a class="page-link" href="javascript:;" onclick="selectedPage(${currentPage})">${currentPage}</a></li>`

            }

            pagination += `<li class="page-item ${selectedPageNumber==noOfPages ? 'disabled' : ''}">

                                <a class="page-link" href="javascript:;" aria-label="Next" onclick="selectedPage('next')"> <span aria-hidden="true">»</span>

                                </a>

                            </li>`

            $("#pagination").html(pagination)

        }

        // console.log(noOfPages)

    }



    function selectedPage(selectedPage = '') {

        // console.log(selectedPage);

        let searchValue = $("#searchBankInput").val()

        if (searchValue.length < 3) {

            searchValue = ''

        }

        let prevVal = $("#curPage").val()

        if (selectedPage == 'prev') {

            selectedPage = Number(prevVal) - 1;

        }

        if (selectedPage == 'next') {

            selectedPage = Number(prevVal) + 1;

        }

        $("#curPage").val(selectedPage)

        loadBank(searchValue, selectedPage)

    }
</script>