<?php
class Common{
	################	MEMBER VARIABLES SECTION	##############
	################	MEMBER FUNCTIONS SECTION	##############
	#Trim spaces from left and right of a string
	function trimspaces(&$post){
		if($post){
			foreach($post as $key=>$value){
				$post[$key]=addslashes(trim($value));
			}
		}
	}
	#Email Validator Funtion
	function validateEmail($email){
	   if(eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,3})?(\.[a-zA-Z]{2,3})?$', $email))
		  return true;
	   else
		  return false;
	}
	function getRealIpAddr(){
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
    	return trim($ip);
	}
	function UploadImage($file='',$dest='',$current_image=''){
		$file_name                        =        $file['name'];
		$file_size                        =        $file['size'];
		$file_tmp_name                =        $file['tmp_name'];
		if($file_name!="" && $file_size>0 && $file_tmp_name!="" && $dest!="")
		{
				$exc        =        explode('.',$file_name);
				$ext        =         strtolower(array_pop($exc));
				if($ext=="jpg"||$ext=="jpeg"||$ext=="gif"||$ext=="png" )
				{
						$uploadrandom        =rand(10000,99999).''.date('d-m-y')."".rand(100,999).".".$ext;
						$remote_file =  $dest.$uploadrandom;
						$upload_status        =        move_uploaded_file($file_tmp_name,$remote_file);
						if($upload_status){
								if($current_image)
										@unlink($dest.$current_image);
								return $uploadrandom;
								return true;
						}
				}
		}else{
			return false;
		}
	}
	function UploadFile($file = '', $dest = '', $current_file = '') {
		$file_name = $file['name'];
		$file_size = $file['size'];
		$file_tmp_name = $file['tmp_name'];
		if ($file_name != "" && $file_size > 0 && $file_tmp_name != "" && $dest != "") {
			
			if ($file_size > 1048576) {
				return "Error: File size must be less than 1 MB.";
			}
			$exc = explode('.', $file_name);
			$ext = strtolower(array_pop($exc));
		
			$allowed_extensions = ['jpg', 'jpeg', 'gif', 'png', 'pdf'];
			if (in_array($ext, $allowed_extensions)) {
				
				$unique_name = uniqid('file_', true) . '_' . time() . '.' . $ext;
				$remote_file = $dest . $unique_name;
			
				if (move_uploaded_file($file_tmp_name, $remote_file)) {
					
					if ($current_file && file_exists($dest . $current_file)) {
						@unlink($dest . $current_file);
					}
					return $unique_name;  
				} else {
					return "Error: Failed to move the uploaded file.";
				}
			} else {
				return "Error: Invalid file type. Allowed types: jpg, jpeg, gif, png, pdf.";
			}
		}
		return "Error: Invalid file input.";
	} 
	function getFirstWords($name) {
		$words = explode(' ', $name); 
		$first12Words = array_slice($words, 0, 1);
		return implode(' ', $first12Words); 
	}
}
?>