<?php
/**
 * @package RxCore.Models
 *
 *
 * @version $Id: RDataModel.php,v 1.1 2008-07-04 13:51:27 nitin Exp $ 
 *
 * Revision Histry:-
 * $Log: RDataModel.php,v $
 * Revision 1.1  2008-07-04 13:51:27  nitin
 * *** empty log message ***
 *
 * Revision 1.1  2008-07-04 05:40:16  kruti
 * *** empty log message ***
 *
 * Revision 1.1  2007-06-16 11:06:29  kruti
 * *** empty log message ***
 *
 * Revision 1.9  2006-11-16 11:24:15  heena
 * *** empty log message ***
 *
 * Revision 1.8  2006-11-06 12:47:20  heena
 * *** empty log message ***
 *
 * Revision 1.7  2006-11-06 12:42:57  heena
 * *** empty log message ***
 *
 * Revision 1.6  2006-10-26 13:42:17  heena
 * *** empty log message ***
 *
 * Revision 1.5  2006-08-14 10:12:07  chintan
 * *** empty log message ***
 *
 * Revision 1.4  2006-08-14 10:05:41  chintan
 * *** empty log message ***
 *
 * Revision 1.3  2006-08-14 05:41:06  chintan
 * *** empty log message ***
 *
 * Revision 1.2  2006-08-11 14:34:38  chintan
 * *** empty log message ***
 *
 * Revision 1.1  2005/11/07 15:14:44  nitin
 * no message
 *
 *
 */

require_once(DIR_LIB_CLASSES_EXCEPTION."RPropertyNotFoundException.php");
require_once(DIR_LIB_CLASSES_DATA."RDataRecord.php");
require_once(DIR_LIB_CLASSES_EXCEPTION."RInvalidPropertyMapException.php");
abstract class RDataModel extends RDataRecord
{

	const INSERT = 'insert';
	const UPDATE = 'update';
	const INSERT_ONLY_DATA = 'insert_only_data';
	
	/**
	 * @var array
	 */
	var $preset_escapes = array( 
									  "'"     => "\\", 
									  "\""     => "\\", 
									  "&"     => "\\", 
									  ">"     => "\\", 
									  "<"     => "\\",
									  "chr("     => "\\"
									  );
	/**
	 * @var array
	 */
	private $_PropertyMap = array();
	/**
	 * @var bool
	 */
	private $_IsNew		 = false;
	/**
	 * Constructor
	 * @param array $Data
	 */
	public function __construct($Data = null)
	{
		parent::__construct($Data);
		
		$PropertyMap = $this->PropertyMap();
		if (is_array($PropertyMap)) {
			$this->_PropertyMap 	= $PropertyMap;	
			$this->_IteratorKeys	= array_keys($this->_PropertyMap);
		}
		
		if (is_null($Data)) {
			$this->_IsNew = true;
		}
	}

	/**
	 * is new object or created from existing
	 *
	 * @return bool
	 */
	public function IsNew()
	{
		return $this->_IsNew;
	}
	
	/**
	 * 
	 * @internal 
	 * @return unknown
	 */
	public function InternalSync($Type = null)
	{
		if (is_null($Type)) {
			return $this->_Data;
		}
		if ($Type === self::INSERT || $Type === self::INSERT_ONLY_DATA) {

			$Args = func_get_args();
			// unset $Type agr
			unset($Args[0]);

			$Vals = call_user_func_array(array($this, 'Encode'), $Args);

			if ($Type === self::INSERT_ONLY_DATA)
			{
				return  $Vals;
				exit;
			}
			
			$Args 	= func_num_args();
			$Ret 	= "";
			$Data 	= $this->_Data;
			for ($I = 1; $I < $Args; $I++) {
				if ($I > 1) {
					//$Ret .= '\"';
					$Ret .= ", ";
					//$Ret .= '\"';
				}
				$Key = func_get_arg($I);
				//$Ret .= '"';
				$Ret .= "" . $Key . "";
				//$Ret .= '"';
			}
			$Query="(".$Ret.") VALUES (".$Vals.")";
			
			if(strpos($Query,", ,"))
			{
				$Query=str_replace(", ,",",null,",$Query);
			}
			if(strpos($Query,",,"))
			{
				$Query=str_replace(",,",",null,",$Query);
			}
			if(strpos($Query,"= ,"))
			{
				$Query=str_replace("= ,",",null,",$Query);
			}
			return  $Query;exit;

		}
		else if ($Type === self::UPDATE) {

			$Args 	= func_num_args();
			$Ret 	= "";
			$Data 	= $this->_Data;
			for ($I = 1; $I < $Args; $I++) {

				$Key = func_get_arg($I);
				if (strlen($Ret) > 0){
					$Ret .= ", ";
				}
				$RetEncode=$this->encode($Key);
				if($RetEncode=='')
				{
					$Ret .= $Key . "=null ";
				}
				else 
				{
					$Ret .= $Key . "=" . $this->encode($Key) ." ";
				}
			}

			return $Ret;
		}

		return $this->_Data;
	}

	/**
	*
	*/
	private function Encode()
	{
		$Args 	= func_num_args();
		$Ret 	= "";
		$Data 	= $this->_Data;

		//create db_escape object
		//$db_esc = new db_escape();
		for ($I=0; $I < $Args; $I++) {
			if ($I > 0 ) {
				$Ret .= ", ";
			}

			$Key = func_get_arg($I);

			// type checking required
			// for escape char see db_escape.php
			if (array_key_exists($Key, $Data) && (!empty($Data[$Key]) || (int)$Data[$Key] === 0)) {
				if (is_string($Data[$Key])) {
					//$ret .= "'". $db_esc->esc_db_str($data[$key]) ."'";
					$FinalValue = $Data[$Key];
					
					if(get_magic_quotes_gpc()){
					//	$Ret .= "'".htmlentities($FinalValue, ENT_QUOTES, 'cp1252')."'";
						//$Ret .= "'".encodeSpecialCharacter($FinalValue)."'";
						//$Ret .= "'".$FinalValue."'";
						$Ret .= "'" . addslashes($FinalValue) . "'";
					}
					else{
						$Ret .= "'" . addslashes($FinalValue) . "'";
					//	$Ret .= "'" . htmlentities($FinalValue, ENT_QUOTES, 'cp1252') . "'";
						//$Ret .= "'".encodeSpecialCharacter($FinalValue)."'";
					}
				}
				else {
				//	$Ret .=  htmlentities($Data[$Key], ENT_QUOTES, 'cp1252');
				//	$Ret .= "'".encodeSpecialCharacter($Data[$Key])."'";
					$Ret .= "'".$Data[$Key]."'";
				}
			}
			else {
				$Ret .= "null";
			}
		} 

		// release db_escape object
		//unset($db_esc);
		return $Ret;
	}
	
	/**
	*
	*
	*/
	
	function esc_db_str( $db_string )
	{
        //debug_print( 'db_string ', $db_string );
		
		$this->escapes =& $this->preset_escapes;
		
			$this->str_buff = $db_string;
			reset( $this->escapes );        
			while ( $key_val = each( $this->escapes ) ) {
				$this->escaped  = $key_val[0];
				$this->esc_with = $key_val[1];
				if( isset( $this->escaped)  && isset( $this->esc_with ) ){
					$this->insert_esc_str();
				}//if
			}// while
		return $this->str_buff;
	}
	
	/**
	*
	*
	*/
	
	function insert_esc_str()
	{
		// find escaped string in buffer (case-insensitive)s
		$parts = explode( strtolower($this->escaped ), strtolower($this->str_buff) );
		
		$pos = 0;
		$tmp_str="";
		$find_len = strlen( $this->escaped );
		
		for( $index=0; isset( $parts[$index] ); $index++){
		  	$part_len = strlen( $parts[$index] );
		  	$tmp_str .= substr( $this->str_buff, $pos, $part_len );
		  	$pos += $part_len;
		  	if( isset( $parts[$index + 1] ) ){
				$tmp_str .= $this->esc_with;
				$tmp_str .= substr( $this->str_buff, $pos, $find_len );
				$pos += $find_len;
		  	} //if
		} //for
		$this->str_buff = $tmp_str;
	}

    /**
	*
	*
	*/
      
	function unesc_db_str( $db_string )
	{
    	$this->escapes =& $this->preset_escapes;
		
			$reversed_escapes = array_reverse( $this->escapes );
			
            reset( $reversed_escapes );
            $this->str_buff = $db_string;
			
            while ( $key_val = each( $reversed_escapes ) ) {
            	$this->escaped  = $key_val[0];
                $this->esc_with = $key_val[1];
                if( isset( $this->escaped )  && isset( $this->esc_with ) ){
                	$this->remove_esc_str();
                }//if
            }//while
			
    	return $this->str_buff;
     }
	
	/**
	*
	*
	*/
	
    function remove_esc_str()
	{
     	$find_str = $this->esc_with . $this->escaped;
        $parts = explode( strtolower( $find_str ), strtolower($this->str_buff) );
        
		$pos = 0;
        $tmp_str="";
		
        $esc_with_len  = strlen( $this->esc_with );
        $escaped_len  = strlen( $this->escaped );
        $find_len = strlen( $find_str );
        
		for( $index=0; isset( $parts[$index] ); $index++){
        	$part_len = strlen( $parts[$index] );
          	$tmp_str .= substr( $this->str_buff, $pos, $part_len );
          	$pos += $part_len;
          	if( isset( $parts[$index + 1] ) ) {
            	$tmp_str .= substr( $this->str_buff, $pos + $esc_with_len, $escaped_len );
            	$pos += $find_len;
          	} //if
        } //for
        
		$this->str_buff = $tmp_str;
   }
	/**
	 * 
	 * @return array
	 */
	abstract protected function PropertyMap();
	
	/**
	 * 
	 * @return array
	 */
	//abstract public function InternalSync();
	
	/**
	 * Has record contain given filed value
	 *
	 * @param string $Name
	 * @return bool
	 */
	public function HasValue($Name)
	{
		return isset($this->_PropertyMap[$Name]);
	}
	
	
	/**
	 * Get value of given field
	 *
	 * @param string $Name
	 * @param bool $IsEscape
	 * @return mixed
	 */
	public function GetValue($Name, $IsEscape = true)
	{	
		if (!isset($this->_PropertyMap[$Name])) {
			throw new RPropertyNotFoundException(get_class($this).'::'.$Name, $Name);
		}
		
		if (count($this->_PropertyMap[$Name]) != 4) {
			throw new RInvalidPropertyMapException($Name);
		}
		
		$MapType 	= $this->_PropertyMap[$Name][0];
		$MapGetter	= $this->_PropertyMap[$Name][1];
		
		if ($MapType == 'RawField') {
			return $this->InternalGetValue($MapGetter, false);	
		}

		if ($MapType == 'Field') {
			return $this->InternalGetValue($MapGetter, true);	
		}
		
		if ($MapType == 'Method') {
			if (method_exists($this, $MapGetter)) {
				return $this->$MapGetter();
			}
			else {
				throw new RInvalidPropertyMapException("Method $MapGetter not found");
			}
		}
		throw new RInvalidPropertyMapException($Name);		
	}
	
	/**
	 * Get value of given field
	 *
	 * @param string $Name
	 * @param string $Value
	 * @param bool $IsEscape
	 * @return mixed
	 */
	public function SetValue($Name, $Value, $IsEscape = true)
	{
		if (!isset($this->_PropertyMap[$Name])) {
			throw new RPropertyNotFoundException(get_class($this), $Name);
		}
		
		if (count($this->_PropertyMap[$Name]) != 4) {
			throw new RInvalidPropertyMapException($Name);
		}
		
		$MapType 	= $this->_PropertyMap[$Name][0];
		$MapSetter	= $this->_PropertyMap[$Name][2];
		
		if (strlen($MapSetter) === 0) {
			throw new RReadOnlyPropertyException("Read Only property $Name");
		}
		
		if ($MapType == 'RawField') {
			return $this->InternalSetValue($MapSetter, $Value, false);	
		}

		if ($MapType == 'Field') {
			return $this->InternalSetValue($MapSetter, $Value, true);	
		}
		
		if ($MapType == 'Method') {
			if (method_exists($this, $MapSetter)) {
				return $this->$MapSetter($Value);
			}
			else {
				throw new RInvalidPropertyMapException("Method $MapSetter not found");
			}
		}
		throw new RInvalidPropertyMapException($Name);		
	}	
		
}

?>
