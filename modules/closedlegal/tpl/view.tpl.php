<!-- start page content wrapper-->
<div class="page-content-wrapper">
   <!-- start page content-->
   <div class="page-content">

      <!--start breadcrumb-->
      <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
         <div class="breadcrumb-title pe-3">Closed Legal</div>
         <div class="ps-3">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0 p-0 align-items-center">
                  <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">View Closed Legal</li>
               </ol>
            </nav>
         </div>
         <div class="ms-auto d-none">
            <div class="btn-group">
               <button type="button" class="btn btn-outline-primary">Settings</button>
               <button type="button" class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
               </button>
               <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item" href="javascript:;">Action</a>
                  <a class="dropdown-item" href="javascript:;">Another action</a>
                  <a class="dropdown-item" href="javascript:;">Something else here</a>
                  <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
               </div>
            </div>
         </div>
      </div>
      <!--end breadcrumb-->
      <div class="card radius-10">
         <div class="card-header py-3">
            <div class="row align-items-center g-3">
               <div class="col-12 col-lg-6">
                  <h5 class="mb-0"></h5>
               </div>
               <div class="col-12 col-lg-6 text-md-end">
                  <a href="javascript: history.go(-1);" class="btn btn-secondary"><ion-icon name="return-down-back-outline"></ion-icon>Back</a>
               </div>
            </div>
         </div>
         <div class="card-header py-2">
            <div class="row row-cols-1 row-cols-lg-3">
               <div class="col">
                  <div class="">
                     <address class="m-t-5 m-b-5">
                        <p>Marketing : <?= $active_legal[0]['User_Client'] ?></p>
                        <p>Client : <?= $active_legal[0]['ClientName'] ?></p>
                     </address>
                  </div>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-invoice">
                  <thead>
                     <tr>
                        <th>Firm/Third/Debt</th>
                        <th>Type</th>
                        <th class="text-center" width="10%">Start Date</th>
                        <th class="text-center" width="10%">Shift Date</th>
                        <th class="text-right" width="20%">Actions View</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if ($shifted_records) { ?>
                        <?php foreach ($shifted_records as $record) { ?>
                           <tr>
                              <td>
                                 <span class="text-inverse"><?= $record['party_name_label'] ?></span><br>
                              </td>
                              <td>
                                 <span class="text-inverse"><?= $label_array[$record['legal_type']] ?></span>
                              </td>
                              <td class="text-center"><?= $record['start_date'] == '' ?  date('Y-m-d', strtotime($active_legal[0]['created_on'])) : $record['start_date'] ?></td>
                              <td class="text-center"><?= $record['shifted_date'] ?></td>
                              <td>
                                 <h4>
                                    <ion-icon name="eye-outline" onclick="window.location.href='<?= ROOT_DIR ?>activelegal/actionview/view/<?= $record['id'] ?>.html';"></ion-icon>
                                 </h4>
                              </td>
                           </tr>
                        <?php } ?>
                     <?php } ?>
                  </tbody>
               </table>
            </div>


         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-invoice">
                  <thead>
                     <tr>
                        <th colspan="9">Case Listed</th>
                     </tr>
                     <tr>
                        <th> Case no</th>
                        <th class="text-center" width="5%">Case Mode</th>
                        <th class="text-center" width="5%">Case Category</th>
                        <th class="text-center" width="5%">Start Date</th>
                        <th class="text-center" width="10%">Claim Amount</th>
                        <th class="text-center" width="20%">Lwyer</th>
                        <th class="text-center" width="20%">First Instance Judgment</th>
                        <th class="text-center" width="20%">Execution Decision</th>

                        <th class="text-center" width="10%">Status</th>
                        <!-- <th class="text-center" width="10%">Actions</th> -->
                     </tr>
                  </thead>
                  <tbody id="showCaseBody">
                     <?php if (!empty($legal_case)) { ?>
                        <?php foreach ($legal_case as $case) { ?>
                           <tr>
                              <td>
                                 <span class="text-inverse"><?= $case['case_number'] ?></span><br>
                              </td>
                              <td class="text-center"><?= $case['case_mode_title'] ?></td>
                              <td class="text-center"><?= $case['category_name'] ?></td>
                              <td class="text-center"><?= $case['register_date'] ?></td>
                              <td class="text-center"><?= $case['total_outstanding'] ?></td>
                              <td class="text-center"><?= $case['lawyer'] ?></td>
                              <td class="text-center"></td>
                              <td class="text-center"></td>
                              <td class="text-center">Pending</td>

                              <!-- <td class="text-center">
                                 <h4>
                                    <a href="<?= ROOT_DIR . "case/view/view/{$case['id']}.html" ?>" class="text-dark">
                                       <ion-icon name="eye-outline" onclick="window.location.href='<?= ROOT_DIR ?>case/view.html';"></ion-icon>
                                    </a>
                                    
                                 </h4>
                              </td> -->
                           </tr>
                        <?php } ?>
                     <?php } else { ?>
                        <tr>
                           <td colspan='9' class='text-center'>No case available.</td>
                        </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <!-- end page content-->
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalDelClsBtn"></button>
         </div>
         <div class="modal-body">
            <form>
               <div class="mb-3">
                  <label class="form-label">Are you sure want to delete the case no. <span id="show_case_no"></span> ?</label>
                  <input type="hidden" class="form-control" value="" id="deleteId">
                  <input type="hidden" class="form-control" value="" id="deleteActiveLegalId">
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="deleteConfirmButton"><i class="lni lni-trash"></i></button>
         </div>
      </div>
   </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
   $(document).ready(function() {
      $("#deleteModal").on('show.bs.modal', function(event) {
         let button = $(event.relatedTarget);

         let current_id = button.data('id')
         let current_case_no = button.data('case_no')
         let current_active_legal_id = button.data('active_legal_id')

         let deleteModal = $(this)
         deleteModal.find("#show_case_no").html(`<b>" ${current_case_no} "</b>`)
         deleteModal.find("#deleteId").val(current_id)
         deleteModal.find("#deleteActiveLegalId").val(current_active_legal_id)
      })
   })

   $("#deleteConfirmButton").click(function() {
      let selectedId = $("#deleteId").val()
      let selectedActiveLegalId = $("#deleteActiveLegalId").val()
      if (selectedId) {
         let csrf_token = '<?= $_SESSION['csrf_token']; ?>'

         $.ajax({
            type: 'post',
            url: '<?= ROOT_DIR ?>modules/case/ajax/case_handle.php',
            data: {
               action: 'delete',
               id: selectedId,
               active_legal_id: selectedActiveLegalId,
               csrf_token
            },
            success: function(response) {
               if (response.success) {
                  $("#modalDelClsBtn").click();
                  round_success_noti(response.message)
                  $("#showCaseBody").html(response.html)
               } else {
                  round_error_notify(response.message)
               }
            }
         })
      }
   })


   function round_error_notify(msg = '') {
      Lobibox.notify('error', {
         pauseDelayOnHover: true,
         size: 'mini',
         rounded: true,
         delayIndicator: false,
         icon: 'bx bx-x-circle',
         continueDelayOnInactiveTab: false,
         position: 'top right',
         msg: msg
      });
   }
</script>