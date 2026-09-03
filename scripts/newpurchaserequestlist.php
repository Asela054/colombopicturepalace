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
$table = 'tbl_print_porder_req';

// Table's primary key
$primaryKey = 'idtbl_print_porder_req';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_print_porder_req`', 'dt' => 'idtbl_print_porder_req', 'field' => 'idtbl_print_porder_req' ),
	array( 'db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date' ),
	array( 'db' => '`ub`.`branch`', 'dt' => 'branch', 'field' => 'branch' ),
	array( 'db' => '`u`.`confirmstatus`', 'dt' => 'confirmstatus', 'field' => 'confirmstatus' ),
	array( 'db' => '`u`.`porderconfirm`', 'dt' => 'porderconfirm', 'field' => 'porderconfirm' ),
	array( 'db' => '`u`.`porder_req_no`', 'dt' => 'porder_req_no', 'field' => 'porder_req_no' ),
	array( 'db' => '`uc`.`group`', 'dt' => 'group', 'field' => 'group' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array( 'db' => '`u`.`check_by`', 'dt' => 'check_by', 'field' => 'check_by' ),
	array( 'db' => '`ud`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array(
        'db' => "CONCAT(
            CASE 
                WHEN `u`.`confirmstatus` = 1 THEN '<i class=\"fas fa-check text-success mr-2\"></i>Confirm Order Request'
                WHEN `u`.`confirmstatus` = 2 THEN '<i class=\"fa fa-times text-danger mr-2\"></i>Reject Order Request'
                ELSE '<i class=\"fa fa-spinner text-warning mr-2\"></i>Pending Order Request for Approval'
            END
        )",
        'dt' => 'confirmstatus_display',
        'field' => 'confirmstatus_display',
        'as' => 'confirmstatus_display'
    )
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

$joinQuery = "FROM `tbl_print_porder_req` AS `u`
 LEFT JOIN `tbl_material_group` AS `uc` ON (`uc`.`idtbl_material_group` = `u`.`tbl_material_group_idtbl_material_group`)
 LEFT JOIN `tbl_company_branch` AS `ub` ON (`ub`.`idtbl_company_branch` = `u`.`tbl_company_branch_idtbl_company_branch`)
LEFT JOIN `tbl_user` AS `ud` ON (`ud`.`idtbl_user` = `u`.`check_by`)";

$extraWhere = "`u`.`status` IN (1,2) AND `u`.`tbl_company_idtbl_company`='$companyID'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
