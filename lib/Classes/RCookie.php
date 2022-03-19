<?php
/**
 * $copyright$
 * 
 * @package RxCore
 *
 * @version $Id: RCookie.php,v 1.1 2008-07-04 13:51:26 nitin Exp $ 
 *
 *
 */

/**
  *
  */
class RCookie
{

	/**
	 * @var string
	 */
	private  $_Domain;
	/**
	 * @var string
	 */
	private  $_Expires;
	/**
	 * @var bool
	 */
	private  $_HasKeys;
	/**
	 * @var string
	 */
	//private  $_Item;
	/**
	 * @var string
	 */
	private  $_Name;
	/**
	 * @var string
	 */
	private  $_Path;
	/**
	 * @var string
	 */
	private  $_Secure;
	/**
	 * @var string
	 */
	private  $_Value;
	/**
	 * @var array
	 */
	private  $_Values = array();

	public function __construct()
	{
	$this->_Path	= SITE_URL;
	$this->_Domain	= SITE_URL_WITHOUT_PROTOCOL;
	$this->_Expires = time() + 60*60*24*1;
	
	}
	
	/**
   	 *  Get the domain to associate the cookie with.
     *  @return string
     */
	public function GetDomain()
	{
		return  $this->_Domain;
	}
	
	/**
     * Set the domain to asscoiate the cookies with.
     * @param string
     */	
	public function SetDomain($Value)
	{
		$this->_Domain  = $Value;
	}
	
	/**
   	 * Get the expiration date and time for the cookie.
     * @return date 
     */
	public function GetExpire()
	{
		return $this->_Expires;
	}
	
	/**
     * Set the expiration date and  time for the cookies;
     * @param date
     */
	public function SetExpire($Value)
	{
		$$this->_Expires = $Value;
	}
	
	/**
   	 * Gets a value indicating whether a cookie has subkeys.
   	 * @return bool
   	 */
	public function GetHasKeys()
	{
		return $this->_HasKeys;
	}
	
	/**
   	 * Gets the name of a cookie
   	 * @return string
   	 */  
	public function GetName()
	{
		return  $this->_Name;
	}
	
	/**
   	 * Sets the name of a cookie
   	 * @param string
   	 */  
	public function SetName($Value)
	{
		$this->_Name = $Value;
	}
	
	/**
   	 * Gets the virtual path to transmit with the current cookie.
   	 * @return string
   	 */
	public function GetPath()
	{
		return  $this->_Path;
	}
	
	/**
   	 * Ste the virtual path to transmit with the current cookie.
   	 * @param string
   	 */
	public function SetPath($Value)
	{
		$this->_Path = $Value;
	}
	
	/**
   	 * Gets a value indicating whether to transmit the cookie 
   	 * using SSL (that is, over HTTPS only).
   	 * @return  bool
   	 */
	public function GetSecure()
	{
		return  $this->_Secure;
	}
	
	/**
   	 * Sets a value indicating whether to transmit the cookie 
   	 * using SSL (that is, over HTTPS only).
   	 * @param bool
   	 */	
	public function SetSecure($Value)
	{
		$this->_Secure = $Value;
	}
	
	/**
   	 * Gets an individual cookie value
   	 * @return string
   	 */ 	
	public function GetValue()
	{
		return  $this->_Value;
	}
	
	/**
   	 * Sets an individual cookie value
   	 * @param string
   	 */ 	
	public function  SetValue($Value)
	{
		$this->_Value = $Value;
	}
	
	/**
     * Gets an individual cookie value
     * @return array
     */ 	
	public function GetUnserialisedValues()
	{
		return 	json_decode($this->_Values,true);
	}
	
	/**
     * Gets an individual cookie value
     * @return array
     */ 	
	public function GetValues()
	{
		return 	$this->_Values;
	}
	/**
     * Sets an individual cookie value
     * @param  array
     */ 	
	public function  SetValues($Value)
	{
		$this->_Values = $Value;
	}
	
   /**
    * @internal 
    */ 
	public function SyncInternal($Object1, $Object2)
	{

	}

	public function SetFinalCookie()
	{
		
		//Write cookies
			$Name 		= $this->GetName();
			$Value		= $this->GetValues();
			$Expire		= $this->GetExpire();
			$Path		= $this->GetPath();
			$Domain		= $this->GetDomain();
			$Secure		= $this->GetSecure();
			
			//$Value		= base64_encode($Value);86400
			$Expire		= (!is_int($Expire)) 	? time() + 60*60*24*1	: $Expire;
			$Path		= (empty($Path)) 		? $UrlPath 				: $Path;
			$Domain		= (empty($Domain))		? $Host					: $Domain;
			$Secure		= (empty($Secure))		? 0						: 1;
			
			//setrawcookie($Name, $Value, $Expire, $Path, $Domain, $Secure);
			setcookie($Name, $Value, $Expire, $Path, $Domain, $Secure);
	}

}

/**
 * RCookie collection
 *
 */
class RCookiesCollection extends RNameValueCollection
{
	/**
	 * Constructor
	 * @internal 
	 * @param array $Data
	 */
	public function __construct($Data = null)
	{
		if (is_null($Data)) {
				$this->_Path	= SITE_URL;
				$this->_Domain	= "ehci.radixweb.in";
				$this->_Expires = time() + 60*60*24*1;
				parent::__construct();
		}
		else {
			parent::__construct($Data, true);
		}
	}

	/**
	 * Add cookie in collection
	 *
	 * @param RCookie $Cookie new cookie
	 */
	public function Add($Cookie)
	{
		$this->SetValue(null, $Cookie);
	}

	/**
	 * Set cookie to collection
	 *
	 * @param string $Name this key is overrided by cookie names
	 * @param RCookie $Cookie new cokie
	 */
	public function SetValue($Key, $Cookie)
	{
		parent::SetValue($Cookie->GetName(), $Cookie);
	}

}

			
?>