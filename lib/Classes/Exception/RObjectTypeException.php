<?php
/**
 * RObjectTypeException class file.
 *
 * @version 
 * @package RxCore.Exception
 */

/**
 * RObjectTypeException class
 * 
 * RObjectTypeException is raised when an expected object is of wrong type.
 *
 */

class RObjectTypeException extends Exception 
{
	
	/**
	 * Constructor.  //for RRequiredListValidator
	 * @internal 
	 * @param string the expected object type.
	 * @param string the actual object used.
	 */	
	function __construct($Expected, $Found)
	{
		parent::__construct("Expecting object of type '$Expected' but found '$Found'.");
	}
}

?>