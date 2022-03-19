<?php
class RGlobalVersFilter
{
	/*public function Process()
	{
		array_walk_recursive($_POST, array($this, 'CleanArrayValue'));
	}*/

	/**
	 * Clean array
	 */	
	/*public function CleanArrayValue(&$Item, $Key)
	{
		if (is_string($Item)) {
			if (get_magic_quotes_gpc()) {
				$Item = stripslashes($Item);

			}

			//filter
		}
	}*/

	private $GET_RAW;
	private $REQUEST_RAW;
	private $POST_RAW;
	private $COOKIE_RAW;
	
	var $is_magic_quotes;
	
	/*
	 *	Constructor
	 */
	function __construct()
	{
	}

	function process_action_string()
	{
		if( !isset($_POST[_ACTION]) )
			return;
			
		// .htaccess
		$action1 = $_POST[_ACTION];
		debug_print( 'action1', $action1 );
		$act_data = explode( "/", $action1 );
		//debug_print( 'act_data', $act_data );
		
		$_POST[_ACTION] = $act_data[0];
		unset( $act_data[0] );
		
		$arg_num = 0;
		foreach( $act_data as $data ) {
			$arg_num++;
			$pos = strpos( $data, "-" );
			if( $pos==false ) {
				$_POST[$arg_num] = $data;
				continue;
			}
			$_POST[substr($data, 0, $pos)] = substr($data,$pos+1);
		}
	
		
	}

	function process_vars()
	{
		if( ini_get( 'magic_quotes_gpc' ) )
			$this->is_magic_quotes = true;
		else
			$this->is_magic_quotes = false;

		//$this->process_action_string();
		
		$this->GET_RAW		= $_GET;
		$this->POST_RAW		= $_POST;
		$this->COOKIE_RAW	= $_COOKIE;
		
	 	$_GET 		= $this->clean_arr($_GET);
	 	$_POST 		= $this->clean_arr($_POST);
	 	$_COOKIE 	= $this->clean_arr($_COOKIE);
		
		//debug_print( 'post ', $_POST );
		//$test = "<script>test <script>";
		//$this->clean_arr($test);
		//debug_print( 'process_vars', $test );
	}

	function &get_raw_env_vars($str_name)
	{
		switch( strtolower($str_name) )
		{
			case 'get':
				return $this->GET_RAW;
			
			case 'post':
				return $this->POST_RAW;

			case 'cookie':
				return $this->COOKIE_RAW;
				
			default:
				return null;
		}
		return null;
	}

	function clean_arr( $arr_or_solo )
	{
		$out = array();
		
		if( !isset($arr_or_solo) )
			return;
		
		if( !is_array($arr_or_solo) ){
			return $this->clean_string($arr_or_solo);
		} else {
			reset ($arr_or_solo);

			while (list($key, ) = each ($arr_or_solo)) {
				if( isset($arr_or_solo[$key]) ){
					if( is_array($arr_or_solo[$key]) ){
						$out[$key] = $this->clean_arr($arr_or_solo[$key]);
					} else {
						if (strpos($key, 'c_') === 0) {
							$key1 = str_replace('c_', '', $key);
							$out[$key1] = $this->clean_string(base64_decode($arr_or_solo[$key]));
						}
						else {
							$out[$key] = $this->clean_string($arr_or_solo[$key]);
						}
					} // is_array
				} //isset
			} //while
		}// else is_array
		return $out;
	}		 


	function clean_string( $str )
	{
		if( !is_string($str) )
			return ;
		
		//debug_print( "str $str" );
		
		$temp = strip_tags($str);
		
		//debug_print( "temp $temp" );
		
		if( $this->is_magic_quotes ) {
			$temp = stripslashes( $temp );
		}
		
		//debug_print( "temp $temp" );
		return $temp;
	}
}
?>