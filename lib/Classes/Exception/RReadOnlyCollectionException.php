<?php
/**
 * @package RxCore.Exception
 *
 * @version $Id: RReadOnlyCollectionException.php,v 1.1 2008-07-04 13:51:27 nitin Exp $ 
 *
 * Revision Histry:-
 * $Log: RReadOnlyCollectionException.php,v $
 * Revision 1.1  2008-07-04 13:51:27  nitin
 * *** empty log message ***
 *
 * Revision 1.1  2008-07-04 05:40:50  kruti
 * *** empty log message ***
 *
 * Revision 1.1  2007-06-16 11:07:35  kruti
 * *** empty log message ***
 *
 * Revision 1.2  2006-08-11 14:34:38  chintan
 * *** empty log message ***
 *
 * Revision 1.1  2005/11/07 15:14:40  nitin
 * no message
 *
 *
 */ 

/**
 * Read only collection
 */
class RReadOnlyCollectionException extends Exception
{
	function __construct($Error = null)
	{
		if (is_string($Error)) {
			parent::__construct($Error);
		}
		else {
			parent::__construct("Read Only Collection");
		}
	}
}
?>