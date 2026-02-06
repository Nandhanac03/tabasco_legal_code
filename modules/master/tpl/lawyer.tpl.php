     <!-- start page content wrapper-->
     <div class="page-content-wrapper">
         <!-- start page content-->
         <div class="page-content">

             <!-- Start Breadcrumb -->
             <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                 <div class="breadcrumb-title pe-3">Dashboard</div>
                 <div class="ps-3">
                     <nav aria-label="breadcrumb">
                         <ol class="breadcrumb mb-0 p-0 align-items-center">
                             <li class="breadcrumb-item">
                                 <a href="javascript:;" id="home-icon">
                                     <ion-icon name="home-outline" title="Back to Dashboard"></ion-icon>
                                 </a>
                             </li>
                             <li class="breadcrumb-item active" aria-current="page">Lawyer</li>
                         </ol>
                     </nav>
                 </div>

                 <!-- Right-Side Buttons (Back + New Client) -->
                 <?php if (LEGAL_AUTH_ADD): ?>
                     <div class="ms-auto ">
                         <div class="btn-group">
                             <button type="button" class="btn btn-primary"
                                 onclick="window.location.href='<?= ROOT_DIR ?>master/lawyer_info.html';"><i
                                     class="fadeIn animated bx bx-plus"></i>New Lawyer</button>
                         </div>
                     </div>
                 <?php endif; ?>
             </div>
             <!-- End Breadcrumb -->


             <div class="card">
                 <div class="card-body">
                     <div class="d-flex align-items-center">
                         <!-- <h5 class="mb-0">Customer Details</h5> -->
                         <form class="ms-auto position-relative">
                             <div class="position-absolute top-50 translate-middle-y search-icon px-3"><ion-icon name="search-sharp"></ion-icon></div>
                             <input class="form-control ps-5" type="text" placeholder="search" id="text_keyword">
                         </form>
                     </div>
                     <div class="table-responsive mt-3">
                         <div id="load_ajax_client"></div>
                     </div>
                 </div>
             </div>



         </div>
         <!-- end page content-->
     </div>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script type="text/javascript">
         $(document).ready(function() {
             $(document).on('click', '.dropdown-toggle', function(e) {
                 //e.preventDefault();
                 //$(this).next('.dropdown-menu').toggle();

             });

             $("#text_keyword").on("keyup", function() {
                 loadData(1);
             });


             function loadData(page) {
                 var keyword = $("#text_keyword").val();
                 $.ajax({
                     url: "<?= ROOT_DIR ?>modules/master/ajax/lawyer.php",
                     type: "POST",
                     cache: false,
                     data: {
                        module: 'master',
                        page: 'lawyer',
                         keyword: keyword,
                         page_no: page
                     },
                     success: function(response) {
                         $("#load_ajax_client").html(response);


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
         });
     </script>