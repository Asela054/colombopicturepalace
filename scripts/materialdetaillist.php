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
$table = 'tbl_print_material_info';

// Table's primary key
$primaryKey = 'idtbl_print_material_info';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_print_material_info`', 'dt' => 'idtbl_print_material_info', 'field' => 'idtbl_print_material_info' ),
	array( 'db' => '`u`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname' ),
	array( 'db' => '`u`.`materialinfocode`', 'dt' => 'materialinfocode', 'field' => 'materialinfocode' ),
	array( 'db' => '`u`.`reorderlevel`', 'dt' => 'reorderlevel', 'field' => 'reorderlevel' ),
	array( 'db' => '`u`.`comment`', 'dt' => 'comment', 'field' => 'comment' ),
	array( 'db' => '`u`.`unitprice`', 'dt' => 'unitprice', 'field' => 'unitprice' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array( 'db' => '`ub`.`paper`', 'dt' => 'paper', 'field' => 'paper' ),
	array( 'db' => '`uc`.`group`', 'dt' => 'group', 'field' => 'group' ),
	array( 'db' => '`ud`.`measure_type`', 'dt' => 'measure_type', 'field' => 'measure_type' )
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
$companyID = $_POST['company_id'];

$joinQuery = "FROM `tbl_print_material_info` AS `u`
LEFT JOIN `tbl_material_type` AS `ub` ON (`ub`.`idtbl_material_type` = `u`.`tbl_material_type_idtbl_material_type`)
LEFT JOIN `tbl_material_group` AS `uc` ON (`uc`.`idtbl_material_group` = `u`.`tbl_material_group_idtbl_material_group`)
LEFT JOIN `tbl_measurements` AS `ud` ON (`ud`.`idtbl_mesurements` = `u`.`tbl_measurements_idtbl_measurements`)";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`tbl_company_idtbl_company`='$companyID'";


echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
