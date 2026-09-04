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
$table = 'tbl_print_issue';

// Table's primary key
$primaryKey = 'idtbl_print_issue';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_print_issue`', 'dt' => 'idtbl_print_issue', 'field' => 'idtbl_print_issue' ),
	array( 'db' => '`uc`.`group`', 'dt' => 'group', 'field' => 'group' ),
	array( 'db' => '`u`.`issuedate`', 'dt' => 'issuedate', 'field' => 'issuedate' ),
	array( 'db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total' ),
	array( 'db' => '`u`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus' ),
	array( 'db' => '`u`.`issued_by`', 'dt' => 'issued_by', 'field' => 'issued_by' ),
	array( 'db' => '`loc`.`location`', 'dt' => 'location', 'field' => 'location' ),
	array( 'db' => '`dep`.`emp_name_with_initial`', 'dt' => 'emp_name_with_initial', 'field' => 'emp_name_with_initial' ),
	array( 'db' => '`dep`.`emp_id`', 'dt' => 'emp_id', 'field' => 'emp_id' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array( 'db' => '`u`.`tbl_grn_req_idtbl_grn_req`', 'dt' => 'tbl_grn_req_idtbl_grn_req', 'field' => 'tbl_grn_req_idtbl_grn_req' ),
	array(
        'db' => "CONCAT(
            CASE 
                WHEN `u`.`approvestatus` = 1 THEN '<i class=\"fas fa-check text-success mr-2\"></i>Approved'
                WHEN `u`.`approvestatus` = 2 THEN '<i class=\"fa fa-times text-danger mr-2\"></i>Rejected'
                ELSE '<i class=\"fa fa-spinner text-warning mr-2\"></i>Pending'
            END
        )",
        'dt' => 'approvestatus_display',
        'field' => 'approvestatus_display',
        'as' => 'approvestatus_display'
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

$joinQuery = "FROM `tbl_print_issue` AS `u` 
LEFT JOIN `tbl_location` AS `loc` ON (`loc`.`idtbl_location` = `u`.`location_id`) 
LEFT JOIN `employees` AS `dep` ON (`dep`.`id` = `u`.`employee_id`)
LEFT JOIN `tbl_material_group` AS `uc` ON (`uc`.`idtbl_material_group` = `u`.`ordertype`)";

$extraWhere = "`u`.`status` IN (1,2) AND `u`.`location_id`='$companyID'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
