<?php
/**
 * @package RxCore.Models
 *
 *
 * @version $Id: RModelCollection.php,v 1.1 2008-07-04 13:51:27 nitin Exp $ 
 *
 * Revision Histry:-
 * $Log: RModelCollection.php,v $
 * Revision 1.1  2008-07-04 13:51:27  nitin
 * *** empty log message ***
 *
 * Revision 1.1  2008-07-04 05:40:16  kruti
 * *** empty log message ***
 *
 * Revision 1.1  2007-06-16 11:06:29  kruti
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
require_once(DIR_LIB_CLASSES."RCollection.php");
class RModelCollection extends RCollection
{
	/**
	 * Constructor.
	 * @param mixed $Data 		initial collection data
	 * @param bool  $ReadOnly  	the collection is read-only
	 */
	public function __construct($Data = null, $ReadOnly = false)
	{
		parent::__construct($Data, $ReadOnly);
	}	
	
	
	// modify column
}
?>