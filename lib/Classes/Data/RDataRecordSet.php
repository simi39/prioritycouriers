<?php

/**
 * Record Set
 *
 */
class RDataRecordSet implements Iterator, ArrayAccess
{
	/**
	 * @var DB_Result
	 */
	private $ResultData		= null;
	/**
	 * @var int
	 */
	private $AffectedRows 	= 0;
	/**
	 * @var int
	 */
	private $RecordCount	= -1;
	/**
	 * @var array
	 */
	private $RecordList		= array();
	/**
	 * @var int
	 */
	private $IteratorCount	= 0;
	
	
	
	/**
	 * Constructor
	 *
	 * @param DB_Result $ResultData
	 * @param int $AffectedRows
	 */
	public function __construct($ResultData, $AffectedRows)
	{
		$this->ResultData 		= $ResultData;
		$this->AffectedRows		= $AffectedRows;
	
		if (is_object($this->ResultData)) {
			$Rows = $this->ResultData->numRows();
			if (is_int($Rows)) {
				$this->RecordCount = $Rows;
			}	
		}
	}
	
	/**
	 * Destructor
	 */
	public function __destruct()
	{
		if (is_object($this->ResultData)) {
			$this->ResultData->free();
		}
	}
	
	/**
	 * Record count
	 * @return int
	 */
	public function RecordCount()
	{
		return $this->RecordCount;
	}
	
	/**
	 * Affected rows
	 * @return int
	 */
	public function AffectedRows()
	{
		return $this->AffectedRows;
	}

	
	/**
	 * fetch data
	 * @internal 
	 * @param int $Index
	 * @return RDataRecord
	 */
	private function FetchDataInternal($Index)
	{
		if ($Index < $this->RecordCount()) {
			if (!isset($this->RecordList[$Index])) {
				//DB_FETCHMODE_ASSOC
				$Data = $this->ResultData->fetchRow(DB_FETCHMODE_ASSOC, $Index);
				$this->RecordList[$Index] = new RDataRecord($Data);
			}
			return $this->RecordList[$Index];
		}
		return null;		
	}
	
	
	
	//--------------------------------------------------------------
	//	Iterator implements
	//---------------------------------------------------------------
	
	/**
	 * Returns the current array element.
	 * @internal 
	 * @return mixed
	 */
	public function current()
	{		
		return $this->FetchDataInternal($this->IteratorCount);
	}
	/**
	 * Returns the key of the current array element.
	 * @internal 
	 * @return int
	 */
	public function key()
	{
		return $this->IteratorCount;
	}

	/**
	 * Moves the internal pointer to the next array element.
	 * @internal 
	 */
	public function next()
	{
		$this->IteratorCount++;
	}

	/**
	 * Rewinds internal array pointer.
	 * @internal 
	 */
	public function rewind()
	{
		$this->IteratorCount = 0;
	}

	/**
	 * Returns whether there is an element at current position.
	 * @internal 
	 * @return bool
	 */
	public function valid()
	{
		return $this->IteratorCount < $this->RecordCount();
	}	

	
	
	//--------------------------------------------------------------
	//	ArrayAccess implements
	//--------------------------------------------------------------
	
	/**
	 * Returns whether there is an element at the specified offset.
	 * @internal 
	 * @param string
	 * @return bool
	 */
	public function offsetExists($Offset)
	{
		return $Offset < $this->RecordCount();
	}

	/**
	 * Returns the element at the specified offset.
	 * This method should only be used by framework
	 * @param string
	 * @return mixed
	 */
	public function offsetGet($Offset)
	{
		if ($this->offsetExists($Offset)) {
			return $this->FetchDataInternal($Offset);
		}
		else {
			throw new RInvalidCollectionOffsetException($Offset);
		}
	}

	/**
	 * Required by interface.
	 * @internal 
	 * @param string
	 * @param mixed
	 */
	public function offsetSet($Offset, $Item)
	{
		throw new RReadOnlyCollectionException();
	}

	/**
	 * Required by interface.
	 * @internal 
	 * @param string
	 */
	public function offsetUnset($Offset)
	{
		throw new RReadOnlyCollectionException();
	}	
}
?>