<?php
/**
 * @package RxCore
 *
 *
 * @version $Id: RNameValueCollection.php,v 1.1 2008-07-04 13:51:26 nitin Exp $ 
 *
 * Revision Histry:-
 * $Log: RNameValueCollection.php,v $
 * Revision 1.1  2008-07-04 13:51:26  nitin
 * *** empty log message ***
 *
 * Revision 1.1  2008-07-04 05:40:01  kruti
 * *** empty log message ***
 *
 * Revision 1.1  2007-06-16 11:06:02  kruti
 * *** empty log message ***
 *
 * Revision 1.2  2006-08-11 14:34:38  chintan
 * *** empty log message ***
 *
 * Revision 1.3  2005/11/08 14:43:45  nitin
 * *** empty log message ***
 *
 * Revision 1.1  2005/11/07 15:14:40  nitin
 * no message
 *
 *
 */



/**
 * RNameValueCollection
 */
class RNameValueCollection implements Iterator, ArrayAccess, Countable
{
	/**
	 * internal data storage
	 * @var array
	 */
	protected $Data		= array();
	
	/**
	 * is collection read only
	 * @var bool
	 */
	protected $ReadOnly = false;

	/**
	 * Constructor.
     * @internal 
	 * @param mixed $Data 		initial collection data
	 * @param bool  $ReadOnly  	the collection is read-only
	 */
	public function __construct($Data = null, $ReadOnly = false)
	{
		if (is_array($Data) || $Data instanceof Traversable) {
			foreach ($Data as $Key => $Value) {
				$this->SetValue($Key, $Value);
			}
		}
		$this->ReadOnly	= $ReadOnly;
	}

	/**
	 * number of elements in the collection
	 * @return int 
	 */
	public function Length()
	{
		return count($this->Data);
	}

	/**
	 * Whether this collection allows addition/removal of elements.
	 * @return bool
	 */
	public function IsReadOnly()
	{
		return $this->ReadOnly;
	}

	/**
	 * Removes all items in the collection.
	 */
	public function Clear()
	{
		if ($this->IsReadOnly()) {
			throw new RReadOnlyCollectionException();
		}
		//foreach ($this->Data as $Index => $Item) {
		//	$this->OnRemoveItem($Item, $Index);
		//}
		$this->Data = array();
	}
		
	/**
	 * Has value exists in collection for given key
	 *
	 * @param string $Key Has value exists for this key
	 * @return bool
	 */
	public function HasValue($Key)
	{
		return isset($this->Data[$Key]);
	}
	
	/**
	 * Get value from collection
	 *
	 * @param string $Key the key of the value
	 * @return mixed
	 */
	public function GetValue($Key)
	{
		if (array_key_exists($Key, $this->Data)) {
			return $this->Data[$Key];
		}
		//throw new RInvalidCollectionKeyException($Key);
	}
	
	/**
	 * Set value to collection
	 *
	 * @param string $Key the key of the value
	 * @param mixed $Value the value, which is being set
	 */
	public function SetValue($Key, $Value)
	{
		if ($this->IsReadOnly()) {
			throw new RReadOnlyCollectionException();
		}
		
		//if (!is_string($Key) || empty($Key)) {
		if (is_null($Key)) {
			throw new RInvalidCollectionKeyException($Key);
		}

		$this->Data[$Key] = $Value;
	}

	/**
	 * Remove value from collection
	 *
	 * @param string $Key the key of value
	 */
	public function Remove($Key)
	{
		if ($this->IsReadOnly()) {
			throw new RReadOnlyCollectionException();
		}
		
		//if (!is_string($Key) || empty($Key)) {
		if (is_null($Key)) {
			throw new RInvalidCollectionKeyException($Key);
		}
		
		unset($this->Data[$Key]);
	}
	
	
	
	
	
	//--------------------------------------------------------------
	//	property overloading
	//---------------------------------------------------------------	
	/**
	 * property get overloading
	 * @internal 
	 * @param string $Name
	 * @return mixed
	 */
	public function __get($Name)
	{
		return $this->GetValue($Name);
	}
	
	/**
	 * property set overloading
	 * @internal 
	 * @param string $Name
	 * @param mixed $Value
	 */
	public function __set($Name, $Value)
	{
		$this->SetValue($Name, $Value);
	}	
	
	
	/**
	 * Returns count of element
	 * Countable impements
	 * @internal This method should only be used by framework
	 * @return int
	 */
	public function count()
	{
		return count($this->Data);
	}

	//--------------------------------------------------------------
	//	Iterator implements
	//---------------------------------------------------------------
	/**
	 * @internal 
	 * @return mixed
	 */
	public function current()
	{
		return $this->GetValue($this->key());//current($this->Data);//
	}
	/**
	 * @internal 
	 * @return int
	 */
	public function key()
	{
		return key($this->Data);
	}
	/**
	 * @internal 
	 */
	public function next()
	{
		next($this->Data);
	}
	/**
	 * @internal 
	 * Rewinds internal array pointer.
	 * This method should only be used by framework
	 */
	public function rewind()
	{
		reset($this->Data);
	}
	/**
	 * @internal 
	 * @return bool
	 */
	public function valid()
	{
		return current($this->Data) !== false;
	}


	
	//--------------------------------------------------------------
	//	ArrayAccess implements
	//--------------------------------------------------------------
	/**
	 * @internal 
	 * @param string
	 * @return bool
	 */
	public function offsetExists($Offset)
	{
		return $this->HasValue($Offset);
	}
	/**
	 * @internal 
	 * @param string
	 * @return mixed
	 */
	public function offsetGet($Offset)
	{
		return $this->GetValue($Offset);
	}
	/**
	 * @internal 
	 * @param string
	 * @param mixed
	 */
	public function offsetSet($Offset, $Item)
	{
		$this->SetValue($Offset, $Item);
	}
	/**
	 * @internal 
	 * @param string
	 */
	public function offsetUnset($Offset)
	{
		$this->Remove($Offset);
	}		
}

?>