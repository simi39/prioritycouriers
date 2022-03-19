<?php
class csrf {
   public  $action='unspecified'; // action page the script is good for
   public  $life = 0; // minutes for which key is good 720 for 12 hours
   private $sid; // session id of user
   
   
   public function csrf() {
      $sid = session_id();

	  $this->sid  = preg_replace('/[^a-z0-9]+/i','',$sid);
	 //$this->ipaddress = $_SERVER['REMOTE_ADDR'];
	  $this->ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	  
   }
      
   public function csrfkey() {
	  require_once(DIR_WS_MODEL."TokenTableMaster.php");
	  require_once(DIR_WS_MODEL."TokenTableData.php");
	  global $__Session;
	  $TokenTableMaster	      = new TokenTableMaster();
	  $TokenTableMaster	      = $TokenTableMaster->Create();
	  $TokenTableData	      = new TokenTableData();
	  
	  
	  
	  if(isset($__Session))
	  {
		$session_data = $__Session->GetValue("_sess_login_userdetails");
		$userid = valid_output($session_data['user_id']);
	  }
	   /*
	   echo "<pre>";
	   print_R($_POST);
	   echo "</pre>";
	   exit(); 
	   */
	  // this is only for the unsigned and empty session pages
	   $expiry_time_taken = '24';
	   if((isset($session_data['user_id']) && $session_data['user_id']=="") || (isset($_SESSION['ses_flag']) && isset($_SESSION['ses_flag']) == ''))
	   {
		   
		   $expiry_time_taken = '24';
		   $this->clean24hrOld();
	   }elseif((isset($session_data['user_id']) && $session_data['user_id']!="") || (isset($_SESSION['ses_flag']) && isset($_SESSION['ses_flag']) != '')){
		   $expiry_time_taken = '24';	
		  // $this->cleanOld();
		    $this->clean24hrOld();	
	   }
	  //deleteLoginIPAddress();
	 // deleteEmailIPAddress(); 
	 // $this->cleanOldSession(); /* this query is there for the page entry one at a time in database */
	  //$this->cleanRestTokenOld();
	  //echo "clean old";
	  //exit();
	  //exit();
	  $stamp = time();
	  /* Below code is commented because everytime it was changing key value and it is logging me out from my particular page */
	  //$key = md5(microtime() . $this->sid . rand());
	  $key = md5($this->sid);
	  //$stamp = time() + (60*60 * $this->life);
	 
	  //echo $this->sid."---".$key."</br>";
	  //echo $this->action;
	  //$TokenTableData->ipaddress = $_SERVER['REMOTE_ADDR'];
	  $TokenTableData->ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	  $TokenTableData->sid = $this->sid;
	  $TokenTableData->mykey = $key;
	  $TokenTableData->stamp = $stamp;
	  $TokenTableData->action = $this->action;
	  $TokenTableData->expiry_token_time = $expiry_time_taken;
	  
	  //echo "session_id:".$this->sid."</br>";
	 // if(!empty($this->sid)) // this line is comment by me on 7th jan 2022
	  //{
		
		$TokenTableMaster->addTokenTable($TokenTableData);	
		//echo "to check session id:".empty($this->sid);	
	  //}
	  /*echo "<pre>";
	  print_r($TokenTableMaster);
	  echo "</pre>";*/
	 //echo "return value key:".$key;
	 //exit();
      return $key;
   }
      
   public function checkcsrf($key) {
	 require_once(DIR_WS_MODEL."TokenTableMaster.php");
	 require_once(DIR_WS_MODEL."TokenTableData.php");
	 require_once("functions.php");
	 
	 $TokenTableMaster	      = new TokenTableMaster();
	 $TokenTableMaster	      = $TokenTableMaster->Create();
	 $TokenTableData	      = new TokenTableData();
	 
    // $this->cleanOld();
	// $this->clean24hrOld();
	  //exit();
	// echo "key:".$key."</br>";
	//echo "this is executing firstly";
	 
	  $cleanKey = preg_replace('/[^a-z0-9]+/','',$key);
	 /* echo "sessionid:".$this->sid."</br>";
	  echo "key:".$key."----"."cleanKey:".$cleanKey."</br>";
	  echo "string comparsion:".strcmp($key,$cleanKey);
	  exit();*/
      if (strcmp($key,$cleanKey) != 0) {
		
			logOut();
			
         } else {
		 $seaByArr = array();
		 $fieldArr = array("id");
         //$this->action
        //echo $this->sid."---".$cleanKey."</br>";
		 $seaByArr[]=array('Search_On'=>'sid', 'Search_Value'=>$this->sid, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
		 $seaByArr[]=array('Search_On'=>'mykey', 'Search_Value'=>$cleanKey, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
         $TokenTableData=$TokenTableMaster->getTokenTable($fieldArr, $seaByArr); // Fetch Data
		 $TokenTableData = $TokenTableData[0];
		
		
		 if(!empty($TokenTableData['id']))
		 {
			$valid = $TokenTableData['id'];
		 }
		 //echo "valid token:".$valid;
		 //exit();
		  if (!isset($valid)) {
			//echo $this->sid."---".$cleanKey."</br>";
			//echo "inside";exit();
			logOut();
			  
		 } else {
			$exp = $valid;	
			$fieldname = 'id=';
			//echo "smitatest";
			//exit();
			$testReturn = $TokenTableMaster->deleteTokenTable($exp,$fieldname);
			return true;
            }
         }
      }
      
   private function cleanOld() {
	  require_once(DIR_WS_MODEL."TokenTableMaster.php");
	  require_once(DIR_WS_MODEL."TokenTableData.php");

	  $TokenTableMaster	      = new TokenTableMaster();
	  $TokenTableMaster	      = $TokenTableMaster->Create();
	  $TokenTableData		      = new TokenTableData();
	  
      // remove expired keys
      $exp = time() - (15 * 60);
     //$exp = time() - (60); //1 min expiry time
	  $fieldname = 'stamp <';
	  $sid  = $this->sid;
	  $seaByArr = array();
	  $fieldArr = array("id","ipaddress","sid","stamp");
	  //$this->action
	  $seaByArr[]=array('Search_On'=>'sid', 'Search_Value'=>$this->sid, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	  $SelectedTokenTableData =$TokenTableMaster->getTokenTable($fieldArr, $seaByArr); // Fetch Data
	  $SelectedTokenTableData = $SelectedTokenTableData[0];
	  $existingipaddress = $SelectedTokenTableData['ipaddress'];
	  $existingsid = $SelectedTokenTableData['sid'];
	  $previoustime = $SelectedTokenTableData['stamp'];
	 // echo "pre:".$previoustime;
	//  echo "exp:".$exp;
	  $expiry_time_token = '15';
	  if($this->sid == $existingsid && !empty($previoustime) && $previoustime < $exp)
	  {
		 //echo "unset things after 15 minutes";
		 //exit();
		 $TokenTableMaster->deleteTokenTable($exp,$fieldname,'',$expiry_time_token);
		 UnsetLoginSession();
		 unSetCookie();
		
		 header("Location:".SITE_INDEX);
		 exit();
	  } 
	  
	  $TokenTableMaster->deleteTokenTable($exp,$fieldname,'',$expiry_time_token);
      return true;
      }
	private function clean24hrOld() {
	  require_once(DIR_WS_MODEL."TokenTableMaster.php");
	  require_once(DIR_WS_MODEL."TokenTableData.php");
	  require_once('functions.php');
	  $TokenTableMaster	      = new TokenTableMaster();
	  $TokenTableMaster	      = $TokenTableMaster->Create();
	  $TokenTableData		      = new TokenTableData();
	  
      // remove expired keys
      $exp = time() - (24 * 60 * 60);
      //$exp = time() - (3 * 60); // 3 min expiry time
	  $fieldname = 'stamp <';
	  //$ipaddress =$_SERVER['REMOTE_ADDR'];
	  $ipaddress =$_SERVER['HTTP_X_FORWARDED_FOR'];
	 
	  $sid  = $this->sid;
	  $seaByArr = array();
	  $fieldArr = array("id","ipaddress","sid","stamp");
	  //$this->action
	 //orignial code $seaByArr[]=array('Search_On'=>'sid', 'Search_Value'=>$this->sid, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	  $SelectedTokenTableData =$TokenTableMaster->getTokenTable($fieldArr, $seaByArr); // Fetch Data
	  $SelectedTokenTableData = $SelectedTokenTableData[0];
	  $existingipaddress = $SelectedTokenTableData['ipaddress'];
	  $existingsid = $SelectedTokenTableData['sid'];
	  $previoustime = $SelectedTokenTableData['stamp'];
	  //echo "pre:".$previoustime;
	 // echo "exp:".$exp;
	  //original code if($this->sid == $existingsid && !empty($previoustime) && $previoustime < $exp)
	  if($this->sid == $existingsid && !empty($previoustime) && $previoustime < $exp)
	  {
		 $expiry_time_token = '24'; 
		 $TokenTableMaster->deleteTokenTable($exp,$fieldname,'',$expiry_time_token);
		 
		 UnsetLoginSession();
		 unSetCookie();
		 //exit();
		 //echo "inside 24 clean function";
		// exit();
		 
		 header("Location:".SITE_INDEX);
		 exit();
	  } 
	  $expiry_time_token = '24'; 
	  $TokenTableMaster->deleteTokenTable($exp,$fieldname,TRUE,$expiry_time_token);
	  return true;
    }
	
	private function cleanRestTokenOld() {
	  require_once(DIR_WS_MODEL."TokenTableMaster.php");
	  require_once(DIR_WS_MODEL."TokenTableData.php");
	  require_once('functions.php');
	  $TokenTableMaster	      = new TokenTableMaster();
	  $TokenTableMaster	      = $TokenTableMaster->Create();
	  $TokenTableData		      = new TokenTableData();
	  
      // remove expired keys
      $exp = time() - (24 * 60 * 60);
      //$exp = time() - (3 * 60); // 3 min expiry time
	  $fieldname = 'stamp <';
	   
		 
	  $TokenTableMaster->deleteRestTokenTable($exp,$fieldname);
	 
	  return true;
    }
    public function cleanOldSession() {
	  require_once(DIR_WS_MODEL."TokenTableMaster.php");
	  require_once(DIR_WS_MODEL."TokenTableData.php");
	  require_once("functions.php");
	  
	  
	  $TokenTableMaster	      = new TokenTableMaster();
	  $TokenTableMaster	      = $TokenTableMaster->Create();
	  $TokenTableData		      = new TokenTableData();
	  
      $sid  = $this->sid;
	  $seaByArr = array();
	  $fieldArr = array("id","ipaddress","sid");
      //$this->action
	  $seaByArr[]=array('Search_On'=>'sid', 'Search_Value'=>$this->sid, 'Type'=>'string', 'Equation'=>'=', 'CondType'=>'and', 'Prefix'=>'', 'Postfix'=>'');
	  $SelectedTokenTableData =$TokenTableMaster->getTokenTable($fieldArr, $seaByArr); // Fetch Data
	  $SelectedTokenTableData = $SelectedTokenTableData[0];
	  $existingipaddress = $SelectedTokenTableData['ipaddress'];
	  $existingsid = $SelectedTokenTableData['sid'];
	 	 // exit();
	  /*
		commented by smita on 21.6.2021
		because it was going in loop in logOut function it was written again
		csrf function.
	  if($this->ipaddress != $existingipaddress && $this->sid == $existingsid)
	  {
		echo $this->sid."---".$existingsid."</br>";
	
		logOut();
	  } */
	  /*echo "<pre>";
	  print_r($existingsid);
	  echo "</pre>";
	  exit();*/
	 if(!empty($SelectedTokenTableData))	
	  {
		$fieldname = 'sid =';
		//echo "inside if statement tokentable";
		
		$TokenTableMaster->deleteTokenTable($this->sid,$fieldname);
		//exit();
	  } 
	  //$this->cleanOld();/* timestamp wise deletion */
	  //echo "inside cleanOldSession";
	  //exit();
	  return true;
	  
    }  
	public function logout() {
	  require_once(DIR_WS_MODEL."TokenTableMaster.php");
	  require_once(DIR_WS_MODEL."TokenTableData.php");

	  $TokenTableMaster	      = new TokenTableMaster();
	  $TokenTableMaster	      = $TokenTableMaster->Create();
	  $TokenTableData		      = new TokenTableData();
	  
      $sid  = $this->sid;
     // $sid  = $key;
     
	  $fieldname = 'sid =';
	  $table = $TokenTableMaster->deleteTokenTable($sid,$fieldname);
	  return true;
    }
	  
	
   }
?>
