<?php
/*
 * Modified server-side processing script with combined field for searching
 */

// DB table to use
$table = 'tbl_print_stock';

// Table's primary key
$primaryKey = 'idtbl_print_stock';

// Array of database columns which should be read and sent back to DataTables.
$columns = array(
    array('db' => '`u`.`idtbl_print_stock`', 'dt' => 'idtbl_print_stock', 'field' => 'idtbl_print_stock'),
    array('db' => '`u`.`batchno`', 'dt' => 'batchno', 'field' => 'batchno'),
    array('db' => '`ua`.`location`', 'dt' => 'location', 'field' => 'location'),
    array('db' => '`u`.`qty`', 'dt' => 'qty', 'field' => 'qty'),
    array('db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total'),
    array('db' => '`u`.`unitprice`', 'dt' => 'unitprice', 'field' => 'unitprice'),
    array('db' => '`uc`.`measure_type`', 'dt' => 'measure_type', 'field' => 'measure_type'),
    array('db' => '`ud`.`wh_name`', 'dt' => 'wh_name', 'field' => 'wh_name'),
    array('db' => '`ub`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname')
);

// SQL server connection information
require('config.php');
$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

require('ssp.customized.class.php');
$companyID = $_POST['company_id'];

$joinQuery = "FROM `tbl_print_stock` AS `u`
LEFT JOIN `tbl_location` As `ua` ON (`ua`.`idtbl_location` = `u`.`location`)
LEFT JOIN `tbl_print_material_info` As `ub` ON (`ub`.`idtbl_print_material_info` = `u`.`tbl_print_material_info_idtbl_print_material_info`)
LEFT JOIN `tbl_measurements` As `uc` ON (`uc`.`idtbl_mesurements` = `u`.`measure_type_id`)
LEFT JOIN `tbl_warehouse` As `ud` ON (`ud`.`idtbl_warehouse` = `u`.`warehouse_id`)";

$extraWhere = "`u`.`status` IN (1,2) AND `u`.`tbl_company_idtbl_company`='$companyID' AND `u`.`qty` > 0";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);