<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
require_once("../lib/common.php");
// DB table to use
$table = 'km_grid';

// Table's primary key
$primaryKey = 'km_grid_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => 'km_grid_id', 'dt' => 0 ),
	array( 'db' => 'pickup_id',  'dt' => 1 ),
	array( 'db' => 'delivery_id',   'dt' => 2 ),
	array( 'db' => 'distance_in_km',     'dt' => 3 )
	);

// SQL server connection information
$sql_details = array(
	'user' => DATABASE_USERNAME,
	'pass' => DATABASE_PASSWORD,
	'db'   => DATABASE_NAME,
	'host' => DATABASE_HOST
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require('ssp.class.php');

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);


