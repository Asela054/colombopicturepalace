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
$table = 'tbl_grn_req';

// Table's primary key
$primaryKey = 'idtbl_grn_req';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_grn_req`', 'dt' => 'idtbl_grn_req', 'field' => 'idtbl_grn_req' ),
	array( 'db' => '`u`.`confirmstatus`', 'dt' => 'confirmstatus', 'field' => 'confirmstatus' ),
	array( 'db' => '`ua`.`employeename`', 'dt' => 'employeename', 'field' => 'employeename' ),
	array( 'db' => '`ua`.`empid`', 'dt' => 'empid', 'field' => 'empid' ),
	array( 'db' => '`ub`.`companyname`', 'dt' => 'companyname', 'field' => 'companyname' ),
	array( 'db' => '`uc`.`group`', 'dt' => 'group', 'field' => 'group' ),
	array( 'db' => '`u`.`company_id`', 'dt' => 'company_id', 'field' => 'company_id' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array(
        'db' => "CONCAT(
            CASE 
                WHEN `u`.`confirmstatus` = 1 THEN '<i class=\"fas fa-check text-success mr-2\"></i>Confirm Order Request'
                WHEN `u`.`confirmstatus` = 2 THEN '<i class=\"fa fa-times text-danger mr-2\"></i>Reject Order Request'
                ELSE '<i class=\"fa fa-spinner text-warning mr-2\"></i>Pending Order Request'
            END
        )",
        'dt' => 'confirmstatus_display',
        'field' => 'confirmstatus_display',
        'as' => 'confirmstatus_display'
		),
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

$joinQuery = "FROM `tbl_grn_req` AS `u` 
LEFT JOIN (SELECT `id`,`emp_id` AS `empid`,`emp_name_with_initial` AS `employeename` FROM `employees`) AS `ua` ON (`ua`.`id` = `u`.`employee_id`)  
LEFT JOIN (SELECT `idtbl_location`,`location` AS `companyname` FROM `tbl_location`) As `ub` ON  (`ub`.`idtbl_location` = `u`.`company_id`)  
LEFT JOIN `tbl_material_group` AS `uc` ON (`uc`.`idtbl_material_group` = `u`.`tbl_material_group_idtbl_material_group`)";

$extraWhere = "`u`.`status` IN (1,2)  AND `u`.`company_id`='$companyID'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
