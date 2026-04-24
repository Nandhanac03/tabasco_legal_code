<?php
class Filemanagement extends Dbcon
{
    public function uploadFile($input_file = '')
    {
        $max_upload_size = 5 * 1024 * 1024; //5MB
        $allowed_file_types = ['image/jpg', 'image/png', 'image/jpeg', 'application/pdf'];
        if (!empty($input_file) && !empty($input_file['uploaded_file'])) {
            $save_file_location = ROOT_DIR . 'uploads/';
            $uploaded_file = $input_file['uploaded_file'];
            //-----------------------get file extension-MIME
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $uploaded_file_type = finfo_file($finfo, $uploaded_file['tmp_name']);
            finfo_close($finfo);
            if (!empty($input_file['file_location'])) {
                $save_file_location = $input_file['file_location'];
            }
            //-----------------------file size validation
            if ($uploaded_file['size'] > $max_upload_size) {
                return ['success' => false, 'msg' => 'Max allowed size: 5MB'];
            }
            $uploaded_file_extension = strtolower(pathinfo($uploaded_file['name'], PATHINFO_EXTENSION));
            //-----------------------file extension validation
            if (!in_array($uploaded_file_type, $allowed_file_types)) {
                $filetype_info = implode(', ', $allowed_file_types);
                return ['success' => false, 'msg' => "Allowed file types are: $filetype_info"];
            }
            if (!file_exists($save_file_location)) {
                mkdir($save_file_location, 0755, true);
            }
            //-----------------------generate unique file name
            $new_file_name = date('dymHis') . rand(0, 999) . "." . $uploaded_file_extension;
            $target_file = $save_file_location . $new_file_name;
            echo "<pre>";
            print_r($target_file);
            exit;
            if (move_uploaded_file($uploaded_file['tmp_name'], $target_file)) {
                return ['success' => true, 'msg' => 'File uploaded successfully'];
            } else {
                return ['success' => false, 'msg' => 'Failed to upload file.'];
            }
        } else {
            return ['success' => false, 'msg' => 'Empty file data'];
        }
    }
    public function validateEmail($email_id)
    {
        return filter_var($email_id, FILTER_VALIDATE_EMAIL);
    }
    public function validateString($string)
    {
        if (preg_match('/[^a-zA-Z0-9]/', $string)) {
            return false;
        } else {
            return true;
        }
    }
}