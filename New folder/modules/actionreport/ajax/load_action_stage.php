<?php
ob_start();
session_start();
error_reporting(0);
include_once("../../../lib/config.php");
include_once("../../../lib/class/class.dbcon.php");
include_once("../../../lib/class/class.legal_case.php");
$objLegalCase = new LegalCase();

if ($_POST) {
    $categoryId = isset($_POST['categoryId']) ? htmlspecialchars($_POST['categoryId']) : null;
    $case_id = isset($_POST['case_id']) ? htmlspecialchars($_POST['case_id']) : null;
    $active_legal_id = isset($_POST['active_legal_id']) ? htmlspecialchars($_POST['active_legal_id']) : null;

    $all_roots = $objLegalCase->get_roots('', $case_id, $active_legal_id, '', $categoryId);

    if ($all_roots) {
        echo '<option value="">--- Select Stage ---</option>';
        foreach (array_reverse($all_roots) as $root) {
            echo '<option value="' . htmlspecialchars($root['id']) . '">' . htmlspecialchars($root['stage']) . '</option>';
        }
    } else {
        echo '<option value="">No stages found</option>';
    }
}
