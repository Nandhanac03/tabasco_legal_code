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

                        <li class="breadcrumb-item active" aria-current="page">Area</li>

                    </ol>

                </nav>

            </div>

            <div class="ms-auto ">

                <div class="btn-group">
                    <?php if (LEGAL_AUTH_ADD): ?>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fadeIn animated bx bx-plus"></i> New Area
                        </button>
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

                        <div class="position-absolute top-50 translate-middle-y search-icon px-3"><ion-icon

                                name="search-sharp" id="searchAreaBtn"></ion-icon></div>

                        <input class="form-control ps-5" type="text" placeholder="search" id="searchAreaInput">

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

                        <tbody id="listingArea">

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

                <form action="" method="post">

                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label">Area title:</label>

                            <input type="text" class="form-control" name="title" id="areaTitle">

                            <span class="small text-danger erospan" id="areaTitleError"></span>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" id="mdalClsBtn" data-bs-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" id="saveAreaBtn">Save </button>

                    </div>

                </form>

            </div>

        </div>

    </div>



    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <form>

                        <div class="mb-3">

                            <label class="form-label">Area title:</label>

                            <input type="text" class="form-control" value="" id="editAreaTitle">

                            <span class="small text-danger erospan" id="areaEditTitleError"></span>

                            <input type="hidden" class="form-control" value="" id="editAreaId">

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="mdalEditClsBtn">Close</button>

                    <button type="button" class="btn btn-primary" id="updateAreaBtn">Update</button>

                </div>

            </div>

        </div>

    </div>



    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="deleteModalLabel">Delete Area</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalDelClsBtn"></button>

                </div>

                <div class="modal-body">

                    <form>

                        <div class="mb-3">

                            <label class="form-label">Are you sure want to delete <span id="deleteAreaTitle"></span>?</label>

                            <input type="hidden" class="form-control" value="" id="deleteAreaId">

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" id="deleteAreaBtn"><i class="lni lni-trash"></i></button>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    $(document).ready(function() {

        loadArea();

        $("#editModal").on('show.bs.modal', function(event) {

            let button = $(event.relatedTarget);

            let areaId = button.data('area_id');

            let areaTitle = button.data('area_title');



            let editModal = $(this)

            editModal.find("#editAreaId").val(areaId)

            editModal.find("#editAreaTitle").val(areaTitle)

        })

        $("#deleteModal").on('show.bs.modal', function(event) {

            let button = $(event.relatedTarget);

            let areaId = button.data('area_id');

            let areaTitle = button.data('area_title');



            let deleteModal = $(this)

            deleteModal.find("#deleteAreaId").val(areaId)

            deleteModal.find("#deleteAreaTitle").html(`<b>${areaTitle}</b>`)

        })

    })





    function checkDuplicate(title = '', id = '', notId = '', inputField, closeBtn, errorSpanField) {

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/master/ajax/area.php',

            data: {
                module: 'master',
                page: 'area',

                method: 'checkDuplicate',

                area: title,

                id,

                notId

            },

            success: function(jsonResponse) {

                let response = typeof jsonResponse === 'string' ? JSON.parse(jsonResponse) : jsonResponse

                if (response.success) {

                    inputField.removeClass('is-invalid').addClass('is-valid')

                    // return

                    if (notId != '') {

                        id = notId

                    }

                    saveArea(title, id, inputField, closeBtn, errorSpanField);

                } else {

                    inputField.addClass('is-invalid')

                    errorSpanField.html(response.msg)

                }

            }

        })

    }



    $("#saveAreaBtn").click(function() {

        $("#areaTitleError").html('')

        let areaInput = $("#areaTitle")

        let closeBtn = $("#mdalClsBtn")

        let errorSpanField = $("#areaTitleError")

        if ($.trim(areaInput.val()) == '') {

            areaInput.addClass('is-invalid')

        } else {

            let title = $.trim(areaInput.val())

            checkDuplicate(title, '', '', areaInput, closeBtn, errorSpanField);

        }

    })



    $("#updateAreaBtn").click(function() {

        let areaIdField = $("#editAreaId")

        let areaTitleField = $("#editAreaTitle")

        let editCloseBtn = $("#mdalEditClsBtn")

        let errorSpanField = $("#areaEditTitleError")

        // checkDuplicate(title, '', '', areaInput, closeBtn, errorSpanField);

        if ($.trim(areaTitleField.val()) == '') {

            areaTitleField.addClass('is-invalid')

        } else {

            checkDuplicate(areaTitleField.val(), '', areaIdField.val(), areaTitleField, editCloseBtn, errorSpanField);

        }

    })



    $("#deleteAreaBtn").click(function() {

        let deleteId = $("#deleteAreaId").val();

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/master/ajax/area.php',

            data: {
                module: 'master',
                page: 'area',
                method: 'deleteArea',

                id: deleteId

            },

            success: function(response) {

                if (response) {

                    $("#modalDelClsBtn").click();

                    $("#alertDiv").html(response.msg)

                    if (response.success) {

                        loadArea();

                    }

                }

            }

        })

    })



    function saveArea(areaTitle, areaId = '', areaInputField = '', modalCloseBtn = '', errorSpan = '', notInId = '') {

        // let areaInput = $("#areaTitle")

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/master/ajax/area.php',

            data: {
                module: 'master',
                page: 'area',
                method: 'saveArea',

                area: areaTitle,

                id: areaId,

                not_id: notInId

            },

            success: function(jsonResponse) {

                let response = typeof jsonResponse === 'string' ? JSON.parse(jsonResponse) : jsonResponse

                if (response.success) {

                    areaInputField.removeClass('is-invalid').addClass('is-valid')

                    clearForm();

                    $("#alertDiv").html(response.response_xml)

                    modalCloseBtn.click()

                    loadArea();

                } else {

                    areaInputField.removeClass('is-valid').addClass('is-invalid')

                    errorSpan.html(response.msg)

                }

            }

        })

    }



    function loadArea(search = '', pageNo = 1) {

        $.ajax({

            type: 'post',

            url: '<?= ROOT_DIR ?>modules/master/ajax/area.php',

            data: {
                module: 'master',
                page: 'area',
                method: 'areaListing',

                search,

                pageNo

            },

            success: function(response) {

                if (response != '') {

                    $("#listingArea").html(response.html);

                    loadPagination(response.area_count);

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



    $("#searchAreaInput").keyup(function(event) {

        let searchArea = event.target.value;

        if (searchArea.length > 2) {

            loadArea(searchArea);

        }

    })



    $("#searchAreaBtn").click(function() {

        let searchArea = $("#searchAreaInput").val();

        loadArea(searchArea);

    })



    function loadPagination(dataCount = 0) {

        let paginationCount = 10; //change pagination listing count here also in backend

        let noOfPages = Math.ceil(dataCount / paginationCount)

        let selectedPageNumber = $("#curPage").val()

        // console.log(selectedPage);



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

        let searchValue = $("#searchAreaInput").val()

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

        loadArea(searchValue, selectedPage)

    }
</script>