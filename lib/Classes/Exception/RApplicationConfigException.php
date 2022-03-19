<?php
/**
 * @package RxCore.Exception
 *
 * @version $Id: RApplicationConfigException.php,v 1.1 2008-07-04 13:51:26 nitin Exp $ 
 *
 * Revision Histry:-
 * $Log: RApplicationConfigException.php,v $
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
 * This Exception generate, if Application Config not valid
 */
class RApplicationConfigException extends Exception
{
	const FILE_NOT_FOUND 			= 'File not found';
	const FILE_LOAD_FAILED 			= 'Error in loading file';
	const INVALID_APPLICATION_TAG 	= 'Application element must first';
	
	
	function __construct($CodeMessage) {
		parent::__construct($CodeMessage);		
	}
}
?>