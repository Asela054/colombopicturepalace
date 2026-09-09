<?php
/*
 * DataTables example server-side processing script.
 */

// DB table to use
$table = 'tbl_location';

// Table's primary key
$primaryKey = 'idtbl_location';

// Array of database columns which should be read and sent back to DataTables.
$columns = array(
    array( 'db' => '`u`.`idtbl_location`', 'dt' => 'idtbl_location', 'field' => 'idtbl_location' ),
    array( 'db' => '`u`.`name`', 'dt' => 'location', 'field' => 'name' ), // Changed from location to name
    array( 'db' => '`u`.`sublocation`', 'dt' => 'sublocation', 'field' => 'sublocation' ),
    array( 'db' => '`u`.`location`', 'dt' => 'code', 'field' => 'location' ), // This is now the Site ID
    array( 'db' => '`u`.`warehouse_type`', 'dt' => 'warehouse_type', 'field' => 'warehouse_type' ),
    array( 'db' => '`u`.`capacity`', 'dt' => 'capacity', 'field' => 'capacity' ),
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

require('ssp.customized.class.php');

$joinQuery = "FROM `tbl_location` AS `u`";
$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>