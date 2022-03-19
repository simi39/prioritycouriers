<?php

require_once("Pager.php");

class DbPager extends DB_pager
{

	/**
	*
	*/
	private $NoOfPageGroup;

	/**
	*
	*/
	private $PageGroup;
	private  $RightsideImage;
	
	/**
	*
	*/
	private $StartRow;
	
	/**
	*
	*/
	private $PageNumberLinks=10;

	
	/**
	*
	*/
	
	private $MaxRecordsPerPage;
	
	/**
	*
	*/
	//public $RightImage = null;
	
	/**
	*
	*/
	public function DbPager()
	{
		
		//$test = new DbPager();
		//$test->GetPaggingTable();
		
	}

	
	/**
	*
	*/
	public function GetNoOfPageGroup()
	{
		return $this->NoOfPageGroup;
	}

	/**
	*
	*/
	public function SetNoOfPageGroup($NoOfPageGroup)
	{
		
		$this->NoOfPageGroup = $NoOfPageGroup;
	}
	
	/**
	*
	*/
	public function GetPageGroup()
	{
		return $this->NoPageGroup;
	}

	/**
	*
	*/
	public function SetPageGroup($PageGroup)
	{
		$this->PageGroup = $PageGroup;
	}
	
	/**
	*
	*/
	public function GetStartRow()
	{
		return $this->StartRow;
	}

	/**
	*
	*/
	public function SetStartRow($StartRow)
	{
		$this->StartRow = $StartRow;
	}
	
	/**
	*
	*/
	
	
	public function GetPageNumberLinks()
	{
		return $this->PageNumberLinks;
	}

	/**
	*
	*/
	public function SetPageNumberLinks($PageNumberLinks)
	{
		if(!is_null($PageNumberLinks) && !empty($PageNumberLinks)) {
			$this->PageNumberLinks = $PageNumberLinks;
		}	
		else {
			$this->PageNumberLinks = PAGE_NUMBER_LINKS;
		}
	}
	
	/**
	*
	*/
	public function GetMaxRecordsPerPage()
	{
		return $this->MaxRecordsPerPage;
	}

	/**
	* 
	*/
	public function SetMaxRecordsPerPage($MaxRecordsPerPage)
	{
		if(!is_null($MaxRecordsPerPage) && !empty($MaxRecordsPerPage)) {
			$this->MaxRecordsPerPage = $MaxRecordsPerPage;
		}	
		else {
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
		}
		else { 
			$Result1 = DB_pager::getData(0,$this->MaxRecordsPerPage,$NoOfRecordsForPaging);
		}
		return $Result1;
	}
	/**
	*
	*/
	public function GetPaggingTable($NoOfRecordsForPaging,$NotToPass=null,$UserDefinedMaxRecordPerPage=null,$ExtraParameter=null)
	{ 		
		
		$RightImage="&nbsp;<img id='imgleft3' src='".SITE_ADMIN_URL . "images/rightarrow.gif' align='absmiddle' border='0' >&nbsp;";
		 $RightsideImage="&nbsp;<img  id='imgleft99' src='". SITE_ADMIN_URL . "images/rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft' src='". SITE_ADMIN_URL . "images/rightsidearrow.gif' align='absmiddle' border='0' >&nbsp;";					
		//		
		 if(!$this->PageGroup){	
		 	$this->PageGroup = 1;
		}
		$PathToBePass = SITE_URL_FOR_PAGGING.$_SERVER['PHP_SELF'];
		
		//checking first offset value
	 	if(isset($_GET['startRow'])) {
			$Start=$_GET['startRow'];
		}
		else {
			$Start=0;
		}
		//checking first offset value
		if(isset($_GET['PageGroup'])) {
			$PageGroup=$_GET['PageGroup'];
		}
		else {
			$PageGroup=1;
		}
		if(isset($_GET['PageNo'])) {
			$PageNo=$_GET['PageNo'];
		}
		else {
			$PageNo=1;
		}
				
		//set value of startgroup and pagegroup
		$this->StartRow = $Start;
		$this->PageGroup = $PageGroup;
		
		//checking any extra path in url
		if(is_null($NotToPass))	{
			$NotToPass = array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo);
		}
		else {
			$NotToPass = array_merge(array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo),$NotToPass);
		}
		
		/*if(is_null($ExtraParameter))
		{
			$ExtraParameter = array("ListRegion"=>$ExtraParameter['Region_str_code'],"ListCountry"=>$ExtraParameter['Country_str_code']);
		}
		else {
			$ExtraParameter = array_merge(array("ListRegion"=>$Start,"ListCountry"=>$PageGroup),$ExtraParameter);
		}*/
		
		
		$WhereExtra = Preferences::GetAddressBarQueryString($NotToPass);//this function return path (including startrow & pagegroup)
		
		//querystring path in $whereExtra variable
		if($WhereExtra) {
			$PathToBePass = "?".$WhereExtra;
		}//checking first offset value
		
		if($ExtraParameter)
		{
			$PathToBePass.="?".$ExtraParameter;
		}
		//
		if(substr_count($PathToBePass,"?")!=0) {
			$PathToBePass = $PathToBePass."&";
		}
		else {
			$PathToBePass = $PathToBePass."?";
		}	
		if(!is_null($UserDefinedMaxRecordPerPage)) {
			$Result1 = DB_pager::getData(0,$UserDefinedMaxRecordPerPage,$NoOfRecordsForPaging);	
		}
		else {
			$Result1 = DB_pager::getData(0,$this->MaxRecordsPerPage,$NoOfRecordsForPaging);
		}
		
		$TotalNumberOfPageGroup = $Result1['numpages'] / $this->PageNumberLinks;
		$this->NoOfPageGroup = ceil($TotalNumberOfPageGroup);
		
		//				
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
			}
			else {
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $this->MaxRecordsPerPage);
			}
		 	//
			if($this->NoOfPageGroup >= $NextPageGroup) {
				$TotalPageLinks = count($Result1['pages']);
				$LastPageStartRow = $Result1['pages'][$TotalPageLinks];
				$KeyRight = array_search($StartRowOfGroup, $Result1['pages']);
				$KeyRightSide = array_search($LastPageStartRow, $Result1['pages']);
				
				$RightImage="&nbsp;<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$NextPageGroup."PageNo=".$KeyRight."' title='Click here to View Next Set of Page'><img  id='imgleft' src='". SITE_ADMIN_URL . "images/rightarrow.gif' align='absmiddle' border='0' ></a>&nbsp;";
				
				$RightsideImage="&nbsp;<a href='".$PathToBePass."startRow=".$LastPageStartRow."&PageGroup=".$this->NoOfPageGroup."PageNo=".$KeyRightSide."' title='Click here to View Last Page Record'><img  id='imgleft1' src='". SITE_ADMIN_URL . "images/rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft11' src='". SITE_ADMIN_URL . "images/rightsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";					
				
			}
			else {
				$RightImage="&nbsp;<img id='imgleft3' src='". SITE_ADMIN_URL . "images/rightarrow.gif' align='absmiddle' border='0' >&nbsp;";
				$RightsideImage="&nbsp;<img  id='imgleft4' src='". SITE_ADMIN_URL . "images/rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft5' src='".SITE_URL."images/rightsidearrow.gif' align='absmiddle' border='0' >&nbsp;";		
										
			}
		} 
		else {
			$CountOfStop = $Result1['numpages'];
		}//if -else end
		
		//set leftimage url 
		if($this->PageGroup>1) {
			if(!is_null($UserDefinedMaxRecordPerPage)) {
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $UserDefinedMaxRecordPerPage;
			}
			else {
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $this->MaxRecordsPerPage;
			}
			$KeyLeft = array_search($StartRowOfGroup, $Result1['pages']);
			
			$LeftImage="&nbsp;<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$PrevPageGroup."PageNo=".$KeyLeft."' title='Click here to View Previous Set of Page'><img id='imgleft11' src='". SITE_ADMIN_URL . "images/leftarrow.gif' align='absmiddle' border='0' ></a>&nbsp;";
			$LeftSideImage="&nbsp;<a href='".$PathToBePass."startRow=0&PageGroup=1&PageNo=1' title='Click here to View First Page Record'><img id='imgleft12' src='". SITE_ADMIN_URL . "images/leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft13' src='". SITE_ADMIN_URL . "images/leftsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";
			
		}
		else {
			$LeftImage="<img id='imgleft15' src='". SITE_ADMIN_URL . "images/leftarrow.gif' align='absmiddle' border='0' >&nbsp;";
			$LeftSideImage="<img id='imgleft16' src='". SITE_ADMIN_URL . "images/leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft17' src='". SITE_ADMIN_URL . "images/leftsidearrow.gif' align='absmiddle' border='0' >&nbsp;";
		} //if -else end
		
		
			$CountOfStop = $this->PageNumberLinks * $this->PageGroup   ;
			$CountOfStart = $CountOfStop - $this->PageNumberLinks + 1;
 		    $LoopOfPageNum = $LeftSideImage;
 		    $LoopOfPageNum = $LoopOfPageNum."&nbsp;".$LeftImage." ";	
 		  
	   for($i=$CountOfStart;$i<=$CountOfStop;$i++) {	
			if($this->StartRow==$Result1['pages'][$i]) {
				//$ExtraLink = "<a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."' >";
				$ExtraLink = "";
				$LoopOfPageNum.="".$ExtraLink."<span class='paging-selected' style=\"font-size:10;\"> ".$i." </span>&nbsp;";
			}
			else {
			
				$ExtraLink = "<span class='paging'><a class='paging' href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."&PageNo=".$i."'>";
				$LoopOfPageNum.="".$ExtraLink."<img src='". SITE_ADMIN_URL . "images/specer.gif' width='5' height='10' border=0 /><img src='". SITE_ADMIN_URL . "images/line.gif' width='1' height='10' border=0 /><img src='". SITE_ADMIN_URL . "images/specer.gif' width='5' height='10' border=0 /> ".$i." <img src='". SITE_ADMIN_URL . "images/specer.gif' width='5' height='10' border=0 /><img src='". SITE_ADMIN_URL . "images/line.gif' width='1' height='10' border=0 /><img src='". SITE_ADMIN_URL . "images/specer.gif' width='5' height='10' border=0 /></a></span>";
			}
			if($i>=$Result1['numpages']) {
				break;
			}
		}// for loop end
		
		$key = array_search($Start, $Result1['pages']);
		$LastPage=$Result1['lastpage'];
		$LoopOfPageNum.=$RightImage;
		$LoopOfPageNum.="".$RightsideImage;
		$ReturnString = "&nbsp;".$LoopOfPageNum;
		$ReturnString.="";

		$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"border:none\">
								<tr height=\"24\" valign=\"middle\" >
								
										<td align=\"center\" >[ Page $key of $LastPage ] &nbsp;</td>
										<td align=\"center\">".$ReturnString."</td>
										<td class=pagingtable align=\"right\"  > Page Number&nbsp;:
													<input type=\"text\" maxLength=7 size=4  name=PageNo  >
											</td>
									    <td align=\"right\">	
									   		 
									       <INPUT id=submit type='submit' value=Go   name=Submit  >
								
											<input type=\"hidden\"  name=\"PageGroup\" >
											<input type=\"hidden\"  name=\"startRow\">
											
									  </td>  
								</tr>
						</table>";  

		$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"border:none\">
								<tr height=\"24\" valign=\"middle\" ><td align=\"right\">".$ReturnString."</td></tr>
						</table>";  

		?>
		
		<?
		return $ReturnString;
	}//GetPaggingTable() function end 
	
	/* ************************************************* end of function ************************************ */
	
	
	
	
	
	
	///
	public function GetPrevNextPage($NoOfRecordsForPaging,$NotToPass=null,$UserDefinedMaxRecordPerPage=null,$ExtraParameter=null,$Image='Next',$Images2='Previous')
	{ 	
		$RightImage="&nbsp;$Image&nbsp;";
		$LeftImage=	"&nbsp;$Images2&nbsp;";		
		 if(!$this->PageGroup){	$this->PageGroup = 1;	}
			$PathToBePass = SITE_URL_FOR_PAGGING.$_SERVER['PHP_SELF'];
			
			//checking first offset value
	 	if(isset($_GET['startRow'])) {
			$Start=$_GET['startRow'];
		}
		else {
			$Start=0;
		}
		//checking first offset value
		if(isset($_GET['PageGroup'])) {
			$PageGroup=$_GET['PageGroup'];
		}
		else {
			$PageGroup=1;
		}
		if(isset($_GET['PageNo'])) {
			$PageNo=$_GET['PageNo'];
		}
		else {
			$PageNo=1;
		}
		
		//set value of startgroup and pagegroup
		$this->StartRow = $Start;
		$this->PageGroup = $PageGroup;
		
		//checking any extra path in url
		if(is_null($NotToPass))	{
			$NotToPass = array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo);
		}
		else {
			$NotToPass = array_merge(array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo),$NotToPass);
		}
		if(isset($ExtraParameter)){
			if(!is_null($ExtraParameter)) {
			$NotToPass = array_merge(array("ListRegion"=>$ExtraParameter['Region_str_code'],"ListCountry"=>$ExtraParameter['Country_str_code']),$NotToPass);
			}
		}
		$WhereExtra = Preferences::GetAddressBarQueryString($NotToPass);//this function return path (including startrow & pagegroup)
		//querystring path in $whereExtra variable
		if($WhereExtra)
		{
			$PathToBePass = "?".$WhereExtra;
		}//checking first offset value
		
		//
		if(substr_count($PathToBePass,"?")!=0){
			$PathToBePass = $PathToBePass."&";
		}
		else{
			$PathToBePass = $PathToBePass."?";
		}
		
		//
		if(!is_null($UserDefinedMaxRecordPerPage)){

			$Result1 = DB_pager::getData(0,$UserDefinedMaxRecordPerPage,$NoOfRecordsForPaging);	
			
		}
		else{
			$Result1 = DB_pager::getData(0,$this->MaxRecordsPerPage,$NoOfRecordsForPaging);
		}
		
		$TotalNumberOfPageGroup = $Result1['numpages'] / $this->PageNumberLinks;
		$this->NoOfPageGroup = ceil($TotalNumberOfPageGroup);
		
		//				
		if($this->PageGroup > $this->NoOfPageGroup || $this->PageGroup <= 0){
			$this->PageGroup = 1;
		}
		
		$NextPageGroup = $this->PageGroup + 1;
		$PrevPageGroup = $this->PageGroup - 1;
		if($PrevPageGroup==0){
			$PrevPageGroup=1;
		}
		
		//set right image url 
		if($Result1['numpages']>$this->PageNumberLinks)
		{
			if(!is_null($UserDefinedMaxRecordPerPage))
			{
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $UserDefinedMaxRecordPerPage);
			}
			else
			{
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $this->MaxRecordsPerPage);
			}
		 	//
			if($this->NoOfPageGroup >= $NextPageGroup){
				$TotalPageLinks = count($Result1['pages']);
				$LastPageStartRow = $Result1['pages'][$TotalPageLinks];
				if(isset($ExtraParameter)) {
					$ListRegionAndCountry = "&ListRegion=".$ExtraParameter['Region_str_code']."&ListCountry=".$ExtraParameter['Country_str_code'];
				}
				$RightImage="&nbsp;<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$NextPageGroup."&PageNo=".$PageNo.$ListRegionAndCountry."' title='Click here to View Next Set of Page'>$Image</a>&nbsp;";
				$RightsideImage="&nbsp;<a href='".$PathToBePass."startRow=".$LastPageStartRow."&PageGroup=".$this->NoOfPageGroup."' title='Click here to View Last Page Record'><img  id='imgleft1' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft11' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";					
			}
			else{
				$RightImage=$Image;
				//$RightsideImage="&nbsp;<img  id='imgleft4' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft5' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' >&nbsp;";					
					
			}
		} 
		else{
			$CountOfStop = $Result1['numpages'];
		}//if -else end
		
		//set leftimage url 
		if($this->PageGroup>1)
		{
			
			if(!is_null($UserDefinedMaxRecordPerPage)){
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $UserDefinedMaxRecordPerPage;
			}
			else{
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $this->MaxRecordsPerPage;
			}
			if(isset($ExtraParameter)) {
				$ListRegionAndCountry = "&ListRegion=".$ExtraParameter['Region_str_code']."&ListCountry=".$ExtraParameter['Country_str_code'];
			}
			$LeftImage="<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$PrevPageGroup.$ListRegionAndCountry."' title='Click here to View Previous Set of Page'>$Images2</a>&nbsp;";
			$LeftSideImage="&nbsp;<a href='".$PathToBePass."startRow=0&PageGroup=1' title='Click here to View First Page Record'><img id='imgleft12' src='". SITE_ADMIN_URL . "images/leftarrow.gif' align='absmiddle' border='0' ><img id='imgleft13' src='". SITE_ADMIN_URL . "images/leftarrow.gif' align='absmiddle' border='0' ></a>&nbsp;";
			
		}
		else{
			$LeftImage=$Images2;
			//$LeftSideImage="<img id='imgleft16' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft17' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' >&nbsp;";
		} //if -else end
		
		
			$CountOfStop = $this->PageNumberLinks * $this->PageGroup   ;
			$CountOfStart = $CountOfStop - $this->PageNumberLinks + 1;
 		   // $LoopOfPageNum = $LeftSideImage;
 		    $LoopOfPageNum = $LeftImage;	
 		  
	   for($i=$CountOfStart;$i<=$CountOfStop;$i++)
		{	
			
			if($this->StartRow==$Result1['pages'][$i]){
				//$ExtraLink = "<a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."' >";
				$ExtraLink = "";
				$LoopOfPageNum.="".$ExtraLink."<span >"."</span>&nbsp;";
				
			}
			else{
				$ExtraLink = "<a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."&PageNo=".$i."'>";
				$LoopOfPageNum.="".$ExtraLink."<span >"."</span></a>&nbsp;";
				
			}
			if($i>=$Result1['numpages']){
				break;
			}
		}// for loop end
		
		$LoopOfPageNum.=$RightImage;
		$ReturnString = "&nbsp;".$LoopOfPageNum;
		if($Image!='Next'&& $Images2!='Previous')
		{
			$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr height=\"24\"  valign=\"middle\">
		<td valign=\"middle\">".$ReturnString."</td></tr></table>";
		return $ReturnString;
		}
//		$ReturnString.="<span class=pagingtable><input maxLength=7 size=4  name=PageNo  ></span><INPUT id=submit style=BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px onclick='' type='submit' value=Go   name=Submit  >";
		
		$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr height=\"24\"  valign=\"middle\">
		<td valign=\"middle\">&laquo;".$ReturnString."&raquo;</td></tr></table>";
		return $ReturnString;
	}//GetPaggingTable() function end 

	/*****************************************Admin Paging**************************************/
	public function GetPaggingTableAdmin($NoOfRecordsForPaging,$NotToPass=null,$UserDefinedMaxRecordPerPage=null,$ExtraParameter=null)
	{ 		
		
		$RightImage="&nbsp;<img id='imgleft3' src='".SITE_URL."images/rightarrowA.gif' align='absmiddle' border='0' >&nbsp;";
		 $RightsideImage="&nbsp;<img  id='imgleft99' src='".SITE_URL."images/rightsidearrowA.gif' align='absmiddle' border='0' ><img  id='imgleft' src='".SITE_URL."images/rightsidearrowA.gif' align='absmiddle' border='0' >&nbsp;";					
		//		
		 if(!$this->PageGroup){	
		 	$this->PageGroup = 1;
		}
		$PathToBePass = SITE_URL_FOR_PAGGING.$_SERVER['PHP_SELF'];
		
		//checking first offset value
	 	if(isset($_GET['startRow'])) {
			$Start=$_GET['startRow'];
		}
		else {
			$Start=0;
		}
		//checking first offset value
		if(isset($_GET['PageGroup'])) {
			$PageGroup=$_GET['PageGroup'];
		}
		else {
			$PageGroup=1;
		}
		if(isset($_GET['PageNo'])) {
			$PageNo=$_GET['PageNo'];
		}
		else {
			$PageNo=1;
		}
				
		//set value of startgroup and pagegroup
		$this->StartRow = $Start;
		$this->PageGroup = $PageGroup;
		
		//checking any extra path in url
		if(is_null($NotToPass))	{
			$NotToPass = array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo);
		}
		else {
			$NotToPass = array_merge(array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo),$NotToPass);
		}
		
		$WhereExtra = Preferences::GetAddressBarQueryString($NotToPass);//this function return path (including startrow & pagegroup)
		
		//querystring path in $whereExtra variable
		if($WhereExtra) {
			$PathToBePass = "?".$WhereExtra;
		}//checking first offset value
		
		if($ExtraParameter)
		{
			$PathToBePass.="?".$ExtraParameter;
		}
		//
		if(substr_count($PathToBePass,"?")!=0) {
			$PathToBePass = $PathToBePass."&";
		}
		else {
			$PathToBePass = $PathToBePass."?";
		}	
		if(!is_null($UserDefinedMaxRecordPerPage)) {
			$Result1 = DB_pager::getData(0,$UserDefinedMaxRecordPerPage,$NoOfRecordsForPaging);	
		}
		else {
			$Result1 = DB_pager::getData(0,$this->MaxRecordsPerPage,$NoOfRecordsForPaging);
		}
		
		$TotalNumberOfPageGroup = $Result1['numpages'] / $this->PageNumberLinks;
		$this->NoOfPageGroup = ceil($TotalNumberOfPageGroup);
		
		//				
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
			}
			else {
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $this->MaxRecordsPerPage);
			}
		 	//
			if($this->NoOfPageGroup >= $NextPageGroup) {
				$TotalPageLinks = count($Result1['pages']);
				$LastPageStartRow = $Result1['pages'][$TotalPageLinks];
				$KeyRight = array_search($StartRowOfGroup, $Result1['pages']);
				$KeyRightSide = array_search($LastPageStartRow, $Result1['pages']);
				
				$RightImage="&nbsp;<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$NextPageGroup."&PageNo=".$KeyRight."' title='Click here to View Next Set of Page'><img  id='imgleft' src='".SITE_URL."images/rightarrowA.gif' align='absmiddle' border='0' ></a>&nbsp;";
				
				$RightsideImage="&nbsp;<a href='".$PathToBePass."startRow=".$LastPageStartRow."&PageGroup=".$this->NoOfPageGroup."&PageNo=".$KeyRightSide."' title='Click here to View Last Page Record'><img  id='imgleft1' src='".SITE_URL."images/rightsidearrowA.gif' align='absmiddle' border='0' ><img  id='imgleft11' src='".SITE_URL."images/rightsidearrowA.gif' align='absmiddle' border='0' ></a>&nbsp;";					
				
			}
			else {
				$RightImage="&nbsp;<img id='imgleft3' src='".SITE_URL."images/rightarrowA.gif' align='absmiddle' border='0' >&nbsp;";
				$RightsideImage="&nbsp;<img  id='imgleft4' src='".SITE_URL."images/rightsidearrowA.gif' align='absmiddle' border='0' ><img  id='imgleft5' src='".SITE_URL."images/rightsidearrowA.gif' align='absmiddle' border='0' >&nbsp;";		
										
			}
		} 
		else {
			$CountOfStop = $Result1['numpages'];
		}//if -else end
		
		//set leftimage url 
		if($this->PageGroup>1) {
			if(!is_null($UserDefinedMaxRecordPerPage)) {
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $UserDefinedMaxRecordPerPage;
			}
			else {
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $this->MaxRecordsPerPage;
			}
			$KeyLeft = array_search($StartRowOfGroup, $Result1['pages']);
			
			$LeftImage="&nbsp;<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$PrevPageGroup."&PageNo=".$KeyLeft."' title='Click here to View Previous Set of Page'><img id='imgleft11' src='".SITE_URL."images/leftarrowA.gif' align='absmiddle' border='0' ></a>&nbsp;";
			$LeftSideImage="&nbsp;<a href='".$PathToBePass."startRow=0&PageGroup=1&PageNo=1' title='Click here to View First Page Record'><img id='imgleft12' src='".SITE_URL."images/leftsidearrowA.gif' align='absmiddle' border='0' ><img id='imgleft13' src='".SITE_URL."images/leftsidearrowA.gif' align='absmiddle' border='0' ></a>&nbsp;";
			
		}
		else {
			$LeftImage="<img id='imgleft15' src='".SITE_URL."images/leftarrowA.gif' align='absmiddle' border='0' >&nbsp;";
			$LeftSideImage="<img id='imgleft16' src='".SITE_URL."images/leftsidearrowA.gif' align='absmiddle' border='0' ><img id='imgleft17' src='".SITE_URL."images/leftsidearrowA.gif' align='absmiddle' border='0' >&nbsp;";
		} //if -else end
		
		
			$CountOfStop = $this->PageNumberLinks * $this->PageGroup   ;
			$CountOfStart = $CountOfStop - $this->PageNumberLinks + 1;
 		    $LoopOfPageNum = $LeftSideImage;
 		    $LoopOfPageNum = $LoopOfPageNum."&nbsp;".$LeftImage." ";	
 		  
	   for($i=$CountOfStart;$i<=$CountOfStop;$i++) {	
			if($this->StartRow==$Result1['pages'][$i]) {
				
				$ExtraLink = "";
				$LoopOfPageNum.="".$ExtraLink."<span ><strong >".$i."</strong></span>&nbsp;";
			}
			else {
			
				$ExtraLink = "<a class=\"style5\" href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."&PageNo=".$i."'>";
				$LoopOfPageNum.="".$ExtraLink."<span >".$i."</span></a>&nbsp;";
			}
			if($i>=$Result1['numpages']) {
				break;
			}
		}// for loop end
		
		$key = array_search($Start, $Result1['pages']);
		$LastPage=$Result1['lastpage'];
		$LoopOfPageNum.=$RightImage;
		$LoopOfPageNum.="".$RightsideImage;
		$ReturnString = "&nbsp;".$LoopOfPageNum;
		$ReturnString.="";
		$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" style=\"border:none\">
								<tr height=\"24\" valign=\"middle\" >
								
										<td align=\"center\" >[ Page $key of $LastPage ] &nbsp;</td>
										<td align=\"center\"  class=\"style5\" >".$ReturnString."</td>
										<td  align=\"right\"  > Page Number&nbsp;:
													<input type=\"text\" maxLength=7 size=4  name=PageNo class='formstyle'>
											</td>
									    <td align=\"right\">	
									   		 
									       <INPUT id='submit' type='submit' value='Go'   name='Submit' class='formbox' >
								
											<input type=\"hidden\"  name=\"PageGroup\" >
											<input type=\"hidden\"  name=\"startRow\">
											
									  </td>  
								</tr>
						</table>";  
		?>
		
		<?
		return $ReturnString;
	}//GetPaggingTable() function end 
	
	
/******************* Trip report Image ******************************/
public function GetNextImage($NoOfRecordsForPaging,$NotToPass=null,$UserDefinedMaxRecordPerPage=null,$ExtraParameter=null)
	{ 	$LeftImage='';
		$RightImage="<img  id='imgleft11' src='".DIR_WS_IMAGES."member/right-arrow-black.gif' align='absmiddle' border='0' >";
		if(!$this->PageGroup){	$this->PageGroup = 1;	}
			$PathToBePass = SITE_URL_FOR_PAGGING.$_SERVER['PHP_SELF'];
			
			//checking first offset value
	 	if(isset($_GET['startRow'])) {
			$Start=$_GET['startRow'];
		}
		else {
			$Start=0;
		}
		//checking first offset value
		if(isset($_GET['PageGroup'])) {
			$PageGroup=$_GET['PageGroup'];
		}
		else {
			$PageGroup=1;
		}
		if(isset($_GET['PageNo'])) {
			$PageNo=$_GET['PageNo'];
		}
		else {
			$PageNo=1;
		}
		
		//set value of startgroup and pagegroup
		$this->StartRow = $Start;
		$this->PageGroup = $PageGroup;
		
		//checking any extra path in url
		if(is_null($NotToPass))	{
			$NotToPass = array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo);
		}
		else {
			$NotToPass = array_merge(array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo),$NotToPass);
		}
		if(isset($ExtraParameter)){
			if(!is_null($ExtraParameter)) {
			$NotToPass = array_merge(array("ListRegion"=>$ExtraParameter['Region_str_code'],"ListCountry"=>$ExtraParameter['Country_str_code']),$NotToPass);
			}
		}
		$WhereExtra = Preferences::GetAddressBarQueryString($NotToPass);//this function return path (including startrow & pagegroup)
		//querystring path in $whereExtra variable
		if($WhereExtra)
		{
			$PathToBePass = "?".$WhereExtra;
		}//checking first offset value
		
		//
		if(substr_count($PathToBePass,"?")!=0){
			$PathToBePass = $PathToBePass."&";
		}
		else{
			$PathToBePass = $PathToBePass."?";
		}
		
		//
		if(!is_null($UserDefinedMaxRecordPerPage)){

			$Result1 = DB_pager::getData(0,$UserDefinedMaxRecordPerPage,$NoOfRecordsForPaging);	
			
		}
		else{
			$Result1 = DB_pager::getData(0,$this->MaxRecordsPerPage,$NoOfRecordsForPaging);
		}
		
		$TotalNumberOfPageGroup = $Result1['numpages'] / $this->PageNumberLinks;
		$this->NoOfPageGroup = ceil($TotalNumberOfPageGroup);
		
		//				
		if($this->PageGroup > $this->NoOfPageGroup || $this->PageGroup <= 0){
			$this->PageGroup = 1;
		}
		
		$NextPageGroup = $this->PageGroup + 1;
		$PrevPageGroup = $this->PageGroup - 1;
		if($PrevPageGroup==0){
			$PrevPageGroup=1;
		}
		
		//set right image url 
		if($Result1['numpages']>$this->PageNumberLinks)
		{
			if(!is_null($UserDefinedMaxRecordPerPage))
			{
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $UserDefinedMaxRecordPerPage);
			}
			else
			{
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $this->MaxRecordsPerPage);
			}
		 	//
			if($this->NoOfPageGroup >= $NextPageGroup){
				$TotalPageLinks = count($Result1['pages']);
				$LastPageStartRow = $Result1['pages'][$TotalPageLinks];
				if(isset($ExtraParameter)) {
					$ListRegionAndCountry = "&ListRegion=".$ExtraParameter['Region_str_code']."&ListCountry=".$ExtraParameter['Country_str_code'];
				}
				$RightImage="&nbsp;<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$NextPageGroup."&PageNo=".$PageNo.$ListRegionAndCountry."' title='Click here to View Next Set of Page'><img  id='imgleft11' src='".DIR_WS_IMAGES."member/right-arrow-black.gif' align='absmiddle' border='0' ></a>&nbsp;";
				//$RightsideImage="&nbsp;<a href='".$PathToBePass."startRow=".$LastPageStartRow."&PageGroup=".$this->NoOfPageGroup."' title='Click here to View Last Page Record'><img  id='imgleft1' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft11' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";					
			}
			else{
				$RightImage="<img  id='imgleft11' src='".DIR_WS_IMAGES."member/right-arrow-black.gif' align='absmiddle' border='0' >";
				//$RightsideImage="&nbsp;<img  id='imgleft4' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft5' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' >&nbsp;";					
					
			}
		} 
		else{
			$CountOfStop = $Result1['numpages'];
		}//if -else end
		
		//set leftimage url 
		if($this->PageGroup>1)
		{
			
			if(!is_null($UserDefinedMaxRecordPerPage)){
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $UserDefinedMaxRecordPerPage;
			}
			else{
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $this->MaxRecordsPerPage;
			}
			if(isset($ExtraParameter)) {
				$ListRegionAndCountry = "&ListRegion=".$ExtraParameter['Region_str_code']."&ListCountry=".$ExtraParameter['Country_str_code'];
			}
		//	$LeftImage="<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$PrevPageGroup.$ListRegionAndCountry."' title='Click here to View Previous Set of Page'><img  id='imgleft11' src='".DIR_WS_IMAGES."member/right-arrow-black.gif' align='absmiddle' border='0' ></a>&nbsp;";
			//$LeftSideImage="&nbsp;<a href='".$PathToBePass."startRow=0&PageGroup=1' title='Click here to View First Page Record'><img id='imgleft12' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft13' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";
			
		}
		else{
			//$LeftImage="<img  id='imgleft11' src='".DIR_WS_IMAGES."member/right-arrow-black.gif' align='absmiddle' border='0' >";
			//$LeftSideImage="<img id='imgleft16' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft17' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' >&nbsp;";
		} //if -else end
		
		
			$CountOfStop = $this->PageNumberLinks * $this->PageGroup   ;
			$CountOfStart = $CountOfStop - $this->PageNumberLinks + 1;
 		   // $LoopOfPageNum = $LeftSideImage;
 		   $LoopOfPageNum = $LeftImage;	
 		  
	   for($i=$CountOfStart;$i<=$CountOfStop;$i++)
		{	
			
			if($this->StartRow==$Result1['pages'][$i]){
				//$ExtraLink = "<a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."' >";
				$ExtraLink = "";
				$LoopOfPageNum.="".$ExtraLink."<span >"."</span>&nbsp;";
				
			}
			else{
				$ExtraLink = "<a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."&PageNo=".$i."'>";
				$LoopOfPageNum.="".$ExtraLink."<span >"."</span></a>&nbsp;";
				
			}
			if($i>=$Result1['numpages']){
				break;
			}
		}// for loop end
		
		$LoopOfPageNum.=$RightImage;
		$ReturnString = "&nbsp;".$LoopOfPageNum;
		if($Image!='Next'&& $Images2!='Previous')
		{
			$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr height=\"24\"  valign=\"middle\">
		<td valign=\"middle\">".$ReturnString."</td></tr></table>";
		return $ReturnString;
		}
//		$ReturnString.="<span class=pagingtable><input maxLength=7 size=4  name=PageNo  ></span><INPUT id=submit style=BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px onclick='' type='submit' value=Go   name=Submit  >";
		
		$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr height=\"24\"  valign=\"middle\">
		<td valign=\"middle\">&laquo;".$ReturnString."&raquo;</td></tr></table>";
		return $ReturnString;
	}//GetPaggingTable() function end 
	//////////////////////////////////////
	
	public function GetPrevImage($NoOfRecordsForPaging,$NotToPass=null,$UserDefinedMaxRecordPerPage=null,$ExtraParameter=null)
	{ 	
		$RightImage='';
		$LeftImage="<img  id='imgleft11' src='".DIR_WS_IMAGES."member/left-arrow-black.gif' align='absmiddle' border='0' >";
		if(!$this->PageGroup){	$this->PageGroup = 1;	}
			$PathToBePass = SITE_URL_FOR_PAGGING.$_SERVER['PHP_SELF'];
			
			//checking first offset value
	 	if(isset($_GET['startRow'])) {
			$Start=$_GET['startRow'];
		}
		else {
			$Start=0;
		}
		//checking first offset value
		if(isset($_GET['PageGroup'])) {
			$PageGroup=$_GET['PageGroup'];
		}
		else {
			$PageGroup=1;
		}
		if(isset($_GET['PageNo'])) {
			$PageNo=$_GET['PageNo'];
		}
		else {
			$PageNo=1;
		}
		
		//set value of startgroup and pagegroup
		$this->StartRow = $Start;
		$this->PageGroup = $PageGroup;
		
		//checking any extra path in url
		if(is_null($NotToPass))	{
			$NotToPass = array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo);
		}
		else {
			$NotToPass = array_merge(array("startRow"=>$Start,"PageGroup"=>$PageGroup,"PageNo"=>$PageNo),$NotToPass);
		}
		if(isset($ExtraParameter)){
			if(!is_null($ExtraParameter)) {
			$NotToPass = array_merge(array("ListRegion"=>$ExtraParameter['Region_str_code'],"ListCountry"=>$ExtraParameter['Country_str_code']),$NotToPass);
			}
		}
		$WhereExtra = Preferences::GetAddressBarQueryString($NotToPass);//this function return path (including startrow & pagegroup)
		//querystring path in $whereExtra variable
		if($WhereExtra)
		{
			$PathToBePass = "?".$WhereExtra;
		}//checking first offset value
		
		//
		if(substr_count($PathToBePass,"?")!=0){
			$PathToBePass = $PathToBePass."&";
		}
		else{
			$PathToBePass = $PathToBePass."?";
		}
		
		//
		if(!is_null($UserDefinedMaxRecordPerPage)){

			$Result1 = DB_pager::getData(0,$UserDefinedMaxRecordPerPage,$NoOfRecordsForPaging);	
			
		}
		else{
			$Result1 = DB_pager::getData(0,$this->MaxRecordsPerPage,$NoOfRecordsForPaging);
		}
		
		$TotalNumberOfPageGroup = $Result1['numpages'] / $this->PageNumberLinks;
		$this->NoOfPageGroup = ceil($TotalNumberOfPageGroup);
		
		//				
		if($this->PageGroup > $this->NoOfPageGroup || $this->PageGroup <= 0){
			$this->PageGroup = 1;
		}
		
		$NextPageGroup = $this->PageGroup + 1;
		$PrevPageGroup = $this->PageGroup - 1;
		if($PrevPageGroup==0){
			$PrevPageGroup=1;
		}
		
		//set right image url 
		if($Result1['numpages']>$this->PageNumberLinks)
		{
			if(!is_null($UserDefinedMaxRecordPerPage))
			{
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $UserDefinedMaxRecordPerPage);
			}
			else
			{
				$StartRowOfGroup = ($this->PageNumberLinks * $this->PageGroup * $this->MaxRecordsPerPage);
			}
		 	//
			if($this->NoOfPageGroup >= $NextPageGroup){
				$TotalPageLinks = count($Result1['pages']);
				$LastPageStartRow = $Result1['pages'][$TotalPageLinks];
				if(isset($ExtraParameter)) {
					$ListRegionAndCountry = "&ListRegion=".$ExtraParameter['Region_str_code']."&ListCountry=".$ExtraParameter['Country_str_code'];
				}
				//$RightImage="&nbsp;<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$NextPageGroup."&PageNo=".$PageNo.$ListRegionAndCountry."' title='Click here to View Next Set of Page'><img  id='imgleft11' src='".DIR_WS_IMAGES."member/left-arrow-black.gif' align='absmiddle' border='0' ></a>&nbsp;";
				//$RightsideImage="&nbsp;<a href='".$PathToBePass."startRow=".$LastPageStartRow."&PageGroup=".$this->NoOfPageGroup."' title='Click here to View Last Page Record'><img  id='imgleft1' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft11' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";					
			}
			else{
				//$RightImage="<img  id='imgleft11' src='".DIR_WS_IMAGES."member/left-arrow-black.gif' align='absmiddle' border='0' >";
				//$RightsideImage="&nbsp;<img  id='imgleft4' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' ><img  id='imgleft5' src='".DIR_WS_IMAGES."rightsidearrow.gif' align='absmiddle' border='0' >&nbsp;";					
					
			}
		} 
		else{
			$CountOfStop = $Result1['numpages'];
		}//if -else end
		
		//set leftimage url 
		if($this->PageGroup>1)
		{
			
			if(!is_null($UserDefinedMaxRecordPerPage)){
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $UserDefinedMaxRecordPerPage;
			}
			else{
				$StartRowOfGroup = ($this->PageGroup - 2) * $this->PageNumberLinks * $this->MaxRecordsPerPage;
			}
			if(isset($ExtraParameter)) {
				$ListRegionAndCountry = "&ListRegion=".$ExtraParameter['Region_str_code']."&ListCountry=".$ExtraParameter['Country_str_code'];
			}
			$LeftImage="<a href='".$PathToBePass."startRow=".$StartRowOfGroup."&PageGroup=".$PrevPageGroup.$ListRegionAndCountry."' title='Click here to View Previous Set of Page'><img  id='imgleft11' src='".DIR_WS_IMAGES."member/left-arrow-black.gif' align='absmiddle' border='0' ></a>&nbsp;";
			//$LeftSideImage="&nbsp;<a href='".$PathToBePass."startRow=0&PageGroup=1' title='Click here to View First Page Record'><img id='imgleft12' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft13' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ></a>&nbsp;";
			
		}
		else{
			$LeftImage="<img  id='imgleft11' src='".DIR_WS_IMAGES."member/left-arrow-black.gif' align='absmiddle' border='0' >";

			//$LeftSideImage="<img id='imgleft16' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' ><img id='imgleft17' src='".DIR_WS_IMAGES."leftsidearrow.gif' align='absmiddle' border='0' >&nbsp;";
		} //if -else end
		
		
			$CountOfStop = $this->PageNumberLinks * $this->PageGroup   ;
			$CountOfStart = $CountOfStop - $this->PageNumberLinks + 1;
 		   // $LoopOfPageNum = $LeftSideImage;
 		   $LoopOfPageNum = $LeftImage;	
 		  
	   for($i=$CountOfStart;$i<=$CountOfStop;$i++)
		{	
			
			if($this->StartRow==$Result1['pages'][$i]){
				//$ExtraLink = "<a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."' >";
				$ExtraLink = "";
				$LoopOfPageNum.=" ".$ExtraLink."<span >"."</span>&nbsp;";
				
			}
			else{
				$ExtraLink = "<a href='".$PathToBePass."startRow=".$Result1['pages'][$i]."&PageGroup=".$this->PageGroup."&PageNo=".$i."'>";
				$LoopOfPageNum.="".$ExtraLink."<span >"."</span></a>&nbsp;";
				
			}
			if($i>=$Result1['numpages']){
				break;
			}
		}// for loop end
		
		$LoopOfPageNum.=$RightImage;
		$ReturnString = "&nbsp;".$LoopOfPageNum;
		if($Image!='Next'&& $Images2!='Previous')
		{
			$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr height=\"24\"  valign=\"middle\">
		<td valign=\"middle\">".$ReturnString."</td></tr></table>";
		return $ReturnString;
		}
//		$ReturnString.="<span class=pagingtable><input maxLength=7 size=4  name=PageNo  ></span><INPUT id=submit style=BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px onclick='' type='submit' value=Go   name=Submit  >";
		
		$ReturnString = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr height=\"24\"  valign=\"middle\">
		<td valign=\"middle\">&laquo;".$ReturnString."&raquo;</td></tr></table>";
		return $ReturnString;
	}//GetPaggingTable() function end 
/***  ************** End *******************************************/
}
?>