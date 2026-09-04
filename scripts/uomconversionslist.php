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

// DB table to use
$table = 'tbl_uom_conversions';

// Table's primary key
$primaryKey = 'idtbl_uom_conversions';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_uom_conversions`', 'dt' => 'idtbl_uom_conversions', 'field' => 'idtbl_uom_conversions' ),
    array( 'db' => '`mm`.`measure_type`', 'dt' => 'main_uom', 'field' => 'main_uom', 'as' => 'main_uom'  ),
    array( 'db' => '`cm`.`measure_type`', 'dt' => 'convert_uom', 'field' => 'convert_uom', 'as' => 'convert_uom'  ),
    array( 'db' => '`u`.`qty`', 'dt' => 'qty', 'field' => 'qty' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )

);

// SQL server connection information
require('config.php');
$sql_details = array(
	'user' => $db_username,
	'pass' => $db_password,
	'db'   => $db_name,
	'host' => $db_host
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `tbl_uom_conversions` AS `u`
JOIN `tbl_measurements` AS `mm` ON (`mm`.`idtbl_mesurements` = `u`.`main_uom`)
JOIN `tbl_measurements` AS `cm` ON (`cm`.`idtbl_mesurements` = `u`.`convert_uom`)";

$extraWhere = "`u`.`status` IN (1, 2)";


echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
