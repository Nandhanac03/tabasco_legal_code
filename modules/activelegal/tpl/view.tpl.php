<!-- start page content wrapper-->
<div class="page-content-wrapper">
   <!-- start page content-->
   <div class="page-content">

      <!--start breadcrumb-->
      <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
         <div class="breadcrumb-title pe-3">Active Legal</div>
         <div class="ps-3">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb mb-0 p-0 align-items-center">
                  <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">View Active Legal</li>
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
                  <!-- Add Notification Button -->
                  <!-- <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addNotificationModal">
                     <ion-icon name="add-outline"></ion-icon> Add Notification
                  </a> -->

                  <a href="<?= ROOT_DIR ?>case/information.html" class="btn btn-primary me-2"><ion-icon name="add-outline"></ion-icon>Add Case</a>
                  <a href="<?= ROOT_DIR?>activelegal/list.html" class="btn btn-secondary"><ion-icon name="return-down-back-outline"></ion-icon>Back</a>
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
                  <style>
                     .description-cell {
                        max-width: 270px;
                        overflow-wrap: break-word;
                        white-space: normal;
                        text-align: justify;
                     }


                     .tooltip {
    position: relative;
    cursor: pointer;
}

.tooltip-text {
    visibility: hidden;
    position: absolute;
    background: #222;
    color: #fff;
    padding: 8px 10px;
    border-radius: 4px;
    width: 260px;
    bottom: 120%;
    left: 50%;
    transform: translateX(-50%);
    z-index: 999;
}

.tooltip:hover .tooltip-text {
    visibility: visible;
}


                  </style>
                  <thead>
                     <tr>
                        <th colspan="9">Case Listed</th>
                     </tr>
                     <tr>
                        <th> Case no</th>
                        <th class="text-center" width="5%">Case Mode</th>
                        <th class="text-center" width="5%">Start Date</th>
                        <th class="text-center" width="10%">Claim Amount</th>
                        <th class="text-center" width="20%">Lawyer</th>
                        <th class="text-center" width="20%">First Instance Judgment</th>
                        <th class="text-center" width="20%">Execution Decision</th>

                        <th class="text-center" width="10%">Status</th>
                        <th class="text-center" width="10%">Actions</th>
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
                              <td class="text-center"><?= $case['register_date'] ?></td>
                              <td class="text-center"><?= $case['total_outstanding'] ?></td>
                              <td class="text-center"><?= $case['lawyer_name'] ?></td>


<style>

.custom-tooltip {
    position: relative;
    cursor: pointer;
}

/* Hidden box */
.custom-tooltip .tooltip-box {
    display: none;
    position: absolute;
    top: 25px;
    left: 0;
    
    width: 300px;
    max-height: 200px;
    overflow-y: auto;

    background-color: #ffffff; /* ✅ WHITE BACKGROUND */
    color: #000;
    padding: 10px;

    border: 1px solid #ccc;
    border-radius: 6px;
    box-shadow: 0px 2px 8px rgba(0,0,0,0.2);

    z-index: 9999;
}

/* Show on hover */
.custom-tooltip:hover .tooltip-box {
    display: block;
}




</style>




                              <td class="description-cell">
    <?php 
    $desc = $case['first_instance_description'];

    if (!empty($desc)) { ?>
        <div class="custom-tooltip">
            <?= substr($desc, 0, 50) . '...'; ?>
            <div class="tooltip-box">
                <?= htmlspecialchars($desc); ?>
            </div>
        </div>
    <?php } else {
        echo '----';
    } ?>
</td>



                              <!-- <td class="description-cell"><?= $case['first_instance_description'] ? $case['first_instance_description'] : '----'; ?></td> -->
                              <style>
.table-responsive {
  overflow-x: unset!important;
  -webkit-overflow-scrolling: touch;
}

.hover-container {
    position: relative;
    cursor: pointer;
}


.full-content-tooltip {
    display: none;
    position: absolute;
    z-index: 100;
    left: 0;
    top: 0;
    width: 100%;
    min-width: 300px;
    background-color: #ffffff;
    border: 1px solid #ccc;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
    padding: 10px;
    border-radius: 4px;
    color: #333;
    white-space: normal;
    word-wrap: break-word;
}


.hover-container:hover .full-content-tooltip {
    display: block;
}

</style>
               
                            
                            
                            <?php
$fullText  = $case['execution_decision_description'] ?? '----';
$shortText = mb_strlen($fullText) > 20 
    ? mb_substr($fullText, 0, 20) . '...' 
    : $fullText;
?>

<td style="max-width:150px; min-width:150px; vertical-align: top;">
    <div class="hover-container">
        <div class="text-box">
            <?= htmlspecialchars($shortText); ?>
        </div>
        <div class="full-content-tooltip">
            <?= nl2br(htmlspecialchars($fullText)); ?>
        </div>

    </div>
</td>

                            
                            
                            
                              <td class="text-center">Pending</td>

                              <td class="text-center">
                                 <h4>
                                    <a href="<?= ROOT_DIR . "case/view/edit/{$case['id']}.html" ?>" class="text-dark">
                                       <ion-icon name="eye-outline" onclick="window.location.href='<?= ROOT_DIR ?>case/view.html';"></ion-icon>
                                    </a>
                                    <a href="<?= ROOT_DIR . "case/information/edit/{$case['id']}.html" ?>" class="text-dark">
                                       <ion-icon name="pencil-outline"></ion-icon>
                                    </a>
                                    <a href="javascript:void();" class="text-dark delete_case_btn"
                                       data-id="<?= $case['id'] ?>"
                                       data-case_no="<?= $case['case_number'] ?>"
                                       data-active_legal_id="<?= $case['active_legal_id'] ?>"
                                       data-bs-toggle="modal" data-bs-target="#deleteModal">
                                       <ion-icon name="trash-outline"></ion-icon>
                                    </a>
                                 </h4>
                              </td>
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



<div class="modal fade" id="addNotificationModal" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">

         <div class="modal-header">
            <h5 class="modal-title">
               <i class="lni lni-pencil"></i> Add Notification
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <form id="notificationForm">
            <div class="modal-body">
               <input type="hidden" id="marketing" value="<?= $active_legal[0]['user_id'] ?>">
               <input type="hidden" id="client" value="<?= $active_legal[0]['client'] ?>">
               <input type="hidden" id="active_legal_id" value="<?= $active_legal[0]['id'] ?>">

               <!-- Case Dropdown -->
               <div class="mb-3">
                  <label for="caseSelect" class="form-label">Case</label>
                  <select class="form-select" id="caseSelect" name="case" required>
                     <option value="">Select Case</option>
                     <?php if ($legal_case) { ?>
                        <?php foreach ($legal_case as $case) { ?>
                           <option value="<?= $case['id'] ?>"><?= $case['case_number'] ?></option>
                        <?php } ?>
                     <?php } ?>

                  </select>
               </div>

               <!-- Hearing Date -->
               <div class="mb-3">
                  <label for="hearingDate" class="form-label">Hearing Date</label>
                  <input type="date" class="form-control" id="hearingDate" name="hearing_date" required>
               </div>

               <!-- Remind Date -->
               <div class="mb-3">
                  <label for="remindDate" class="form-label">Remind From Date</label>
                  <input type="date" class="form-control" id="remind_date" name="remind_date" required>
               </div>

               <!-- Status Dropdown -->
               <div class="mb-3">
                  <label for="statusSelect" class="form-label">Status</label>
                  <select class="form-select" id="statusSelect" name="status" required>
                     <option value="Pending">Pending</option>
                  </select>
               </div>

            </div>

            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary">Save Notification</button>
            </div>
         </form>

      </div>
   </div>
</div>

<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;"></div>




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

      $("#notificationForm").on("submit", function(e) {
         e.preventDefault(); // prevent normal form submit

         $.ajax({
            type: "POST",
            url: "<?= ROOT_DIR ?>modules/activelegal/ajax/case_notification.php", // change to your save route
            data: {
               marketing: $("#marketing").val(),
               client: $("#client").val(),
               case: $("#caseSelect").val(),
               hearing_date: $("#hearingDate").val(),
               remind_date: $("#remind_date").val(),
               status: $("#statusSelect").val(),
               active_legal_id: $("#active_legal_id").val()

            },
            dataType: "json",
            success: function(response) {
               if (response.success) {
                  $("#addNotificationModal").modal("hide");
                  showToast("success", response.message);
                  setTimeout(function() {
                     location.reload();
                  }, 2000);
               } else {
                  showToast("danger", response.message || "Failed to save notification.");
               }
            },
            error: function(xhr) {
               console.error(xhr.responseText);
               showToast("danger", "An error occurred. Please try again.");
            }
         });
      });

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

   function showToast(type, message) {
      let toastHTML = `
        <div class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
      let toastContainer = $("#toastContainer");
      toastContainer.append(toastHTML);
      let newToast = toastContainer.find(".toast").last();
      let bsToast = new bootstrap.Toast(newToast[0], {
         delay: 3000
      });
      bsToast.show();
   }
</script>