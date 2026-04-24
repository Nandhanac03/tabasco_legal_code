<!-- start page content wrapper-->
<div class="page-content-wrapper">
  <!-- start page content-->
  <div class="page-content">
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Action Update</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0 align-items-center">
            <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Action Report List</li>
          </ol>
        </nav>
      </div>

    </div>
    <!--end breadcrumb-->

    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-body">
            <div class="row d-flex flex-sm-column flex-md-row justify-content-center align-items-center"
              style="height: 75vh !important;">
              <div class="col-md-2 col-sm-12">
                <a href="<?= ROOT_DIR ?>actionreport/caseactions.html">
                  <div class="card radius-10 bg-gradient-royal border-0">
                    <div class="card-body">
                      <i class="fadeIn animated lni lni-comments-alt fs-1 text-white mb-3"></i>
                      <h5 class="text-white text-uppercase">Case Actions</h5>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-md-2 col-sm-12">
                <a href="<?= ROOT_DIR ?>actionreport/followupactions.html">
                  <div class="card radius-10 bg-gradient-danger border-0">
                    <div class="card-body">
                    <i class="fadeIn animated lni lni-pencil-alt fs-1 text-white mb-3"></i>
                      <h5 class="text-white text-uppercase">Follow up Actions</h5>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end page content-->
  </div>
</div>