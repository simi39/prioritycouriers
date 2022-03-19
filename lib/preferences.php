<?php
/**
 * Prerferences class is responsible for managing the default settings of the site.
 * 
 * Preferences for the site. Preferences class will have all the default
 * configurations of the site.Preferences if changed will get applied for the
 * whole site.
 * @version 1.0
 * @created 11-Jun-2005 11:16:34 AM
 */
class Preferences 
{ 


 /**
 * Send mail mail according to passed parameter
 * $flag : for checking $message  variable contain file or static content
 */
/************************************Send Mail function Start*****************************************/
	function SendMail($subject, $from, $to, $cc, $bcc, $type, $message,$attachfilename ,$sm_var='',$newsLetter=array())
	{
		global $subdomain;
		require_once(DIR_LIB_CLASSES_PHPMAILER.'class.phpmailer.php');
		
		$mail = new phpmailer();
		
		$mail->ClearAllRecipients();
		$mail->CharSet     = 	'UTF-8';
		$mail->Subject     = 	$subject;
		$mail->From    	   =	$from;

		$mail->FromName    = $from;
		$mail->AddReplyTo($from);
		
		$arr_localhost = array("radixusers.com", "radixdev210.com");
		$cnhosts = count($arr_localhost);
		$local_server = false;
		for($i=0; $i<$cnhosts; $i++) {
			if(strpos($_SERVER['HTTP_HOST'],$arr_localhost[$i])!==FALSE) {
				$local_server=true;
				break;
			}
		}
		if($local_server == true) {
			$mail->Mailer      = 'mail';
		} else {
	//		$mail->Host        = 'mail.live.onprintshop.com';
			$mail->Host	   	   = 'localhost';
			$mail->Username    = 'onlineco';
			$mail->Password    = 'madam6arouse*creepy';
			$mail->Mailer      = 'smtp';
		}
		
		$mail->Mailer      = 'mail';  // Set the mail method by Naresh Devra
		
		$mail->LangaugeFilePath = DIR_WS_CURRENT_LANGUAGE.'mailer_message.php' ;
		
		$mail->IsHTML(true); // True if HTML format otherwise false for text format		
		
		$mail->Body    = $message;
				
		if(is_array($attachfilename) && count($attachfilename) > 0) {
			foreach($attachfilename as $key => $attachfile) { //loop the Attachments to be added ...
				$mail->AddAttachment($attachfile);
			}
		} 
		
		if(is_array($to) && count($to) > 0) {
			foreach($to as $key => $toemail)
			{
				if(trim($toemail)!='') {
					$mail->AddAddress($toemail);
				}
			}
		}else{
			
			if(trim($to)!='') {
					$mail->AddAddress($to);
				}
		}
		
		if(is_array($cc) && count($cc) > 0) {
			foreach($cc as $key => $ccemail)
			{
				if(trim($ccemail)!='') {
					$mail->AddCC($ccemail);
				}
			}
		}
		
		if($mail->Send()) {
			return true;
		} else {
			return false;
		}
		
		$mail->ClearAddresses();
	}


/**
 * Returns Array of Data Which will not passed to the Next Page
 * 
 * Example of Parameter
 * $NotReqArray = array('Submit', 'Search', 'Id');
 */
	function NotToPassQueryString($NotReqArray=null){
		$nArray=array();
		if(is_array($NotReqArray) === true) {
			foreach ($NotReqArray as $param){
				$nArray[$param]=$_GET[$param];
			}
		}
		return $nArray;
	}
/**
* To Make query String for Requested page Get parameters
*/
	function GetAddressBarQueryString($NotReqArr=null)
	{
		$getvars = $_GET;
		
		$link_part = "";
		foreach($getvars as $k => $v) {
	   		if(is_array($NotReqArr) === true) {
	   			if(array_key_exists($k,$NotReqArr) === true)
	   			{	} else {
	   				if($v!=''){
						$link_part .= "&$k=$v";
	   				}
	   			}
	   		} else {
	   			if($k == $NotReqArr)
	   			{	} else {
	   				if($v != ''){
						$link_part .= "&$k=$v";
	   				}
	   			}
	   		}
		}
		$link_part = substr($link_part,1,strlen($link_part));
		return $link_part;
	}

/********************  added on 28/09/05  ****************/

/**************** added on 3/10/2005 *********************/	

    function datediff($interval, $datefrom, $dateto, $using_timestamps = false) 
	{
/*
How to use : echo datediff('w', '9 July 2003', '4 March 2004', false);
$interval can be:
yyyy - Number of full years
q - Number of full quarters
m - Number of full months
y - Difference between day numbers
  (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
d - Number of full days
w - Number of full weekdays
ww - Number of full weeks
h - Number of full hours
n - Number of full minutes
s - Number of full seconds (default)
*/
		  
		if (!$using_timestamps) {
			$datefrom = strtotime($datefrom, 0);
			$dateto = strtotime($dateto, 0);
		}
		$difference =  $datefrom- $dateto; // Difference in seconds
		// echo "<br>".$difference."<br>";
		switch($interval) {
			case 'yyyy': // Number of full years
		      $years_difference = floor($difference / 31536000);
		      if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
		        $years_difference--;
		      }
		      if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
		        $years_difference++;
		      }
		      $datediff = $years_difference;
		      break;

		    case "q": // Number of full quarters
		 
		      $quarters_difference = floor($difference / 8035200);
		      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
		        $months_difference++;
		      }
		      $quarters_difference--;
		      $datediff = $quarters_difference;
		      break;

		    case "m": // Number of full months
		 
		      $months_difference = floor($difference / 2678400);
		      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
		        $months_difference++;
		      }
		      $months_difference--;
		      $datediff = $months_difference;
		      break;
 
		    case 'y': // Difference between day numbers
		      $datediff = date("z", $dateto) - date("z", $datefrom);
		      break;

		    case "d": // Number of full days
		      $datediff = floor($difference / 86400);
		      break;

		    case "w": // Number of full weekdays
		      $days_difference = floor($difference / 86400);
		      $weeks_difference = floor($days_difference / 7); // Complete weeks
		      $first_day = date("w", $datefrom);
		      $days_remainder = floor($days_difference % 7);
		      $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
		      if ($odd_days > 7) { // Sunday
		        $days_remainder--;
		      }
		      if ($odd_days > 6) { // Saturday
		        $days_remainder--;
		      }
		      $datediff = ($weeks_difference * 5) + $days_remainder;
		      break;

		    case "ww": // Number of full weeks
		      $datediff = floor($difference / 604800);
		      break;

		    case "h": // Number of full hours
		      $datediff = floor($difference / 3600);
		      break;

		    case "n": // Number of full minutes
		      $datediff = floor($difference / 60);
		      break;

		    default: // Number of full seconds (default)
		      $datediff = $difference;
		      break;
		}
		return $datediff;
	}




// Date format
	function SetDateFormat($OldDate, $LayOut)
  	{  			
		//$OldDate = ereg_replace('[^0-9]', '', $OldDate);
		$OldDate = preg_replace('/[^0-9]/', '', $OldDate);			
		$Year = substr($OldDate,0,4); 
		$Month = substr($OldDate,4,2); 			
		$Day = substr($OldDate,6,2); 
		$Hour = substr($OldDate,8,2); 
		$Minute = substr($OldDate,10,2); 
		$Second = substr($OldDate,12,2); 
		$NewDate = date($LayOut, mktime($Hour, $Minute, $Second, $Month, $Day, $Year)); 
		return $NewDate; 
  	}
  	/*******************************************************************************************/
function  ImageUpload($htmlControlName,$dest_dir,$MaxImageSize=null,$ToSaveFileName=null,$prepend=null,$append=null)
{
			$upload = new http_upload('en'); 
			$file = $upload->getFiles($htmlControlName);
			//dprint($file);
			if($MaxImageSize != '')
			{
				$MaxImageSize=$MaxImageSize;
			}
			else{
			$MaxImageSize = MAX_SIZE_MOUNTAIN_LARGE_IMG;
			}
			srand((double)microtime()*1000000);
			$TemporaryCode=md5(uniqid(rand()));
			$UniqueCode=substr($TemporaryCode,0,4);
			$prepend = null;

			foreach ($file as $key => $obj) {
				if ($key == "upload") {
					$ToSaveFileName = trim($obj['name']);
					$ToSaveFileName=str_replace(' ','_',$ToSaveFileName);
					$ToSaveFileName=str_replace('%20','_',$ToSaveFileName);
					$ToSaveFileNameTemp = explode(".",$ToSaveFileName);
					$ToSaveFileNameTemp[0]=self::RemoveSpaceName($ToSaveFileNameTemp[0]);
					$ToSaveFileName = $ToSaveFileNameTemp[0]."_org".".".$ToSaveFileNameTemp[1];
					
				}	
			}	
	
			if(isset($MaxImageSize) && !empty($MaxImageSize))
			{
			}
			else
			{
				$MaxImageSize = "512000";//$GLOBALS['Image_Max_Size'];	
			}
			if(isset($ToSaveFileName) && !empty($ToSaveFileName))
			{	
			}
			else
			{
				$ToSaveFileName = "uniq";
			}
			if(($file->upload['size']/1024) <= $MaxImageSize)
			{	
				if (PEAR::isError($file)) 
				{
						$mystring = $_SERVER['REQUEST_URI'];
						$findme   = '?';
						$pos = strpos($mystring, $findme);
						if ($pos === false)
						 {
							$HeaderMessage="?Error=InSize";
						}
						else{
							$HeaderMessage="&Error=InSize";
						}

						header('location:'.$_SERVER['REQUEST_URI'].$HeaderMessage);
						exit;
				}
				if ($file->isValid()) 
				{
					$file->setName($ToSaveFileName,null,null);
					$dest_name = $file->moveTo($dest_dir);
					if (PEAR::isError($dest_name)) 
					{
						//Error($dest_name->getMessage().$dest_dir,$dest_name);
						$mystring = $_SERVER['REQUEST_URI'];
						$findme   = '?';
						$pos = strpos($mystring, $findme);
						if ($pos === false) 
						{
							
								$pos1 = strpos($mystring, "Error=Extension");
								if($pos1==false)
								{
									$HeaderMessage="?Error=Extension";
								}
						}else{
							$pos1 = strpos($mystring, "Error=Extension");
								if($pos1==false)
								{
									$HeaderMessage="&Error=Extension";
								}
							
						}

						header('location:'.$_SERVER['REQUEST_URI'].$HeaderMessage);
						exit;
						
					}
					return $dest_name;
				}
				if($file->isMissing())
				{
					return false;//$GLOBALS['no_image_file'];
				}
				return null;
			}
			else   
			{
				return -1;
			}
		  
		}
/*******************************************************************************************/	


}//end of class

?>