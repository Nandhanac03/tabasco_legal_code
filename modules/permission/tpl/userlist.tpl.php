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
                <li class="breadcrumb-item active" aria-current="page">Set Permission </li>
            </ol>
        </nav>
    </div>

    <!-- Right-Side Buttons (Back + New Client) -->
    <div class="ms-auto ">

            </div>
</div>
<!-- End Breadcrumb -->


<div class="card">
  <div class="card-body">
    <div class="d-flex align-items-center d-none">
      <!-- <h5 class="mb-0">Customer Details</h5> -->
      <form class="ms-auto position-relative d-flex align-items-center gap-2">
        <!-- Select dropdown -->
        <select class="form-select w-auto" style="min-width: 150px;">
          <option selected>All Users</option>
          <option value="1">HR</option>
          <option value="2">Operations Manager</option>
          <option value="3">Legal Team</option>

        </select>

        <!-- Search box -->
        <div class="position-relative">
          <div class="position-absolute top-50 translate-middle-y search-icon px-3">
            <ion-icon name="search-sharp"></ion-icon>
          </div>
          <input class="form-control ps-5" type="text" placeholder="Search">
        </div>
      </form>
    </div>

    <div class="table-responsive mt-3">
      <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>#</th>
            <th>User Type</th>
            <th>Name</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          if($array_Userlist){
            $i=1;
            foreach($array_Userlist as $user){
              ?>
              <tr>
            <td><?=$i?></td>
            <td><p class="mb-0"><?=$user['usertype_title']?></p></td>
            <td><p class="mb-0"><?=$user['user_name']?></p></td>
            <td>
              <a type="button" href="<?=ROOT_DIR.'permission/set/view/'.intval($user['user_Id'])?>.html" class="btn btn-sm btn-primary p-1" title="View">
                <i class="lni lni-lock"></i>
              </a>
            </td>
          </tr>
              <?php
          $i++;

          }} else {
            ?>
            <tr>
              <td colspan="4" class="text-center">
                <div style="width: 100%; text-align: center; padding: 50px 0; color: #ff0000; font-size: 20px;">
            No records found
          </div>
              </td>
            </tr>
            <?php
        }
?>




        </tbody>
      </table>
    </div>
  </div>
</div>




          </div>
          <!-- end page content-->
         </div>
