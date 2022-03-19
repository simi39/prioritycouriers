<?php
/**
 * $copyright$
 * 
 * @package RxCore
 * 
 * @version $Id: RRequest.php,v 1.1 2008-07-04 13:51:26 nitin Exp $ 
 *
 */

require_once("RCookie.php");

/**
 * This class must be initiate before RServer Class 
 * because $_SERVER variable is used
 */
class RRequest
{
	/**
	 * php global vars array
	 * @var array
	 */
	private $_Data;
	
	/**
	 * Constructor
	 * @internal 
	 * @param RxCoreContext $Context
	 */
	public function __construct()
	{	
		$IsMagicQuotesOn = false;
		if (get_magic_quotes_gpc()) {
			$IsMagicQuotesOn = true;
		}
		
		//Initiate RBrowser
		//$this->_Data['Browser'] 	= new RBrowser($Context);

		//Clean superglobal variables and set at local variables
		
		//$this->_Data['Raw_Server'] 	= $_SERVER;
		//$_SERVER 					= array();
		//$HTTP_SERVER_VARS 			= array();

		//$this->_Data['Raw_Post'] 	= $_POST;
		//$_POST 						= array();
		//$HTTP_POST_VARS 			= array();

		//$this->_Data['Raw_Get'] 	= $_GET;   
		//$_GET 						= array();
		//$HTTP_GET_VARS 				= array();

		//$this->_Data['Raw_Get'] 	= $_GET;
		//$_GET 						= array();
		//$HTTP_GET_VARS 				= array();
	
		//Making Name value collection for cookies
		$this->_Data['Raw_Cookies'] = $_COOKIE;
		$Cookies					= $_COOKIE;
		//$_COOKIE 					= array();
		//$HTTP_COOKIE_VARS 			= array();
		
		unset($Cookies['ZDEDebuggerPresent']);
		unset($Cookies['PHPSESSID']);
		unset($Cookies['ZendDebuggerCookie']);
		
		$CookiesList 				= array();
		foreach ($Cookies as $CookieName => $Value) {
			$Obj = new RCookie();
			$Obj->SetName($CookieName);
			if ($IsMagicQuotesOn) {
				$Value = stripslashes($Value);
			}
			$Obj->SetValues($Value);
			$CookiesList[$CookieName] = $Obj;
		}
		
		$this->_Data['CookiesList']	= new RCookiesCollection($CookiesList);
		

		$this->_Data['Raw_Files'] 	= $_FILES;
		
		//Making Name value collection for posted files
		$FilesList 					= array();
		
		while(list($FieldName)=each($_FILES)) {
			//$FilesList[$FieldName] 	= new RPostedFile($_FILES[$FieldName]);
		}
		
		$this->_Data['FilesList']	= new RNameValueCollection($FilesList, true);
		//$_FILES 					= array();
		//$HTTP_POST_FILES 			= array();

		//Making server accept type named value collection
		$this->_Data['ServerAcceptTypes'] 	= array(
			'HTTP_ACCEPT' 			=> (isset($this->_Data['Raw_Server']['HTTP_ACCEPT']) 			? $this->_Data['Raw_Server']['HTTP_ACCEPT'] 			: "Unknown"),
			'HTTP_ACCEPT_CHARSET' 	=> (isset($this->_Data['Raw_Server']['HTTP_ACCEPT_CHARSET']) 	? $this->_Data['Raw_Server']['HTTP_ACCEPT_CHARSET'] 	: "Unknown"),
			'HTTP_ACCEPT_ENCODING' 	=> (isset($this->_Data['Raw_Server']['HTTP_ACCEPT_ENCODING'])	? $this->_Data['Raw_Server']['HTTP_ACCEPT_ENCODING'] : "Unknown"),
			'HTTP_ACCEPT_LANGUAGE' 	=> (isset($this->_Data['Raw_Server']['HTTP_ACCEPT_LANGUAGE']) 	? $this->_Data['Raw_Server']['HTTP_ACCEPT_LANGUAGE'] : "Unknown")
			);
		$this->_Data['ServerAcceptTypes'] = new RNameValueCollection($this->_Data['ServerAcceptTypes'], true);
	}

	/**
	 * Gets host name for current request
     * @return string
     */	 
	public function GetHostName()
	{
		return strtoupper($this->_Data['Raw_Server']['HTTP_HOST']);
	}
	
	/**
	 * Http method for current request
     * @return string
     */	 
	public function GetHttpMethod()
	{
		return strtoupper($this->_Data['Raw_Server']['REQUEST_METHOD']);
	}

	/**
	 * Gets request value associated with the key passed as parameter
	 * @desc the value return from PHP global var _REQUEST
     * @param string $Name the request variable variable
     * @param mixed $Default the default value returns, if given value not found
     * @return mixed
     */	 
	public function GetValue($Name, $Default = null)
	{
		return isset($this->_Data['Raw_Request'][$Name]) ? $this->_Data['Raw_Request'][$Name] : $Default;
	}

	/**
	 * Gets query string values associated with the key passed as parameter
	 * @desc the value return from PHP global var _GET
     * @param string $Name the request variable variable
     * @param mixed $Default the default value returns, if given value not found
     * @return mixed
     */	 
	public function GetQueryString($Name, $Default = null)
	{
		return isset($this->_Data['Raw_Get'][$Name]) ? $this->_Data['Raw_Get'][$Name] : $Default;
	}
	
	/**
     * Gets a string collection of client-supported MIME accept types
     * @return RNameValueCollection
     */	 
	public function GetAcceptTypes()
	{
		return $this->_Data['ServerAcceptTypes'];
	}
	
	/**
   	 * Gets information about the requesting client's browser capabilities    	
   	 * @return RBrowser
   	 */ 
	public function GetBrowser()
	{
		return $this->_Data['Browser'];
	}

	/**
     * Gets a collection of cookies sent by the client.
     *
     * @return RCookiesCollection
     */
	public function GetCookies()
	{
		return $this->_Data['CookiesList'];
	}
	
	/**
     * Gets the collection of client-uploaded files (Multipart MIME format).
     *
     * @return RNameValueCollection
     */
	public function GetFiles()
	{
		return $this->_Data['FilesList'];
	}

	/**
	 * Return true data is posted, false othewise
	 * @return bool
	 */
	public function IsPostBack()
	{
		return $this->GetHttpMethod() === 'POST' ? true : false;
	}
	

	/**
	 * Get request uri
	 *
	 * @return string
	 */
	public function GetRequestUri($WithHost = false)
	{
		$Uri = $this->_Data['Raw_Server']['REQUEST_URI'];
		if ($WithHost) {
			$Uri = 'http://' . $this->_Data['Raw_Server']['HTTP_HOST'] . $Uri;
		}
		return $Uri;
	}	

	/**
	 * Get request url
	 *
	 * @return RUrl
	 */
	public function GetUrl($WithHost = false)
	{
		$Uri = $this->_Data['Raw_Server']['REQUEST_URI'];
		$Url = new RUrl($Uri);
		
		if ($WithHost) {
			$Url->SetHost($this->_Data['Raw_Server']['HTTP_HOST']);
		}
		return $Url;
	}	
		
	/**
	 * Returns raw value for the specified key
	 * @internal 
	 * @param string $CollectionName
	 * @param string $Key
	 * @return bool
	 */
	public function InternalGetValue($CollectionName, $Key)
	{
		if (!key_exists($CollectionName, $this->_Data)) {
			if (strpos($CollectionName, 'Raw_') !== 0) {
				$CollectionName = "Raw_" . $CollectionName;
			}
			if (!key_exists($CollectionName, $this->_Data)) {
				return null;
			}
		}
		
		if (key_exists($Key, $this->_Data[$CollectionName])) {
			return $this->_Data[$CollectionName][$Key];
		}
		return $this->_Data[$CollectionName];
	}
}
?>