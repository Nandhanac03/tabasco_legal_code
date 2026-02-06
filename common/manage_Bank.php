<?php
include_once("lib/class/class.legal_bank.php");
$ObjbankDetails = new bankDetails();

$array_bank_names = $ObjbankDetails->get_bank_names('');
$array_bank_ac_types = $ObjbankDetails->get_bank_ac_types('');
$array_bank_country = $ObjbankDetails->get_bank_country();

?>
<div class="card">
    <div class="card-header">
        <h6 class="mb-0"><i class="lni lni-text-align-justify"></i>
            Bank Account Details</h6>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Account Type:</label>
            <select class="form-select" id="ac_type" name="ac_type">
                <option value="">Select Account Type</option>
                <?php if ($array_bank_ac_types): ?>
                    <?php foreach ($array_bank_ac_types as $bankactypes): ?>
<option value="<?= $bankactypes['id'] ?>" <?php if($bankactypes['id']==$bank_detals['ac_type']){?> selected="selected" <?php }?>><?= $bankactypes['name'] ?>
</option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Account Name:</label>
            <input type="text" class="form-control" id="ac_name" name="ac_name" value="<?=$bank_detals['ac_name']?>" autocomplete="off" />
        </div>
        <div class="mb-3">
            <label class="form-label">Bank Name:</label>
            <?php if ($array_bank_names): ?>
                <select class="form-select" id="bank_id" name="bank_id">
                    <option value="">Select Bank Name</option>
                    <?php foreach ($array_bank_names as $banknames): ?>
<option value="<?= $banknames['id'] ?>" <?php if($banknames['id']==$bank_detals['bank_id']){?> selected="selected" <?php }?>><?= $banknames['name'] ?>
</option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">IBAN No:</label>
            <input type="text" class="form-control" id="iban_no" name="iban_no" value="<?=$bank_detals['iban_no']?>" autocomplete="off" />
        </div>
        <div class="mb-3">
            <label class="form-label">Account No.:</label>
            <input type="text" class="form-control" id="ac_number" name="ac_number" value="<?=$bank_detals['ac_number']?>" autocomplete="off" />
        </div>
        <div class="mb-3">
            <label class="form-label">Bank Country:</label>
            <?php if ($array_bank_country): ?>
                <select class="form-select" id="bank_county_id" name="bank_county_id">
                    <option value="">Select Bank Country</option>
                    <?php foreach ($array_bank_country as $bankcountry): ?>
<option value="<?= $bankcountry['id'] ?>" <?php if($bankcountry['id']==$bank_detals['bank_county_id']){?> selected="selected" <?php }?>><?= $bankcountry['name'] ?>
</option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Swift Code:</label>
            <input type="text" class="form-control" value="<?=$bank_detals['swift_code']?>" autocomplete="off" id="swift_code" name="swift_code" />
        </div>
    </div>
</div>
<input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" readonly="true" />
<input type="hidden" id="hid_module" name="hid_module" value="<?= $_GET['module']; ?>" readonly="true" />
<input type="hidden" id="hid_page" name="hid_page" value="<?= $_GET['page']; ?>" readonly="true" />
<input type="hidden" id="hid_parentID" name="hid_parentID" value="<?= $_GET['param1']; ?>" readonly="true" />