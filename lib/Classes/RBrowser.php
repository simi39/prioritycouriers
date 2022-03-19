<?php
/**
 * +-----------------------------------------------------------------------------+
 * | RxCore  .:. Enterprise Architecture for PHP Development                          
 * +-----------------------------------------------------------------------------+
 * | Copyright (c) 2005 RadixWeb, India                        
 * +-----------------------------------------------------------------------------+
 * +-----------------------------------------------------------------------------+
 * | RxCore IS NOT FREE SOFTWARE
 * | You may not distribute this program in any manner,
 * | modified or otherwise, without the express, written
 * | consent from RadixWeb.com
 * |
 * | You may make modifications, but only for your own 
 * | use and within the confines of the License Agreement.
 * | All rights reserved.
 * |
 * | Selling the code for this program without prior 
 * | written consent is expressly forbidden. Obtain 
 * | permission before redistributing this program over 
 * | the Internet or in any other medium.  In all cases 
 * | copyright and header must remain intact.
 * +-----------------------------------------------------------------------------+
 * | This source file is subject to the RxCore (RadixWeb, India) End 
 * | User License Agreement (EULA), that is bundled with this package in the file     
 * | LICENSE, and is available at through the world-wide-web at          
 * | http://www.radixweb.com/extranet/LICENSE.txt                      
 * | If you did not receive a copy of the RxCore license and are      
 * | unable to obtain it through the world-wide-web, please send a note   
 * | to license@radixweb.com so we can email you a copy immediately.    
 * +-----------------------------------------------------------------------------+
 * | Authors: RadixWeb, India <info@radixweb.com>               
 * | Support: http://www.radixweb.com/RxCore/                    
 * +-----------------------------------------------------------------------------+
 * | RadixWeb and RxCore are trademarks of RadixWeb,India. 
 * +-----------------------------------------------------------------------------+
 * | License ID : Not Registered
 * | License Owner : Not Registered *
 * +-----------------------------------------------------------------------------+
 *
 * @package RxCore
 *
 *
 * @version $Id: RBrowser.php,v 1.1 2008-07-04 13:51:26 nitin Exp $ 
 *
 * Revision Histry:-
 * $Log: RBrowser.php,v $
 * Revision 1.1  2008-07-04 13:51:26  nitin
 * *** empty log message ***
 *
 * Revision 1.1  2008-07-04 05:40:01  kruti
 * *** empty log message ***
 *
 * Revision 1.1  2007-06-16 11:06:03  kruti
 * *** empty log message ***
 *
 * Revision 1.3  2006-10-19 08:18:06  heena
 * *** empty log message ***
 *
 * Revision 1.2  2006-08-11 14:34:38  chintan
 * *** empty log message ***
 *
 * Revision 1.5  2005/11/15 10:31:15  nitin
 * *** empty log message ***
 *
 * Revision 1.4  2005/11/11 08:11:12  nitin
 * *** empty log message ***
 *
 * Revision 1.3  2005/11/08 14:28:09  nitin
 * *** empty log message ***
 *
 * Revision 1.2  2005/11/07 15:23:22  nitin
 * *** empty log message ***
 *
 *
 *
 */

/**
 * Browser class
 */
class RBrowser
{

	/**
	 * @var bool
	 */
	private $_JavaScriptEnabled;
	/**
	 * @var string
	 */
	private $_Type;
	/**
	 * @var string
	 */
	private $_Name;
	/**
	 * @var string
	 */
	private $_Platform;
	/**
	 * @var string
	 */
	private $_UserAgent;

	/**
	 * Constructor
     *
     * @internal  
	 */
	public function __construct()
	{
		// get server data from request through param
		
		// cookie enable or not?
		
		
		$this->_JavaScriptEnabled = true;
		 
		$this->_UserAgent = $_SERVER['HTTP_USER_AGENT'];

		//Browser type detection
		//if user agent conyains "Mozilla" then pick first word of the user agent
		if (eregi('Mozilla', $this->_UserAgent))		{
			$this->_Type = substr($this->_UserAgent, 0, strspn($this->_UserAgent, "Mozilla/.1234567890"));
		}
		else {
			$this->_Type = "Unknown";
		}


		//Browser name detection
		//if user agent contains word "Gecko" pick last word of the user agent
		if (eregi('Gecko', $this->_UserAgent)) {
			$this->_Name = substr($this->_UserAgent, strrpos($this->_UserAgent, " ") + 1, strlen($this->_UserAgent));
		}
		elseif (eregi('MSIE', $this->_UserAgent)){
			$this->_Name = substr($this->_UserAgent, stripos($this->_UserAgent, "MSIE"), strlen($this->_UserAgent));
			$this->_Name = substr($this->_Name, 0, strpos($this->_Name, ";"));

		}
		else{
			$this->_Name 	= 	(eregi('Netscape', $this->_UserAgent))?"Netscape":(
			(eregi('Opera', $this->_UserAgent))?"Opera":(
			(eregi('Safari', $this->_UserAgent))?"Safari":(
			(eregi('Firefox', $this->_UserAgent))?("Firefox"):(
			"Unknown"
			))));
		}

		//Platfor detection
		if (eregi('windows', $this->_UserAgent)) {
			$this->_Platform = "Windows ";
			$this->_Platform .= (eregi('NT', $this->_UserAgent))?("NT"):(
			(eregi('98', $this->_UserAgent))?("98"):(
			(eregi('95', $this->_UserAgent))?("95"):""));
		}
		else{
			$this->_Platform = (eregi('Linux', $this->_UserAgent))?"Linux":(
			(eregi('Unix', $this->_UserAgent))?"Unix":(
			(eregi('SunOS', $this->_UserAgent))?"SunOS":(
			(eregi('Mac', $this->_UserAgent))?("Macintosh"):
			"Unknown"
			)));
		}
	}
	
	/**
	 * Is java script enabled in client's browser
	 * @return boolean
	 */
	public function IsJavaScriptEnabled()
	{
		return $this->_JavaScriptEnabled;
	}
	
	/**
	 * Gets browser type
	 * @return string
	 */
	public function GetType()
	{
		return $this->_Type;
	}
	
	/**
	 * The client's browser name
	 * @return string
	 */
	public function GetName()
	{
		return $this->_Name;
	}

	/**
	 * The client's platfrom on which browser is running
	 * @return string
	 */
	public function GetPlatform()
	{
		return $this->_Platform;
	}
	
	/**
	 * The USER AGENT string for the client's browser
	 * @return string
	 */
	public function GetUserAgent()
	{
		return $this->_UserAgent;
	}
	
}
?>