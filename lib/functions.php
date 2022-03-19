<?php
/**
 * This file is contain some common function
 *
 * @author     Radixweb <team.radixweb@radixweb.com>
 * @copyright  Copyright (c) 2009, Radixweb
 * @version    1.0
 * @since      1.0
 */

//code by parag +start

function mbStringToArray ($str) {
    if (empty($str)) return false;
    $len = mb_strlen($str);
    $array = array();
    for ($i = 0; $i < $len; $i++) {
        $array[] = mb_substr($str, $i, 1);
    }
    return $array;
}

function mb_chunk_split($str, $len, $glue) {
    if (empty($str)) return false;
    $array = mbStringToArray ($str);
    $n = -1;
    $new = '';
    foreach ($array as $char) {
        $n++;
        if ($n < $len) $new .= $char;
        elseif ($n == $len) {
            $new .= $glue . $char;
            $n = 0;
        }
    }
    return $new;
}
function filteredBusinessDate($startDate,$state="") {
    //$holiday = day_holiday();
    //20210404
    require_once(DIR_WS_MODEL . "PublicHolidayMaster.php");

    $PublicHolidayMasterObj = new PublicHolidayMaster();
	$PublicHolidayMasterObj	= $PublicHolidayMasterObj->Create();
	$PublicHolidayData		= new PublicHolidayData();


    if(isset($state) && !empty($state))
    {
    	$fieldHolidayArr =array();
		$fieldHolidayArr=array("sdate");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'state', 'Search_Value'=>$state, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		$PublicHolidayData=$PublicHolidayMasterObj->getPublicHoliday($fieldHolidayArr,$seaByArr);
        foreach ($PublicHolidayData as $holidayRow){

			$holiday[] = strtotime(date('d-m-Y',strtotime($holidayRow->sdate)));
		}

    }else{
    	$holiday = array(
					strtotime('02-04-2021'),
					strtotime('03-04-2021'),
					strtotime('04-04-2021'),
					strtotime('06-04-2021'),

					);
    }


	//Y-m-d H:i
	//2021-03-02 17:50:18
	/*$holiday = array(
	'2021-04-02',
	'2021-04-03',
	'2021-04-04',
	'2021-04-05',
	);*/
   $start = date_create_from_format('d-m-Y H:i:s', $startDate. ' 00:00:00');
   //$format = 'Y-m-d';
   $format = 'd-m-Y';
    //$start = DateTime::createFromFormat($format, $startDate. ' 00:00:00');

    do {

        $ts = (int)$start->format('U');
        //echo "ts:".$ts."</br>";
        $dow = (int)$start->format('w');
       // echo "dow:".$dow."</br>";
       /* if(in_array($ts, $holiday) && ($dow == 0 || $dow == 6)){
        	$start->modify('+1 day');
        }elseif (in_array($ts, $holiday) && ($dow != 0 && $dow != 6)) {
        	# code...
        	$start->modify('+1 day');
        }else{
        	break;
        }*/

        if ((!in_array($ts, $holiday) && ($dow != 0 && $dow != 6))) break;
        $start->modify('+1 day');
        //print_r($start);
    }
    while (true);
    return $start->format($format);
}

function aWeekBusinessDays($state,$currentZoneDate){
	require_once(DIR_WS_MODEL . "PublicHolidayMaster.php");

    $PublicHolidayMasterObj = new PublicHolidayMaster();
	$PublicHolidayMasterObj	= $PublicHolidayMasterObj->Create();
	$PublicHolidayData		= new PublicHolidayData();
	//echo $state."---".$currentZoneDate."</br>";

	if(isset($state) && !empty($state))
    {
    	$fieldHolidayArr =array();
		$fieldHolidayArr=array("sdate");
		$seaByArr=array();
		$seaByArr[]=array('Search_On'=>'state', 'Search_Value'=>$state, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		$PublicHolidayData=$PublicHolidayMasterObj->getPublicHoliday($fieldHolidayArr,$seaByArr);
        foreach ($PublicHolidayData as $holidayRow){

			$holidays[] = date('d-m-Y',strtotime($holidayRow->sdate));
		}

    }

    $weekend = array('Sun','Sat');
	//echo "currentZoneDate:".$currentZoneDate."</br>";
	/*echo "<pre>";
	print_r($holidays);
	echo "</pre>";*/
    $date = new DateTime($currentZoneDate);

	$nextDay = clone $date;
	$i = 0; // We have 0 future dates to start with
	$nextDates = array(); // Empty array to hold the next 3 dates

	while ($i < 9)
	{

		if($i==0){
			$nextDay = clone $date;
		}else{
			$nextDay->add(new DateInterval('P1D'));
		}

	     // Add 1 day
		/*echo "value of i".$i."</br>";
		echo "<pre>";
		print_r($holidays);
		echo "</pre>";
		echo $nextDay->format('d-m-Y');
		 exit();*/
	   // if (in_array($nextDay->format('d-m-Y'), $holidays)) continue; // Don't include year to ensure the check is year independent
	   if (in_array($nextDay->format('d-m-Y'), $holidays)) {
			$i++;
			continue;
		}
	    // Note that you may need to do more complicated things for special holidays that don't use specific dates like "the last Friday of this month"
	    //if (in_array($nextDay->format('D'), $weekend)) continue;
		if (in_array($nextDay->format('D'), $weekend)) {
            $i++;
            continue;
        }
	    // These next lines will only execute if continue isn't called for this iteration
	    $nextDates[] = $nextDay->format('d-m-Y');

	    $i++;
	}
	/*echo "<pre>";
	print_r($date);
	echo "</pre>";
	echo "<pre>";
	print_r($nextDates);
	echo "</pre>";
	exit();*/
	return $nextDates;
}
//code by parag +end

/* For PDF files these functions are used */
function GenerateWord()
{
	//Get a random word
	$nb=rand(3,10);
	$w='';
	for($i=1;$i<=$nb;$i++)
		$w.=chr(rand(ord('a'),ord('z')));
	return $w;
}
function str_replace_assoc(array $replace, $subject) {
   return str_replace(array_keys($replace), array_values($replace), $subject);
}
function GenerateSentence()
{
	//Get a random sentence
	$nb=rand(1,10);
	$s='';
	for($i=1;$i<=$nb;$i++)
		$s.=GenerateWord().' ';
	return substr($s,0,-1);
}
/* End of the pdf files functions used */

function generateRandomNo($length=10)
{
		srand((double)microtime()*1000000);
		$TemporaryCode11=uniqid(rand());
		return substr($TemporaryCode11,0,$length);
}

function funFileWright($filename, $filecontent)
{
	if($fp = @fopen($filename,"w")) {
		$contents = fwrite($fp, $filecontent);
		fclose($fp);
		return true;
	} else {
	  return false;
	}
}

function funFileCount($filename)
{
	$lines = file($filename);
	$l_count = count($lines);

	return $l_count;
}


function funFileRead($filename)
{
	$lines = file($filename);
	$l_count = count($lines);
	for($x = 0; $x< $l_count; $x++)
	{
	  $content.= $lines[$x];
	}
	return $content;
}
function addWrapper (&$value, $key, $wrapper) {
	$value = $wrapper.$value.$wrapper;
}
function CreateDirectory($dirname,$path)
{
		if (!file_exists($path.$dirname)) {
		if (mkdir($path.$dirname)) {
			chmod($path.$dirname,0777);
			return true;
		} else {
			$ErrorMessage	= "Template Dir can't create";
			return false;
		}
	}
}



function createthumbImage($infile,$maxw=100,$maxh=100,$stretch = false) {
	#
	/* Create new imagick object */
	#
	if (!is_file($infile)) {
		//trigger_error("Cannot open file: $infile",E_USER_WARNING);
	    return false;
	}
	$outfile =  getthumbimgname($infile);

	$im = new imagick($infile);
	#

	$size = getimagesize($infile);
	list($neww,$newh) = scale_dimensions($size[0],$size[1],$maxw,$maxh,$stretch);

	#
	/* Clone the object for different types */
	#
	$fit = $im->clone();
	#
	/* Create a fit thumbnail, both sides need to be smaller
	#
	   than the given values, save dimensions */
	#
	$fit->thumbnailImage($neww, $newh, true );
	#
	$fit->writeImage($outfile);
}
// Scales dimensions
function scale_dimensions($w,$h,$maxw,$maxh,$stretch = FALSE)
{
    if (!$maxw && $maxh) {
      // Width is unlimited, scale by width
      $newh = $maxh;
      if ($h < $maxh && !$stretch) { $newh = $h; }
      else { $newh = $maxh; }
      $neww = ($w * $newh / $h);
    } elseif (!$maxh && $maxw) {
      // Scale by height
      if ($w < $maxw && !$stretch) { $neww = $w; }
      else { $neww = $maxw; }
      $newh = ($h * $neww / $w);
    } elseif (!$maxw && !$maxh) {
      return array($w,$h);
    } else {
      if ($w / $maxw > $h / $maxh) {
        // Scale by height
        if ($w < $maxw && !$stretch) { $neww = $w; }
        else { $neww = $maxw; }
        $newh = ($h * $neww / $w);
      } elseif ($w / $maxw <= $h / $maxh) {
        // Scale by width
        if ($h < $maxh && !$stretch) { $newh = $h; }
        else { $newh = $maxh; }
        $neww = ($w * $newh / $h);
      }
    }
    return array(round($neww),round($newh));
}

function getImageScaleSize($ImageSysPath=null, $newWidth=0, $newHeight=0, $stretch = FALSE){
	$Size = '';
	if( $ImageSysPath!='' && file_exists($ImageSysPath) && is_file($ImageSysPath) ) {

		list($width, $height, $type, $attr) = getimagesize($ImageSysPath);
		if($newWidth > 0 || $newHeight > 0){
			$GetImageSize = scale_dimensions($width, $height, $newWidth, $newHeight, $stretch);
			$Size[0]  = $GetImageSize[0];	// New Width
			$Size[1] = $GetImageSize[1];	// New Height
		}else{
			$Size[0]  = $width;				// New Width
			$Size[1] = $height;				// New Height
		}
	}
	return $Size;
}


function getimageextension($filename)
{
	$pathinfo = pathinfo($filename);
	$image_extension = $pathinfo['extension'];
	return $image_extension;
}

function getthumbimgname($filename)
{
	$pathinfo = pathinfo($filename);
	$image_extension = $pathinfo['extension'];
	$newFileName = substr($filename,0,(strlen($filename)-strlen($image_extension)-1)).'_thumb.'.$image_extension;
	return $newFileName;
}

function getImageFromThumbImg($filename)
{
	$pathinfo = pathinfo($filename);
	$image_extension = $pathinfo['extension'];
	$newFileName = substr($filename,0,(strlen($filename)-strlen($image_extension)-7)).'.'.$image_extension;
	return $newFileName;
}



function recursive_remove_directory($directory, $empty=FALSE)
{
    // if the path has a slash at the end we remove it here
    if(substr($directory,-1) == '/') {
        $directory = substr($directory,0,-1);
    }

    // if the path is not valid or is not a directory ...
    if(!file_exists($directory) || !is_dir($directory)) {
        // ... we return false and exit the function
        return FALSE;

    // ... if the path is not readable
    } elseif(!is_readable($directory)) {
        // ... we return false and exit the function
        return FALSE;
    // ... else if the path is readable
    } else {
        // we open the directory
        $handle = opendir($directory);

        // and scan through the items inside
        while (FALSE !== ($item = readdir($handle)))
        {
            // if the filepointer is not the current directory
            // or the parent directory
            if($item != '.' && $item != '..')
            {
                // we build the new path to delete
                $path = $directory.'/'.$item;

                // if the new path is a directory
                if(is_dir($path))
                {
                    // we call this function with the new path
                    recursive_remove_directory($path);

                // if the new path is a file
                }else{
                    // we remove the file
                    unlink($path);
                }
            }
        }
        // close the directory
        closedir($handle);

        // if the option to empty is not set to true
        if($empty == FALSE) {
            // try to delete the now empty directory
            if(!rmdir($directory))
            {
                // return false if not possible
                return FALSE;
            }
        }
        // return success
        return TRUE;
    }
}

function countDigits( $string )
{
	return preg_match_all( "/[0-9]/", $string );
}	



function show_page_link($pagename=null,$SSL=false)
{


	if($pagename != '' ) {
		//$pagename = get_seo_link($pagename);

		if(ENABLE_SSL == true || $SSL == true) {
			$url = "http://" . SITE_URL_WITHOUT_PROTOCOL . $pagename;
		}else{
			 $url = SITE_URL  . $pagename;
		}
	}
	return $url;
}

/**
* To Make query String for Deleted Record for Requested page Get parameters
*/
function GetAddressBarQueryStringForDelete($TotalRecords=null, $NotToPass=null) {
	$link_part='';
	if($TotalRecords!=null){
		$start=$_GET['startRow'];
		$PageGroup=$_GET['PageGroup'];
		$PageNo=$_GET['PageNo'];

		$RemainRecords = $TotalRecords-1;
		if($RemainRecords<=$start && $RemainRecords>0 && $start >=1){
			if($NotToPass!=null){
				$NotToPassQueryArray=array_merge($NotToPass, array('startRow', 'PageGroup', 'PageNo'));
			}else{
				$NotToPassQueryArray=array('startRow', 'PageGroup', 'PageNo');
			}

			$NotReqArr=Preferences::NotToPassQueryString($NotToPassQueryArray);

			$Param=Preferences::GetAddressBarQueryString($NotReqArr);
			$start=$start-ADMIN_NO_RECORDS;
			$PageNo=$PageNo-1;

			$link_part='startRow='.$start.'&PageGroup='.$PageGroup.'&PageNo='.$PageNo.(($Param!='')?"&".$Param:'');

		}else{

			$NotReqArr=Preferences::NotToPassQueryString($NotToPass);
			$link_part=Preferences::GetAddressBarQueryString($NotReqArr);

		}
	}
	return $link_part;
}

/**
 * function addCSSFile
 * @param : $arr_css_include : include jcss file which defined in this array
 * @param : $arr_css_exclude : exlude css file which defined in this array
 *
 */

function addCSSFile($inlcusion_files=array(), $exclusion_files=array()) {
	if(!empty($inlcusion_files)) {
		$arr_main_css = array_unique($inlcusion_files);
		if(!empty($exclusion_files)) {
			$arr_main_css = array_diff($arr_main_css, $exclusion_files);
		}
		if(!empty($arr_main_css)) {
			foreach ($arr_main_css as $CSSPath) {
				echo '<link rel="stylesheet" type="text/css" href="'.DIR_HTTP_CSS . $CSSPath.'">'. "\n";
			}
		}
	}
}
/**
 * function addCSSFileBelow
 * @param : $arr_css_below_include : include jcss file which defined in this array
 * @param : $arr_css_below_exclude : exlude css file which defined in this array
 *
 */

function addCSSFileBelow($inlcusion_files=array(), $exclusion_files=array()) {
	if(!empty($inlcusion_files)) {
		$arr_main_css = array_unique($inlcusion_files);
		if(!empty($exclusion_files)) {
			$arr_main_css = array_diff($arr_main_css, $exclusion_files);
		}
		if(!empty($arr_main_css)) {
			foreach ($arr_main_css as $CSSPath) {
				echo '<link rel="stylesheet" type="text/css" href="'.DIR_HTTP_CSS . $CSSPath.'" >'. "\n";
			}
		}
	}
}
/**
 * function addPluginCSSFile
 * @param : $arr_css_plugin_include : include jcss file which defined in this array
 * @param : $arr_css_plugin_exclude : exlude css file which defined in this array
 *
 */

function addPluginCSSFile($inlcusion_files=array(), $exclusion_files=array()) {
 if(!empty($inlcusion_files)) {
  $arr_main_css = array_unique($inlcusion_files);
  if(!empty($exclusion_files)) {
   $arr_main_css = array_diff($arr_main_css, $exclusion_files);
  }
  if(!empty($arr_main_css)) {
   foreach ($arr_main_css as $CSSPluginPath) {
    echo '<link rel="stylesheet" type="text/css" href="'.DIR_HTTP_PLUGINS . $CSSPluginPath.'">'. "\n";
   }
  }
 }
}
/**
 * function addPluginCSSFileBelow
 * @param : $arr_css_plugin_below_include : include jcss file which defined in this array
 * @param : $arr_css_plugin_below_exclude : exlude css file which defined in this array
 *
 */

function addPluginCSSFileBelow($inlcusion_files=array(), $exclusion_files=array()) {
 if(!empty($inlcusion_files)) {
  $arr_main_css = array_unique($inlcusion_files);
  if(!empty($exclusion_files)) {
   $arr_main_css = array_diff($arr_main_css, $exclusion_files);
  }
  if(!empty($arr_main_css)) {
   foreach ($arr_main_css as $CSSPluginPath) {
    echo '<link rel="stylesheet" type="text/css" href="'.DIR_HTTP_PLUGINS . $CSSPluginPath.'" >'. "\n";
   }
  }
 }
}
/**
 * function addCSSFileAdmin
 * @param : $arr_css_admin_include : include jcss file which defined in this array
 * @param : $arr_css__admin_exclude : exlude css file which defined in this array
 *
 */

function addCSSFileAdmin($inlcusion_files=array(), $exclusion_files=array()) {
	if(!empty($inlcusion_files)) {
		$arr_main_css = array_unique($inlcusion_files);
		if(!empty($exclusion_files)) {
			$arr_main_css = array_diff($arr_main_css, $exclusion_files);
		}
		if(!empty($arr_main_css)) {
			foreach ($arr_main_css as $CSSPath) {
				echo '<link rel="stylesheet" type="text/css" href="'.DIR_HTTP_ADMIN_CSS . $CSSPath.'">'. "\n";
			}
		}
	}
}
/**
 * function addJavaScriptFile
 * @param : $arr_javascript_include : include js/php file which defined in this array
 * @param : $arr_javascript_exclude : exlude js/php file which defined in this array
 *
 */
function addJavaScriptFile($inlcusion_files=array(), $exclusion_files=array()) {

	if(!empty($inlcusion_files)) {
		$arr_main_jscript = array_unique($inlcusion_files);
		if(!empty($exclusion_files)) {
			$arr_main_jscript = array_diff($arr_main_jscript, $exclusion_files);
		}
		if(!empty($arr_main_jscript)) {

			foreach ($arr_main_jscript as $jScriptName) {
				//echo $jScriptName."jscript".DIR_WS_JSCRIPT."</br>";
				if($jScriptName!="" && file_exists(DIR_WS_JSCRIPT . $jScriptName)) {
					$str_ext = strtolower(getimageextension($jScriptName));
					//echo "jscriptname:".$jScriptName."str ext:".$str_ext."</br>";
					//echo DIR_HTTP_JSCRIPT . $jScriptName."</br>";
					//exit();
					if($str_ext=="js") {
						//echo
						echo '<script type="text/javascript" src="'.DIR_HTTP_JSCRIPT . $jScriptName.'"></script>'. "\n";
					}
					elseif($str_ext=="php") {
						require_once(DIR_WS_JSCRIPT . $jScriptName);
					}
				}
			}
		}
	}
}
/**
 * function addJavaScriptFileBelow
 * @param : $arr_javascript_below_include : include js/php file which defined in this array
 * @param : $arr_javascript_below_exclude : exlude js/php file which defined in this array
 *
 */
function addJavaScriptFileBelow($inlcusion_files=array(), $exclusion_files=array()) {
	if(!empty($inlcusion_files)) {
		$arr_main_jscript = array_unique($inlcusion_files);
		if(!empty($exclusion_files)) {
			$arr_main_jscript = array_diff($arr_main_jscript, $exclusion_files);
		}
		if(!empty($arr_main_jscript)) {
			foreach ($arr_main_jscript as $jScriptName) {
				if($jScriptName!="" && file_exists(DIR_WS_JSCRIPT . $jScriptName)) {
					$str_ext = strtolower(getimageextension($jScriptName));
					if($str_ext=="js") {
						echo '<script type="text/javascript" src="'.DIR_HTTP_JSCRIPT . $jScriptName.'"></script>'. "\n";
					}
					elseif($str_ext=="php") {
						require_once(DIR_WS_JSCRIPT . $jScriptName);
					}
				}
			}
		}
	}
}
/**
 * function addPluginJavaScriptFile
 * @param : $arr_javascript_plugin_include : include js/php file which defined in this array
 * @param : $arr_javascript_plugin_exclude : exlude js/php file which defined in this array
 *
 */
function addPluginJavaScriptFile($inlcusion_files=array(), $exclusion_files=array()) {
 if(!empty($inlcusion_files)) {
  $arr_main_jscript = array_unique($inlcusion_files);
  if(!empty($exclusion_files)) {
   $arr_main_jscript = array_diff($arr_main_jscript, $exclusion_files);
  }
  /*echo "<pre>";
  print_r($arr_main_jscript);
  echo "</pre>";*/
  //exit();
  if(!empty($arr_main_jscript)) {
   foreach ($arr_main_jscript as $jScriptName) {
    if($jScriptName!="" && file_exists(DIR_WS_PLUGINS . $jScriptName)) {
     $str_ext = strtolower(getimageextension($jScriptName));
     if($str_ext=="js") {
      	echo '<script type="text/javascript" src="'.DIR_HTTP_PLUGINS . $jScriptName.'"></script>'. "\n";
     }

    }
   }
  }
 }
}
/**
 * function addPluginJavaScriptFileBelow
 * @param : $arr_javascript_plugin_below_include : include js/php file which defined in this array
 * @param : $arr_javascript_plugin_below_exclude : exlude js/php file which defined in this array
 *
 */
function addPluginJavaScriptFileBelow($inlcusion_files=array(), $exclusion_files=array()) {
 if(!empty($inlcusion_files)) {
  $arr_main_jscript = array_unique($inlcusion_files);
  if(!empty($exclusion_files)) {
   $arr_main_jscript = array_diff($arr_main_jscript, $exclusion_files);
  }

  if(!empty($arr_main_jscript)) {
  	/*echo "<pre>";
  print_r($arr_main_jscript);
  echo "</pre>";
  exit();*/
   foreach ($arr_main_jscript as $jScriptName) {
    if($jScriptName!="" && file_exists(DIR_WS_PLUGINS . $jScriptName)) {
     $str_ext = strtolower(getimageextension($jScriptName));
     if($str_ext=="js") {
      echo '<script src="'.DIR_HTTP_PLUGINS . $jScriptName.'" type="text/javascript"></script>'. "\n";
     }

    }
   }
  }
 }
}
/**
 * User Authentication
 *
 * @param string $str_email =>  Email String
 * @param unknown_type $str_pwd	 =>  Password
 * @return mix
 */
function user_athuentication($str_email, $str_pwd) {
	require_once("bcrypt.php");
	require_once(DIR_WS_MODEL . "IPAddressMaster.php");

	$IPAddressMasterObj = new IPAddressMaster();
	$IPAddressMasterObj = $IPAddressMasterObj->Create();

	$error = array();
	$str_email = trim($str_email);
	$bcrypt = new bcrypt(12);
	$has_pwd  = $bcrypt->genHash($str_pwd);
	$clientip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$csrf = new csrf();
	$filename = basename($_SERVER['PHP_SELF']);

	$resultIP = checkIPAddress($clientip,$str_email); // check the ip address for ban
	$result = checkEmailAddress($str_email);
    if($resultIP == 1)
	{

	  $error['error_password'] = COMMON_LOGIN_ATTEMPTS;
	  return $error;
	}


	if($result == 1)
	{
	  $error['error_password'] = COMMON_LOGIN_ATTEMPTS;
	  return $error;

	}



	$error['error_email']		 = isEmpty($str_email,ERROR_EMAIL_ID_IS_REQUIRED);
	$error['error_password']	 = isEmpty($str_pwd,ERROR_PASSWORD_REQUIRE);

	if(empty($error['error_email'])) {
		$error['error_email'] = checkEmailPattern($str_email, ERROR_EMAIL_ID_INVALID);
	}

	if(empty($error['error_password'])) {
		if(checkPassword($str_pwd))
		{
			$error['error_password'] = "Either the email address or password you entered is incorrect. Please try again.";
		}
	}

	if(empty($error['error_email']))
	{
		if(!empty($str_email))
		{
			require_once(DIR_WS_MODEL . "UserMaster.php");

			$UserMasterObj = new UserMaster();
			$UserMasterObj = $UserMasterObj->Create();

			$userSeaArr = array();

			$userSeaArr[] = array('Search_On'=>'email', 'Search_Value'=>$str_email, 'Type'=>'string', 'Equation'=>'Like', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
			$userSeaArr[] = array('Search_On'=>'deleted', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
			$DataUser  = $UserMasterObj->getUser(null, $userSeaArr);
			$DataUser = $DataUser[0];

			if(!empty($DataUser))
			{
				$HashFromDB = $DataUser['password'];
			}
			if (password_verify($str_pwd, $HashFromDB)) {
			    $pass_error = true;
			}
			else {
			    $pass_error = false;
			}
			//Commented By Smita 11 Dec 2020 $pass_error = $bcrypt->verify($str_pwd, $HashFromDB);

		}


		if(empty($pass_error))
		{
			$error['error_password'] = COMMON_EMAIL_PASSWORD;
		}
	}
	$err_flag = false;
	foreach($error as $key => $Value) {
		if($Value != '') {
			$err_flag=true;
		}
	}

	if($err_flag == false) {


		if(isEmpty(valid_input($_POST['ptoken']), true)){
			logOut();
		}else{
			$csrf->checkcsrf($_POST['ptoken']);
		}
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		exit();*/
		$flag_sess = false;
		if(empty($DataUser)) {
			/* Check User has Enter Master Admin Password or Not */
			require_once(DIR_WS_MODEL . "AdminLoginMaster.php");
			$AdminLoginMasterObj = new AdminLoginMaster();
			$AdminLoginMasterObj = $AdminLoginMasterObj->Create();

			$adminUserSeaArr = array();
			$adminUserSeaArr[] = array('Search_On'=>'master_password', 'Search_Value'=>$str_pwd, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
			$adminUserSeaArr[] = array('Search_On'=>'superadmin', 'Search_Value'=>1, 'Type'=>'string', 'Equation'=>'Like', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
			$AminUserData  = $AdminLoginMasterObj->getAdminLogin(null,$adminUserSeaArr);
			if(!empty($AminUserData)) {
				$userSeaArr = array();
				$userSeaArr[] = array('Search_On'=>'email', 'Search_Value'=>$str_email, 'Type'=>'string', 'Equation'=>'Like', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
				$userSeaArr[] = array('Search_On'=>'deleted', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
				//$userSeaArr[] = array('Search_On'=>'customer_type', 'Search_Value'=>'R', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
				$DataUser  = $UserMasterObj->getUser(null, $userSeaArr);
			}
			$DataUser  = $DataUser[0];
		}
		/*echo "<pre>";
		print_r($DataUser);
		echo "</pre>";
		exit();*/
		 $flag_sess = create_user_session($DataUser);

		 if($flag_sess) {
			$ObjUserData = new UserData();
			$ObjUserData->last_login_date = date('Y-m-d H:i:s');
			$ObjUserData->userid = $DataUser['userid'];
			$ObjUserData->login_attempt = 0;
			//$ObjUserData->last_login_attempt_datetime = date('Y-m-d H:i:s');
			$ObjUserData->last_login_attempt_datetime = '0000-00-00 00:00:00';
			$changeStatus = array("last_login_date","last_login_attempt_datetime","login_attempt");
			$UserMasterObj->editUser($ObjUserData, $changeStatus);$IPAddressMasterObj->deleteIPAddress($clientip);
		}

		return $flag_sess;
	}else
	{
		//echo "userid:".$DataUser['userid'];
		//exit();
		if(!empty($DataUser['userid']))
		{
			/* for updating the attempts in user table*/
			$ObjUserData = new UserData();
			$ObjUserData->last_login_attempt_datetime = date('Y-m-d H:i:s');
			$ObjUserData->userid = $DataUser['userid'];
			$ObjUserData->login_attempt = $DataUser['login_attempt']+1;
			$changeStatus = array("last_login_attempt_datetime","login_attempt");
			$UserMasterObj->editUser($ObjUserData, $changeStatus);
			/* for updating the attempts in user table*/
		}
		/* for updating the attempts in login_attempts table*/
		addIPAttempts($clientip);
		/* for updating the attempts in login_attempts table*/
		return $error;
	}
}
function checkIPAddress($ip,$emailid='')
{
	require_once(DIR_WS_MODEL . "IPAddressMaster.php");
	require_once(DIR_WS_MODEL . "UserMaster.php");

	$UserMasterObj = new UserMaster();
	$UserMasterObj = $UserMasterObj->Create();
	$IPAddressMasterObj = new IPAddressMaster();
	$IPAddressMasterObj = $IPAddressMasterObj->Create();
	$IPAddressFieldArr   = array('attempts','(CASE when lastlogin is not NULL and DATE_ADD(LastLogin, '.LOGIN_IP_TIME_PERIOD.')>NOW() then 1 else 0 end) as Denied');
	$IPAddressSeaArr   = array();
	$IPAddressSeaArr[] = array('Search_On'=>'ip', 'Search_Value'=>$ip, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$DataIPAddress  = $IPAddressMasterObj->getIPAddress($IPAddressFieldArr, $IPAddressSeaArr);
	$DataIPAddress = $DataIPAddress[0];

	if(empty($DataIPAddress))
	{
		return 0;
	}
	if ($DataIPAddress["attempts"] >= ATTEMPTS_NUMBER)
    {
	  if($DataIPAddress["Denied"] == 1)
	  {
		  /*
		  $attempts = $DataIPAddress["attempts"];
			if($attempts==ATTEMPTS_NUMBER)
			{
				$attempts = $DataIPAddress["attempts"]+1;
				$QueryString = 'UPDATE login_attempts SET attempts ="'.$attempts.'",lastlogin=NOW() WHERE ip = "'.$ip.'"';
				$IPAddressMasterObj->editIPAddress($DataIPAddress, $QueryString);
			} */
		 return 1;
	  }
	 else
	 {
		//$QueryString = 'UPDATE login_attempts SET attempts ="0",lastlogin=NOW() WHERE ip = "'.$ip.'"';
		//$IPAddressMasterObj->editIPAddress($IPAddressData, $QueryString);
		$IPAddressMasterObj->deleteIPAddress($ip);
		//exit();
		if($emailid !='')
		{
			$userSeaArr = array();
			$userSeaArr[] = array('Search_On'=>'email', 'Search_Value'=>$emailid, 'Type'=>'string', 'Equation'=>'Like', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
			$userSeaArr[] = array('Search_On'=>'deleted', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
			$DataUser  = $UserMasterObj->getUser($userFieldArr, $userSeaArr);
			$DataUser  = $DataUser[0];
			$ObjUserData = new UserData();
			//$ObjUserData->last_login_attempt_datetime = date('Y-m-d H:i:s');
			$ObjUserData->last_login_attempt_datetime = '0000-00-00 00:00:00';
			$ObjUserData->userid = $DataUser['userid'];
			$ObjUserData->login_attempt = 0;
			$changeStatus = array("login_attempt");
			$UserMasterObj->editUser($ObjUserData, $changeStatus);
		}
		return 0;
	 }
    }
	return 0;
}

function checkEmailAddress($email)
{
	require_once(DIR_WS_MODEL . "UserMaster.php");

	$UserMasterObj = new UserMaster();
	$UserMasterObj = $UserMasterObj->Create();
	$userFieldArr   = array('userid','login_attempt','(CASE when last_login_attempt_datetime is not NULL and DATE_ADD(last_login_attempt_datetime, '.LOGIN_TIME_PERIOD.')>NOW() then 1 else 0 end) as Denied');
	$userSeaArr = array();
	$userSeaArr[] = array('Search_On'=>'email', 'Search_Value'=>$email, 'Type'=>'string', 'Equation'=>'Like', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$userSeaArr[] = array('Search_On'=>'deleted', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$DataUser  = $UserMasterObj->getUser($userFieldArr, $userSeaArr);
	$DataUser  = $DataUser[0];

	//echo $DataUser["login_attempt"];
	//exit(); Remaining to check how  unlimited condition can be applied
	if(empty($DataUser))
	{
		return 0;
	}
	if($DataUser["login_attempt"] >= ATTEMPTS_NUMBER)
    {

	  if($DataUser["Denied"] == 1)
	  {
		 $attempts = $DataUser["login_attempt"];
		 return 1;
	  }/*else{
		$ObjUserData = new UserData();
		$ObjUserData->last_login_attempt_datetime = '0000-00-00 00:00:00';
		$ObjUserData->userid = $DataUser['userid'];
		$ObjUserData->login_attempt = 0;
		$changeStatus = array("last_login_attempt_datetime","login_attempt");
		$UserMasterObj->editUser($ObjUserData, $changeStatus);
		return 0;
	 } this is commented because we need to block user for unlimited time
	 he will be unblocked through reset password.
	 */
    }
	return 0;
}
function addIPAttempts($ip)
{
	require_once(DIR_WS_MODEL . "IPAddressMaster.php");
	$IPAddressMasterObj = new IPAddressMaster();
	$IPAddressMasterObj = $IPAddressMasterObj->Create();
	$IPAddressFieldArr   = array("*");
	$IPAddressSeaArr   = array();
	$IPAddressSeaArr[] = array('Search_On'=>'ip', 'Search_Value'=>$ip, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$DataIPAddress  = $IPAddressMasterObj->getIPAddress($IPAddressFieldArr, $IPAddressSeaArr);
	$DataIPAddress = $DataIPAddress[0];
	if($DataIPAddress)
      {
        $attempts = $DataIPAddress["attempts"]+1;

        if($attempts==ATTEMPTS_NUMBER)
		{
			$QueryString = 'UPDATE login_attempts SET attempts ="'.$attempts.'",lastlogin=NOW() WHERE ip = "'.$ip.'"';
			$IPAddressMasterObj->editIPAddress($IPAddressData, $QueryString);
		}
        else
		{
			$IPAddressData = new IPAddressData();
			$IPAddressData->attempts = $attempts;
			$IPAddressData->ip = $ip;
			$IPAddressData->lastlogin = $DataIPAddress["lastlogin"];
			$IPAddressSeaArr = array("ip","attempts");
			$IPAddressMasterObj->editIPAddress($IPAddressData, null);
		}
       }
      else
	  {
		  $IPAddressData = new IPAddressData();
		  $QueryString = "INSERT INTO login_attempts (ip,attempts,lastlogin) values ('$ip','1',NOW())";
		  $IPAddressMasterObj->addIPAddress($IPAddressData, $IPAddressSeaArr,$QueryString);

	  }
}
function addForgotPassIPAttempts($ip)
{
	require_once(DIR_WS_MODEL . "ForgotPassIPAddressMaster.php");
	$ForgotPassIPAddressMasterObj = new ForgotPassIPAddressMaster();
	$ForgotPassIPAddressMasterObj = $ForgotPassIPAddressMasterObj->Create();
	$ForgotPassIPAddressFieldArr   = array("*");
	$ForgotPassIPAddressSeaArr   = array();
	$ForgotPassIPAddressSeaArr[] = array('Search_On'=>'ip', 'Search_Value'=>$ip, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$DataIPAddress  = $ForgotPassIPAddressMasterObj->getForgotPassIPAddress($ForgotPassIPAddressFieldArr, $ForgotPassIPAddressSeaArr);
	$DataIPAddress = $DataIPAddress[0];
	if($DataIPAddress)
      {
        $attempts = $DataIPAddress["attempts"]+1;

        if($attempts==ATTEMPTS_NUMBER)
		{

			$QueryString = 'UPDATE forgotpass_ipaddress_attempts SET attempts ="'.$attempts.'",lastlogin=NOW() WHERE ip = "'.$ip.'"';
			$ForgotPassIPAddressMasterObj->editForgotPassIPAddress($ForgotPassIPAddressData, $QueryString);

		}
        else
		{
			$ForgotPassIPAddressData = new ForgotPassIPAddressData();
			$ForgotPassIPAddressData->attempts = $attempts;
			$ForgotPassIPAddressData->ip = $ip;
			$ForgotPassIPAddressData->lastlogin = $DataIPAddress["lastlogin"];
			$ForgotPassIPAddressSeaArr = array("ip","attempts");
			$ForgotPassIPAddressMasterObj->editForgotPassIPAddress($ForgotPassIPAddressData, null);
		}
       }
      else
	  {
		  $ForgotPassIPAddressData = new ForgotPassIPAddressData();
		  $QueryString = "INSERT INTO forgotpass_ipaddress_attempts (ip,attempts,lastlogin) values ('$ip','1',NOW())";
		  $ForgotPassIPAddressMasterObj->addForgotPassIPAddress($ForgotPassIPAddressData, $ForgotPassIPAddressSeaArr,$QueryString);

	  }
}

function addForgotPassEmailIdAttempts($emailid)
{
	require_once(DIR_WS_MODEL . "ForgotPassEmailIdAddressMaster.php");
	$ForgotPassEmailIdAddressMasterObj = new ForgotPassEmailIdAddressMaster();
	$ForgotPassEmailIdAddressMasterObj = $ForgotPassEmailIdAddressMasterObj->Create();
	$ForgotPassEmailIdAddressFieldArr   = array("*");
	$ForgotPassEmailIdAddressSeaArr   = array();
	$ForgotPassEmailIdAddressSeaArr[] = array('Search_On'=>'emailid', 'Search_Value'=>$emailid, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$DataEmailIdAddress  = $ForgotPassEmailIdAddressMasterObj->getForgotPassEmailIdAddress($ForgotPassEmailIdAddressFieldArr, $ForgotPassEmailIdAddressSeaArr);
	$DataEmailIdAddress = $DataEmailIdAddress[0];
	if($DataEmailIdAddress)
      {
        $attempts = $DataEmailIdAddress["attempts"]+1;

        if($attempts==ATTEMPTS_NUMBER)
		{

			$QueryString = 'UPDATE forgotpass_email_attempts SET attempts ="'.$attempts.'",lastlogin=NOW() WHERE emailid = "'.$emailid.'"';
			$ForgotPassEmailIdAddressMasterObj->editForgotPassEmailIdAddress($ForgotPassEmailIdAddressData, $QueryString);
		}
        else
		{
			$ForgotPassEmailIdAddressData = new ForgotPassEmailIdAddressData();
			$ForgotPassEmailIdAddressData->attempts = $attempts;
			$ForgotPassEmailIdAddressData->emailid = $emailid;
			$ForgotPassEmailIdAddressData->lastlogin = $DataEmailIdAddress["lastlogin"];
			$ForgotPassEmailIdAddressSeaArr = array("emailid","attempts");
			$ForgotPassEmailIdAddressMasterObj->editForgotPassEmailIdAddress($ForgotPassEmailIdAddressData, null);
		}
       }
      else
	  {
		  $ForgotPassEmailIdAddressData = new ForgotPassEmailIdAddressData();
		  $QueryString = "INSERT INTO forgotpass_email_attempts (emailid,attempts,lastlogin) values ('$emailid','1',NOW())";
		  $ForgotPassEmailIdAddressMasterObj->addForgotPassEmailIdAddress($ForgotPassEmailIdAddressData, $ForgotPassEmailIdAddressSeaArr,$QueryString);

	  }
}
function checkForgotPassIPAddress($ip)
{
	require_once(DIR_WS_MODEL . "ForgotPassIPAddressMaster.php");
	require_once(DIR_WS_MODEL . "ForgotPassEmailIdAddressMaster.php");


	$ForgotPassEmailIdAddressMasterObj = new ForgotPassEmailIdAddressMaster();
	$ForgotPassEmailIdAddressMasterObj = $ForgotPassEmailIdAddressMasterObj->Create();

	$ForgotPassIPAddressMasterObj = new ForgotPassIPAddressMaster();
	$ForgotPassIPAddressMasterObj = $ForgotPassIPAddressMasterObj->Create();
	$ForgotPassIPAddressFieldArr   = array('attempts','(CASE when lastlogin is not NULL and DATE_ADD(LastLogin, '.FORGOTPASS_IP_TIME_PERIOD.')>NOW() then 1 else 0 end) as Denied');
	$ForgotPassIPAddressSeaArr   = array();
	$ForgotPassIPAddressSeaArr[] = array('Search_On'=>'ip', 'Search_Value'=>$ip, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$DataIPAddress  = $ForgotPassIPAddressMasterObj->getForgotPassIPAddress($ForgotPassIPAddressFieldArr, $ForgotPassIPAddressSeaArr);

	$DataIPAddress = $DataIPAddress[0];
	/*echo "<pre>";
	print_r($DataIPAddress);
	echo "</pre>";
	echo "ip:".$ip;
	exit();*/
	if(empty($DataIPAddress))
	{
		return 0;
	}
	if ($DataIPAddress["attempts"] >=  ATTEMPTS_NUMBER)
    {
	  if($DataIPAddress["Denied"] == 1)
	  {
		/*
		$attempts = $DataIPAddress["attempts"];
        if($attempts==ATTEMPTS_NUMBER)
		{
			$attempts = $DataIPAddress["attempts"]+1;
			$QueryString = 'UPDATE forgotpass_ipaddress_attempts SET attempts ="'.$attempts.'",lastlogin=NOW() WHERE ip = "'.$ip.'"';
			$ForgotPassIPAddressMasterObj->editForgotPassIPAddress($ForgotPassIPAddressData, $QueryString);
		} */
		return 1;
	  }
	 else
	 {
		//echo $DataIPAddress["attempts"]."---".$DataIPAddress["Denied"]."</br>";
		//echo "inside the delet function";
		$ForgotPassIPAddressMasterObj->deleteForgotPassIPAddress($ip);
		//exit();
		$ForgotPassEmailIdAddressMasterObj = new ForgotPassEmailIdAddressMaster();
		$ForgotPassEmailIdAddressMasterObj = $ForgotPassEmailIdAddressMasterObj->Create();
		$ForgotPassEmailIdAddressMasterObj->deleteForgotPassEmailIdAddress('',true);
		return 0;
	 }
    }
	return 0;
}

function checkForgotPassEmailIdAddress($emailid)
{
	require_once(DIR_WS_MODEL . "ForgotPassEmailIdAddressMaster.php");


	$ForgotPassEmailIdAddressMasterObj = new ForgotPassEmailIdAddressMaster();
	$ForgotPassEmailIdAddressMasterObj = $ForgotPassEmailIdAddressMasterObj->Create();
	$ForgotPassEmailIdAddressFieldArr   = array('attempts','(CASE when lastlogin is not NULL and DATE_ADD(LastLogin,'.FORGOTPASS_TIME_PERIOD.')>NOW() then 1 else 0 end) as Denied');
	$ForgotPassEmailIdAddressSeaArr   = array();
	$ForgotPassEmailIdAddressSeaArr[] = array('Search_On'=>'emailid', 'Search_Value'=>$emailid, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'','Postfix'=>'');
	$DataEmailIdAddress  = $ForgotPassEmailIdAddressMasterObj->getForgotPassEmailIdAddress($ForgotPassEmailIdAddressFieldArr, $ForgotPassEmailIdAddressSeaArr);
	$DataEmailIdAddress = $DataEmailIdAddress[0];

	if(empty($DataEmailIdAddress))
	{
		return 0;
	}
	if($DataEmailIdAddress["attempts"] >= ATTEMPTS_NUMBER)
    {
	  //echo "denied:".$DataEmailIdAddress["Denied"];
	 // exit();
	  if($DataEmailIdAddress["Denied"] == 1)
	  {
		  /*
		  $attempts = $DataEmailIdAddress["attempts"];
        if($attempts==ATTEMPTS_NUMBER)
		{
			$attempts = $DataEmailIdAddress["attempts"]+1;
			$QueryString = 'UPDATE forgotpass_email_attempts SET attempts ="'.$attempts.'",lastlogin=NOW() WHERE emailid = "'.$emailid.'"';
			$ForgotPassEmailIdAddressMasterObj->editForgotPassEmailIdAddress($ForgotPassEmailIdAddressData, $QueryString);

		} */
		 return 1;
	  }else{
		$ForgotPassEmailIdAddressMasterObj->deleteForgotPassEmailIdAddress($emailid);
		return 0;
	  }
    }
	return 0;
}
function deleteLoginIPAddress()
{
	/* Entries to be deleted for IP address blocking of login user */
	require_once(DIR_WS_MODEL . "IPAddressMaster.php");
	require_once(DIR_WS_MODEL . "UserMaster.php");

	$UserMasterObj = new UserMaster();
	$UserMasterObj = $UserMasterObj->Create();

	$IPAddressMasterObj = new IPAddressMaster();
	$IPAddressMasterObj = $IPAddressMasterObj->Create();

	//$ip = $_SERVER['REMOTE_ADDR'];
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

	$queryString = true;
	$UserMasterObj->editUser('','','',true);
	$IPAddressMasterObj->deleteIPAddress('',$queryString);
}
function deleteEmailIPAddress()
{
	/* This is only for forgot password deletion of unwanted ips and email id */

	require_once(DIR_WS_MODEL . "ForgotPassEmailIdAddressMaster.php");
	require_once(DIR_WS_MODEL . "ForgotPassIPAddressMaster.php");



	$ForgotPassEmailIdAddressMasterObj = new ForgotPassEmailIdAddressMaster();
	$ForgotPassEmailIdAddressMasterObj = $ForgotPassEmailIdAddressMasterObj->Create();
	$ForgotPassIPAddressMasterObj = new ForgotPassIPAddressMaster();
	$ForgotPassIPAddressMasterObj = $ForgotPassIPAddressMasterObj->Create();


	$queryString = true;

	$ForgotPassEmailIdAddressMasterObj->deleteForgotPassEmailIdAddress('',$queryString);
	$ForgotPassIPAddressMasterObj->deleteForgotPassIPAddress('',$queryString);
}
function create_user_session($user_details) {

	if(!empty($user_details) && !empty($user_details['userid'])) {
		global $__Session;
		$csrf = new csrf();
		$csrf->cleanOldSession();
		unset($_SESSION['final_fuel_fee']);
		unset($_SESSION['nett_due_amt']);
		unset($_SESSION['total_new_charges']);
		unset($_SESSION['total_due']);
		unset($_SESSION['discountAmt']);
		unset($_SESSION['couponCode']);
		unset($_SESSION['total_gst']);
		unset($_SESSION['ses_flag']);
		unset($_SESSION['total_tansit_gst']);
		unset($_SESSION['total_gst_delivery']);
		unset($_SESSION['total_delivery_fee']);
		unset($_SESSION['dangerousgoods']);
		unset($_SESSION['securitystatement']);
		unset($_SESSION['terms']);
		$__Session->ClearValue("service_details");
		/*below lines are commented because when logged in
		* through login button in services pages session values are getting
		* deleted for booking values coming from get quote(Start)
		* Commented by Smita 4th Jan 2021
		*/
		//$__Session->ClearValue("booking_details");
		//$__Session->ClearValue("booking_details_items");
		/*
			End part
		*/
		$__Session->ClearValue("booking_id");
		$__Session->ClearValue("client_address_dilivery");
		$__Session->ClearValue("client_address_pickup");
		$__Session->Store();
		session_regenerate_id(true);
		$user_session_array = array();
		$user_session_array['user_id'] 		= $user_details['userid'];
		$user_session_array['email'] 		= $user_details['email'];
		$user_session_array['firstname'] 	= $user_details['firstname'];
		$user_session_array['lastname'] 	= $user_details['lastname'];
		$user_session_array['user_type_id'] = $user_details['user_type_id'];
		$user_session_array['corporate_id'] = $user_details['corporate_id'];
		$user_session_array['site_language_id'] = $user_details['site_language_id'];

		$current_time =time();
		$_SESSION['loginTime']=$current_time;
		$__Session->SetValue("_sess_login_userdetails", $user_session_array);
		$__Session->Store();
		return true;
	}
	return false;
}
function validURL($url)
{
  if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url))
  {
	return INVALID_URL;
  }
}

/* To check String empty or not */
function isEmpty($string,$msgstring) {
  $string = trim($string);
  $msgstring = trim($msgstring);
  $length = strlen ($string);
  if (($length == 0)) {
	return $msgstring;
  }
}
/* To check the input value */
function valid_input($data)
{

//exit();
   $data = trim($data);
   $data = stripslashes($data);
   return $data;
}

function valid_output($data)
{
   $data = htmlspecialchars($data,ENT_QUOTES,'UTF-8');
   return $data;
}
/* To check if Numeric or not */
function isNumeric($element,$msgstring) {

	if(preg_match ("/[^0-9]/", $element)) {
		return $msgstring ;
	}
}
function isDays($element,$msgstring) {
	if(preg_match ("/[^0-9-]/", $element)) {
		return $msgstring ;
	}
}
function isNumFloat($element,$msgstring)
{
	$pattern = '[\d*(?:\.\d+)?]';
	if(!preg_match ("[^\d*(?:\.\d+)?]", $element)) {
		return $msgstring ;
	}
}
/* To check length of a string or not */
function checkLength($string, $min, $max,$msgstring) {
	$length = trim(strlen($string));
	if (($length < $min) || ($length > $max)) {
		return $msgstring;
	}
}
function checkPassword($pwd) {

if( strlen($pwd) < 8 ) {
	$error .= "- Password is too short<br />";
}
if( strlen($pwd) > 128 ) {
	$error .= "- Password is too long<br />";
}

if( !preg_match("#[0-9]+#", $pwd) ) {
	$error .= "- Password must include at least one number (0-9)<br />";
}
if( !preg_match("#[a-z]+#", $pwd) ) {
	$error .= "- Password must include at least one lowercase (a-z)<br />";
}

if( !preg_match("#[A-Z]+#", $pwd) ) {
	$error .= "- Password must include at least one uppercase (A-Z)<br />";
}
/*
if( !preg_match("#\W+#", $pwd) ) {
	$error .= "Password must include at least one symbol! ";
}*/
if($error){
	$error = "Your chosen password is too weak:<br />".$error;
} /*else {
	$error = "Your password is strong.";
}*/
	return $error;
}
function passChk($pwd)
{
	if( preg_match("#\W+#", $pwd) ) {
		$error = "Something's wrong in here. Please, try again! ";
	}
	return $error;
}
function specialcharaChk($txt)
{
	if (!preg_match('/[a-zA-Z0-9 .,:;]/', $txt)) {
		$error = "Something's wrong in here. Please, try again! ";
	}
	return $error;
}
/* To check string is float or not */
function isFloat($element,$msgstring) {
	$element=trim($element);
	if(preg_match ("/[^((\d+(\.\d*)?)|((\d*\.)?\d+))]$/", $element)) {
		return $msgstring;
	}
}

/* To check password and confirm password is same */
function isPassConpassSame($password,$confirmPass) {
  	if ($password != $confirmPass) {
  		return COMMON_NEW_PASSWORD_AND_CONFIRM_PASSWORD_SAME;
  	}
}

/* Email Validation */
function checkEmailPattern($email,$msgstring) {
  /*
  $pattern = "/^[A-z0-9\._-]+"
         . "@"
         . "[A-z0-9][A-z0-9-]*"
         . "(\.[A-z0-9_-]+)*"
         . "\.([A-z]{2,6})$/";*/
  $pattern = '/^[a-zA-Z0-9+&*-]+(?:\.[a-zA-Z0-9_+&*-]+)*@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,7}$/';
  if (!preg_match($pattern, $email)) {

		return $msgstring;
	}

}
function chkOrgRate($rate)
{
	/* Its checking dollar sign ,space and number */
	if(preg_match("/[^$0-9\s((\d+(\.\d*)?)|((\d*\.)?\d+))]/", $rate))
	{
		return COMMON_NUMERIC_VAL;
	}
}
function areaCodePattern($contact_no,$msgstring,$valid_format)
{
	if($valid_format == 1)
	{
		//$pattern ="/^[+]?[0-9]+$/";
		$pattern ="/[+]?-?[0-9]+/";
	}else
	{
		$pattern ="/^[0-9]+$/";
	}
	if(!preg_match($pattern, $contact_no))
  	{
		return $msgstring;
	}
	if($valid_format == 1)
	{

		if(strlen($contact_no)<1 || strlen($contact_no)>6)
		{
			return "Please enter the Area Code of lengths between 1 and 6.";

		}
	}else
	{
		if(strlen($contact_no)<6 || strlen($contact_no)>16)
		{
			return "Please enter the Contact Number of lengths between 6 and 16.";
		}
	}

}

/* To Check date is valid */
function isDate($string1,$string2,$string3, $msgString='') {
	if ($string1 > 29 && $string2 == 2 && ($string3%4) == 0 && ($string3%400) != 0) {
		return $msgString;
	} elseif ($string1 >= 29 && $string2 == 2 && ($string3%4) != 0 && ($string3%400) != 0) {
		return $msgString;
	} elseif ($string1 > 29 && $string2 == 2 && ($string3%4) == 0 && ($string3%400) == 0) {
		return $msgString;
	} else {
		if ($string1 > 30) {
			if(($string2%2) == 0 && $string2!=8 && $string2!=10 && $string2!=12) {
				return $msgString;
			} else if (($string2 == 11) | ($string2 == 9)) {
				return $msgString;
			}
		}
	}
}

/* To Check if number or characters */
function isDigitOrLetters($element,$msgstring) {
	if(preg_match ("/[^a-zA-Z0-9{13}]$/", $element)) {
		return $msgstring;
	}
}



/* To Implement class on header nebu when selected*/
function classOnSelect($FileName=null,$getPage=null) {
	if($FileName!=''){
		if($FileName==FILE_FILENAME_WITH_EXT) {
			$class='act';
		}
	}
	else if($getPage!=''){
	 	if($getPage==$_GET['page']){
			$class='act';
		}
		else if($getPage==$_GET['pid']){
			$class='act';
		}
	}

	return $class ;
}


// This functiona is used for create thumb image in the admin side top_banner.php file.
function createthumbImageforflashgallary($infile,$imagename,$thumbpath,$maxw=100,$maxh=100,$stretch = false) {
  clearstatcache();

  if (!is_file($infile)) {
    //trigger_error("Cannot open file: $infile",E_USER_WARNING);
    return false;
  }
  $outfile =  $thumbpath."/".$imagename;

  $functions = array(
    'image/png' => 'ImageCreateFromPng',
    'image/jpeg' => 'ImageCreateFromJpeg',
  );

  // Add GIF support if GD was compiled with it
  if (function_exists('ImageCreateFromGif')) { $functions['image/gif'] = 'ImageCreateFromGif'; }

  $size = getimagesize($infile);

  // Check if mime type is listed above
  if (!$function = $functions[$size['mime']]) {
      //trigger_error("MIME Type unsupported: {$size['mime']}",E_USER_WARNING);
    return false;
  }

  // Open source image
  if (!$source_img = $function($infile)) {
      //trigger_error("Unable to open source file: $infile",E_USER_WARNING);
		return false;
  }

  $save_function = "image" . strtolower(substr(strrchr($size['mime'],'/'),1));

  // Scale dimensions
  list($neww,$newh) = scale_dimensions($size[0],$size[1],$maxw,$maxh,$stretch);

  if ($size['mime'] == 'image/png') {
    // Check if this PNG image is indexed
    $temp_img = imagecreatefrompng($infile);
    if (imagecolorstotal($temp_img) != 0) {
      // This is an indexed PNG
      $indexed_png = TRUE;
    } else {
      $indexed_png = FALSE;
    }
    imagedestroy($temp_img);
  }

  // Create new image resource
  if ($size['mime'] == 'image/gif' || ($size['mime'] == 'image/png' && $indexed_png)) {
    // Create indexed
    $new_img = imagecreate($neww,$newh);
    // Copy the palette
    imagepalettecopy($new_img,$source_img);

    $color_transparent = imagecolortransparent($source_img);
    if ($color_transparent >= 0) {
      // Copy transparency
      imagefill($new_img,0,0,$color_transparent);
      imagecolortransparent($new_img, $color_transparent);
    }
  } else {
    $new_img = imagecreatetruecolor($neww,$newh);
  }

  // Copy and resize image
  imagecopyresampled($new_img,$source_img,0,0,0,0,$neww,$newh,$size[0],$size[1]);

  // Save output file
  if ($save_function == 'imagejpeg') {
      // Change the JPEG quality here
      if (!$save_function($new_img,$outfile,75)) {
          //trigger_error("Unable to save output image",E_USER_WARNING);
          return FALSE;
      }
  } else {
      if (!$save_function($new_img,$outfile)) {
          //trigger_error("Unable to save output image",E_USER_WARNING);
          return FALSE;
      }
  }

  // Cleanup
  imagedestroy($source_img);
  imagedestroy($new_img);

  return true;
}

function dateTimeDiff($data_ref)
{
	// Get the current date
	$current_date = date('Y-m-d H:i:s');

	// Extract from $current_date
	$current_year = substr($current_date,0,4);
	$current_month = substr($current_date,5,2);
	$current_day = substr($current_date,8,2);

	// Extract from $data_ref
	$ref_year = substr($data_ref,0,4);
	$ref_month = substr($data_ref,5,2);
	$ref_day = substr($data_ref,8,2);

	// create a string yyyymmdd 20071021
	$tempMaxDate = $current_year . $current_month . $current_day;
	$tempDataRef = $ref_year . $ref_month . $ref_day;

	$tempDifference = $tempMaxDate-$tempDataRef;

	// If the difference is GT 10 days show the date
	if($tempDifference >= 10){
		echo $data_ref;
	} else {
	// Extract $current_date H:m:ss
	$current_hour = substr($current_date,11,2);
	$current_min = substr($current_date,14,2);
	$current_seconds = substr($current_date,17,2);

	// Extract $data_ref Date H:m:ss
	$ref_hour = substr($data_ref,11,2);
	$ref_min = substr($data_ref,14,2);
	$ref_seconds = substr($data_ref,17,2);

	$hDf = $current_hour-$ref_hour;
	$mDf = $current_min-$ref_min;
	$sDf = $current_seconds-$ref_seconds;
	if($sDf < 0 ) { $ref_seconds = $ref_seconds - $current_seconds; $sDf = 60 - $ref_seconds;}

	// Show time difference ex: 2 min 54 sec ago.
	if($dDf < 1) {
		if($hDf > 0) {
			if($mDf < 0) {
				$mDf = 60 + $mDf;
				$hDf = $hDf - 1;
				echo $mDf . ' min ago';
			} else {
			echo $hDf. ' hr ' . $mDf . ' min ago';
			}
		} else {
			if($mDf > 0) {
				echo $mDf . ' min ' . $sDf . ' sec ago';
			} else {
				echo $sDf . ' sec ago';
			}
		}
	} else {
		echo $dDf . ' days ago';
	}
  }
}
function show_page_header($pagename=null,$SSL=false)
{

	if($pagename != '') {
		if(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) =='on' && $SSL == true) {

			$currentProtocol = "https://";
			//echo "smitatest";
		}else{
			$currentProtocol = "http://";
		}

		$url= $currentProtocol.SITE_URL_WITHOUT_PROTOCOL.$pagename;
		/*echo $_SERVER['HTTPS'].$url;
		exit();*/

		header('Location:'. $url);
		exit();
	}
}

function show_page_header_light($pagename=null,$loginvalue=null,$SSL=false)
{

	if($pagename != '') {
		if(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) =='on' && $SSL == true) {

			$currentProtocol = "https://";
		} else {

			$currentProtocol = "https://";
		}
			//$pagename = get_seo_link($pagename);
			if($loginvalue!='')
			{
				$url= $currentProtocol.SITE_URL_WITHOUT_PROTOCOL.$pagename."?autho=".$loginvalue;
			}
			else
			{
				$url= $currentProtocol.SITE_URL_WITHOUT_PROTOCOL.$pagename;
			}
		header('Location:'. $url);
		exit();
	}
}

function xml2array($contents, $get_attributes=1, $priority = 'tag') {
    if(!$contents) return array();

    if(!function_exists('xml_parser_create')) {
        //print "'xml_parser_create()' function not found!";
        return array();
    }

    //Get the XML parser of PHP - PHP must have this module for the parser to work
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);

    if(!$xml_values) return;//Hmm...

    //Initializations
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();

    $current = &$xml_array; //Refference

    //Go through the tags.
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
    foreach($xml_values as $data) {
        unset($attributes,$value);//Remove existing values, or there will be trouble

        //This command will extract these variables into the foreach scope
        // tag(string), type(string), level(int), attributes(array).
        extract($data);//We could use the array by itself, but this cooler.

        $result = array();
        $attributes_data = array();

        if(isset($value)) {
            if($priority == 'tag') $result = $value;
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
        }

        //Set the attributes too.
        if(isset($attributes) and $get_attributes) {
            foreach($attributes as $attr => $val) {
                if($priority == 'tag') $attributes_data[$attr] = $val;
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }

        //See tag status and do the needed.
        if($type == "open") {//The starting of the tag '<tag>'
            $parent[$level-1] = &$current;
            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                $current[$tag] = $result;
                if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                $repeated_tag_index[$tag.'_'.$level] = 1;

                $current = &$current[$tag];

            } else { //There was another element with the same tag name

                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    $repeated_tag_index[$tag.'_'.$level]++;
                } else {//This section will make the value an array if multiple tags with the same name appear together
                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                    $repeated_tag_index[$tag.'_'.$level] = 2;

                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                        $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                        unset($current[$tag.'_attr']);
                    }

                }
                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                $current = &$current[$tag][$last_item_index];
            }

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
            //See if the key is already taken.
            if(!isset($current[$tag])) { //New Key
                $current[$tag] = $result;
                $repeated_tag_index[$tag.'_'.$level] = 1;
                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

            } else { //If taken, put all things inside a list(array)
                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

                    // ...push the new element into that array.
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;

                    if($priority == 'tag' and $get_attributes and $attributes_data) {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag.'_'.$level]++;

                } else { //If it is not an array...
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $get_attributes) {
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well

                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }

                        if($attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
                }
            }

        } elseif($type == 'close') { //End of tag '</tag>'
            $current = &$parent[$level-1];
        }
    }

    return($xml_array);
}
function gettrackingid($bid=""){

	if(substr($bid, 0,1)=='1'){
	 	 $bid =  substr($bid, 1);
    	return $bid;
	}
}
function generatebookigid($obj="", $bid="") {

	$bid=json_decode($_SESSION["Thesessiondata"]["booking_id"],true);
	if(empty($bid))
	{
		$digits = '0123456789';
		$length = '12';
		$charLength ='2';
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$digitsLength = strlen($digits);
		$charactersLength = strlen($characters);

		$digitsPattern = '';
		$charPattern = '';
		$patternArr = array();

		for($i = 0; $i < $length; $i++) {
			$digitsPattern .= $digits[rand(0, $digitsLength - 1)];
		$patternArr[] = $digits[rand(0, $digitsLength - 1)];
		}
		for($j = 0; $j < $charLength; $j++) {
		$charPattern .= $characters[rand(0, $charactersLength - 1)];
		$patternArr[] = $characters[rand(0, $charactersLength - 1)];
		}

		$bid = str_shuffle($digitsPattern.$charPattern);

	}
    return $bid;
}
function generateoriginalbookigid($bid="") {
	$bookingid= $bid;
	$newbid= substr($bookingid,1);
	return $newbid;

}
function date_time_zone_compare($passname,$passzone,$passdate,$passtime) {
	if($passzone=="NT")
    {
    	date_default_timezone_set("Australia/North");
    }
    else if($passzone=="SA")
    {
    	date_default_timezone_set("Australia/South");
    }
    else if($passzone=="WA")
    {
    	date_default_timezone_set("Australia/West");
    }
    else if($passzone=="NSW")
    {
    	if($passname=="Broken Hill") //pass name
    	{
    		date_default_timezone_set("Australia/Broken_Hill");
    	}
    	else
    	{
    		date_default_timezone_set("Australia/NSW");
    	}
    }
      else if($passzone=="QLD")
    {
    	date_default_timezone_set("Australia/Queensland");
    }
      else if($passzone=="VIC")
    {
    	date_default_timezone_set("Australia/Victoria");
    }
    else if($passzone=="TAS")
    {
    	date_default_timezone_set("Australia/Tasmania");
    }
    else if($passzone=="ACT")
    {
    	date_default_timezone_set("Australia/ACT");
    }
    else if($passzone=="broken hill")
    {
    	date_default_timezone_set("Australia/Broken_Hill");
    }
    $currentdate = date("Ymd");
    $currenttime = date('Hi');

    $dateArray = explode(" ",$passdate);
    $date_d = $dateArray[0]; //date
    $date_m = $dateArray[1]; //month
    $date_y = $dateArray[2]; //year

    if($date_m=="Jan") {
    	$date_m="01";
    } else if($date_m == "Feb") {
    	$date_m="02";
    } else if($date_m == "Mar") {
    	$date_m="03";
    } else if($date_m == "Apr") {
    	$date_m="04";
    } else if($date_m == "May") {
    	$date_m="05";
    } else if($date_m == "Jun") {
    	$date_m="06";
    } else if($date_m == "Jul") {
    	$date_m="07";
    } else if($date_m == "Aug") {
    	$date_m="08";
    } else if($date_m == "Sep") {
    	$date_m="09";
    } else if($date_m == "Oct") {
    	$date_m="10";
    } else if($date_m == "Nov") {
    	$date_m="11";
    } else if($date_m == "Dec") {
    	$date_m="12";
    }

    $newdate=$date_y.$date_m.$date_d;

    $timeArray = explode(" ",$passtime);
    $time_tmp = explode(":",$timeArray[0]);
    $time_h = $time_tmp[0]; //hours
    $time_m = $time_tmp[1]; //min
    $time_q = $timeArray[1]; // am/pm

    if($time_q == "pm"){
    		$time_h = $time_h + 12;
    } else if($time_q == "am") {
    	if($time_h == 12) {
    		$time_h = 0;
    	}
    }
    $newtime = $time_h.$time_m;

    $flag=0;
	if($currentdate > $newdate) {
		$flag=1;
	} else if($currentdate == $newdate) {
		if($currenttime > $newtime) {
			$flag=1;
		}
	}

	if($flag==0) {
		return true; //valid
	} else {
		return false; //invalid or older from now
	}

}

function get_payment_due(){

	$BookingDetailsData = json_decode($_SESSION['Thesessiondata']["booking_details"],true);
	if(!empty($BookingDetailsData))
	{
		foreach ($BookingDetailsData as $key=>$val) {
			$BookingDatashow->{$key}=$val;
			$$key=$val;
		}
	}
	//echo "additional cost:".$additional_cost."</br>";

	if($additional_cost=="" && $additional_cost!=0) {
		$amount_tmp = $international_rate;
		return ceil($amount_tmp);
	} else {
		$sameday_name =$service_name."_rate";
		switch($servicepagename){
			case "international":
				if($additional_cost=="" || $additional_cost==0)
					$amount_tmp = $international_rate;
				else
					$amount_tmp = $additional_cost;
			break;
			case "sameday":
				$amount_tmp = $$sameday_name;
				if(empty($amount_tmp)){
				 	$amount_tmp = $rate;
				 }
			break;
			case "overnight":
				 $amount_tmp = $$sameday_name;
				 if(empty($amount_tmp)){
				 	$amount_tmp = $rate;
				 }
			break;

		}
		//echo "amount tmp:".$amount_tmp."<br>";
	}
	/*
	echo "coverage_rate:".$coverage_rate."</br>";
	echo "tmp_amoutn".$amount_tmp."</br>";
	echo "<pre>";
	print_r($amount_tmp);
	echo "</pre>";
	*/
	return ceil($coverage_rate + $amount_tmp);
}


function readCSVFile($fileName, $syncArray=array()){

	$FieldDataArray = array();
	$data_array = array();
	if($fileName!='' && file_exists($fileName)) {
		$current_row = 1;
		$handle = fopen($fileName, "r"); //Open the CSV file in Read Mode
		$total_fields_db = count($syncArray);
		while ( ($data = fgetcsv($handle, 10000, ",") ) !== FALSE ) {
			$number_of_fields = count($data);
			/*if($current_row == 1 && $number_of_fields != $total_fields_db) {
				return false;
			}*/

			for ($c=0; $c < $number_of_fields; $c++) {
				if ($current_row == 1) {
					if(isset($syncArray[strtolower($data[$c])])) {
					//Get field name
						$FieldsNumArray[$c] = $syncArray[strtolower($data[$c])];
					}
				} else {
					if(isset($FieldsNumArray[$c])) {
						$data_array[$current_row][$FieldsNumArray[$c]] = $data[$c];
					}
				}
			}
			$current_row++;
		}
		asort($data_array);
		fclose($handle);
	}

	return $data_array;
}
function db_prepare_input($data_array) {
	foreach ($data_array as $postkey => $postvalue) {
		if(is_array($postvalue)) {
			$data_array[$postkey]=db_prepare_input($postvalue);
		} else {
			$postvalue=stripcslashes($postvalue);
			//$data_array[$postkey] = htmlspecialchars($postvalue, ENT_QUOTES);
			$data_array[$postkey] = $postvalue;
		}
	}
	return $data_array;
}
function get_state_code($postcode_arr){
	$pickup_array=array();
	$pickup_array=explode(" ",$postcode_arr);
	$no_pickup=count($pickup_array);
	$q2=$pickup_array[$no_pickup-2];
	$q3=$pickup_array[$no_pickup-1];
	unset($pickup_array[$no_pickup-2]);
	unset($pickup_array[$no_pickup-1]);
	$q1=implode(" ",$pickup_array);
	$Pickupvalue=array();
	$Pickupvalue['Name']=$q1;
	$Pickupvalue['State']=$q2;
	$Pickupvalue['Postcode']=$q3;
	return $Pickupvalue['State'];
}

function default_time_zone($state){
	$time_array = array();
	$time_array ='';


	switch ($state)
			{
			case "NT":
			  date_default_timezone_set("Australia/North");
              $time_array = array("time" => date('h:i a'),"date" => date('jS F Y'));
			  break;
			case "SA":
			  date_default_timezone_set("Australia/South");
			  $time_array = array("time" => date('h:i a'),"date" => date('jS F Y'));
			  break;
			case "WA":
			  date_default_timezone_set("Australia/West");
              $time_array = array("time" => date('h:i a'),"date" => date('jS F Y'));
              break;
			case "NSW":
			  ($Pickupvalue['Name']=="Broken Hill")?date_default_timezone_set("Australia/Broken_Hill"):date_default_timezone_set("Australia/NSW");
              $time_array = array("time" => date('h:i a'),"date" => date('jS F Y'));
              break;
			case "QLD":
			  date_default_timezone_set("Australia/Queensland");
              $time_array = array("time" => date('h:i a'),"date" => date('jS F Y'));
              break;
            case "VIC":
			  date_default_timezone_set("Australia/Victoria");
              $time_array = array("time" => date('h:i a'),"date" => date('jS F Y'));
              break;
            case "TAS":
			  date_default_timezone_set("Australia/Tasmania");
              $time_array = array("time" => date('h:i a'),"date" => date('jS F Y'));
              break;
            case "ACT":
			  date_default_timezone_set("Australia/ACT");
              $time_array = array("time" => date('h:i a'),"date" => date('jS F Y'));
              break;
            case "broken hill":
			  date_default_timezone_set("Australia/Broken_Hill");
              $time_array = array("time" => date('h:i a'),"date" => date('jS F Y'));
              break;
            }
		return $time_array;

}
function get_time_zonewise($pickupid)
{

	$state_code = get_state_code($pickupid);
	default_time_zone($state_code);
	//$time=date('d M Y h:i:s a',strtotime('+ 15 minutes'));
	$time=date('d M Y h:i:s a');
	$date = date('jS F Y');
	return $time;
}
function getNextCDate($newdate,$publicholidaydate)
{
	$dd=0;
	while(true)
	{
		$date = strtotime($newdate . " +".$dd." day");
		if((date('D',$date)=="Sun") || (date('D',$date)=="Sat")){
			$dd++;
		}else{
			break;
		}
	}
	return date( 'd M Y', $date );
}
function conv($time){
	$ampm=explode(" ",$time);
	$hms=explode(":",$ampm[0]);
	if($hms[0]==12 && $ampm[1]=="am"){
		$hms[0]="00";
	}
	else{
		if($ampm[1]=="pm"){
			if($hms[0]<12){
				$hms[0]=$hms[0]+12;
			}
		}
	}
	$build=$hms[0].$hms[1].$hms[2];
	return $build;
}
function outboundDir($city)
{
	$basetariff = strtolower('out'.$city);
	return $basetariff;
}
function inboundDir($city)
{
	$basetariff = strtolower('in'.$city);
	return $basetariff;
}
function bothDir($city)
{
	$basetariff = strtolower('bo'.$city);
	return $basetariff;
}
function checkTableExit($basetariff)
{
	global $con;
	if(!empty($basetariff))
	{
		//echo "select ste_table_name from ste_rates_formate where table_name = '$basetariff'";
		$sql = mysqli_query($con,"select ste_table_name from ste_rates_formate where table_name = '$basetariff'");
		$no =  mysqli_num_rows($sql);
		if($no != 0)
		{
			while($row = mysqli_fetch_array($sql))
			{
				$table_name = $row['ste_table_name'];

			}
			return $table_name;
		}else{
			return 0;
		}
	}else{
		return 0;
	}
}
function totalServices($o_city='',$d_city='',$code_format_id='')
{
	global $con;
	if($o_city != '' && $d_city != '')
	{
		$like = "'%$o_city%' OR table_name like '%$d_city%'";
	}
	if($o_city != '' && $d_city == '')
	{
		$like = "'%$o_city%'";
	}
	if($d_city != '' && $o_city == '')
	{
		$like = "'%$d_city%'";

	}
	if($d_city == '' && $o_city == '' && $code_format_id==0)
	{
		$like = "'%aus%'";

	}
	if($d_city == '' && $o_city == '' && $code_format_id==2)
	{
		$like = "'%tnt%'";

	}
	//echo "o_city:".$o_city."d_city:".$d_city."</br>";
	if($like != '')
	{



		if($d_city != 'in')
		{
			//echo "select distinct(service_code) from ste_rates_formate where table_name like $like";
			$sql = mysqli_query($con,"select distinct(service_code) from ste_rates_formate where table_name like $like");
		}else
		{
			$like = "'$d_city'";
			$sql = mysqli_query($con,"select distinct(service_code) from ste_rates_formate where service_code = $like");

		}
		//echo "select distinct(service_code) from ste_rates_formate where table_name like $like";
		//exit();

		if($sql == false){
			return 0;
		}else
		{
			$no =  mysqli_num_rows($sql);
			if( $no != 0){
				return $sql;
			}
			else{
				return 0;
			}
		}
	}else{
		return 0;
	}

}
function ajax_cal_val($ste_table,$o_zone,$d_zone)
{
	global $con;
	if($ste_table)
	{

		$sql = mysqli_query($con,"select * from $ste_table where From_zone ='".valid_input($o_zone)."' and To_zone='".valid_input($d_zone)."'");
	}
	$no=mysqli_num_rows($sql);
	return $no;

}
function cal_val($base_tariff,$kg,$ste_table,$o_zone,$d_zone)
{
	global $con;

	$subtariff = substr($base_tariff,5);
	$servicename = strtoupper($subtariff);
	
	if($ste_table)
	{
		//echo "select * from $ste_table where From_zone ='".valid_input($o_zone)."' and To_zone='".valid_input($d_zone)."' and Service='".$servicename."'";
		//$sql = mysqli_query($con,"select * from $ste_table where From_zone ='".valid_input($o_zone)."' and To_zone='".valid_input($d_zone)."'");
		$sql = mysqli_query($con,"select * from $ste_table where From_zone ='".valid_input($o_zone)."' and To_zone='".valid_input($d_zone)."' and Service='".$servicename."'");
	}
//exit();
	if($sql == false){
		redirectOnException($_GET['pickup'],$_GET['deliver']);
	}
	$no=mysqli_num_rows($sql);

	if($no!=0){
		while($row = mysqli_fetch_array($sql)){
			/* Price from table selected eg: sydbase */
			//echo $row['Specific_minimum_charger']."basic:".$row['Basic_charge']."kilo".$row['Kilo_rate'];
			$minimum_price_table=$row['Specific_minimum_charger'];
			$basic_price_table=$row['Basic_charge'];
			$kilo_rate_table=$row['Kilo_rate'];
		}
	}
	//echo "minimum:".$minimum_price_table."basic:".$basic_price_table."kilo:".$kilo_rate_table."</br>";
	//exit();
	//echo "select * from ste_rates_formate where table_name='".$base_tariff."'"."</br>";
	//exit();
	$sql = mysqli_query($con,"select * from ste_rates_formate where table_name='".$base_tariff."'");
	if($sql == false){
		redirectOnException($_GET['pickup'],$_GET['deliver']);
	}
	$no=mysqli_num_rows($sql);
	if($no!=0){
		while($row = mysqli_fetch_array($sql)) {
			$_POST['price1']=substr($row['format'],0,1);
			$_POST['price2']=substr($row['format'],1,1);
			$_POST['price3']=substr($row['format'],2,1);
			$_POST['ctype1']=substr($row['method'],0,1);
			$_POST['ctype2']=substr($row['method'],1,1);
			$_POST['ctype3']=substr($row['method'],2,1);
			$minimum_price_format_table=$row['Specific_minimum_charger'];
			$basic_price_format_table=$row['Basic_charge'];
			$kilo_rate_format_table=$row['Kilo_rate'];

			//echo "select * from ste_details where table_name='".$base_tariff."' and method=1";
			$sql1 = mysqli_query($con,"select * from ste_details where table_name='".$base_tariff."' and method=1");
			$no1=mysqli_num_rows($sql1);
			if($no1!=0){
				while($row1 = mysqli_fetch_array($sql1)) {
					$minimum_price_format_table1=$row1['Specific_minimum_charger'];
					$basic_price_format_table1=$row1['Basic_charge'];
					$kilo_rate_format_table1=$row1['Kilo_rate'];
				}
			}

			//echo "select * from ste_details where table_name='".$base_tariff."' and method=2";
			$sql2 = mysqli_query($con,"select * from ste_details where table_name='".$base_tariff."' and method=2");
			$no2=mysqli_num_rows($sql2);
			if($no2!=0){
				while($row2 = mysqli_fetch_array($sql2)) {
					$minimum_price_format_table2=$row2['Specific_minimum_charger'];
					$basic_price_format_table2=$row2['Basic_charge'];
					$kilo_rate_format_table2=$row2['Kilo_rate'];
				}
			}
		}

		if($_POST['price1']==0){
			if($_POST['ctype1']==1){
				$minimum_price_table=(($minimum_price_table*$minimum_price_format_table1)/100);
			}elseif($_POST['ctype1']==2){
				$minimum_price_table=$minimum_price_format_table2;
			}
		}elseif($_POST['price1']==1){
			if($_POST['ctype1']==1){
				$basic_price_table=(($basic_price_table*$basic_price_format_table1)/100);
			}elseif($_POST['ctype1']==2){
				$basic_price_table=$basic_price_format_table2;
			}
		}elseif($_POST['price1']==2){
			if($_POST['ctype1']==1){

				$kilo_rate_table=(($kilo_rate_table*$kilo_rate_format_table1)/100);
			}elseif($_POST['ctype1']==2){
				$kilo_rate_table=$kilo_rate_format_table2;
			}
		}

		if($_POST['price2']==0){
			if($_POST['ctype2']==1){
				$minimum_price_table=(($minimum_price_table*$minimum_price_format_table1)/100);
			}elseif($_POST['ctype2']==2){
				$minimum_price_table=$minimum_price_format_table2;
			}
		}elseif($_POST['price2']==1){
			if($_POST['ctype2']==1){
				$basic_price_table=(($basic_price_table*$basic_price_format_table1)/100);
			}elseif($_POST['ctype2']==2){
				$basic_price_table=$basic_price_format_table2;
			}

		}elseif($_POST['price2']==2){
			if($_POST['ctype2']==1){
				$kilo_rate_table=(($kilo_rate_table*$kilo_rate_format_table1)/100);

			}elseif($_POST['ctype2']==2){
				$kilo_rate_table=$kilo_rate_format_table2;
			}
		}


		if($_POST['price3']==0){
			if($_POST['ctype3']==1){
				$minimum_price_table=(($minimum_price_table*$minimum_price_format_table1)/100);
			}elseif($_POST['ctype3']==2){
				$minimum_price_table=$minimum_price_format_table2;
			}
		}elseif($_POST['price3']==1){
			if($_POST['ctype3']==1){
				$basic_price_table=(($basic_price_table*$basic_price_format_table1)/100);
			}elseif($_POST['ctype3']==2){
				$basic_price_table=$basic_price_format_table2;
			}
		}elseif($_POST['price3']==2){
			if($_POST['ctype3']==1){
				//echo $kilo_rate_table."--".$kilo_rate_format_table1."</br>";
				$kilo_rate_table=(($kilo_rate_table*$kilo_rate_format_table1)/100);
			}elseif($_POST['ctype3']==2){
				$kilo_rate_table=$kilo_rate_format_table2;
			}
		}
//echo $minimum_price_table."--basic".$basic_price_table."--kilo".$kilo_rate_table."kg:".$kg."</br>";
		//exit();
		//echo "min:".$minimum_price_table."</br>";
		//echo "basic:".$basic_price_table."</br>";
//echo "kilo:".$kilo_rate_table."</br>";
	//	//exit();

		if(($minimum_price_table!="" || $minimum_price_table==0) && $basic_price_table!="" && $kilo_rate_table!=""){
			$price=$basic_price_table+($kilo_rate_table*$kg);
			//echo $price;
			//exit();
			if($price<$minimum_price_table){
				return  $minimum_price_table;
			}else{
				return $price;
			}
		}else{
			return 0;
		}
	}else{
		return 0;
	}
}

function cal_val_tnt($base_tariff,$kg,$ste_table,$o_zone,$d_zone)
{
	global $con;
	if($ste_table)
	{
		$sql = mysqli_query($con,"select * from $ste_table where From_zone ='".valid_input($o_zone)."' and To_zone='".valid_input($d_zone)."'");
	}
	if($sql == false){
		redirectOnException($_GET['pickup'],$_GET['deliver']);
	}
	$no=mysqli_num_rows($sql);

	if($no!=0){
		while($row = mysqli_fetch_array($sql)){
			/* Price from table selected eg: sydbase */
			$minimum_price_table=$row['Specific_minimum_charger'];
			$basic_price_table=$row['Basic_charge'];
			$kilo_rate_table=$row['Kilo_rate'];
		}
	}

	$sql = mysqli_query($con,"select * from ste_rates_formate where table_name='".$base_tariff."'");
	if($sql == false){
		redirectOnException($_GET['pickup'],$_GET['deliver']);
	}
	$no=mysqli_num_rows($sql);
	if($no!=0){
		while($row = mysqli_fetch_array($sql)) {
			$_POST['price1']=substr($row['format'],0,1);
			$_POST['price2']=substr($row['format'],1,1);
			$_POST['price3']=substr($row['format'],2,1);
			$_POST['ctype1']=substr($row['method'],0,1);
			$_POST['ctype2']=substr($row['method'],1,1);
			$_POST['ctype3']=substr($row['method'],2,1);
			$minimum_price_format_table=$row['Specific_minimum_charger'];
			$basic_price_format_table=$row['Basic_charge'];
			$kilo_rate_format_table=$row['Kilo_rate'];
			//echo $minimum_price_format_table."--basic".$basic_price_format_table."--kilo".$kilo_rate_format_table;
			//echo "select * from ste_details where table_name='".$base_tariff."' and method=1";
			$sql1 = mysqli_query($con,"select * from ste_details where table_name='".$base_tariff."' and method=1");
			$no1=mysqli_num_rows($sql1);
			if($no1!=0){
				while($row1 = mysqli_fetch_array($sql1)) {
					$minimum_price_format_table1=$row1['Specific_minimum_charger'];
					$basic_price_format_table1=$row1['Basic_charge'];
					$kilo_rate_format_table1=$row1['Kilo_rate'];
				}
			}


			$sql2 = mysqli_query($con,"select * from ste_details where table_name='".$base_tariff."' and method=2");
			$no2=mysqli_num_rows($sql2);
			if($no2!=0){
				while($row2 = mysqli_fetch_array($sql2)) {
					$minimum_price_format_table2=$row2['Specific_minimum_charger'];
					$basic_price_format_table2=$row2['Basic_charge'];
					$kilo_rate_format_table2=$row2['Kilo_rate'];
				}
			}
		}
		if($_POST['price1']==0){
			if($_POST['ctype1']==1){
				$minimum_price_table=$minimum_price_table+(($minimum_price_table*$minimum_price_format_table1)/100);
			}elseif($_POST['ctype1']==2){
				$minimum_price_table=$minimum_price_format_table2;
			}
		}elseif($_POST['price1']==1){
			if($_POST['ctype1']==1){
				$basic_price_table=$basic_price_table+(($basic_price_table*$basic_price_format_table1)/100);
			}elseif($_POST['ctype1']==2){
				$basic_price_table=$basic_price_format_table2;
			}
		}elseif($_POST['price1']==2){
			if($_POST['ctype1']==1){
				$kilo_rate_table=$kilo_rate_table+(($kilo_rate_table*$kilo_rate_format_table1)/100);
			}elseif($_POST['ctype1']==2){
				$kilo_rate_table=$kilo_rate_format_table2;
			}
		}

		if($_POST['price2']==0){
			if($_POST['ctype2']==1){
				$minimum_price_table=$minimum_price_table+(($minimum_price_table*$minimum_price_format_table1)/100);
			}elseif($_POST['ctype2']==2){
				$minimum_price_table=$minimum_price_format_table2;
			}
		}elseif($_POST['price2']==1){
			if($_POST['ctype2']==1){
				$basic_price_table=$basic_price_table+(($basic_price_table*$basic_price_format_table1)/100);
			}elseif($_POST['ctype2']==2){
				$basic_price_table=$basic_price_format_table2;
			}

		}elseif($_POST['price2']==2){
			if($_POST['ctype2']==1){
				$kilo_rate_table=$kilo_rate_table+(($kilo_rate_table*$kilo_rate_format_table1)/100);
			}elseif($_POST['ctype2']==2){
				$kilo_rate_table=$kilo_rate_format_table2;
			}
		}

		if($_POST['price3']==0){
			if($_POST['ctype3']==1){
				$minimum_price_table=$minimum_price_table+(($minimum_price_table*$minimum_price_format_table1)/100);
			}elseif($_POST['ctype3']==2){
				$minimum_price_table=$minimum_price_format_table2;
			}
		}elseif($_POST['price3']==1){
			if($_POST['ctype3']==1){
				$basic_price_table=$basic_price_table+(($basic_price_table*$basic_price_format_table1)/100);
			}elseif($_POST['ctype3']==2){
				$basic_price_table=$basic_price_format_table2;
			}
		}elseif($_POST['price3']==2){
			if($_POST['ctype3']==1){
				$kilo_rate_table=$kilo_rate_table+(($kilo_rate_table*$kilo_rate_format_table1)/100);
			}elseif($_POST['ctype3']==2){
				$kilo_rate_table=$kilo_rate_format_table2;
			}
		}

		if(($minimum_price_table!="" || $minimum_price_table==0) && $basic_price_table!="" && $kilo_rate_table!=""){
			if($kg >= 21)
			{
				$kg = $kg-20;
				$price=$basic_price_table+($kilo_rate_table*$kg);
			}else{
				$price=$basic_price_table;
			}
			if($price<$minimum_price_table){
				return  $minimum_price_table;
			}else{
				return $price;
			}
		}else{
			return 0;
		}
	}else{
		return 0;
	}
}
function cal_val_direct($base_tariff,$kg,$ste_table,$distance)
{
	global $con;
	$base_tariff = strtolower($base_tariff);
	//echo "select basic_charge,perkm from $ste_table where from_weight<=".$kg." and to_weight>=".$kg;
	//exit();
	//echo $base_tariff."</br>";
	//exit();
	$sql = mysqli_query($con,"select basic_charge,perkm from $ste_table where from_weight<=".$kg." and to_weight>=".$kg);
	$no = mysqli_num_rows($sql);

	if($no!=0){
		while($row = mysqli_fetch_array($sql)){
			$basic_price_table = $row['basic_charge'];
			$kilo_rate_table = $row['perkm'];
		}

		//echo "minimum:".$minimum_price_table."basic price".$basic_price_table."kilo rate".$kilo_rate_table."</br>";
		//exit();
		//echo "select format,method from ste_rates_formate where table_name='".$base_tariff."'"."<br>";


		$sql = mysqli_query($con,"select format,method from ste_rates_formate where table_name='".$base_tariff."'");
		$no=mysqli_num_rows($sql);
		if($no!=0){
			while($row = mysqli_fetch_array($sql)) {

				$_POST['price1'] = substr($row['format'],0,1); //price1 means 1st combo from ste calculation admin panel page generally we select minimum
				$_POST['price2'] = substr($row['format'],1,1); //price2 means 2nd combo from admin/ste_cal.php we select basic
				$_POST['price3'] = substr($row['format'],2,1); //price2 means 2nd combo from admin/ste_cal.php we select unit
				$_POST['ctype1'] = substr($row['method'],0,1); //similarly ctype1 means combo1 for example flat Charge Calculator from admin/ste_cal.php
				$_POST['ctype2'] = substr($row['method'],1,1); //similarly ctype2 means combo2 for flat Charge Calculator from admin/ste_cal.php
				$_POST['ctype3'] = substr($row['method'],2,1); //admin/ste_cal.php ctype3 means combo3 for example percentage
				/* This is of no use
				$minimum_price_format_table=$row['minimum'];
				$basic_price_format_table=$row['basic_charge'];
				$kilo_rate_format_table=$row['perkm'];
				*/
				//echo "select Specific_minimum_charger,Basic_charge,Kilo_rate from ste_details where table_name='".$base_tariff."' and method=1"."<br>";
				//select value for percentage method
				$sql1 = mysqli_query($con,"select Specific_minimum_charger,Basic_charge,Kilo_rate from ste_details where table_name='".$base_tariff."' and method=1"); //percentage method value
				$no1=mysqli_num_rows($sql1);
				if($no1!=0){
					while($row1 = mysqli_fetch_array($sql1)) {
						$minimum_price_format_table1=$row1['Specific_minimum_charger'];
						$basic_price_format_table1=$row1['Basic_charge'];
						$kilo_rate_format_table1=$row1['Kilo_rate'];
					}
				}
				//echo "select Specific_minimum_charger,Basic_charge,Kilo_rate from ste_details where table_name='".$base_tariff."' and method=2"."<br>";
				//select value for Flat Charge Calculator
				$sql2 = mysqli_query($con,"select Specific_minimum_charger,Basic_charge,Kilo_rate from ste_details where table_name='".$base_tariff."' and method=2"); // flat rate value
				$no2=mysqli_num_rows($sql2);
				if($no2!=0){
					while($row2 = mysqli_fetch_array($sql2)){
						$minimum_price_format_table2=$row2['Specific_minimum_charger'];
						$basic_price_format_table2=$row2['Basic_charge'];
						$kilo_rate_format_table2=$row2['Kilo_rate'];
					}
				}

			}

			/*
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
			*/
			/* First Combo values from backened */
			if($_POST['price1']==0){ //Minimum if selected
				if($_POST['ctype1']==1){ // Percentage if selected
					$minimum_price_table=(($minimum_price_table*$minimum_price_format_table1)/100);
				}elseif($_POST['ctype1']==2){ // Flat Charge Calculator if selected
					 $minimum_price_table=$minimum_price_format_table2;
					//exit();
				}
			}
			elseif($_POST['price1']==1){ // Basic if selected
				if($_POST['ctype1']==1){ //Percentage if selected
					$basic_price_table=(($basic_price_table*$basic_price_format_table1)/100);
				}
				elseif($_POST['ctype1']==2){ // Flat charge calculator if selected
					$basic_price_table=$basic_price_format_table2;
				}
			}
			elseif($_POST['price1']==2){ // Unit if selected
				if($_POST['ctype1']==1){ // Percentage if selected
					$kilo_rate_table=(($kilo_rate_table*$kilo_rate_format_table1)/100);
				}elseif($_POST['ctype1']==2){ // Flat charge calculator if selected
					$kilo_rate_table=$kilo_rate_format_table2;
				}
			}
			/* First Combo values from backened
			/* Second Combo values from backened */
			if($_POST['price2']==0){ //Minimum if selected
				if($_POST['ctype2']==1){ // Percentage if selected
					$minimum_price_table=(($minimum_price_table*$minimum_price_format_table1)/100);
				}elseif($_POST['ctype2']==2){ // Flat charge calculator if selected
					$minimum_price_table=$minimum_price_format_table2;
				}
			}elseif($_POST['price2']==1){ //Basic if selected
				if($_POST['ctype2']==1){ // Percentage if selected
					//echo $basic_price_table."---".$basic_price_format_table1."</br>";
					$basic_price_table=(($basic_price_table*$basic_price_format_table1)/100);
				}elseif($_POST['ctype2']==2){ // Flat charge calculator if selected
					$basic_price_table=$basic_price_format_table2;
				}
			}elseif($_POST['price2']==2){ // Unit if selected
				if($_POST['ctype2']==1){ // Percentage if selected
					$kilo_rate_table=(($kilo_rate_table*$kilo_rate_format_table1)/100);
				}elseif($_POST['ctype2']==2){ // Flat charge calculator if selected
					$kilo_rate_table=$kilo_rate_format_table2;
				}
			}
			//echo $basic_price_table."---".$basic_price_format_table1."</br>";
			/* Second Combo values from backened */
			/* Third Combo values from backened */
			if($_POST['price3']==0){ //Minimum if selected
				if($_POST['ctype3']==1){ // Percentage if selected
					$minimum_price_table=(($minimum_price_table*$minimum_price_format_table1)/100);
				}elseif($_POST['ctype3']==2){ // Flat charge calculator if selected
					$minimum_price_table=$minimum_price_format_table2;
				}
			}elseif($_POST['price3']==1){ //Basic if selected
				if($_POST['ctype3']==1){ // Percentage if selected
					$basic_price_table=(($basic_price_table*$basic_price_format_table1)/100);
				}elseif($_POST['ctype3']==2){ // Flat charge calculator if selected
					$basic_price_table=$basic_price_format_table2;
				}
			}elseif($_POST['price3']==2){ // Unit if selected
				if($_POST['ctype3']==1){ // Percentage if selected
				//echo $kilo_rate_table."---".$kilo_rate_format_table1."</br>";
					$kilo_rate_table=(($kilo_rate_table*$kilo_rate_format_table1)/100);
				}elseif($_POST['ctype3']==2){ // Flat charge calculator if selected
					$kilo_rate_table=$kilo_rate_format_table2;
				}
			}

			/* echo "basic price table:".$basic_price_table."<br>";
			 echo "kilo rate:".$kilo_rate_table."<br>";
			 echo "minimum price table:".$minimum_price_table."<br>";
			exit();*/
			/* Third Combo values from backened */
			if(($minimum_price_table!="" || $minimum_price_table==0) && $basic_price_table!="" && $kilo_rate_table!=""){


				$price=$basic_price_table+(($kilo_rate_table*$distance));
				if($price<$minimum_price_table){
					return  $minimum_price_table;
				}else{
					return $price;
				}
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}

}
function cal_val_int($base_tariff,$int_item_type,$int_kg,$ste_table,$deliverinterzone)
{
	//echo "ste table:".$ste_table."</br>";
	//exit();
	global $con;
	if(isset($int_item_type))
	{
		switch($int_item_type)
		{
			case "4":
				if($int_kg <= 3)
				{
					$query =  "select cost,multi from $ste_table where weight_from<=".$int_kg." and weight_to>=".$int_kg." and zone ='$deliverinterzone' and doc_type='4'";

				}else{
					if($int_kg < 1000)
					{
						$query = "select cost,multi from $ste_table where weight_from<=".$int_kg." and weight_to>=".$int_kg." and zone ='$deliverinterzone' and doc_type='5'";
					}else
					{
						$query = "select cost,multi from $ste_table where weight_from='1000' and zone ='$deliverinterzone' and doc_type='5'";
					}
				}
				$sql = mysqli_query($con,$query);
				break;
			case "5":
				if($int_kg < 1000)
				{
					$query = "select cost,multi from $ste_table where weight_from<=".$int_kg." and weight_to>=".$int_kg." and zone ='$deliverinterzone' and doc_type='5'";
				}else
				{
					$query = "select cost,multi from $ste_table where weight_from='1000' and zone ='$deliverinterzone' and doc_type='5'";
				}
				$sql = mysqli_query($con,$query);
				break;
			default:
			if($int_kg < 1000)
			{
				$query = "select cost,multi from $ste_table where weight_from<=".$int_kg." and weight_to>=".$int_kg." and zone ='$deliverinterzone' and doc_type='5'";
			}else
			{
				$query = "select cost,multi from $ste_table where weight_from='1000' and zone ='$deliverinterzone' and doc_type='5'";
			}
			$sql = mysqli_query($con,$query);
			break;
		}

		if(!empty($sql))
		{
			while($row = mysqli_fetch_array($sql))
			{
				$multi = $row['multi'];
				$kilo_rate_table = $row['cost'];
				if($multi == 1)
				{
					$kilo_rate_table = $row['cost']*$int_kg;
				}
			}
		}

		$sql = mysqli_query($con,"select format,method from ste_rates_formate where table_name='".$base_tariff."'");
		$no=mysqli_num_rows($sql);
		if($no!=0){
			while($row = mysqli_fetch_array($sql)) {

				$_POST['price1'] = substr($row['format'],0,1); //price1 means 1st combo from ste calculation admin panel page generally we select minimum
				$_POST['price2'] = substr($row['format'],1,1); //price2 means 2nd combo from admin/ste_cal.php we select basic
				$_POST['price3'] = substr($row['format'],2,1); //price2 means 2nd combo from admin/ste_cal.php we select unit
				$_POST['ctype1'] = substr($row['method'],0,1); //similarly ctype1 means combo1 for example flat Charge Calculator from admin/ste_cal.php
				$_POST['ctype2'] = substr($row['method'],1,1); //similarly ctype2 means combo2 for flat Charge Calculator from admin/ste_cal.php
				$_POST['ctype3'] = substr($row['method'],2,1); //admin/ste_cal.php ctype3 means combo3 for example percentage

				//echo "select Specific_minimum_charger,Basic_charge,Kilo_rate from ste_details where table_name='".$base_tariff."' and method=1"."<br>";
				//select value for percentage method
				$sql1 = mysqli_query($con,"select Specific_minimum_charger,Basic_charge,Kilo_rate from ste_details where table_name='".$base_tariff."' and method=1"); //percentage method value
				$no1=mysqli_num_rows($sql1);
				if($no1!=0){
					while($row1 = mysqli_fetch_array($sql1)) {
						$minimum_price_format_table1=$row1['Specific_minimum_charger'];
						$basic_price_format_table1=$row1['Basic_charge'];
						$kilo_rate_format_table1=$row1['Kilo_rate'];
					}
				}
				//echo "select Specific_minimum_charger,Basic_charge,Kilo_rate from ste_details where table_name='".$base_tariff."' and method=2"."<br>";
				//select value for Flat Charge Calculator
				$sql2 = mysqli_query($con,"select Specific_minimum_charger,Basic_charge,Kilo_rate from ste_details where table_name='".$base_tariff."' and method=2"); // flat rate value
				$no2=mysqli_num_rows($sql2);
				if($no2!=0){
					while($row2 = mysqli_fetch_array($sql2)){
						$minimum_price_format_table2=$row2['Specific_minimum_charger'];
						$basic_price_format_table2=$row2['Basic_charge'];
						$kilo_rate_format_table2=$row2['Kilo_rate'];
					}
				}
				//echo $minimum_price_fromt_table
			}
			/*
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
			*/
			/* First Combo values from backened */
			if($_POST['price1']==0){ //Minimum if selected
				if($_POST['ctype1']==1){ // Percentage if selected
					$minimum_price_table=(($minimum_price_table*$minimum_price_format_table1)/100);
				}elseif($_POST['ctype1']==2){ // Flat Charge Calculator if selected
					 $minimum_price_table=$minimum_price_format_table2;
					//exit();
				}
			}
			elseif($_POST['price1']==1){ // Basic if selected
				if($_POST['ctype1']==1){ //Percentage if selected
					$basic_price_table=(($basic_price_table*$basic_price_format_table1)/100);
				}
				elseif($_POST['ctype1']==2){ // Flat charge calculator if selected
					$basic_price_table=$basic_price_format_table2;
				}
			}
			elseif($_POST['price1']==2){ // Unit if selected
				if($_POST['ctype1']==1){ // Percentage if selected
					$kilo_rate_table=(($kilo_rate_table*$kilo_rate_format_table1)/100);
				}elseif($_POST['ctype1']==2){ // Flat charge calculator if selected
					$kilo_rate_table=$kilo_rate_format_table2;
				}
			}
			/* First Combo values from backened
			/* Second Combo values from backened */
			if($_POST['price2']==0){ //Minimum if selected
				if($_POST['ctype2']==1){ // Percentage if selected
					$minimum_price_table=(($minimum_price_table*$minimum_price_format_table1)/100);
				}elseif($_POST['ctype2']==2){ // Flat charge calculator if selected
					$minimum_price_table=$minimum_price_format_table2;
				}
			}elseif($_POST['price2']==1){ //Basic if selected
				if($_POST['ctype2']==1){ // Percentage if selected
					$basic_price_table=(($basic_price_table*$basic_price_format_table1)/100);
				}elseif($_POST['ctype2']==2){ // Flat charge calculator if selected
					$basic_price_table=$basic_price_format_table2;
				}
			}elseif($_POST['price2']==2){ // Unit if selected
				if($_POST['ctype2']==1){ // Percentage if selected
					$kilo_rate_table=(($kilo_rate_table*$kilo_rate_format_table1)/100);
				}elseif($_POST['ctype2']==2){ // Flat charge calculator if selected
					$kilo_rate_table=$kilo_rate_format_table2;
				}
			}

			/* Second Combo values from backened */
			/* Third Combo values from backened */
			if($_POST['price3']==0){ //Minimum if selected
				if($_POST['ctype3']==1){ // Percentage if selected
					$minimum_price_table=(($minimum_price_table*$minimum_price_format_table1)/100);
				}elseif($_POST['ctype3']==2){ // Flat charge calculator if selected
					$minimum_price_table=$minimum_price_format_table2;
				}
			}elseif($_POST['price3']==1){ //Basic if selected
				if($_POST['ctype3']==1){ // Percentage if selected
					$basic_price_table=(($basic_price_table*$basic_price_format_table1)/100);
				}elseif($_POST['ctype3']==2){ // Flat charge calculator if selected
					$basic_price_table=$basic_price_format_table2;
				}
			}elseif($_POST['price3']==2){ // Unit if selected
				if($_POST['ctype3']==1){ // Percentage if selected
					$kilo_rate_table=(($kilo_rate_table*$kilo_rate_format_table1)/100);
				}elseif($_POST['ctype3']==2){ // Flat charge calculator if selected
					$kilo_rate_table=$kilo_rate_format_table2;
				}
			}
//echo "kilo rate table:".$kilo_rate_table."<br>";
			/* Third Combo values from backened */
			if(($minimum_price_table!="" || $minimum_price_table==0) && $kilo_rate_table!=""){
			// echo "basic price table:".$basic_price_table."<br>";

			// echo "minimum price table:".$minimum_price_table."<br>";

				$price = $basic_price_table+$kilo_rate_table;
				if($price<$minimum_price_table){
					return  $minimum_price_table;
				}else{
					return $price;
				}
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	//exit();
}
function calculate_charge($sup_id_per,$amount,$surcharge){
    $surchargeamount =  $amount+$surcharge;// this is residential or business surcharge
	//echo $amount;
	//exit();
    $fuelamount = calculate_fuel_charge($sup_id_per,$amount);//this is fuel surcharge
	//$securityamount = calculate_security_charge($security_surchage,$amount);//this is security surcharge

	$amount = $surchargeamount +  $fuelamount;
	return number_format($amount,2,'.','');

}
function calculate_fuel_charge($sup_id_per,$amount){
	$amount = $amount*($sup_id_per/100);//this is fuel surcharge
	return number_format($amount,2,'.','');
}
function calculate_charge_with_gst($amount,$gst)
{
	$amount = $gst + $amount;
	return number_format($amount,2,'.','');

}
function calculate_security_charge($security_surchage,$amount){
	$amount = $amount*($security_surchage/100);//this is security surcharge
	return number_format($amount,2,'.','');
}
function calculate_gst_charge($gst,$amount){
	$amount = number_format(($amount*($gst/100)),2,'.','');//this is gst surcharge which is not applicable to international
	return $amount;
}
function volumetricWeight($l,$w,$h)
{
	$volumetric_divisor = services_volumetric_charges;
	$volumetric_divisor = ($volumetric_divisor=='')?('4000'):($volumetric_divisor);
	$weight = ($l*$w*$h)/$volumetric_divisor;
	return $weight;
}
//This function getPublicHoliDays added shailesh jamanapara on date Wed Feb 06 19:21:43 IST 2013
//This function used to get public holidays dates created by Admin and it is called for calender date boxes to view active/inactive holidays
function getPublicHoliDays(){
	require_once(DIR_WS_MODEL.'PublicHolidayMaster.php');
	$ObjPublicholidaysMaster = new PublicHolidayMaster();
	$ObjPublicholidaysMaster = $ObjPublicholidaysMaster->create();
	$fieldArr = array("public_holiday.sdate, public_holiday.edate");
	$searchArr = array();
	$DataPublicholidaysMaster = $ObjPublicholidaysMaster->getPublicHoliday($fieldArr,$searchArr);
	$joinDates = array();
	for ($i=0;$i<count($DataPublicholidaysMaster);$i++)
		{
			$joinDates[$i]['start_date'] = $DataPublicholidaysMaster[$i]->sdate;
			$joinDates[$i]['end_date'] = $DataPublicholidaysMaster[$i]->edate;
		}
	return $joinDates;
}
function dateArr($public_holidays)
{
	if(isset($public_holidays)){
		for($q=0;$q<count($public_holidays);$q++)
		{
			$holiday_date[] = getDatesFromRange($public_holidays[$q]['start_date'],$public_holidays[$q]['end_date']);
		}

		$holiday_arr = array();
		for($s=0;$s<count($holiday_date);$s++)
		{
			$holiday_arr = array_merge($holiday_arr,$holiday_date[$s]);
		}

		//array_walk($holiday_arr, 'addWrapper', "'");
		$date_arr = implode(",",$holiday_arr);
	}
	return $date_arr;
}
//This function set_tracking_status added shailesh jamanapara on date Wed May 15 17:05:15 IST 2013
function set_tracking_status(){

	/* to take all the tracking status in array */
	require_once(DIR_WS_MODEL."tracking_evantMaster.php");

	$trackingEvantMasterObj = new tracking_evantMaster();
	$trackingEvantMasterObj = $trackingEvantMasterObj->create();
	$EventIdDes = $trackingEvantMasterObj->gettracking_evant(array("eventid","description"));

	$event_tracking_arr = array();
	foreach ($EventIdDes as $all_tracking_status){
		$event_tracking_arr[$all_tracking_status['eventid']] = $all_tracking_status['description'];
	}

	define("BOOKED_STATUS_VALUE",0);
	foreach($event_tracking_arr as $tracking_status_id =>$tracking_status){
		if(defined("TRACKING_EVENT_TRANSIT") && TRACKING_EVENT_TRANSIT == $tracking_status){
			define("TRANSTI_STATUS_VALUE",$tracking_status_id);
		}
		if(defined("TRACKING_EVENT_DELIVERED") && TRACKING_EVENT_DELIVERED == $tracking_status){
			define("DELIVERED_STATUS_VALUE", $tracking_status_id);
		}
	}

	/* to take all the tracking status in array */

}
//This function tracking_xml_response added shailesh jamanapara on date Wed May 15 17:04:32 IST 2013
function tracking_xml_response($tracking_id)
{

	$xmlString=rawurlencode("<?xml version='1.0' encoding='ISO-8859-1' ?><WSGET><AccessRequest><WSVersion>WS1.0</WSVersion><FileType>2</FileType><Action>download</Action><EntityID>PMG_001</EntityID><EntityPIN>p3gp455</EntityPIN><MessageID>0001</MessageID><AccessID>OlCourier_ID</AccessID><AccessPIN>edy203f</AccessPIN><CreatedDateTime>2010/07/08 12:00:00 AM</CreatedDateTime></AccessRequest><ReferenceNumber>".$tracking_id."</ReferenceNumber></WSGET>");
	$data = array();
    $data['Username']='pmgusr';
	$data['Password']='p@ssw0rd88';
	$data['xmlStream']=$xmlString;
	$data['LevelConfirm']='detail';
	$post_str = '';
	foreach($data as $key=>$val) {
		$post_str .= $key.'='.$val.'&';
	}
	$post_str = substr($post_str, 0, -1);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://ws05.ffdx.net/ffdx_ws/service.asmx/WSDataTransfer');
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	curl_close($ch);
	if(isset($result) && !empty($result)){
		$pxml = simplexml_load_string($result);
		$result = xml2array($pxml);
		$max = count((array)$result['WSGET']['Event']);
		for($i=0;$i<count((array)$result['WSGET']['Event']);$i++)
		{
			$tracking_status_ids[$i]= ($result['WSGET']['Event'][$i]['EventID']);
		}
		return $tracking_status_ids;
	}
	

	
}
function getItemTypes($itemTypeId){
	require_once(DIR_WS_MODEL . "ItemTypeMaster.php");

	$ObjItemTypeMaster  = new ItemTypeMaster();
	$ObjItemTypeMaster	= $ObjItemTypeMaster->Create();
	$ItemTypeData		= new ItemTypeData();
	if($itemTypeId!=''){
		$fieldArr=array("*");
		$seaByArr[]=array('Search_On'=>'item_id', 'Search_Value'=>"$itemTypeId", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');

		$ItemTypeData=$ObjItemTypeMaster->getItemType($fieldArr,$seaByArr); // Fetch Data

		$ItemTypeData = $ItemTypeData[0];

	}

	if(isset($ItemTypeData['item_name'])){
		return $ItemTypeData['item_name'];
	}
}

//This function getTransitData added shailesh jamanapara on date Fri May 24 12:03:11 IST 2013
//This function getTransitData edited by shailesh jamanapara on Date Sat Jun 22 14:29:03 IST 2013
/*****************************************************************************/
/*@ params 																	 */
/*$bookingType 	= string [domestic OR international]						 */
/*$shippingType	= string [commercial/business OR personal Effect/residential]*/
/*returns an array() on success OR int 0  on failure.						 */
/*****************************************************************************/
function getTransitPriceData($bookingType,$shippingType,$goodsvalue){

	require_once(DIR_WS_MODEL . "TransitPriceMaster.php");
	$ObjTranPriceMaster = new TransitPriceMaster();
	$ObjTranPriceMaster	= $ObjTranPriceMaster->create();
	$TransitData		= new TransitPriceData();

	require_once(DIR_WS_MODEL . "TransitPriceDetailMaster.php");
	$ObjTranPriceDetailMaster = new TransitPriceDetailMaster();
	$ObjTranPriceDetailMaster 	= $ObjTranPriceDetailMaster->create();
	$TranPriceDetailData		= new TransitPriceDetailData();

	$transMetArr = array(0=>"None", 1=>"transit_flat_fee", 2=>"transit_basic_fee");
	$transChargeType = array(0=>"None", 1=>"transit_min_charge", 2=>"transit_min_charge");

	$fldArr 	= array("*");
	$rangeArr[]	=	array('Search_On'=>'tariff_type',
			 									'Search_Value'=>$bookingType,
			 									'Type'=>'string',
			 									'Equation'=>'=',
			 									'CondType'=>'AND',
			 									'Prefix'=>'',
			 									'Postfix'=>'');
	$rangeArr[]	=	array('Search_On'=>'tariff_goods_nature',
			 									'Search_Value'=>$shippingType,
			 									'Type'=>'string',
			 									'Equation'=>'=',
			 									'CondType'=>'AND',
			 									'Prefix'=>'',
			 									'Postfix'=>'');


	$TranPriceData = $ObjTranPriceMaster->getTransitPrice($fldArr,$rangeArr);
	$TranPriceData = $TranPriceData[0];

	if(!empty($TranPriceData)){
		$transitArr = json_decode($TranPriceData['status'],true);
		return $transitArr;
	}else {
		return 0;
	}
}
//This function calTransitPrice added shailesh jamanapara on date Fri May 24 12:32:45 IST 2013
/*****************************************************************************/
/*@ params 																	 */
/*$transType 	= array()													 */
/*$goodsValue   = (int) state by users for the goods value					 */
/*returns (double) transit price on success OR (int) 0  on failure.			 */
/*****************************************************************************/
function calTransitPrice($unitType){

		$goodStaticsVal	= $unitType["goodsValue"];
		$percent 		= intval(($goodStaticsVal) / 100);
		for($i=0;$i<=count($unitType['unit1']);$i++)
		{
			if($goodStaticsVal>=$unitType['range_from'][$i] && $goodStaticsVal<=$unitType['range_to'][$i])
			{
				$j=$i;
			}
		}

			if($unitType["unit"]["rate_type"][$j] == 2){
				$percentOfGoods 	= $unitType["unit"]["amount"][$j];
				$unitAmount		= $percent * intval($percentOfGoods);
				$unit_val		= $unitType["unit"]["amount"][$j];
			}else{
				$unitAmount		= $unitType["unit"]["amount"][$j];
				$unit_val		= $unitType["unit"]["amount"][$j];
			}

			if($unitType["basic"]["rate_type"][$j] == 2){
				$basicPercentOfGoods 	= $unitType["basic"]["amount"][$j];
				$basicAmount			= $percent * intval($basicPercentOfGoods);
				$basic_val 				= $unitType["basic"]["amount"][$j];
			}else{
				$basicAmount			= $unitType["basic"]["amount"][$j];
				$basic_val 				= $unitType["basic"]["amount"][$j];
			}

			if($unitType["minimum"]["rate_type"][$j] == 2){
				$minPercentOfGoods 	= $unitType["minimum"]["amount"][$j];
				$minAmount			= intval($percent * intval($minPercentOfGoods));
				$minimum_val 		= $unitType["minimum"]["amount"][$j];
			}else{
				$minAmount			= $unitType["minimum"]["amount"][$j];
				$minimum_val 		= $unitType["minimum"]["amount"][$j];
			}
			$addUnitAmt 		= 0;

			if($basic_val != '' && $basic_val > 0){
				$addUnitAmt = $unitAmount + $basic_val;
			}else{
				$addUnitAmt = $unitAmount;
			}
			if($minimum_val !='' && $minimum_val > 0){
				if($addUnitAmt < $minAmount){
					$transitVal = $minAmount;
				}else{
					$transitVal = $addUnitAmt;
				}
			}else{
				$transitVal = $addUnitAmt;
			}

		return $transitVal;
}
//This function redirectOnException added shailesh jamanapara on date Mon Jul 29 11:51:08 IST 2013
function redirectOnException($pickup,$deliver){
	$message= "pickup=".$pickup."&deliver=".$deliver;
	header("Location:".FILE_GET_QUOTE."?".$message);
}
function unsetAdminSession()
{
	session_start();
	require_once("common.php");
	global $__Session;
	$__Session->ClearValue("_Sess_Admin_Login");
	$__Session->Store();
}
function UnsetLoginSession()
{
	session_start();
	require_once("common.php");
	global $__Session;
	//echo "inside the unset login session";

	$__Session->ClearValue("_sess_login_userdetails");
	$__Session->ClearValue("_Session_Template_Design");
	$__Session->ClearValue("_session_checkout_details");
	$__Session->ClearValue("_Sess_Coupon_Code");
	$__Session->ClearValue("_Sess_Coupon_Amount");
	$__Session->ClearValue("booking_details");
	$__Session->ClearValue("booking_details_items");
	$__Session->ClearValue("booking_id");
	$__Session->ClearValue("_Sess_Front_Site_Language");
	$__Session->ClearValue("service_details");
	$__Session->ClearValue("client_address_dilivery");
	$__Session->ClearValue("client_address_pickup");
	$__Session->ClearValue("commercial_invoice_id");
	$__Session->ClearValue("commercial_invoice");
	$__Session->ClearValue("commercial_invoice_item");
	$__Session->ClearValue("pickup_add_from_book");
	$__Session->ClearValue("delivery_add_from_book");
	unset($_SESSION['address_return']);
	unset($_SESSION['pickup']);
	unset($_SESSION['deliver']);
	unset($_SESSION['same_zone']);
	unset($_SESSION['timeready']);
	unset($_SESSION['booking_date']);
	unset($_SESSION['deliveredby']);
	unset($_SESSION['dayname']);
	unset($_SESSION['overnighteconomyamt']);
	unset($_SESSION['express_rate']);
	unset($_SESSION['priority_rate']);
	unset($_SESSION['distance_in_km']);
	unset($_SESSION['dayready']);
	unset($_SESSION['ses_flag']);
	unset($_SESSION['dangerousgoods']);
	unset($_SESSION['securitystatement']);
	unset($_SESSION['terms']);
	unset($_SESSION['sessionX']);
	$__Session->Store();
}

function UnsetSession()
{
	session_start();
	require_once("common.php");
	global $__Session;
	//echo "inside this";
	//exit();
	$__Session->ClearValue("_session_checkout_details");
	$__Session->ClearValue("_Sess_Coupon_Code");
	$__Session->ClearValue("_Sess_Coupon_Amount");
	$__Session->ClearValue("booking_details");
	$__Session->ClearValue("booking_details_items");
	$__Session->ClearValue("booking_id");
	$__Session->ClearValue("client_address_dilivery");
	$__Session->ClearValue("client_address_pickup");
	$__Session->ClearValue("commercial_invoice_id");
	$__Session->ClearValue("commercial_invoice");
	$__Session->ClearValue("commercial_invoice_item");
	$__Session->ClearValue("pickup_add_from_book");
	$__Session->ClearValue("delivery_add_from_book");
	unset($_SESSION['address_return']);
	unset($_SESSION['pickup']);
	unset($_SESSION['deliver']);
	unset($_SESSION['timeready']);
	unset($_SESSION['booking_date']);
	unset($_SESSION['deliveredby']);
	unset($_SESSION['original_amount']);
    unset($_SESSION['base_fuel_fee']);
    unset($_SESSION['due_amt']);
    unset($_SESSION['coverage_rate']);
	unset($_SESSION['final_fuel_fee']);
	unset($_SESSION['nett_due_amt']);
	unset($_SESSION['total_new_charges']);
	unset($_SESSION['total_due']);
	unset($_SESSION['discountAmt']);
	unset($_SESSION['couponCode']);
	unset($_SESSION['total_gst']);
	unset($_SESSION['total_tansit_gst']);
	unset($_SESSION['total_gst_delivery']);
	unset($_SESSION['total_delivery_fee']);
	unset($_SESSION['set_pkp_addressbook']);
	unset($_SESSION['chk_pk_address']);
	unset($_SESSION['set_del_addressbook']);
	unset($_SESSION['chk_del_address']);
	unset($_SESSION['dangerousgoods']);
	unset($_SESSION['securitystatement']);
	unset($_SESSION['terms']);
	$__Session->Store();
}

function SetBrowserAgent()
{
	if (!empty($_SERVER['HTTP_USER_AGENT'])) {
        $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
    } else if (!empty($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) {
        $HTTP_USER_AGENT = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
    }
	//exit();
    // 2. browser and version
    if (preg_match('/\MSIE ([0-9]\.[0-9]{1,2})/', $HTTP_USER_AGENT, $log_version)) {
        define('USR_BROWSER_VER', $log_version[1]);
        define('USR_BROWSER_AGENT', 'IE');
    } else if (preg_match('/\Opera ([0-9]\.[0-9]{1,2})/', $HTTP_USER_AGENT, $log_version)) {
        define('USR_BROWSER_VER', $log_version[2]);
        define('USR_BROWSER_AGENT', 'OPERA');
    } else if (preg_match('/\OmniWeb ([0-9]\.[0-9]{1,2})/', $HTTP_USER_AGENT, $log_version)) {
        define('USR_BROWSER_VER', $log_version[1]);
        define('USR_BROWSER_AGENT', 'OMNIWEB');
    } else if (preg_match('/\Mozilla ([0-9]\.[0-9]{1,2})/', $HTTP_USER_AGENT, $log_version)) {
        define('USR_BROWSER_VER', $log_version[1]);
        define('USR_BROWSER_AGENT', 'MOZILLA');
		echo "mozilla";
    } else if (preg_match('/\Konqueror ([0-9]\.[0-9]{1,2})/', $HTTP_USER_AGENT, $log_version)) {
        define('USR_BROWSER_VER', $log_version[1]);
        define('USR_BROWSER_AGENT', 'KONQUEROR');
    } else {
        define('USR_BROWSER_VER', 0);
        define('USR_BROWSER_AGENT', 'OTHER');
    }

}



function encrypt($str, $key)
{
    # Add PKCS7 padding.
    $block = mcrypt_get_block_size('des', 'ecb');
    if (($pad = $block - (strlen($str) % $block)) < $block) {
      $str .= str_repeat(chr($pad), $pad);
    }

    return mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);
}

function decrypt($str, $key)
{
    $str = mcrypt_decrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);

    # Strip padding out.
    $block = mcrypt_get_block_size('des', 'ecb');
    $pad = ord($str[($len = strlen($str)) - 1]);
    if ($pad && $pad < $block && preg_match(
          '/' . chr($pad) . '{' . $pad . '}$/', $str
                                            )
       ) {
      return substr($str, 0, strlen($str) - $pad);
    }
    return $str;
}
/**
 * Field is required *
 */
function checkEmpty($str)
{
	if(empty ($str))
	{
		return ERROR_FIELD_REQUIRED;
	}

}
function checkName($str)
{
	if(!preg_match("/^[a-zA-Z'\-\s]*$/", $str))
	{
		return ERROR_ALPHABETS_ONLY;
	}

}
function checkSuburb($str)
{
	if(!preg_match("/^[a-zA-Z0-9'\-\s]*$/", $str))
	{
		return ERROR_SUBURB_ONLY;
	}

}
function checkHelp($str)
{
	if(!preg_match("/^[a-zA-Z0-9'()_:\,\.\-\s\/\|\?\!]*$/", $str))
	{
		return COMMON_SECURITY_ANSWER_ALPHANUMERIC;
	}
}
function chkbrkts($str)
{
	if(!preg_match("/^[a-zA-Z'.()\s\-\/\/]/", $str))
	{
		return ERROR_CHKBRKTS_ONLY;
	}
}
function checkStr($str)
{
	/// validation for small,capital,apostrophes,space,number
	if(preg_match("/[^a-zA-Z0-9',_.\-\s]/", $str))
	{
		return COMMON_GENERIC;
	}
	//exit();
}
function checkMessage($str)
{
	/// validation for small,capital,apostrophes,space,number
	if(preg_match("/[^a-zA-Z0-9',_.!\s\-\/\/]/", $str))
	{
		return COMMON_GENERIC;
	}
	//exit();
}
function checkHeader($str)
{
	/// validation for small,capital,apostrophes,space,number
	if(preg_match("/[^a-zA-Z0-9.&\-\s]/", $str))
	{
		return COMMON_GENERIC;
	}
	//exit();
}
function chkStr($str)
{
	/// validation for small,capital,number,space
	if(preg_match ("/[^a-zA-Z0-9\s]/", $str))
	{
		return COMMON_SECURITY_ANSWER_ALPHANUMERIC;
	}
}
function chkTrk($str)
{
	/// validation for small,capital,number
	if(preg_match ("/[^a-zA-Z0-9]/", $str))
	{
		return COMMON_TRACKING_ANSWER_ALPHANUMERIC;
	}
}
function chkStreet($str)
{
		/// validation for small,capital,number
	if(preg_match("/[^a-zA-Z0-9 .,:;'?_%\s\-\/\/]/", $str))
	{
		return COMMON_SECURITY_ANSWER_ALPHANUMERIC;
	}

}
function chkStreetSessionData($str)
{
	if(preg_match("/[^a-zA-Z0-9 &#.,:;'?_%\s\-\/\/]/", $str))
	{
		return COMMON_SECURITY_ANSWER_ALPHANUMERIC;
	}

}
function chkRestFields($str)
{
		/// validation for small,capital,number
	if(preg_match("/[^a-zA-Z0-9 .,:;'!?_%\s\-\/\/]/", $str))
	{
		return COMMON_SECURITY_ANSWER_ALPHANUMERIC;
	}

}
function chkState($str)
{
	/// validation for capital
	if(preg_match("/[^a-zA-Z\s]/", $str))
	{
		return ENTER_ONLY_SMALL_CAPITALS;
	}
}
function chkSmallCapital($str)
{
	/// validation for capital
	if(preg_match("/[^a-zA-Z]/", $str))
	{
		return ENTER_ONLY_SMALL_CAPITALS;
	}
}
function chkCapital($str)
{
	/// validation for capital
	if(preg_match("/[^A-Z]/", $str))
	{
		return ENTER_ONLY_CAPITALS;
	}
}
function chkCurrency($str)
{
	/// validation for capital
	if(preg_match("/[^a-zA-Z]/", $str))
	{
		return ENTER_ONLY_CAPITALS;
	}
}
function chkBox($box)
{
	/// validation for small,capital
	if(!isset($box))
	{
		return ERROR_CHECKBOX_REQUIRED;
	}
}
function chkSmall($str)
{
	/// validation for small,capital
	if(preg_match("/[^a-z]/", $str))
	{
		return ERROR_SMALL_ALPHABETS_ONLY;
	}
}
function chkPages($page)
{
		/// validation for small,capital
	if(preg_match("/[^a-zA-Z\-_]/", $page))
	{
		return COMMON_SECURITY_ANSWER_ALPHANUMERIC;
	}
}
function chkFax($fax_no)
{
	/// validation for small,capital
	if(preg_match("/[^\+0-9]/", $fax_no))
	{
		return COMMON_VALID_FAX_NO;
	}

}
function chkDG($str)
{
	/// validation for small,capital
  if(preg_match("/[^0]/", $str))
	{
		return ERROR_DANGEROUS_GOODS_YES;
	}

}
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
');';
    if ($with_script_tags) {
        $js_code = '<script type="text/javascript">' . $js_code . '</script>';
    }

    echo $js_code;
    //print_r($js_code);
    //exit();
}
# Session Logout after in activity
function sessionX(){
	global $__Session;
	session_start();

	if(isset($__Session))
	{
		$session_data = $__Session->GetValue("_sess_login_userdetails");
		$userid = $session_data['user_id'];
	}
	if(IS_ADMIN)
	{
		$userid = 1;
		$logLength = 86400; # time in seconds :: 900 = 15 minutes please change this when go for live
		//$logLength = 900;
	}
	else
	{
		$userid =$userid;
		if($userid)
		{
			//$logLength = 900; # time in seconds :: 1800 = 30 minutes
			//$logLength = 86400; # time in seconds :: 1800 = 30 minutes
			//$logLength = 120;
			$logLength = 86400;
		}elseif($_SESSION['ses_flag']){
			//$logLength = 1800; # time in seconds :: 1800 = 30 minutes 40
			$logLength = 86400; # time in seconds :: 1800 = 30 minutes 1min
		}else{
			//$logLength = 120;
			$logLength = 86400;

		}

	}

    $ctime = strtotime("now"); # Create a time from a string

    # If no session time is created, create one
    if(!isset($_SESSION['sessionX'])){
        # create session time
        $_SESSION['sessionX'] = $ctime;
    }else{

		# Check if they have exceded the time limit of inactivity
        if(((strtotime("now") - $_SESSION['sessionX']) > $logLength) ){

        	//print("");


			/*echo "current time:".strtotime("now")."</br>";
			echo "stored session timing:".$_SESSION['sessionX']."</br>";
            echo "expiry length:".$logLength;
			exit();*/
			# If exceded the time, log the user out
            logOut();

			//unSetCookie();
        }else{
            # If they have not exceded the time limit of inactivity, keep them logged in
            $_SESSION['sessionX'] = $ctime;
        }
    }

}
function Expiry()
{
	echo "1";
}
function unSetCookie()
{
	session_start();
	$_SESSION = array();

    if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}

	session_destroy();
	session_write_close();
}

function logOut()
{
	//include("csrf.php");
	session_start();
	$currentFile = $_SERVER["PHP_SELF"];
	$parts = Explode('/', $currentFile);
	$fileName =  $parts[count($parts) - 1];
	$csrf = new csrf();
	$csrf->cleanOldSession();
	$csrf->logout();
	//$clientip = $_SERVER['REMOTE_ADDR'];
	$clientip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	UnsetLoginSession();
	unSetCookie();

	///if($fileName != 'index.php')
	//{
	if(IS_ADMIN)
	  {

		show_page_header(SITE_ADMIN_DIRECTORY.FILE_WELCOME_ADMIN.'?Action=Logout',false);
		exit();
	  }else
	  {
		//show_page_header(FILE_INDEX.'?action=logout',false);
		header("Location:".SITE_INDEX);
		$view_variable = "debugging message:from php function Logout:";
        console_log($view_variable);
		exit();
	  }

	//}
}
function getDatesFromRange($start, $end) {
    $realEnd = new DateTime($end);
    $realEnd->add(new DateInterval('P1D'));

    $period = new DatePeriod(
         new DateTime($start),
         new DateInterval('P1D'),
         $realEnd
    );

    foreach($period as $date) {
        $array[] = $date->format('Y-m-d');
    }

    return $array;
}

function getDirectZoneFromSt($q){
	require_once(DIR_WS_MODEL . "StePostCodeMaster.php");
	require_once(DIR_WS_MODEL . "StePostcodeData.php");

	$StePostCodeData = new StePostcodeData();
	$ObjStePostCodeMaster = new StePostCodeMaster();
	$ObjStePostCodeMaster = $ObjStePostCodeMaster->Create();

	$seaByArr = array();
	$fieldArr = array();
	$fieldArr = array("FullName","DirectZone","Zone");
	$q =  valid_input(trim($q));
	$suburbArr = explode(" ",$q);
	$lengthofsuburb = sizeof($suburbArr);
	$q = $suburbArr[0];
	$postcode = $suburbArr[$lengthofsuburb-1];

	$seaByArr[]=array('Search_On'=>'FullName', 'Search_Value'=>"%$q%", 'Type'=>'string', 'Equation'=>'LIKE', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
	$seaByArr[]=array('Search_On'=>'Postcode', 'Search_Value'=>"$postcode", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	$StePostCodeData = $ObjStePostCodeMaster->getStePostCode($fieldArr,$seaByArr);
	$StePostCodeData = $StePostCodeData[0];
	//$count_record=count($StePostCodeData);
	$DataStePostCodes=$StePostCodeData;
	//if(!empty($count_record) || $count_record!=0)

	if(is_array((array)$StePostCodeData) && count((array)$StePostCodeData) > 0)
	{
		 $o_s_city_zone=$DataStePostCodes['DirectZone'];
	}
	if(empty($o_s_city_zone))
	{
		 $o_s_city_zone=$DataStePostCodes['Zone'];

	}
	/*
	$metrozones = explode(",",zones_within_australia);

	if(!empty($metrozones))
	{

		if(in_array($o_s_city_zone,$metrozones))
		{
			$o_s_city_zone=$DataStePostCodes['DirectZone'];
		}else{
			$o_s_city_zone=$DataStePostCodes['Zone'];
		}
	} */
	return $o_s_city_zone;
}

function getMessengerZone($q)
{
	require_once(DIR_WS_MODEL ."PostCodeMaster.php");

	$PostCodeMasterObj = new PostCodeMaster();
	$PostCodeMasterObj = $PostCodeMasterObj->create();
	$PostCodedataObj = new PostCodeData();

	$seaByArr[]=array('Search_On'=>'FullName', 'Search_Value'=>"%$q%", 'Type'=>'string', 'Equation'=>'LIKE', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
	$PostCodedataObj =   $PostCodeMasterObj->getPostCode(null,false,$seaByArr);
	$PostCodedataObj = $PostCodedataObj[0];
	//$count_record=count($PostCodedataObj);
	if(is_array((array)$PostCodedataObj) && count((array)$PostCodedataObj) > 0) {
	//if(empty($count_record) || $count_record==0){

		$DataStePostCodes = $PostCodedataObj;
		$o_city_zone['charging_zone'] = $DataStePostCodes['charging_zone'];
		$o_city_zone['id'] = $DataStePostCodes['Id'];
		$o_city_zone['Name'] = $DataStePostCodes['Name'];
		$o_city_zone['Postcode'] = $DataStePostCodes['Postcode'];
		$o_city_zone['time_zone'] = $DataStePostCodes['time_zone'];
		return $o_city_zone;
	}else{

		$err['PICKUPNOTEXISTS'] =  ERROR_DATA_DOES_NOT_EXITS;
		/* When pickup is not selected from km_grid.(Typed in text box then error will be displayed for this purpose this variable is set.) */
		$Svalidation=true;
		return $Svalidation;
	}

}
function getMessengerValid($Name,$Postcode)
{
	require_once(DIR_WS_MODEL ."MsgPostCodeMaster.php");

	$MsgPostCodeMasterObj = new MsgPostCodeMaster();
	$MsgPostCodeMasterObj = $MsgPostCodeMasterObj->create();
	$MsgPostCodedataObj = new MsgPostCodeData();

	$seaByArr[]=array('Search_On'=>'Name', 'Search_Value'=>"$Name", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'', 'Postfix'=>'');
	$seaByArr[]=array('Search_On'=>'PostCode', 'Search_Value'=>"$Postcode", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'AND', 'Postfix'=>'');
	$MsgPostCodedataObj = $MsgPostCodeMasterObj->getMsgPostCode(null,false,$seaByArr);
	$MsgPostCodedataObj = $MsgPostCodedataObj[0];
	//$count_record=count($MsgPostCodedataObj);
	//exit();
	/*if(empty($count_record) || $count_record==0){
		$err['PICKUPNOTEXISTS'] =  ERROR_DATA_DOES_NOT_EXITS;
		/* When pickup is not selected from km_grid.(Typed in text box then error will be displayed for this purpose this variable is set.) */
		/*$Svalidation=true;
		return $Svalidation;
	}else{
		$DataStePostCodes = $MsgPostCodedataObj;
		$o_city_msg['Courier'] = $DataStePostCodes['Courier'];
		$o_city_msg['State'] = $DataStePostCodes['State'];
		return $o_city_msg;
	}*/

	if(is_array((array)$MsgPostCodedataObj) && count((array)$MsgPostCodedataObj) > 0) {

		$DataStePostCodes = $MsgPostCodedataObj;
		$o_city_msg['Courier'] = $DataStePostCodes['Courier'];
		$o_city_msg['State'] = $DataStePostCodes['State'];
		return $o_city_msg;

	}else{
		$err['PICKUPNOTEXISTS'] =  ERROR_DATA_DOES_NOT_EXITS;
		/* When pickup is not selected from km_grid.(Typed in text box then error will be displayed for this purpose this variable is set.) */
		$Svalidation=true;
		return $Svalidation;
	}

}
function getServiceData($ser_code,$supplier_id,$cond_metro=null)
{
	require_once(DIR_WS_MODEL . "ServiceMaster.php");

	$ObjServiceMaster = new ServiceMaster();
	$ObjServiceMaster	      = $ObjServiceMaster->Create();
	$ServiceData		      = new ServiceData();

	$fieldArr = array("service.*","supplier_detail.supplier_name");
	$seaByArr = array();
	if($supplier_id == 3)
	{
		$seaByArr[] = array('Search_On'=>'type', 'Search_Value'=>'0', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		$seaByArr[] = array('Search_On'=>'supplier_id', 'Search_Value'=>'3', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	}
	if($supplier_id == 10)
	{
		$seaByArr[] = array('Search_On'=>'type', 'Search_Value'=>'0', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		$seaByArr[] = array('Search_On'=>'supplier_id', 'Search_Value'=>'10', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	}
	elseif($supplier_id == 4)
	{
		$seaByArr[] = array('Search_On'=>'type', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		$seaByArr[] = array('Search_On'=>'supplier_id ', 'Search_Value'=>'4', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
	}
	elseif($supplier_id == 0)
	{
		if($cond_metro == false)
		{
			$seaByArr[] = array('Search_On'=>'type', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'(', 'Postfix'=>'');
			$seaByArr[] = array('Search_On'=>'type', 'Search_Value'=>'0', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'OR', 'Prefix'=>'', 'Postfix'=>')');
		}else
		{
			$seaByArr[] = array('Search_On'=>'type', 'Search_Value'=>'0', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		}
		$seaByArr[] = array('Search_On'=>'supplier_id ', 'Search_Value'=>'0', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
	}


	$seaByArr[] = array('Search_On'=>'deleted', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
	$seaByArr[] = array('Search_On'=>'status', 'Search_Value'=>'1', 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
	$seaByArr[] = array('Search_On'=>'service_code', 'Search_Value'=>"$ser_code", 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'', 'Prefix'=>'and', 'Postfix'=>'');
	$tableJoins = "service LEFT JOIN supplier_detail ON supplier_detail.auto_id = service.supplier_id";
	$service_val = $ObjServiceMaster->getService($fieldArr,$seaByArr,null,null,null,null,$tableJoins);

	return $service_val;
}
function distanceKm($pickupid,$deliverid)
{
	require_once(DIR_WS_MODEL ."KmGridMaster.php");/* Kilometer grid is used here for the sameday.Used to calculate the distances*/

	$KmGridMasterObj = new KmGridMaster();
	$KmGridMasterObj = $KmGridMasterObj->create();
	$kmGriddataObj = new KmGridData();


	$fieldArr=array("distance_in_km");
	$kmSearName = Array();
	$kmSearName[] =array('Search_On'=>'pickup_id', 'Search_Value'=>"$pickupid", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	$kmSearName[] =array('Search_On'=>'delivery_id', 'Search_Value'=>"$deliverid", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
	$kmGriddataObj = $KmGridMasterObj->getKmGrid($fieldArr,$kmSearName);

	if($pickupid==$deliverid){
		$distance = 0;
	}
	if($kmGriddataObj!=""){
		foreach ($kmGriddataObj as $kmgriddataval){
			$distance = $kmgriddataval['distance_in_km'];/* distance from km_grid table for the calculation of sameday rates */
		}
	}else{
		/* this distance has been calculated on the basis of delivery to pickup */
		$fieldArr=array("distance_in_km");
		$kmSearName = Array();
		$kmSearName[] =array('Search_On'=>'pickup_id', 'Search_Value'=>"$deliverid", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$kmSearName[] =array('Search_On'=>'delivery_id', 'Search_Value'=>"$pickupid", 'Type'=>'int', 'Equation'=>'=', 'CondType'=>'AND', 'Prefix'=>'', 'Postfix'=>'');
		$kmGriddataObj = $KmGridMasterObj->getKmGrid($fieldArr,$kmSearName);
		if($kmGriddataObj!=""){
			foreach ($kmGriddataObj as $kmgriddataval){
				$distance =$kmgriddataval['distance_in_km'];/* distance from km_grid table for the calculation of sameday rates */
			}
		}elseif ($pickupid==$deliverid){
			$distance = 0;
		}
	}
	return $distance;
}
function null2unknown($data) {
    if ($data == "") {
        return "No Value Returned";
    } else {
        return $data;
    }
}
function getResultDescription($responseCode) {

    switch ($responseCode) {
        case "0" : $result = "Transaction Successful"; break;
        case "?" : $result = "Transaction status is unknown"; break;
        case "E" : $result = "Referred"; break;
        case "1" : $result = "Transaction Declined"; break;
        case "2" : $result = "Bank Declined Transaction"; break;
        case "3" : $result = "No Reply from Bank"; break;
        case "4" : $result = "Expired Card"; break;
        case "5" : $result = "Insufficient funds"; break;
        case "6" : $result = "Error Communicating with Bank"; break;
        case "7" : $result = "Payment Server detected an error"; break;
        case "8" : $result = "Transaction Type Not Supported"; break;
        case "9" : $result = "Bank declined transaction (Do not contact Bank)"; break;
        case "A" : $result = "Transaction Aborted"; break;
        case "B" : $result = "Fraud Risk Blocked"; break;
		case "C" : $result = "Transaction Cancelled"; break;
        case "D" : $result = "Deferred transaction has been received and is awaiting processing"; break;
        case "E" : $result = "Transaction Declined - Refer to card issuer"; break;
		case "F" : $result = "3D Secure Authentication failed"; break;
        case "I" : $result = "Card Security Code verification failed"; break;
        case "L" : $result = "Shopping Transaction Locked (Please try the transaction again later)"; break;
        case "M" : $result = "Transaction Submitted (No response from acquirer)"; break;
		case "N" : $result = "Cardholder is not enrolled in Authentication scheme"; break;
        case "P" : $result = "Transaction has been received by the Payment Adaptor and is being processed"; break;
        case "R" : $result = "Transaction was not processed - Reached limit of retry attempts allowed"; break;
        case "S" : $result = "Duplicate SessionID (Amex Only)"; break;
        case "T" : $result = "Address Verification Failed"; break;
        case "U" : $result = "Card Security Code Failed"; break;
        case "V" : $result = "Address Verification and Card Security Code Failed"; break;
        default  : $result = "Unable to be determined"; 
    }
    return $result;
}
function makeRandomString($bits = 256) {
    $bytes = ceil($bits / 8);
    $return = '';
    for ($i = 0; $i < $bytes; $i++) {
        $return .= chr(mt_rand(0, 255));
    }
    return $return;
}

function verifyNonce($data, $cnonce, $hash, $userid, $nonce) {
    $id = $userid;

    //removeNonce($id, $nonce); //Remove the nonce from being used again!
    $testHash = hash('sha512',$nonce . $cnonce . $data);
    return $testHash == $hash;
}
/** This function is used to sort services based on the sorting value set in the back-end Services page **/
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
 $sort_col = array();
 foreach ($arr as $key => $row) {
   $sort_col[$key] = $row[$col];
 }

 array_multisort($sort_col, $dir, $arr);
}

?>
