<?php
class Session
{
	private $_Data = array();
	/**
	 * Constructor
	 * @internal 
	 * @param RxCoreContext $Context
	 */
	function __construct($Data = array())
	{
		$this->_Data = $Data;
	}

	/**
	 * Destructor
	 *
	 * @internal 
	 */
	public function __destruct()
	{
		//$_SESSION['Thesessiondata'] = $this->_Data;
		$this->_Data = array();
		//dprint($_SESSION, (string)$this);
	}

	/**
	 * Destory current session
	 */
	public function Destroy()
	{
		session_destroy();
	}
	
	/**
	 * Has value in session associated with the given key name
	 * @param string $Name the value key name
	 * @return bool
	 */
	public function HasValue($Name)
	{
		return array_key_exists($Name, $this->_Data);
	}
	
	/**
	 * Gets value from session associated with the given key name
	 * @param string $Name the value key name
	 * @return mixed
	 */
	public function GetValue($Name)
	{	
		$Value = json_decode($this->_Data[$Name],true);
		return $this->clean_arr($Value);
	}
	
	function clean_arr( $arr_or_solo )
	{
		$out = array();
		
		if( !isset($arr_or_solo) )
			return;
		
		if( !is_array($arr_or_solo) ){
			return stripslashes($arr_or_solo);
		} else {
			reset ($arr_or_solo);

			while (list($key, ) = each ($arr_or_solo)) {
				if( isset($arr_or_solo[$key]) ){
					if( is_array($arr_or_solo[$key]) ){
						$out[$key] = $this->clean_arr($arr_or_solo[$key]);
					} else {
						$out[$key] = stripslashes($arr_or_solo[$key]);
					} // is_array
				} //isset
			} //while
		}// else is_array
		return $out;
	}

	/**
	 * Sets value to session associated with the given key name
	 * @param string $Name the value key name
	 * @param mix $Value the new value
	 */
	public function SetValue($Name, $Value)
	{
		$this->_Data[$Name] = json_encode($Value);
	}

	/**
	 * Clear value to session associated with the given key name
	 * @param string $Name the value key name
	 * @param mix $Value the new value
	 */
	public function ClearValue($Name)
	{
		 unset($this->_Data[$Name]);
	}


	/**
	 * Returns current session Id
	 * @return string
	 */
	public function GetId($Id=null)
	{
		if($Id)
		{
			return session_id($Id);
		}
		else{ 
			return session_id();	
		}
		
	}

	public function Store()
	{		
		$_SESSION['Thesessiondata'] = $this->_Data;
		//dprint($_SESSION, (string)$this);
		//dprint_callstack();
		//session_write_close();
		//exit;
	}
	public function GetData()
	{		
		return $this->_Data;
		
	}
	public function SetData($data)
	{		
		$this->_Data =$data;
		
	}
}
?>