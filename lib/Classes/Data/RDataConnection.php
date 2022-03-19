<?php
// app pear path in include_path


//$include_path .= ';'. ini_get('include_path');
//echo $include_path;
//ini_set('include_path', $include_path);

//require_once('/home/qantasgr/olc-test/lib/pear/DB.php');
require_once(DIR_LIB_PEAR.'DB.php');
require_once('RDataRecordSet.php');
require_once('RDataRecord.php');
require_once(DIR_LIB_CLASSES_EXCEPTION.'RDataException.php');


class RDataConnection
{
	/**
	 * @var DB_common
	 */
	private $Connection;
	
	/**
	 * Destructor
	 */
	public function __destruct()
	{
		//dprint_callstack();
		// close connection
		//if (DB::isConnection($this->Connection)) {
		//	$this->Connection->disconnect(); //Commented by meghna on 6th March 2006 11:37 
		//}
		//$this->Connection = null;
	}
	
	public function GetConnection()
	{
		return $this->Connection;
	}
	
	public function __construct()
	{
		//dprint_callstack();
	}

	/**
	 * Connect to database
	 *
	 * @param string $Type
	 * @param string $User
	 * @param string $Password
	 * @param string $Database
	 * @param string $Host
	 * @param string $Port0
	 */
	public function Connect($Type, $User, $Password, $Database, $Host = null, $Port = null)
	{
		//dprint_callstack();
		$ConnectionString = "$Type://$User:$Password@$Host/$Database";
		$db = new DB();
		
		if ($db->isConnection($this->Connection)) { 
			$this->Connection->disconnect();
		}
	
		
		$this->Connection = $db->connect($ConnectionString);
		/*echo "<pre>";
		print_r($this->Connection);
		echo "</pre>";
		exit();*/
		if ($db->isError($this->Connection)) {
			throw new RDataException('can not connect to db', $this->Connection);
		}
	}

	/**
	 * Execute query
	 *
	 * @param string $Query
	 * @return RDataRecordSet
	 */
	public function Execute($Query)
	{
		$db = new DB();
		if (!$db->isConnection($this->Connection)) {
			return;
		}
		$Result = $this->Connection->query($Query);
		/*echo "<pre>";
		print_r($Result);
		echo "</pre>";*/
		if ($db->isError($Result)) {
			throw new RDataException('Execute failed', $Result);
		}
		$RecordSet = new RDataRecordSet($Result, $this->Connection->affectedRows());
		return $RecordSet;
	}
	
	public function LastInsertedId()
	{
		$db = new DB();
		if (!$db->isConnection($this->Connection)) {
			return;
		}
		$last_insert_id = mysqli_insert_id($this->Connection->connection);
		if ($db->isError($last_insert_id)) {
			throw new RDataException('Execute failed', $last_insert_id);
		}
		return $last_insert_id;
		
	}
}
?>