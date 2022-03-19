<?php
class UplaodFileMaster {
	/**
	 * Create a null object of UplaodFileMaster
	 * @return UplaodFileMaster $UplaodFileMasterObj
	 */
	public function Create() {
		$UplaodFileMasterObj = new UplaodFileMaster();
		return  $UplaodFileMasterObj;
	}

	/**
	 * Check the file and upload it in the given path
	 * @param File name,File path
	 * @return If any error, then Throw Exception else return file name
	 */
	public function UploadFile($FieldName,$directorypath,$newfilename="",$siteLanguage="")
	{
		
		if($siteLanguage != ""){
			$errorField = $_FILES[$FieldName]['error'][$siteLanguage];
			$sizeField = $_FILES[$FieldName]['size'][$siteLanguage];
			$tmpName = $_FILES[$FieldName]['tmp_name'][$siteLanguage];
			$Name = $_FILES[$FieldName]['name'][$siteLanguage];
		}
		else {
			$errorField = $_FILES[$FieldName]['error'];
			$sizeField = $_FILES[$FieldName]['size'];
			$tmpName = $_FILES[$FieldName]['tmp_name'];
			$Name = $_FILES[$FieldName]['name'];
		}
		
		
		if((!isset($Name) || ($Name) == '')) {
			return false;
		} else {
			if(($errorField == 0) && ($sizeField > 0) && ($error != true)) {
				//NEW CODE DIRECT IMAGE UPLOAD
				list($usec, $sec) = explode(' ', microtime());
				$tmp=(float) $sec + ((float) $usec * 100000);

				mt_srand($tmp);
				$randval1 = mt_rand();

				$str_filename = preg_replace("/[^A-Za-z0-9.-]/", "_", $Name); 
				while (strpos($str_filename,"__")>0) {  
					$str_filename = str_replace("__", "_", $str_filename); 
				}
				
				if($newfilename=="") {
					//$Upload_FileName = $randval1.'_'.$FieldName['name'];						
					//$Upload_FileName = $randval1.'_'.$str_filename;						
					$Upload_FileName = $str_filename;
				} else {
					$Upload_FileName = $newfilename;
				}

				//upload file on server
				if(file_exists($directorypath.'/'.$Upload_FileName)) {
					$Upload_FileName = $randval1."_".$Upload_FileName;
				}
				/*$dirPath1 = substr($directorypath, strlen($directorypath)-1);
				if($dirPath1 == '/'){
					$directorypath = substr($directorypath, 0, strlen($directorypath)-1);
				}*/
				move_uploaded_file($tmpName,$directorypath.'/'.$Upload_FileName );
			} else {
				$Upload_FileName = '';
			}
			return $Upload_FileName;
		}
	}

	public function UploadFileWithoutRandNo($FieldName,$directorypath,$newfilename="")
	{
		if((!isset($FieldName['name']) || ($FieldName['name']) == '')) {
			return false;
		} else {
			if(($FieldName['error'] == 0) && ($FieldName['size'] > 0) && ($error != true)) {
				//NEW CODE DIRECT IMAGE UPLOAD
				list($usec, $sec) = explode(' ', microtime());
				$tmp=(float) $sec + ((float) $usec * 100000);

				mt_srand($tmp);
				$randval1 = mt_rand();

				if($newfilename=="") {
					$Upload_FileName = $randval1.'_'.$FieldName['name'];	
					//$Upload_FileName = $FieldName['name'];
				} else {
					$Upload_FileName = $newfilename;
				}

				//upload file on server
				if(is_dir($directorypath)) {
					copy($FieldName['tmp_name'],$directorypath.'/'.$Upload_FileName );
				}
			} else {
				$Upload_FileName = '';
			}
			return $Upload_FileName;
		}
	}

	public function copyfile($FieldName,$sourcedirectorypath,$destinationdirectorypath,$newfilename=null)
	{
		if((!isset($FieldName) || ($FieldName) == '')) {
			return false;
		} else {
			if(isset($newfilename) && $newfilename != '' && file_exists($sourcedirectorypath.'/'.$FieldName)) {
				copy($sourcedirectorypath.'/'.$FieldName,$destinationdirectorypath.'/'.$newfilename);
				return $newfilename;
			} else {
				if(file_exists($sourcedirectorypath.'/'.$FieldName)) {
					copy($sourcedirectorypath.'/'.$FieldName,$destinationdirectorypath.'/'.$FieldName);
					return $FieldName;
				}
			}
		}
	}

	public function DeleteFile($FileName,$directorypath)
	{
		if(is_file($directorypath.'/'.$FileName)) {
			$delete = unlink($directorypath.'/'.$FileName);
		}

		if($delete)
			return true;
		else
			return false;
	}

	public function uploadvalidation($FieldName, $Arr_extensions, $SizeInByte, $siteLanguage=null)
	{
		$errors = '';
		
		
		if(!empty($siteLanguage)){
			$errorField = $_FILES[$FieldName]['error'][$siteLanguage];
			$sizeField = $_FILES[$FieldName]['size'][$siteLanguage];
			$tmpName = $_FILES[$FieldName]['tmp_name'][$siteLanguage];
			$Name = $_FILES[$FieldName]['name'][$siteLanguage];
		}else{
			$errorField = $_FILES[$FieldName]['error'];
			$sizeField = $_FILES[$FieldName]['size'];
			$tmpName = $_FILES[$FieldName]['tmp_name'];
			$Name = $_FILES[$FieldName]['name'];
		}
		
		if(($errorField == 0) && ($sizeField > 0)) {
			if (isset($tmpName)) {
				$UploadFile = explode(".",$Name);
				$Last = count($UploadFile)-1;
				$UploadedExtension = $UploadFile[$Last]; // Get the extenstion of uploaded image
				if(!empty($Arr_extensions)) {
					if(!(in_array(strtolower($UploadedExtension), $Arr_extensions)))
						$errors[$FieldName] = 'extError';
				}

				if(!empty($SizeInByte)) {
					if(($sizeField >= $SizeInByte))
						$errors[$FieldName] = 'sizeError';
				}
			}
		} else {
			$errors[$FieldName] = 'ExistError';
		}

		return $errors;
	}
}