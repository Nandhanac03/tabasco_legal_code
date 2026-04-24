<!-- start page content wrapper-->

<div class="page-content-wrapper">

    <!-- start page content-->

    <div class="page-content">



        <!-- Start Breadcrumb -->

        <div class="page-breadcrumb d-flex align-items-center mb-3">

            <div class="breadcrumb-title pe-3 d-none d-sm-block">Dashboard</div>

            <div class="ps-3 d-none d-sm-block">

                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb mb-0 p-0 align-items-center">

                        <li class="breadcrumb-item">

                            <a href="javascript:;" id="home-icon">

                                <ion-icon name="home-outline" title="Back to Dashboard"></ion-icon>

                            </a>

                        </li>

                        <li class="breadcrumb-item active" aria-current="page">Debt Collector List</li>

                    </ol>

                </nav>

            </div>



            <!-- Right-Side Buttons (Back + New Client) -->

            <div class="ms-auto d-flex gap-2">
<?php if (LEGAL_AUTH_ADD): ?>
<button type="button" class="btn btn-primary" onclick="window.location.href='<?= ROOT_DIR ?>debtcollector/information.html';"><i class="fadeIn animated bx bx-plus"></i>Add Debt Collector</button>
<?php endif; ?>
            </div>

        </div>



        <!-- End Breadcrumb -->





        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="col  py-2">

                                <button type="button" id="exportExcel" class="btn btn-sm btn-outline-primary px-1">

                                    <i class="lni lni-download"></i>

                                </button>



                            </div>

                            <form class="ms-auto position-relative" action="" id="form_dc" name="form_dc" enctype="multipart/form-data">

                                <div class="position-absolute top-50 translate-middle-y search-icon px-3"><ion-icon

                                        name="search-sharp"></ion-icon></div>

                                <input class="form-control ps-5" type="text" id="keywordsearch" placeholder="search" value="" />



                            </form>

                        </div>

                        <div class="table-responsive mt-3">

                            <div id="load_debt_collector_data"></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- end page content-->





        <div class="modal fade" id="lock_unlock_Modal" tabindex="-1" aria-labelledby="lock_unlock_ModalLabel"

            aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h6 class="modal-title" id="lock_unlock_ModalLabel"><i class="lni lni-lock"></i> Lock / Unlock

                            Panel</h6>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>

                    <div class="modal-body">

                        <h6 class="text-danger ">Do you want to lock this <u>Alpha Debt Collection</u> record. ?</h6>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary">Save changes</button>

                    </div>

                </div>

            </div>

        </div>







        <div class="modal fade" id="login_credentials_Modal" tabindex="-1" aria-labelledby="login_credentials_Modal"

            aria-hidden="true">

            <div class="modal-dialog modal-xl">

                <div class="modal-content">

                    <div class="modal-header">

                        <h6 class="modal-title" id="login_credentials_ModalLabel"><i

                                class="fadeIn animated bx bx-log-in"></i> Login Credentials Panel</h6>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>

                    <div class="modal-body">

                        <div class="card">

                            <div class="card-body">

                                <form>

                                    <div class="mb-3">

                                        <label class="form-label">User ID:</label>

                                        <input type="text" class="form-control" placeholder="Enter User ID" />

                                    </div>

                                    <div class="mb-3">

                                        <label class="form-label">Password:</label>

                                        <input type="password" class="form-control" autocomplete="off"

                                            placeholder="Enter Password" />

                                    </div>

                                    <div class="mb-3">

                                        <label class="form-label">Confirm Password:</label>

                                        <input type="password" class="form-control" autocomplete="off"

                                            placeholder="Enter Confirm Password" />

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary">Save changes</button>

                    </div>

                </div>

            </div>

        </div>





        <div class="modal fade" id="sharelink_Modal" tabindex="-1" aria-labelledby="sharelink_ModalLabel"

            aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h6 class="modal-title" id="sharelink_ModalLabel"><i class="lni lni-world"></i> Shareable Link

                            Panel</h6>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>

                    <div class="modal-body">

                        <textarea class="form-control" id="textToCopy"

                            rows="4">https://tabascouae.com/project</textarea>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" onclick="copyTextToClipboard()">Copy</button>

                    </div>

                </div>

            </div>

        </div>

        <script>

            function copyTextToClipboard() {

                // Get the text to copy

                const textToCopy = document.getElementById("textToCopy").textContent;



                // Use the Clipboard API to copy the text

                navigator.clipboard.writeText(textToCopy)

                    .then(() => {

                        alert("Text copied to clipboard!");

                    })

                    .catch(err => {

                        console.error("Failed to copy: ", err);

                    });

            }

        </script>





    </div>

</div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    function copyTextToClipboard() {

        // Get the text to copy

        const textToCopy = document.getElementById("textToCopy").textContent;



        // Use the Clipboard API to copy the text

        navigator.clipboard.writeText(textToCopy)

            .then(() => {

                alert("Text copied to clipboard!");

            })

            .catch(err => {

                console.error("Failed to copy: ", err);

            });

    }

</script>







<script type="text/javascript">

    $(document).ready(function() {

        $(document).on('click', '.dropdown-toggle', function(e) {

            //e.preventDefault();

            //$(this).next('.dropdown-menu').toggle();



        });



        $(document).ready(function() {

            let typingTimer;

            let doneTypingInterval = 300; // 300ms delay



            $("#keywordsearch").on("input", function() {

                let keyword = $(this).val().trim();



                clearTimeout(typingTimer);



                if (keyword.length >= 3) {

                    typingTimer = setTimeout(function() {

                        loadData(1); // Execute AJAX when user stops typing

                    }, doneTypingInterval);

                }

            });

        });





        function loadData(page) {

            var keyword = $("#keywordsearch").val();

            $.ajax({

                url: "<?= ROOT_DIR ?>modules/debtcollector/ajax/load_debtcollector.php",

                type: "POST",

                cache: false,

                data: {

                    keyword: keyword,

                    page_no: page

                },

                success: function(response) {

                    $("#load_debt_collector_data").html(response);

                }

            });

        }



        loadData(1);

        // Pagination code

        $(document).on("click", ".pagination li a", function(e) {

            e.preventDefault();

            var pageId = $(this).attr("id");

            loadData(pageId);

        });



        /* $("#txt_item_search").keyup(function () {

             console.log($(this).val());

             const item_search = document.getElementById("txt_item_search").value;



                 loadData(1);



         });*/









    });







    $("#exportExcel").click(() => {

        var keyword = $("#keywordsearch").val().trim(); // Get keyword and remove extra spaces

        var exportUrl = "<?= ROOT_DIR ?>excel/debtcollector.php?type=excel";

        if (keyword.length > 0) {

            exportUrl += "&keyword=" + encodeURIComponent(keyword);

        }

        window.location.href = exportUrl;

    });

</script>