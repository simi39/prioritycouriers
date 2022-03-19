<?php
/**
 * @package RxCore.Models
 *
 *
 * @version $Id: RMasterModel.php,v 1.1 2008-07-04 13:51:27 nitin Exp $ 
 *
 * Revision Histry:-
 * $Log: RMasterModel.php,v $
 * Revision 1.1  2008-07-04 13:51:27  nitin
 * *** empty log message ***
 *
 * Revision 1.1  2008-07-04 05:40:16  kruti
 * *** empty log message ***
 *
 * Revision 1.1  2007-06-16 11:06:29  kruti
 * *** empty log message ***
 *
 * Revision 1.3  2006-08-26 13:01:50  girish
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
require_once(DIR_LIB_CLASSES_DATA."RDataConnection.php");
require_once(DIR_LIB_CLASSES_MODELS."RModelCollection.php");
require_once(DIR_LIB_CLASSES."RCollection.php");
require_once(DIR_LIB_PEAR."DB.php");
abstract class RMasterModel
{
	public $Connection;
	
	public function __construct()
	{ 
		$this->Connection = new RDataConnection();	
		//Connect($Type, $User, $Password, $Database, $Host = null, $Port = null)

		$this->Connection->Connect(CONNECTION_TYPE,DATABASE_USERNAME,DATABASE_PASSWORD,DATABASE_NAME,DATABASE_HOST,DATABASE_PORT);
		
	}	
}

?>