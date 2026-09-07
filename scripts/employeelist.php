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
$table = 'employees';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// Only the text-field columns used on the Employee form/list are included here;
// add the dropdown-driven columns (emp_status, emp_job_code, emp_shift,
// emp_company, emp_department, emp_location, job_category_id) once those
// selects are wired up.
$columns = array(
	array( 'db' => '`u`.`id`', 'dt' => 'id', 'field' => 'id' ),
	array( 'db' => '`u`.`emp_etfno`', 'dt' => 'emp_etfno', 'field' => 'emp_etfno' ),
	array( 'db' => '`u`.`emp_id`', 'dt' => 'emp_id', 'field' => 'emp_id' ),
	array( 'db' => '`u`.`emp_fullname`', 'dt' => 'emp_fullname', 'field' => 'emp_fullname' ),
	array( 'db' => '`u`.`emp_mobile`', 'dt' => 'emp_mobile', 'field' => 'emp_mobile' ),
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

$joinQuery = "FROM `employees` AS `u`";
$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere)
);