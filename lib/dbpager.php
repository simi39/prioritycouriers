<?php
//echo DIR_LIB_PEAR . "Pager.php";
require_once(DIR_LIB_PEAR . "Pager.php");

class DbPagerAdmin extends DB_pager
{
	private $NoOfPageGroup;
	private $PageGroup;
	private  $RightsideImage;
	private $StartRow;
	private $PageNumberLinks=10;
	private $MaxRecordsPerPage;

//public $RightImage = null;
	public function DbPagerAdmin()
	{
		//$test = new DbPager();
		//$test->GetPaggingTable();
	}
	
	public function CreatePaging($TotalRecords,$no_Records,$no_Pages,$NotToPass=null,$ExtraParameter=null)
	{
		if($TotalRecords > $no_Records){
			$paging = new DbPagerAdmin();
			$paging->SetMaxRecordsPerPage($no_Records); 	//set No of Records to be display
			$paging->SetPageNumberLinks($no_Pages);		//set No of Page Links to be display
			$PagingResult = $paging->GetPaggingTable($TotalRecords,$NotToPass,null,$ExtraParameter); //get no of pages through this method
			return $PagingResult;
		}
	}

	public function CreateAjaxPaging($TotalRecords,$no_Records,$no_Pages,$NotToPass=null,$ExtraParameter=null)
	{
		if($TotalRecords>$no_Records){
			$paging = new DbPagerAdmin();
			$paging->SetMaxRecordsPerPage($no_Records); 	//set No of Records to be display
			$paging->SetPageNumberLinks($no_Pages);		//set No of Page Links to be display
			$PagingResult = $paging->GetAjaxPaggingTable($TotalRecords,$NotToPass,null,$ExtraParameter); //get no of pages through this method
			return $PagingResult;
		}
	}

/* ************************************************* sart of ajax pagingfunction ************************************ */	
	
public function GetAjaxPaggingTable($NoOfRecordsForPaging,$NotToPass=null,$UserDefinedMaxRecordPerPage=null,$ExtraParameter=null)
	{ 		
		if((dirname($_SERVER['SCRIPT_NAME']) == DIR_ADMIN_NAME)||(dirname($_SERVER['SCRIPT_NAME']) == DIR_ADMIN_NAME)) {
			$RightImage="<span class='page_nav_off'>".PAGING_COMMON_NEXT."</span>";
			$RightsideImage="<span class='page_nav_off'>".PAGING_COMMON_LAST."</span>";
			
		} else {
			$RightImage = '<strong><span>' . PAGING_COMMON_NEXT . '</span></strong>';
			$RightsideImage = '<strong><span>' . PAGING_COMMON_LAST . '</span></strong>';
							
		}

		if(!$this->PageGroup) {
		 	$this->PageGroup = 1;
		}

		$PathToBePass = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		
		//checking first offset value
	 	if(isset($_GET['startRow'])) {
			$Start=$_GET['startRow'];
		} else {
			$Start=0;
		}
		
		if(!empty($Start))
		{
			$err['startRow'] = isNumeric(valid_input($Start),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['startRow']))
		{
			logOut();
		}
		//checking first offset value
		if(isset($_GET['PageGroup'])) {
			$PageGroup=$_GET['PageGroup'];
		} else {
			$PageGroup=1;
		}
		if(!empty($PageGroup))
		{
			$err['PageGroup'] = isNumeric(valid_input($PageGroup),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['PageGroup']))
		{
			logOut();
		}
		if(isset($_GET['PageNo'])) {
			$PageNo=$_GET['PageNo'];
		} else {
			$PageNo=1;
		}
		if(!empty($PageNo))
		{
			$err['PageNo'] = isNumeric(valid_input($PageNo),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['PageNo']))
		{
			logOut();
		}
		//set value of startgroup and pagegroup
		$this->StartRow = $Start;
		$this->PageGroup = $PageGroup;

		//checking any extra path in url
		if(is_null($NotToPass))	{
			$NotToPass = array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo);
		} else {
			$NotToPass = array_merge(array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo),$NotToPass);
		}

		$WhereExtra = Preferences::GetAddressBarQueryString($NotToPass);//this function return path (including startrow & pagegroup)
		
		//querystring path in $whereExtra variable
		if($WhereExtra) {
			$PathToBePass = "?".$WhereExtra;
		}//checking first offset value
		
		if($ExtraParameter) {
			$PathToBePass.="?".$ExtraParameter;
		}

		if(substr_count($PathToBePass,"?")!=0) {
			$PathToBePass = $PathToBePass."&";
		} else {
			$PathToBePass = $PathToBePass."?";
		}	

		if(!is_null($UserDefinedMaxRecordPerPage)) {
			$Result1 = DB_pager::getData(0,$UserDefinedMaxRecordPerPage,$NoOfRecordsForPaging);	
		} else {
			$Result1 = DB_pager::getData(0,$this->MaxRecordsPerPage,$NoOfRecordsForPaging);
		}

		$TotalNumberOfPageGroup = $Result1['numpages'] / $this->PageNumberLinks;
		$this->NoOfPageGroup = ceil($TotalNumberOfPageGroup);
		
		if($this->PageGroup > $this->NoOfPageGroup || $this->PageGroup <= 0) {
			$this->PageGroup = 1;
		}

        $NextPageGroup = floor(($PageNo / $this->PageNumberLinks ) + 1);

        if ($PageNo == (($this->PageGroup * $this->PageNumberLinks ) - ($this->PageNumberLinks - 1))) {
            if ($this->PageNumberLinks == 1)
                $PrevPageGroup = floor(($PageNo / $this->PageNumberLinks ) - 1);
            else
                $PrevPageGroup = floor(($PageNo / $this->PageNumberLinks ));
        } else {
            $PrevPageGroup = ceil(($PageNo / $this->PageNumberLinks ));
        }

		if($PrevPageGroup==0) {
			$PrevPageGroup=1;
		}
		
		//set right image url 
		if($Result1['numpages']>$PageNo) {
			if(!is_null($UserDefinedMaxRecordPerPage)) {
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $UserDefinedMaxRecordPerPage);
			} else {
			    if ($_GET['PageNo'])
				    $StartRowOfGroup = ($_GET['PageNo'] * $this->PageGroup * $this->MaxRecordsPerPage) / $this->PageGroup;
				else 
				    $StartRowOfGroup = ($this->PageGroup * $this->MaxRecordsPerPage);
			}
			if($Result1['numpages'] != $PageNo) {
				$TotalPageLinks = count($Result1['pages']);
				$LastPageStartRow = $Result1['pages'][$TotalPageLinks];
				$KeyRight = array_search($StartRowOfGroup, $Result1['pages']);
				$KeyRightSide = array_search($LastPageStartRow, $Result1['pages']);
				
				$currentLink= $PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$NextPageGroup."&PageNo=".$KeyRight;
				$currentLinkI=$PathToBePass."startRow=".$LastPageStartRow."&PageGroup=".$this->NoOfPageGroup."&PageNo=".$KeyRightSide;				
												
				$RightImage = '<strong><a href="javascript:void(0);" onclick="return ShowAjaxPaging(\''.$currentLink.'\')" class="pagging">' . PAGING_COMMON_NEXT . '</a></strong>';
				$RightsideImage = '<strong><a href="javascript:void(0);" onclick="return ShowAjaxPaging(\''.$currentLinkI.'\')" class="pagging" >' . PAGING_COMMON_LAST . '</a></strong>';
				
			} else {
				   if((dirname($_SERVER['SCRIPT_NAME']) == DIR_ADMIN_NAME)||(dirname($_SERVER['SCRIPT_NAME']) == DIR_ADMIN_NAME)){
				   	
					$RightImage="<span class='page_nav_off'>".PAGING_COMMON_NEXT."</span>";
			 		$RightsideImage="<span class='page_nav_off'>".PAGING_COMMON_LAST."</span>";

				}else
			
					$RightImage = '<strong><span>' . PAGING_COMMON_NEXT . '</span></strong>';
					$RightsideImage = '<strong><span>' . PAGING_COMMON_LAST . '</span></strong>';		
			}
		} else {
			$CountOfStop = $Result1['numpages'];
		}//if -else end
		
		//set leftimage url 
		if($_GET['PageNo']>1) {
			if(!is_null($UserDefinedMaxRecordPerPage)) {
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $UserDefinedMaxRecordPerPage;
			}
			else {
				$StartRowOfGroup = ($_GET['startRow'] - $this->MaxRecordsPerPage);
			}
			$KeyLeft = array_search($StartRowOfGroup, $Result1['pages']);
			
			$leftCurrent = $PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$PrevPageGroup."&PageNo=".$KeyLeft;
			$leftCurrentLink = $PathToBePass."startRow=0&PageGroup=1&PageNo=1";
								
			$LeftImage = '<strong><a href="javascript:void(0);"  onclick="return ShowAjaxPaging(\''.$leftCurrent.'\')"  class="pagging">' . PAGING_COMMON_PREVIOUS . '</a></strong>';
			$LeftSideImage = '<strong><a  href="javascript:void(0);" onclick="return ShowAjaxPaging(\''.$leftCurrentLink.'\')" class="pagging" >' . PAGING_COMMON_FIRST . '</a></strong>';
						
			
		} else {
			 if((dirname($_SERVER['SCRIPT_NAME']) == DIR_ADMIN_NAME)||(dirname($_SERVER['SCRIPT_NAME']) == DIR_ADMIN_NAME)){
			 
			 	$LeftImage="<span class='page_nav_off'>".PAGING_COMMON_PREVIOUS."</span>";
				$LeftSideImage="<span class='page_nav_off'>".PAGING_COMMON_FIRST."</span>";	
			
		   }else{
			
				$LeftImage = '<strong><span>' . PAGING_COMMON_PREVIOUS . '</span></strong>';
				$LeftSideImage = '<strong><span>' . PAGING_COMMON_FIRST . '</span></strong>';			
			}
		 //if -else end
		}
		
		$CountOfStop = $this->PageNumberLinks * $this->PageGroup   ;
		$CountOfStart = $CountOfStop - $this->PageNumberLinks + 1;
		$LoopOfPageNum = $LeftSideImage;
		$LoopOfPageNum = $LoopOfPageNum."&nbsp;".$LeftImage." ";	
 		  
	   for($i=$CountOfStart;$i<=$CountOfStop;$i++) {
			if($this->StartRow==$Result1['pages'][$i]) {
				$ExtraLink = "";
				//$LoopOfPageNum.="&nbsp;&nbsp;".$ExtraLink."<strong >".$i."</strong>&nbsp;&nbsp;";
				
				$LoopOfPageNum.= $ExtraLink . '<span class="activepagelink" >' . $i . '</span>';
			} else {
				$linkFunction = $PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."&PageNo=".$i;
			
				$ExtraLink = '<span class="pagelink"><a onclick="return ShowAjaxPaging(\''.$linkFunction.'\')"  href="javascript:void(0);">';
				$LoopOfPageNum.= $ExtraLink.$i."</a></span>";
				
			}
			
			if($i>=$Result1['numpages']) {
				break;
			}
		}// for loop end
		
		//$LoopOfPageNum= substr($LoopOfPageNum,0,-1);
		$key = array_search($Start, $Result1['pages']);
		$LastPage=$Result1['lastpage'];
		$LoopOfPageNum.=$RightImage;
		$LoopOfPageNum.="&nbsp;".$RightsideImage;
		$ReturnString = "&nbsp;".$LoopOfPageNum;
		$ReturnString.="";
		$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"border:none;clear:both;\">
								<tr valign=\"middle\" >
										<td align=\"center\" class='pagging' >".$ReturnString;
			$ReturnString.= "				<input type=\"hidden\"  name=\"PageGroup\" \>
											<input type=\"hidden\"  name=\"startRow\" \>
									  </td>  
								</tr>
						</table>";
		$ReturnString = '<div class="paging">' . $ReturnString . '</div>';			
		if($Result1['lastpage']>1){
			return $ReturnString;
		}
	}
	
/* ************************************************* end of ajax Pagnig function ************************************ */	
	
	public function GetNoOfPageGroup()
	{
		return $this->NoOfPageGroup;
	}

	public function SetNoOfPageGroup($NoOfPageGroup)
	{
		$this->NoOfPageGroup = $NoOfPageGroup;
	}

	public function GetPageGroup()
	{
		return $this->NoPageGroup;
	}

	public function SetPageGroup($PageGroup)
	{
		$this->PageGroup = $PageGroup;
	}
	
	public function GetStartRow()
	{
		return $this->StartRow;
	}

	public function SetStartRow($StartRow)
	{
		$this->StartRow = $StartRow;
	}

	public function GetPageNumberLinks()
	{
		return $this->PageNumberLinks;
	}

	public function SetPageNumberLinks($PageNumberLinks)
	{
		if(!is_null($PageNumberLinks) && !empty($PageNumberLinks)) {
			$this->PageNumberLinks = $PageNumberLinks;
		} else {
			$this->PageNumberLinks = PAGE_NUMBER_LINKS;
		}
	}
	
	public function GetMaxRecordsPerPage()
	{
		return $this->MaxRecordsPerPage;
	}

	public function SetMaxRecordsPerPage($MaxRecordsPerPage)
	{
		if(!is_null($MaxRecordsPerPage) && !empty($MaxRecordsPerPage)) {
			$this->MaxRecordsPerPage = $MaxRecordsPerPage;
		} else {
			$this->MaxRecordsPerPage = MAX_RECORD_PER_PAGE;
		}
	}

/**
*     this function return no of pages and all information
*/
	public  function GetPagingResult($NoOfRecordsForPaging,$NotToPass=null,$UserDefinedMaxRecordPerPage=null)
	{
		if(!is_null($UserDefinedMaxRecordPerPage)) {
			$Result1 = DB_pager::getData(0,$UserDefinedMaxRecordPerPage,$NoOfRecordsForPaging);	
		} else { 
			$Result1 = DB_pager::getData(0,$this->MaxRecordsPerPage,$NoOfRecordsForPaging);
		}
		return $Result1;
	}

	public function GetPaggingTable($NoOfRecordsForPaging,$NotToPass=null,$UserDefinedMaxRecordPerPage=null,$ExtraParameter=null) {
		
		if(IS_ADMIN == true) {
			$RightImage="<span class='page_nav_off'>".PAGING_COMMON_NEXT."</span>";
			 $RightsideImage="<span class='page_nav_off'>".PAGING_COMMON_LAST."</span>";
		} else {
			$RightImage = '<strong><span>' . PAGING_COMMON_NEXT . '</span></strong>';
			$RightsideImage = '<strong><span>' . PAGING_COMMON_LAST . '</span></strong>';
		}

		if(!$this->PageGroup) {
		 	$this->PageGroup = 1;
		}

		$PathToBePass = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

//checking first offset value
	 	if(isset($_GET['startRow'])) {
			$Start=$_GET['startRow'];
		} else {
			$Start=0;
		}
		if(!empty($Start))
		{
			$err['Start'] = isNumeric(valid_input($Start),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['Start']))
		{
			logOut();
		}
//checking first offset value
		if(isset($_GET['PageGroup'])) {
			$PageGroup=$_GET['PageGroup'];
		} else {
			$PageGroup=1;
		}
		if(!empty($PageGroup))
		{
			$err['PageGroup'] = isNumeric(valid_input($PageGroup),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['PageGroup']))
		{
			logOut();
		}
		if(isset($_GET['PageNo'])) {
			$PageNo=$_GET['PageNo'];
		} else {
			$PageNo=1;
		}
		if(!empty($PageNo))
		{
			$err['PageNo'] = isNumeric(valid_input($PageNo),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['PageNo']))
		{
			logOut();
		}
//set value of startgroup and pagegroup
		$this->StartRow = $Start;
		$this->PageGroup = $PageGroup;

//checking any extra path in url
		if(is_null($NotToPass))	{
			$NotToPass = array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo);
		} else {
			$NotToPass = array_merge(array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo),$NotToPass);
		}
		$Preferences = new Preferences();
		$WhereExtra = $Preferences->GetAddressBarQueryString($NotToPass);//this function return path (including startrow & pagegroup)
		
//querystring path in $whereExtra variable
	
		if(!empty($WhereExtra)) {
			$PathToBePass .= "?".$WhereExtra;
		}//checking first offset value
		
		if(substr_count($PathToBePass,"?")!=0) {
			$PathToBePass = $PathToBePass."&";
		} else {
			$PathToBePass = $PathToBePass."?";
		}
		
		if( !empty($ExtraParameter) ) {
			$PathToBePass .= $ExtraParameter ."&";
		}

		if(!is_null($UserDefinedMaxRecordPerPage)) {
			$Result1 = DB_pager::getData(0,$UserDefinedMaxRecordPerPage,$NoOfRecordsForPaging);	
		} else {
			$Result1 = DB_pager::getData(0,$this->MaxRecordsPerPage,$NoOfRecordsForPaging);
		}

		$TotalNumberOfPageGroup = $Result1['numpages'] / $this->PageNumberLinks;
		$this->NoOfPageGroup = ceil($TotalNumberOfPageGroup);
		
		if($this->PageGroup > $this->NoOfPageGroup || $this->PageGroup <= 0) {
			$this->PageGroup = 1;
		}

/*		
        if ((($this->PageNumberLinks * $this->PageGroup) == $_GET['PageNo']) || ($Result1['numpages'] == $_GET['PageNo']))
        {
        	$NextPageGroup = $this->PageGroup + 1;
        	$PrevPageGroup = $this->PageGroup;
        } else {
            $NextPageGroup = $this->PageGroup;
        	$PrevPageGroup = $this->PageGroup - 1;
        }
*/
        $NextPageGroup = floor(($PageNo / $this->PageNumberLinks ) + 1);

        if ($PageNo == (($this->PageGroup * $this->PageNumberLinks ) - ($this->PageNumberLinks - 1))) {
            if ($this->PageNumberLinks == 1)
                $PrevPageGroup = floor(($PageNo / $this->PageNumberLinks ) - 1);
            else
                $PrevPageGroup = floor(($PageNo / $this->PageNumberLinks ));
        } else {
            $PrevPageGroup = ceil(($PageNo / $this->PageNumberLinks ));
        }

/*
        if ($this->PageNumberLinks == 1)
            $PrevPageGroup = floor(($PageNo / $this->PageNumberLinks ) - 1);
        elseif ($this->PageNumberLinks == 2)
            $PrevPageGroup = floor(($PageNo / $this->PageNumberLinks ));
        else
            $PrevPageGroup = round(($PageNo / $this->PageNumberLinks ));
*/        
		if($PrevPageGroup==0) {
			$PrevPageGroup=1;
		}
		
		//set right image url 
//		if($Result1['numpages']>$this->PageNumberLinks) {
		if($Result1['numpages']>$PageNo) {
			if(!is_null($UserDefinedMaxRecordPerPage)) {
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $UserDefinedMaxRecordPerPage);
			} else {
//				    $StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $this->MaxRecordsPerPage);
			    if ($_GET['PageNo'])
				    $StartRowOfGroup = ($_GET['PageNo'] * $this->PageGroup * $this->MaxRecordsPerPage) / $this->PageGroup;
				else 
				    $StartRowOfGroup = ($this->PageGroup * $this->MaxRecordsPerPage);
			}

			if($Result1['numpages'] != $PageNo) {
				$TotalPageLinks = count($Result1['pages']);
				$LastPageStartRow = $Result1['pages'][$TotalPageLinks];
				$KeyRight = array_search($StartRowOfGroup, $Result1['pages']);
				$KeyRightSide = array_search($LastPageStartRow, $Result1['pages']);
				/*$RightImage="&nbsp;<a  class='pagging' href='".$PathToBePass."startRow=".$StartRowOfGroup."&amp;PageGroup=".$NextPageGroup."&amp;PageNo=".$KeyRight."' title='".PAGING_COMMON_NEXT_COMMENT."'>".PAGING_COMMON_NEXT."</a><img  id='imgleft' src='".SITE_URL."/images/rightarrow.gif' align='middle' border='0' /></a>&nbsp;";
				$RightsideImage="&nbsp;<a  class='pagging' href='".$PathToBePass."startRow=".$LastPageStartRow."&PageGroup=".$this->NoOfPageGroup."&PageNo=".$KeyRightSide."' title='".PAGING_COMMON_LAST_COMMENT."'>".PAGING_COMMON_LAST."</a><img  id='imgleft1' src='".SITE_URL."/images/rightarrow.gif' align='middle' border='0' /><img  id='imgleft11' src='".SITE_URL."/images/rightarrow.gif' align='middle' border='0' />&nbsp;";*/
				
				$RightImage = '<strong><a href="' . $PathToBePass . "startRow=" . $StartRowOfGroup . "&amp;PageGroup=" . $NextPageGroup . "&amp;PageNo=" . $KeyRight . '" title="' . PAGING_COMMON_NEXT_COMMENT . '">' . PAGING_COMMON_NEXT . '</a></strong>';
				$RightsideImage = '<strong><a href="' . $PathToBePass . "startRow=" . $LastPageStartRow . "&amp;PageGroup=" . $this->NoOfPageGroup . "&amp;PageNo=" . $KeyRightSide . '" title="' . PAGING_COMMON_LAST_COMMENT . '">' . PAGING_COMMON_LAST . '</a></strong>';
				
			} else {
				if(IS_ADMIN == true) {
					
					/*$RightImage="<span>".PAGING_COMMON_NEXT."</span>";
					$RightsideImage="<span class='pagging1'>".PAGING_COMMON_LAST."</span>";*/
					
					$RightImage="<span class='page_nav_off'>".PAGING_COMMON_NEXT."</span>";
			 		$RightsideImage="<span class='page_nav_off'>".PAGING_COMMON_LAST."</span>";
					
				} else {
					/*$RightImage="&nbsp;".PAGING_COMMON_NEXT."</span><img id='imgleft3' src='".SITE_URL."/images/rightarrow.gif' align='middle' border='0' />&nbsp;";
					$RightsideImage="&nbsp;<span class='pagging1'>".PAGING_COMMON_LAST."</span><img  id='imgleft4' src='".SITE_URL."/images/rightarrow.gif' align='middle' border='0' /><img  id='imgleft5' src='".SITE_URL."/images/rightarrow.gif' align='middle' border='0' />&nbsp;";*/
					
					$RightImage = '<strong><span>' . PAGING_COMMON_NEXT . '</span></strong>';
					$RightsideImage = '<strong><span>' . PAGING_COMMON_LAST . '</span></strong>';
				}
			}
		} else {
			$CountOfStop = $Result1['numpages'];
		}//if -else end
		
		//set leftimage url 
//		if($this->PageGroup>1) {
		if($_GET['PageNo']>1) {
			if(!is_null($UserDefinedMaxRecordPerPage)) {
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $UserDefinedMaxRecordPerPage;
			}
			else {
//				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $this->MaxRecordsPerPage;
				$StartRowOfGroup = ($_GET['startRow'] - $this->MaxRecordsPerPage);
			}
			$KeyLeft = array_search($StartRowOfGroup, $Result1['pages']);
			
			//$LeftImage="&nbsp;<a class='section_option' href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$PrevPageGroup."&PageNo=".$KeyLeft."' title='Click here to View Previous Set of Page'><img id='imgleft11' src='".SITE_URL."/images/leftarrow.gif' align='absmiddle' border='0' ></a>&nbsp;";
			/*$LeftImage="&nbsp;<img id='imgleft11' src='".SITE_URL."/images/leftarrow.gif' align='middle' border='0' /><a class='pagging' href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$PrevPageGroup."&PageNo=".$KeyLeft."' title='".PAGING_COMMON_PREVIOUS_COMMENT."'>".PAGING_COMMON_PREVIOUS."</a>&nbsp;";
			$LeftSideImage="&nbsp;<img id='imgleft12' src='".SITE_URL."/images/leftarrow.gif' align='middle' border='0' /><img id='imgleft13' src='".SITE_URL."/images/leftarrow.gif' align='middle' border='0' /><a  class='pagging' href='".$PathToBePass."startRow=0&PageGroup=1&PageNo=1' title='".PAGING_COMMON_FIRST_COMMENT."'>".PAGING_COMMON_FIRST."</a>&nbsp;";*/
		//	$LeftSideImage="&nbsp;<a  class='section_option' href='".$PathToBePass."startRow=0&PageGroup=1&PageNo=1' title='Click here to View First Page Record'><img id='imgleft12' src='".SITE_URL."/images/leftarrow.gif' align='absmiddle' border='0' ><img id='imgleft13' src='".SITE_URL."/images/leftarrow.gif' align='absmiddle' border='0' ></a>&nbsp;";
			
			$LeftImage = '<strong><a href="' . $PathToBePass . "startRow=" . $StartRowOfGroup . "&amp;PageGroup=" . $PrevPageGroup . "&amp;PageNo=" . $KeyLeft . '" title="' . PAGING_COMMON_PREVIOUS_COMMENT . '">' . PAGING_COMMON_PREVIOUS . '</a></strong>';
			$LeftSideImage = '<strong><a href="' . $PathToBePass . 'startRow=0&amp;PageGroup=1&amp;PageNo=1" title="' . PAGING_COMMON_FIRST_COMMENT . '">' . PAGING_COMMON_FIRST . '</a></strong>';
		
		} else {
			 if(IS_ADMIN == true) {

			 	$LeftImage="<span class='page_nav_off'>".PAGING_COMMON_PREVIOUS."</span>";
				$LeftSideImage="<span class='page_nav_off'>".PAGING_COMMON_FIRST."</span>";	
				
			}else{
				/*$LeftImage="&nbsp;<img id='imgleft15' src='".SITE_URL."/images/leftarrow.gif' align='middle' border='0' /><span class='pagging1'>".PAGING_COMMON_PREVIOUS."</span>&nbsp;";
				$LeftSideImage="&nbsp;<img id='imgleft16' src='".SITE_URL."/images/leftarrow.gif' align='middle' border='0' /><img id='imgleft17' src='".SITE_URL."/images/leftarrow.gif' align='middle' border='0' /><span class='pagging1'>".PAGING_COMMON_FIRST."</span>&nbsp;";*/
				
				$LeftImage = '<strong><span>' . PAGING_COMMON_PREVIOUS . '</span></strong>';
				$LeftSideImage = '<strong><span>' . PAGING_COMMON_FIRST . '</span></strong>';
			}
		 //if -else end
		}
		
			$CountOfStop = $this->PageNumberLinks * $this->PageGroup   ;
			$CountOfStart = $CountOfStop - $this->PageNumberLinks + 1;
 		    $LoopOfPageNum = $LeftSideImage;
 		    $LoopOfPageNum = $LoopOfPageNum . $LeftImage;
 		
 		
	   	for($i=$CountOfStart;$i<=$CountOfStop;$i++) {
			if($this->StartRow==$Result1['pages'][$i]) {
				$ExtraLink = "";
				$LoopOfPageNum.= $ExtraLink . '<span class="activepagelink" >' . $i . '</span>';
			} else {
				$ExtraLink = "<span class='pagelink'><a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."&PageNo=".$i."'>";
				$LoopOfPageNum.= $ExtraLink.$i."</a></span>";
			}
			
			if($i>=$Result1['numpages']) {
				break;
			}
		}// for loop end
	//$LoopOfPageNum .= '</span>';
	
	/*$LoopOfPageNum= substr($LoopOfPageNum,0,-1);*/
	
	$key = array_search($Start, $Result1['pages']);
	$LastPage=$Result1['lastpage'];
	$LoopOfPageNum.=$RightImage;
	$LoopOfPageNum.= $RightsideImage;
	$ReturnString = $LoopOfPageNum;
	$ReturnString.="";
		/*$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"border:none\">
								<tr valign=\"middle\" >
										<td align=\"center\" class='pagging' >".$ReturnString;
			$ReturnString.= "				<input type=\"hidden\"  name=\"PageGroup\" \>
											<input type=\"hidden\"  name=\"startRow\" \>
									  </td>  
								</tr>
						</table>";  */
		 $ReturnString = '<div class="paging">' . $ReturnString . '</div>';
		if($Result1['lastpage']>1){
			return $ReturnString;
		}
	}//GetPaggingTable() function end 
/* ************************************************* end of function ************************************ */
	

	public function GetPrevNextPage($NoOfRecordsForPaging,$NotToPass=null,$UserDefinedMaxRecordPerPage=null,$ExtraParameter=null,$Image=PAGING_COMMON_NEXT ,$Images2=PAGING_COMMON_PREVIOUS)
	{ 	
		$RightImage="&nbsp;$Image&nbsp;";
		$LeftImage=	"&nbsp;$Images2&nbsp;";		
		if(!$this->PageGroup){	$this->PageGroup = 1;	}
		$PathToBePass = SITE_URL_FOR_PAGGING.$_SERVER['PHP_SELF'];
			
			//checking first offset value
	 	if(isset($_GET['startRow'])) { 
	 	     $Start=$_GET['startRow'];
		} else {
			$Start=0;
		}
		if(!empty($Start))
		{
			$err['Start'] = isNumeric(valid_input($Start),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['Start']))
		{
			logOut();
		}
		//checking first offset value
		if(isset($_GET['PageGroup'])) {
			$PageGroup=$_GET['PageGroup'];
		} else {
			$PageGroup=1;
		}
		if(!empty($PageGroup))
		{
			$err['PageGroup'] = isNumeric(valid_input($PageGroup),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['PageGroup']))
		{
			logOut();
		}
		if(isset($_GET['PageNo'])) {
			$PageNo=$_GET['PageNo'];
		} else {
			$PageNo=1;
		}
		if(!empty($PageNo))
		{
			$err['PageNo'] = isNumeric(valid_input($PageNo),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['PageNo']))
		{
			logOut();
		}
		//set value of startgroup and pagegroup
		$this->StartRow = $Start;
		$this->PageGroup = $PageGroup;
		
		//checking any extra path in url
		if(is_null($NotToPass))	{
			$NotToPass = array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo);
		} else {
			$NotToPass = array_merge(array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo),$NotToPass);
		}

		if(isset($ExtraParameter)) {
			if(!is_null($ExtraParameter)) {
			$NotToPass = array_merge(array("ListRegion"=>$ExtraParameter['Region_str_code'],"ListCountry"=>$ExtraParameter['Country_str_code']),$NotToPass);
			}
		}
		$WhereExtra = Preferences::GetAddressBarQueryString($NotToPass);//this function return path (including startrow & pagegroup)
		//querystring path in $whereExtra variable
		if($WhereExtra) {
			$PathToBePass = "?".$WhereExtra;
		}//checking first offset value
		
		//
		if(substr_count($PathToBePass,"?")!=0) {
			$PathToBePass = $PathToBePass."&";
		} else{
			$PathToBePass = $PathToBePass."?";
		}

		if(!is_null($UserDefinedMaxRecordPerPage)) {
			$Result1 = DB_pager::getData(0,$UserDefinedMaxRecordPerPage,$NoOfRecordsForPaging);	
		} else{
			$Result1 = DB_pager::getData(0,$this->MaxRecordsPerPage,$NoOfRecordsForPaging);
		}

		$TotalNumberOfPageGroup = $Result1['numpages'] / $this->PageNumberLinks;
		$this->NoOfPageGroup = ceil($TotalNumberOfPageGroup);
		
		if($this->PageGroup > $this->NoOfPageGroup || $this->PageGroup <= 0) {
			$this->PageGroup = 1;
		}

		$NextPageGroup = $this->PageGroup + 1;
		$PrevPageGroup = $this->PageGroup - 1;
		if($PrevPageGroup==0) {
			$PrevPageGroup=1;
		}

//set right image url 
		if($Result1['numpages']>$this->PageNumberLinks) {
			if(!is_null($UserDefinedMaxRecordPerPage)) {
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $UserDefinedMaxRecordPerPage);
			} else {
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $this->MaxRecordsPerPage);
			}
		 	//
			if($this->NoOfPageGroup >= $NextPageGroup) {
				$TotalPageLinks = count($Result1['pages']);
				$LastPageStartRow = $Result1['pages'][$TotalPageLinks];
				if(isset($ExtraParameter)) {
					$ListRegionAndCountry = "&ListRegion=".$ExtraParameter['Region_str_code']."&ListCountry=".$ExtraParameter['Country_str_code'];
				}
				$RightImage="&nbsp;<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$NextPageGroup."&PageNo=".$PageNo.$ListRegionAndCountry."' title='".PAGING_COMMON_NEXT_COMMENT."'>$Image</a>&nbsp;";
				//$RightsideImage="&nbsp;<a href='".$PathToBePass."startRow=".$LastPageStartRow."&PageGroup=".$this->NoOfPageGroup."' title='Click here to View Last Page Record'><img  id='imgleft1' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft11' src='".DDIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";					
			} else {
				$RightImage=$Image;
				//$RightsideImage="&nbsp;<img  id='imgleft4' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft5' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' >&nbsp;";					
					
			}
		} else {
			$CountOfStop = $Result1['numpages'];
		}//if -else end
		
		//set leftimage url 
		if($this->PageGroup>1) {
			if(!is_null($UserDefinedMaxRecordPerPage)) {
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $UserDefinedMaxRecordPerPage;
			} else {
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $this->MaxRecordsPerPage;
			}

			if(isset($ExtraParameter)) {
				$ListRegionAndCountry = "&ListRegion=".$ExtraParameter['Region_str_code']."&ListCountry=".$ExtraParameter['Country_str_code'];
			}
			$LeftImage="<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$PrevPageGroup.$ListRegionAndCountry."' title='".PAGING_COMMON_PREVIOUS_COMMENT."'>$Images2</a>&nbsp;";
			//$LeftSideImage="&nbsp;<a href='".$PathToBePass."startRow=0&PageGroup=1' title='Click here to View First Page Record'><img id='imgleft12' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft13' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";
			
		} else {
			$LeftImage=$Images2;
			//$LeftSideImage="<img id='imgleft16' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft17' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' >&nbsp;";
		} //if -else end

			$CountOfStop = $this->PageNumberLinks * $this->PageGroup;
			$CountOfStart = $CountOfStop - $this->PageNumberLinks + 1;
 		   // $LoopOfPageNum = $LeftSideImage;
 		    $LoopOfPageNum = $LeftImage;	

	   	for($i=$CountOfStart;$i<=$CountOfStop;$i++)
		{	
			
			if($this->StartRow==$Result1['pages'][$i]) {
				$ExtraLink = "";
				$LoopOfPageNum.="".$ExtraLink."<span >"."</span>&nbsp;";
			} else {
				$ExtraLink = "<a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."&PageNo=".$i."'>";
				$LoopOfPageNum.="".$ExtraLink."<span >"."</span></a>&nbsp;";
			}

			if($i>=$Result1['numpages']) {
				break;
			}
		}// for loop end

		$LoopOfPageNum.=$RightImage;
		$ReturnString = "&nbsp;".$LoopOfPageNum;
		if($Image!=PAGING_COMMON_NEXT && $Images2!=PAGING_COMMON_PREVIOUS) {
			$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr height=\"24\"  valign=\"middle\">
		<td valign=\"middle\">".$ReturnString."</td></tr></table>";
		return $ReturnString;
		}
//		$ReturnString.="<span class=pagingtable><input maxLength=7 size=4  name=PageNo  ></span><INPUT id=submit style=BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px onclick='' type='submit' value=Go   name=Submit  >";
		
		$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr height=\"24\"  valign=\"middle\">
		<td valign=\"middle\">&laquo;".$ReturnString."&raquo;</td></tr></table>";
		return $ReturnString;
	}//GetPaggingTable() function end 

/******************* Trip report Image ******************************/
	public function GetNextImage($NoOfRecordsForPaging,$NotToPass=null,$UserDefinedMaxRecordPerPage=null,$ExtraParameter=null,$ImagePath=ImageAdminPath)
	{ 	
		$NewImage=$ImagePath."/images/member/right-arrow-black.gif";
		$LeftImage='';
		$RightImage="<img  id='imgleft11' src='".$NewImage."' align='middle' border='0' />";
		if(!$this->PageGroup){	$this->PageGroup = 1;	}
			$PathToBePass = SITE_URL_FOR_PAGGING.$_SERVER['PHP_SELF'];
			
			//checking first offset value
	 	if(isset($_GET['startRow'])) {
			$Start=$_GET['startRow'];
		} else {
			$Start=0;
		}
		if(!empty($Start))
		{
			$err['Start'] = isNumeric(valid_input($Start),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['Start']))
		{
			logOut();
		}
		//checking first offset value
		if(isset($_GET['PageGroup'])) {
			$PageGroup=$_GET['PageGroup'];
		} else {
			$PageGroup=1;
		}
		if(!empty($PageGroup))
		{
			$err['PageGroup'] = isNumeric(valid_input($PageGroup),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['PageGroup']))
		{
			logOut();
		}
		if(isset($_GET['PageNo'])) {
			$PageNo=$_GET['PageNo'];
		} else {
			$PageNo=1;
		}
		if(!empty($PageNo))
		{
			$err['PageNo'] = isNumeric(valid_input($PageNo),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['PageNo']))
		{
			logOut();
		}
//set value of startgroup and pagegroup
		$this->StartRow = $Start;
		$this->PageGroup = $PageGroup;
		
		//checking any extra path in url
		if(is_null($NotToPass))	{
			$NotToPass = array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo);
		} else {
			$NotToPass = array_merge(array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo),$NotToPass);
		}

		if(isset($ExtraParameter)) {
			if(!is_null($ExtraParameter)) {
			$NotToPass = array_merge(array("ListRegion"=>$ExtraParameter['Region_str_code'],"ListCountry"=>$ExtraParameter['Country_str_code']),$NotToPass);
			}
		}
		$WhereExtra = Preferences::GetAddressBarQueryString($NotToPass);//this function return path (including startrow & pagegroup)
		//querystring path in $whereExtra variable
		if($WhereExtra) {
			$PathToBePass = "?".$WhereExtra;
		}//checking first offset value
		
		//
		if(substr_count($PathToBePass,"?")!=0) {
			$PathToBePass = $PathToBePass."&";
		} else{
			$PathToBePass = $PathToBePass."?";
		}

		if(!is_null($UserDefinedMaxRecordPerPage)) {
			$Result1 = DB_pager::getData(0,$UserDefinedMaxRecordPerPage,$NoOfRecordsForPaging);	
		} else{
			$Result1 = DB_pager::getData(0,$this->MaxRecordsPerPage,$NoOfRecordsForPaging);
		}

		$TotalNumberOfPageGroup = $Result1['numpages'] / $this->PageNumberLinks;
		$this->NoOfPageGroup = ceil($TotalNumberOfPageGroup);
		
		if($this->PageGroup > $this->NoOfPageGroup || $this->PageGroup <= 0) {
			$this->PageGroup = 1;
		}

		$NextPageGroup = $this->PageGroup + 1;
		$PrevPageGroup = $this->PageGroup - 1;
		if($PrevPageGroup==0) {
			$PrevPageGroup=1;
		}

//set right image url 
		if($Result1['numpages']>$this->PageNumberLinks) {
			if(!is_null($UserDefinedMaxRecordPerPage)) {
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $UserDefinedMaxRecordPerPage);
			} else {
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $this->MaxRecordsPerPage);
			}

			if($this->NoOfPageGroup >= $NextPageGroup) {
				$TotalPageLinks = count($Result1['pages']);
				$LastPageStartRow = $Result1['pages'][$TotalPageLinks];
				if(isset($ExtraParameter)) {
					$ListRegionAndCountry = "&ListRegion=".$ExtraParameter['Region_str_code']."&ListCountry=".$ExtraParameter['Country_str_code'];
				}
				$RightImage="&nbsp;<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$NextPageGroup."&PageNo=".$PageNo.$ListRegionAndCountry."' title='".PAGING_COMMON_NEXT_COMMENT."'><img  id='imgleft11' src='".$NewImage."' align='middle' border='0' /></a>&nbsp;";
				//$RightsideImage="&nbsp;<a href='".$PathToBePass."startRow=".$LastPageStartRow."&PageGroup=".$this->NoOfPageGroup."' title='Click here to View Last Page Record'><img  id='imgleft1' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft11' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";					
			} else {
				$RightImage="<img  id='imgleft11' src='".$NewImage."' align='middle' border='0' />";
				//$RightsideImage="&nbsp;<img  id='imgleft4' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft5' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' >&nbsp;";					
			}
		} else{
			$CountOfStop = $Result1['numpages'];
		}//if -else end
		
		//set leftimage url 
		if($this->PageGroup>1) {
			if(!is_null($UserDefinedMaxRecordPerPage)) {
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $UserDefinedMaxRecordPerPage;
			} else {
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $this->MaxRecordsPerPage;
			}

			if(isset($ExtraParameter)) {
				$ListRegionAndCountry = "&ListRegion=".$ExtraParameter['Region_str_code']."&ListCountry=".$ExtraParameter['Country_str_code'];
			}
		//	$LeftImage="<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$PrevPageGroup.$ListRegionAndCountry."' title='Click here to View Previous Set of Page'><img  id='imgleft11' src='".DIR_WS_IMAGES."member/right-arrow-black.gif' align='absmiddle' border='0' ></a>&nbsp;";
			//$LeftSideImage="&nbsp;<a href='".$PathToBePass."startRow=0&PageGroup=1' title='Click here to View First Page Record'><img id='imgleft12' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft13' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";
			
		} else {
			//$LeftImage="<img  id='imgleft11' src='".DIR_WS_IMAGES."member/right-arrow-black.gif' align='absmiddle' border='0' >";
			//$LeftSideImage="<img id='imgleft16' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft17' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' >&nbsp;";
		} //if -else end

			$CountOfStop = $this->PageNumberLinks * $this->PageGroup   ;
			$CountOfStart = $CountOfStop - $this->PageNumberLinks + 1;
 		   // $LoopOfPageNum = $LeftSideImage;
 		   $LoopOfPageNum = $LeftImage;	
 		  
	   	for($i=$CountOfStart;$i<=$CountOfStop;$i++)
		{	
			if($this->StartRow==$Result1['pages'][$i]) {
				//$ExtraLink = "<a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."' >";
				$ExtraLink = "";
				$LoopOfPageNum.="".$ExtraLink."<span >"."</span>&nbsp;";
			} else {
				$ExtraLink = "<a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."&PageNo=".$i."'>";
				$LoopOfPageNum.="".$ExtraLink."<span >"."</span></a>&nbsp;";
			}

			if($i>=$Result1['numpages']) {
				break;
			}
		}// for loop end

		$LoopOfPageNum.=$RightImage;
		$key = array_search($Start, $Result1['pages']);
		$LastPage=$Result1['lastpage'];
		$ReturnString = "&nbsp;".$LoopOfPageNum;
		$ImageArray[0]="[ Page ".$key ." of ".$LastPage."]";
		if($Image!=PAGING_COMMON_NEXT && $Images2!=PAGING_COMMON_PREVIOUS ) {
			$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr height=\"24\"  valign=\"middle\">
		<td valign=\"middle\">".$ReturnString."</td></tr></table>";
			$ImageArray[1]=$ReturnString;
		return $ImageArray;
		}
//		$ReturnString.="<span class=pagingtable><input maxLength=7 size=4  name=PageNo  ></span><INPUT id=submit style=BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px onclick='' type='submit' value=Go   name=Submit  >";
		
		$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr height=\"24\"  valign=\"middle\">
		<td valign=\"middle\">&laquo;".$ReturnString."&raquo;</td></tr></table>";
		$ImageArray[1]=$ReturnString;
		return $ImageArray;
	}//GetPaggingTable() function end 
	//////////////////////////////////////
	
	public function GetPrevImage($NoOfRecordsForPaging,$NotToPass=null,$UserDefinedMaxRecordPerPage=null,$ExtraParameter=null,$ImagePath=ImageAdminPath)
	{ 	
		$RightImage='';
		$NewImage=$ImagePath."/images/member/left-arrow-black.gif";
		$LeftImage="<img  id='imgleft11' src='".$NewImage."' align='middle' border='0' />";
		if(!$this->PageGroup){	$this->PageGroup = 1;	}
			$PathToBePass = SITE_URL_FOR_PAGGING.$_SERVER['PHP_SELF'];
			
			//checking first offset value
	 	if(isset($_GET['startRow'])) {
			$Start=$_GET['startRow'];
		} else {
			$Start=0;
		}
		if(!empty($Start))
		{
			$err['Start'] = isNumeric(valid_input($Start),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['Start']))
		{
			logOut();
		}
//checking first offset value
		if(isset($_GET['PageGroup'])) {
			$PageGroup=$_GET['PageGroup'];
		} else {
			$PageGroup=1;
		}
		if(!empty($PageGroup))
		{
			$err['PageGroup'] = isNumeric(valid_input($PageGroup),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['PageGroup']))
		{
			logOut();
		}
		if(isset($_GET['PageNo'])) {
			$PageNo=$_GET['PageNo'];
		} else {
			$PageNo=1;
		}
		if(!empty($PageNo))
		{
			$err['PageNo'] = isNumeric(valid_input($PageNo),ENTER_NUMERIC_VALUES_ONLY);
		}
		if(!empty($err['PageNo']))
		{
			logOut();
		}
//set value of startgroup and pagegroup
		$this->StartRow = $Start;
		$this->PageGroup = $PageGroup;
		
//checking any extra path in url
		if(is_null($NotToPass))	{
			$NotToPass = array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo);
		} else {
			$NotToPass = array_merge(array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo),$NotToPass);
		}

		if(isset($ExtraParameter)) {
			if(!is_null($ExtraParameter)) {
			$NotToPass = array_merge(array("ListRegion"=>$ExtraParameter['Region_str_code'],"ListCountry"=>$ExtraParameter['Country_str_code']),$NotToPass);
			}
		}
		$WhereExtra = Preferences::GetAddressBarQueryString($NotToPass);//this function return path (including startrow & pagegroup)
		//querystring path in $whereExtra variable
		if($WhereExtra) {
			$PathToBePass = "?".$WhereExtra;
		}//checking first offset value

		if(substr_count($PathToBePass,"?")!=0) {
			$PathToBePass = $PathToBePass."&";
		} else{
			$PathToBePass = $PathToBePass."?";
		}

		if(!is_null($UserDefinedMaxRecordPerPage)) {
			$Result1 = DB_pager::getData(0,$UserDefinedMaxRecordPerPage,$NoOfRecordsForPaging);	
		} else {
			$Result1 = DB_pager::getData(0,$this->MaxRecordsPerPage,$NoOfRecordsForPaging);
		}

		$TotalNumberOfPageGroup = $Result1['numpages'] / $this->PageNumberLinks;
		$this->NoOfPageGroup = ceil($TotalNumberOfPageGroup);

		if($this->PageGroup > $this->NoOfPageGroup || $this->PageGroup <= 0) {
			$this->PageGroup = 1;
		}

		$NextPageGroup = $this->PageGroup + 1;
		$PrevPageGroup = $this->PageGroup - 1;
		if($PrevPageGroup==0) {
			$PrevPageGroup=1;
		}

//set right image url 
		if($Result1['numpages']>$this->PageNumberLinks) {
			if(!is_null($UserDefinedMaxRecordPerPage)) {
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $UserDefinedMaxRecordPerPage);
			} else {
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $this->MaxRecordsPerPage);
			}

			if($this->NoOfPageGroup >= $NextPageGroup) {
				$TotalPageLinks = count($Result1['pages']);
				$LastPageStartRow = $Result1['pages'][$TotalPageLinks];
				if(isset($ExtraParameter)) {
					$ListRegionAndCountry = "&ListRegion=".$ExtraParameter['Region_str_code']."&ListCountry=".$ExtraParameter['Country_str_code'];
				}
				//$RightImage="&nbsp;<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$NextPageGroup."&PageNo=".$PageNo.$ListRegionAndCountry."' title='Click here to View Next Set of Page'><img  id='imgleft11' src='".DIR_WS_IMAGES."member/left-arrow-black.gif' align='absmiddle' border='0' ></a>&nbsp;";
				//$RightsideImage="&nbsp;<a href='".$PathToBePass."startRow=".$LastPageStartRow."&PageGroup=".$this->NoOfPageGroup."' title='Click here to View Last Page Record'><img  id='imgleft1' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft11' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";					
			} else {
				//$RightImage="<img  id='imgleft11' src='".DIR_WS_IMAGES."member/left-arrow-black.gif' align='absmiddle' border='0' >";
				//$RightsideImage="&nbsp;<img  id='imgleft4' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft5' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' >&nbsp;";					
					
			}
		} else {
			$CountOfStop = $Result1['numpages'];
		}//if -else end

		//set leftimage url 
		if($this->PageGroup>1) {
			if(!is_null($UserDefinedMaxRecordPerPage)) {
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $UserDefinedMaxRecordPerPage;
			} else {
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $this->MaxRecordsPerPage;
			}

			if(isset($ExtraParameter)) {
				$ListRegionAndCountry = "&ListRegion=".$ExtraParameter['Region_str_code']."&ListCountry=".$ExtraParameter['Country_str_code'];
			}
			$LeftImage="<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$PrevPageGroup.$ListRegionAndCountry."' title='".PAGING_COMMON_PREVIOUS_COMMENT."'><img  id='imgleft11' src='".$NewImage."' align='middle' border='0' /></a>&nbsp;";
			//$LeftSideImage="&nbsp;<a href='".$PathToBePass."startRow=0&PageGroup=1' title='Click here to View First Page Record'><img id='imgleft12' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft13' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";
			
		} else {
			$LeftImage="<img  id='imgleft11' src='".$NewImage."' align='middle' border='0' />";

			//$LeftSideImage="<img id='imgleft16' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft17' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' >&nbsp;";
		} //if -else end

		$CountOfStop = $this->PageNumberLinks * $this->PageGroup   ;
		$CountOfStart = $CountOfStop - $this->PageNumberLinks + 1;
		// $LoopOfPageNum = $LeftSideImage;
		$LoopOfPageNum = $LeftImage;	

	   	for($i=$CountOfStart;$i<=$CountOfStop;$i++)
		{	
			if($this->StartRow==$Result1['pages'][$i]) {
				//$ExtraLink = "<a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."' >";
				$ExtraLink = "";
				$LoopOfPageNum.=" ".$ExtraLink."<span >"."</span>&nbsp;";
			} else {
				$ExtraLink = "<a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."&PageNo=".$i."'>";
				$LoopOfPageNum.="".$ExtraLink."<span >"."</span></a>&nbsp;";
			}

			if($i>=$Result1['numpages']) {
				break;
			}
		}// for loop end

		$LoopOfPageNum.=$RightImage;
		$ReturnString = "&nbsp;".$LoopOfPageNum;
		if($Image!=PAGING_COMMON_NEXT && $Images2!=PAGING_COMMON_PREVIOUS) {
			$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr height=\"24\"  valign=\"middle\">
		<td valign=\"middle\">".$ReturnString."</td></tr></table>";
		return $ReturnString;
		}
//		$ReturnString.="<span class=pagingtable><input maxLength=7 size=4  name=PageNo  ></span><INPUT id=submit style=BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px onclick='' type='submit' value=Go   name=Submit  >";
		
		$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr height=\"24\"  valign=\"middle\">
		<td valign=\"middle\">&laquo;".$ReturnString."&raquo;</td></tr></table>";
		return $ReturnString;
	}//GetPaggingTable() function end 

/**
 * set No of record display in per page .
 * set No of page set in per page. 
 *
 * @param unknown_type $SelectedPage
 * @param unknown_type $SelectedRecord
 */
public function GetResulPerPage($SelectedRecord=null,$PageGroup,$LastPage)
{
	$NewSetPage='';
	$NewSetRecord='';
	$SetRecord=array('10','20','30','40','50');
	for ($i = 0; $i < 5; $i++)
    {
		if(!is_null($SelectedRecord)) {
			if ($SetRecord[$i] == $SelectedRecord)
				$NewSetRecord.='<option value="'.$SetRecord[$i].'" selected>'.$SetRecord[$i].'</option>';
			else
				$NewSetRecord.='<option value="'.$SetRecord[$i].'">'.$SetRecord[$i].'</option>';	
		} else
			$NewSetRecord.='<option value="'.$SetRecord[$i].'">'.$SetRecord[$i].'</option>';
    }
    $PathToBePass = SITE_URL_FOR_PAGGING.$_SERVER['PHP_SELF'];
//checking any extra path in url
	$NotToPass = array("RecordRow"=>$RecordRow,"startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo);
	$WhereExtra = Preferences::GetAddressBarQueryString($NotToPass);//this function return path (including startrow & pagegroup)
	//querystring path in $whereExtra variable
	if($WhereExtra) {
		$PathToBePass = "?".$WhereExtra;
	}//checking first offset value

	if(substr_count($PathToBePass,"?")!=0) {
		$PathToBePass = $PathToBePass."&";
	} else {
		$PathToBePass = $PathToBePass."?";
	}

	if(isset($_GET['PageNo']) && $_GET['PageNo']!='') {
		$PageNo=$_GET['PageNo'];
	} else  {
		$PageNo=1;
	}
	if(!empty($PageNo))
	{
		$err['PageNo'] = isNumeric(valid_input($PageNo),ENTER_NUMERIC_VALUES_ONLY);
	}
	if(!empty($err['PageNo']))
	{
		logOut();
	}

	//$PathToBePass=urlencode($PathToBePass);
?>
<form name='frmnoofrecord' action='' method='GET'>
	<table border='0' cellpadding='1' cellspacing='1' width='100%'>
		<tr>
			<td valign="top">
Results per page : <select name='RecordRow' onchange='test1(this.options[this.options.selectedIndex].value,"<?php echo $PathToBePass;?>","<?php echo $PageGroup ?>","<?php echo $LastPage?>","<?php echo $PageNo;?>");' style='width:75px;'><?php echo $NewSetRecord?></select>
			</td>
		</tr>
	</table>
</form>
<?php }
/***  ************** End *******************************************/
}
?>