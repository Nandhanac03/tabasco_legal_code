<!-- start page content wrapper-->

<div class="page-content-wrapper">

    <!-- start page content-->

    <div class="page-content">



            <!--start breadcrumb-->

    <div class="d-flex justify-content-between align-items-center mb-3">

    <!-- Breadcrumb on the Left -->

    <div class="page-breadcrumb d-none d-sm-flex align-items-center">

        <div class="breadcrumb-title pe-3">Dashboard</div>

        <div class="ps-3">

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb mb-0 p-0 align-items-center">

                    <li class="breadcrumb-item">

                        <a href="javascript:;" id="home-icon">

                            <ion-icon name="home-outline" title="Back to Dashboard"></ion-icon>

                        </a>

                    </li>

                    <li class="breadcrumb-item active" aria-current="page">Active Legal Contact</li>

                </ol>

            </nav>

        </div>

    </div>

    <!-- Back Button on the Right -->

    <?php include("common/backButton_list.php");?>

</div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <div class="row">

            <div class="col col-lg-12 mx-auto">



                <div class="card">

                    <div class="card-body">

                    <ul class="nav nav-tabs nav-primary" role="tablist">

              <?php

              echo createNavItem('activelegal', "Information", "information-sharp", "information", $edit_id); // Active tab

              echo createNavItem('activelegal', "Documents", "document-attach-sharp", "document", $edit_id);        // Inactive tab



              echo createNavItem('activelegal', "Contact", "person-add-outline", "contact", $edit_id,true);        // Inactive tab



              echo createNavItem('activelegal', "Commission", "cash", "commission", $edit_id); 
              
              
              echo createNavItem('activelegal', "RelatedCases", "person-add-outline", "relatedcases", $edit_id);// Inactive tab

              ?>



            </ul>

            <div class="tab-content py-3">

                        <?php include('common/manage_Contact.php'); ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- end page content-->



</div>