<?php
/**
 * @package RxCore.Exception
 *
 * @version $Id: RInvalidCollectionKeyException.php,v 1.1 2008-07-04 13:51:26 nitin Exp $ 
 *
 * Revision Histry:-
 * $Log: RInvalidCollectionKeyException.php,v $
 * Revision 1.1  2008-07-04 13:51:26  nitin
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
 * Invalid Offset provided to collection
 */
class RInvalidCollectionKeyException extends Exception
{
	function __construct($Key)
	{
		parent::__construct("Invalid Key '$Key'");
	}
}
?>