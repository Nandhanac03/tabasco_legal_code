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

                        <li class="breadcrumb-item active" aria-current="page">Court</li>

                    </ol>

                </nav>

            </div>
            <?php if (LEGAL_AUTH_ADD): ?>
            <div class="ms-auto ">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal"><i class="fadeIn animated bx bx-plus"></i>New Court</button>
                </div>
            </div>
            <?php endif; ?>

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

                        <input class="form-control ps-5" type="text" placeholder="search" id="searchCourtInput">

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

                        <tbody id="listingCourtData">

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

                            <label class="form-label">Court name <span class="text-danger">*</span></label>

                            <input type="text" class="form-control" name="title" id="courtTitle">

                            <span class="small text-danger erospan" id="courtTitleError"></span>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" id="mdalClsBtn" data-bs-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary" id="saveCourtBtn">Save </button>

                </div>

            </div>

        </div>

    </div>



    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">Update Court</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <form>

                        <div class="mb-3">

                            <label class="form-label">Court name<span class="text-danger">*</span></label>

                            <input type="text" class="form-control" value="" id="editCourtTitle">

                            <span class="small text-danger erospan" id="courtEditTitleError"></span>

                            <input type="hidden" class="form-control" value="" id="editCourtId">

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="mdalEditClsBtn">Close</button>

                    <button type="button" class="btn btn-primary" id="updateCourtBtn">Update</button>

                </div>

            </div>

        </div>

    </div>



    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="deleteModalLabel">Delete Court</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalDelClsBtn"></button>

                </div>

                <div class="modal-body">

                    <form>

                        <div class="mb-3">

                            <label class="form-label">Are you sure want to delete <span id="deleteCourtTitle"></span>?</label>

                            <input type="hidden" class="form-control" value="" id="deleteCourtId">

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" id="deleteCourtBtn"><i class="lni lni-trash"></i></button>

                </div>

            </div>

        </div>

    </div>

</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>

    $(document).ready(function() {

        loadCourt();

        $("#editModal").on('show.bs.modal', function(event) {

            let button = $(event.relatedTarget);

            let courtId = button.data('court_id');

            let courtTitle = button.data('court_name');



            let editModal = $(this)

            editModal.find("#editCourtId").val(courtId)

            editModal.find("#editCourtTitle").val(courtTitle)

        })



        $("#deleteModal").on('show.bs.modal', function(event) {

            let button = $(event.relatedTarget);

            let courtId = button.data('court_id');

            let courtTitle = button.data('court_name');



            let deleteModal = $(this)

            deleteModal.find("#deleteCourtId").val(courtId)

            deleteModal.find("#deleteCourtTitle").html(`<b>${courtTitle}</b>`)

        })

    })





    function loadCourt(search = '', pageNo = 1) {

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/master/ajax/court.php',

            data: {
                module: 'master',
                page: 'court',
                method: 'courtListing',

                search,

                pageNo

            },

            success: function(response) {

                if (response != '') {

                    $("#listingCourtData").html(response.html);

                    loadPagination(response.court_count);

                }

            }

        })

    }





    function checkDuplicate(title = '', id = '', notId = '', inputField, closeBtn, errorSpanField) {

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/master/ajax/court.php',

            data: {
                module: 'master',
                page: 'court',
                method: 'checkDuplicate',

                court: title,

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

                    saveCourt(title, id, inputField, closeBtn, errorSpanField);

                } else {

                    inputField.addClass('is-invalid')

                    errorSpanField.html(response.msg)

                }

            }

        })

    }



    $("#saveCourtBtn").click(function() {

        $("#courtTitleError").html('')

        let courtInput = $("#courtTitle")

        let closeBtn = $("#mdalClsBtn")

        let errorSpanField = $("#courtTitleError")

        if ($.trim(courtInput.val()) == '') {

            courtInput.addClass('is-invalid')

        } else {

            let title = $.trim(courtInput.val())

            checkDuplicate(title, '', '', courtInput, closeBtn, errorSpanField);

        }

    })



    $("#updateCourtBtn").click(function() {

        let courtIdField = $("#editCourtId")

        let courtTitleField = $("#editCourtTitle")

        let editCloseBtn = $("#mdalEditClsBtn")

        let errorSpanField = $("#courtEditTitleError")

        // checkDuplicate(title, '', '', areaInput, closeBtn, errorSpanField);

        if ($.trim(courtTitleField.val()) == '') {

            courtTitleField.addClass('is-invalid')

        } else {

            checkDuplicate(courtTitleField.val(), '', courtIdField.val(), courtTitleField, editCloseBtn, errorSpanField);

        }

    })



    $("#deleteCourtBtn").click(function() {

        let deleteId = $("#deleteCourtId").val();

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/master/ajax/court.php',

            data: {
                module: 'master',
                page: 'court',
                method: 'deleteCourt',

                id: deleteId

            },

            success: function(response) {

                if (response) {

                    $("#modalDelClsBtn").click();

                    $("#alertDiv").html(response.msg)

                    if (response.success) {

                        loadCourt();

                    }

                }

            }

        })

    })









    function saveCourt(courtInput, courtId = '', courtInputField = '', modalCloseBtn = '', errorSpan = '', notInId = '') {

        

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/master/ajax/court.php',

            data: {
                module: 'master',
                page: 'court',
                method: 'saveCourt',

                court: courtInput,

                id: courtId,

                not_id: notInId

            },

            success: function(jsonResponse) {

                let response = typeof jsonResponse === 'string' ? JSON.parse(jsonResponse) : jsonResponse

                if (response.success) {

                    courtInputField.removeClass('is-invalid').addClass('is-valid')

                    clearForm();

                    $("#alertDiv").html(response.response_xml)

                    modalCloseBtn.click()

                    loadCourt();

                } else {

                    courtInputField.removeClass('is-valid').addClass('is-invalid')

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



    $("#searchCourtInput").keyup(function(event) {

        let searchCourt = event.target.value;

        if (searchCourt.length > 2) {

            loadCourt(searchCourt);

        }

    })



    $("#searchIcon").click(function() {

        let searchCourt = $("#searchCourtInput").val();

        loadCourt(searchCourt);

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

        let searchValue = $("#searchCourtInput").val()

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

        loadCourt(searchValue, selectedPage)

    }

</script>