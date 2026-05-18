<?php
$_POST['active_legal_id'] = 1; // dummy id
ob_start();
include("modules/case/ajax/get_related_cases.php");
$out = ob_get_clean();
echo "OUTPUT: \n" . $out;
?>
