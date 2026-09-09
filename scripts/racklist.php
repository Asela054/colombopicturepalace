<?php
/*
 * DataTables server-side processing script for Zone Management
 */

// DB table to use
$table = 'tbl_rack';

// Table's primary key
$primaryKey = 'idtbl_rack';

// Array of database columns
$columns = array(
    array( 'db' => '`u`.`idtbl_rack`', 'dt' => 'idtbl_rack', 'field' => 'idtbl_rack' ),
    array( 'db' => '`u`.`zone_name`', 'dt' => 'zone_name', 'field' => 'zone_name' ),
    array( 'db' => '`u`.`rack_number`', 'dt' => 'rack_number', 'field' => 'rack_number' ),
    array( 'db' => '`u`.`max_weight`', 'dt' => 'max_weight', 'field' => 'max_weight' ),
    array( 'db' => '`u`.`max_unit`', 'dt' => 'max_unit', 'field' => 'max_unit' ),
    array( 'db' => '`l`.`location`', 'dt' => 'location', 'field' => 'location' ),
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

// Include SSP class
require('ssp.customized.class.php' );

// Join query with location table
$joinQuery = "FROM `tbl_rack` AS `u` 
              LEFT JOIN `tbl_location` AS `l` ON `u`.`tbl_location_idtbl_location` = `l`.`idtbl_location`";

// Extra where condition
$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);