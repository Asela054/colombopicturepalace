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
$table = 'tbl_print_stock';

// Table's primary key
$primaryKey = 'idtbl_print_stock';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_print_stock`', 'dt' => 'idtbl_print_stock', 'field' => 'idtbl_print_stock' ),
	array( 'db' => '`u`.`batchno`', 'dt' => 'batchno', 'field' => 'batchno' ),
	array( 'db' => '`u`.`qty`', 'dt' => 'qty', 'field' => 'qty' ),
	array( 'db' => '`ua`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname' ),
	array( 'db' => '`ub`.`machine`', 'dt' => 'machine', 'field' => 'machine' ),
    array( 'db' => '`uc`.`location`', 'dt' => 'location', 'field' => 'location' ),
	array( 'db' => '`u`.`unitprice`', 'dt' => 'unitprice', 'field' => 'unitprice' ),
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

$companyID = $_POST['company_id'];


$joinQuery = "FROM `tbl_print_stock` AS `u` LEFT JOIN `tbl_print_material_info` AS `ua` ON (`ua`.`idtbl_print_material_info` = `u`.`tbl_print_material_info_idtbl_print_material_info`) 
                LEFT JOIN `tbl_machine` AS `ub` ON (`ub`.`idtbl_machine` = `u`.`tbl_machine_id`)
                LEFT JOIN `tbl_location` AS `uc` ON (`uc`.`idtbl_location` = `u`.`location`)";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`tbl_company_idtbl_company`='$companyID'";
$groupBy ="`u`.`idtbl_print_stock`";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere,$groupBy)
);
