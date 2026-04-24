<?php

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    ob_start();
    session_start();
    error_reporting(0);
    include_once("../../../lib/config.php");
    include_once("../../../lib/class/class.dbcon.php");
    include_once("../../../lib/class/class.legal_case_root_actions.php");

    $objCaseRootAction = new CaseRootAction();

    $case_id = isset($_POST['case_id']) ? intval($_POST['case_id']) : 0;
    
    $filter = ['created_from' => 'CA'];
    if ($case_id > 0) {
        $filter['case_id'] = $case_id;
    } else {
        $filter['case_root_id'] = $id;
    }

    $rows = $objCaseRootAction->get_case_root('', $filter);
/* Adjust this width as needed */

    if ($rows) {
        echo '
        
        <style>
        .description-cell {
         max-width: 260px; /* Adjust this width as needed */
         overflow-wrap: break-word; /* Breaks long words to wrap */
         white-space: normal; /* Allows text to wrap to multiple lines */
         text-align: justify; /* Justifies the text */
        }
        </style>
        
        <table class="table align-middle mb-0 table-borderless">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Sub-category</th>
                        <th>Document</th>
                        <th>Email Link</th>
                        <th>Updated By</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($rows as $row) {
            echo "<tr>
                    <td>{$row['date']}</td>
                    <td class='description-cell'>{$row['description']}</td>
                    <td>{$row['subcategory_title']}</td>";
            if ($row['document']) {
                $root_doc = ROOT_DIR . 'uploads/action_documents/' . $row['document'];
                echo '<td>
        <a href="' . htmlspecialchars($root_doc) . '" target="_blank">
            <button type="button" class="btn text-success">
                <i class="fadeIn animated bx bx-file"></i>
            </button>
        </a>
      </td>';
            } else {
                echo "<td><button class='btn text-danger'><i class='fadeIn animated bx bx-file'></i></button>";
            }
            if (!empty($row['email'])) {
                // Has email → make send link
                echo "<td>
                        <a href='" . htmlspecialchars($row['email']) . "' class='btn btn-outline-dark ps-3 rounded' target='_blank'>
                            <ion-icon name='mail-outline'></ion-icon>
                        </a>
                      </td>
                     ";
            } else {
                // No email → placeholder
                echo "<td>
                        <button class='btn btn-outline-secondary ps-3 rounded' disabled>
                            <ion-icon name='mail-outline'></ion-icon>
                        </button>
                      </td>
                      ";
            }
            echo " <td>{$row['case_root_action_user']}</td>
            </tr>";
        }
        echo '</tbody></table>';
    } else {
        echo "<div class='p-3 text-danger'>No data available.</div>";
    }
}
