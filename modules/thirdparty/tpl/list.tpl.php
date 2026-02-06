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

                <li class="breadcrumb-item active" aria-current="page">Third Party List</li>

            </ol>

        </nav>

    </div>



    <!-- Right-Side Buttons (Back + New Client) -->

    <div class="ms-auto d-flex gap-2">
<?php if (LEGAL_AUTH_ADD): ?>
    <button type="button" class="btn btn-primary"

                        onclick="window.location.href='<?= ROOT_DIR ?>thirdparty/information.html';"><i

                            class="fadeIn animated bx bx-plus"></i>Add Third

                        Party</button>
<?php endif;?>
    </div>

</div>



<!-- End Breadcrumb -->







        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-body">



                        <!-- <div class="col text-end py-2">

  <button type="button" class="btn btn-sm btn-outline-primary px-1">

    <i class="lni lni-download"></i>

  </button>

</div> -->

                        <div class="d-flex align-items-center">

                            <div class="col  py-2">

                                <button type="button" id="exportExcel" class="btn btn-sm btn-outline-primary px-1">

                                    <i class="lni lni-download"></i>

                                </button>



                            </div>

<form class="ms-auto position-relative" action="" id="form_tp" name="form_tp" enctype="multipart/form-data">

<div class="position-absolute top-50 translate-middle-y search-icon px-3"><ion-icon

        name="search-sharp"></ion-icon></div>

<input class="form-control ps-5" type="text" id="keywordsearch" placeholder="search" value=""/>



</form>



                        </div>





                        <div class="table-responsive mt-3">

                            <div id="load_third_party_data"></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- end page content-->

















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



$(document).ready(function () {

    $(document).on('click', '.dropdown-toggle', function(e) {

    //e.preventDefault();

   // $(this).next('.dropdown-menu').toggle();



});



$(document).ready(function () {

    let typingTimer;

    let doneTypingInterval = 300; // 300ms delay



    $("#keywordsearch").on("input", function () {

        let keyword = $(this).val().trim();



        clearTimeout(typingTimer);



        if (keyword.length >= 3) {

            typingTimer = setTimeout(function () {

                loadData(1); // Execute AJAX when user stops typing

            }, doneTypingInterval);

        }

    });

});





function loadData(page) {

var keyword     = $("#keywordsearch").val();

$.ajax({

    url: "<?= ROOT_DIR ?>modules/thirdparty/ajax/load_thirdparty.php",

    type: "POST",

    cache: false,

    data: {

      keyword:keyword,

      page_no: page },

    success: function (response) {

        $("#load_third_party_data").html(response);

    }

});

}



                loadData(1);

                // Pagination code

                $(document).on("click", ".pagination li a", function (e) {

                    e.preventDefault();

                    var pageId = $(this).attr("id");

                    loadData(pageId);

                });



               /* $("#txt_item_search").keyup(function () {

                    console.log($(this).val());

                    const item_search = document.getElementById("txt_item_search").value;



                        loadData(1);



                });*/





                $('#sort_by_marketing').change(function () {

      const marketingId = $(this).val();



      //Load search panel Client List

      $('#sort_by_client').html('<option value="">-- Select Client --</option>');



      if (marketingId) {

        $.ajax({

          url: '<?= ROOT_DIR ?>modules/client/ajax/get_client.php', // Adjust as needed

          type: 'POST',

          data: { marketingId: marketingId, action: 'client_legal_list' },

          dataType: 'json',

          success: function (response) {

            console.log(response);

            if (Array.isArray(response)) {

              response.forEach(item => {

                $('#sort_by_client').append(`<option value="${item.id}">${item.name}</option>`);

              });

            } else {

              $('#sort_by_client').append('<option value="">No Clients found</option>');

            }

          },

          error: function (xhr, status, error) {

            console.error('Error:', error);

          }

        });

      }

    });

            });







$("#exportExcel").click(() => {

    var keyword = $("#keywordsearch").val().trim(); // Get keyword and remove extra spaces

    var exportUrl = "<?= ROOT_DIR ?>excel/thirdpartylist.php?type=excel";

    if (keyword.length > 0) {

        exportUrl += "&keyword=" + encodeURIComponent(keyword);

    }

    window.location.href = exportUrl;

});



        </script>