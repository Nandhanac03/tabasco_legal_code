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
                    <li class="breadcrumb-item active" aria-current="page">Third Party Information</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Back Button on the Right -->
<?php include("common/backButton_list.php");?>
</div>


        <div class="row">
            <div class="col col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                        <?php
              echo createNavItem('thirdparty', "Information", "information-sharp", "information", $edit_id, true); // Active tab
              echo createNavItem('thirdparty', "Documents", "document-attach-sharp", "document", $edit_id);        // Inactive tab

              echo createNavItem('thirdparty', "Contact", "person-add-outline", "contact", $edit_id);        // Inactive tab

              echo createNavItem('thirdparty', "Commission", "cash", "commission", $edit_id);        // Inactive tab
              ?>






                        </ul>
                        <div class="tab-content py-3">
                            <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                                <!--start shop cart-->
                                <section class="shop-page">
                                    <div class="shop-container">
                                        <div class="shop-cart">
                                            <div class="container">
<form method="POST" enctype="multipart/form-data" id="frm_thirdparty" name="frm_thirdparty" action="">
                                                <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6 class="mb-0"><i class="lni lni-user"></i> Third Party
                                                                    Profile</h6>
                                                            </div>
<div class="card-body">
<input type="hidden" class="form-control" id="id" name="id" value="<?= ($action == 'edit') ? htmlspecialchars($data['id']) : '' ?>" autocomplete="off" readonly="true"  />
<input type="hidden" class="form-control" id="ac_id" name="ac_id" value="<?= ($action == 'edit') ? htmlspecialchars($bank_detals['ac_id']) : '' ?>" autocomplete="off" readonly="true"  />
        <div class="mb-3">
            <label class="form-label">Code: <span class="asterisk text-danger">*</span></label>
            <input type="text" class="form-control" id="code" name="code" value="<?=$data['code']?>" autocomplete="off" readonly="true"  required/>
        </div>
        <div class="mb-3">
            <label class="form-label">Name: <span class="asterisk text-danger">*</span></label>
            <input type="text" class="form-control" class="form-control" id="name" name="name" value="<?=$data['name']?>" autocomplete="off"  required />
        </div>
        <div class="mb-3">
            <label class="form-label">Address:</label>
            <input type="text" class="form-control" id="address" name="address" value="<?=$data['address']?>" autocomplete="off"   />
        </div>
        <div class="mb-3">
            <label class="form-label">Contact No.:</label>
            <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?=$data['contact_no']?>" autocomplete="off"   />
        </div>
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email"  class="form-control" id="email" name="email" value="<?=$data['email']?>" autocomplete="off"   />
        </div>
        <div class="mb-3">
            <label class="form-label">Notes:</label>
 <input type="text" class="form-control" id="notes" name="notes" value="<?=$data['notes']?>" autocomplete="off"   />
        </div>
        <div class="mb-3">
            <label class="form-label">Visiting Card:</label>
    <input type="file" class="form-control" id="visiting_card" name="visiting_card" value="" accept=".jpg,.jpeg,.png,.pdf"/>
    <small class="text-danger"> Allowed types: jpg, jpeg, gif, png, pdf & maximum size
    allowed 1MB. </small>
        </div>
        <?php if($data['visiting_card']!= '' && file_exists('uploads/visiting_card/'.$data['visiting_card'])) { ?>
  <div class="mb-3">
  <label class="form-label">View Visiting Card:</label>
  <a href="<?=ROOT_DIR.'uploads/visiting_card/'.$data['visiting_card']?>" target="_blank"><?=$data['visiting_card']?></a>
  </div>
<?php }
?>


</div>
                                                        </div>
                                                    </div>
                                                   </div>
                                                   <div class="col-lg-6">
                                                    <div class="col">
<?php include("common/manage_Bank.php");?>

                                                    </div>
                                                    </div>
                                                </div>

                                                <div class="row justify-content-center">
    <div class="mb-4 d-flex justify-content-center">
        <button type="submit" class="btn btn-primary px-5 mx-2">Save</button>
        <button type="reset" class="btn btn-secondary px-5 mx-2">Reset</button>
    </div>
</div></form>

                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page content-->


    <div class="modal fade" id="exampleExtraLargeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="lni lni-plus"></i> Add Contacts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>