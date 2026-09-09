<?php
/*
 * DataTables server-side processing script for allocations
 * No GRN / batch / rack any more — just material + site location.
 */

$table = 'tbl_allocation';
$primaryKey = 'idtbl_allocation';

$columns = array(
    array('db' => '`a`.`idtbl_allocation`', 'dt' => 'idtbl_allocation', 'field' => 'idtbl_allocation'),

    array('db' => '`m`.`materialname`',      'dt' => 'materialname',    'field' => 'materialname'),

    array('db' => '`l`.`location`',          'dt' => 'site_location',   'field' => 'location'),

    array('db' => '`a`.`qty`',               'dt' => 'qty',             'field' => 'qty'),

    array('db' => '`a`.`status`',            'dt' => 'status',          'field' => 'status'),

    array('db' => '`a`.`sorting_complete`',  'dt' => 'sorting_complete','field' => 'sorting_complete'),

    array('db' => '`a`.`insertdatetime`',    'dt' => 'insertdatetime',  'field' => 'insertdatetime',
          'formatter' => function($d) {
              return $d ? date('Y-m-d', strtotime($d)) : '';
          })
);

require('config.php');

$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

require('ssp.customized.class.php');

$joinQuery = "FROM `tbl_allocation` AS `a`
    LEFT JOIN `tbl_print_material_info` AS `m` ON `a`.`material_id`      = `m`.`idtbl_print_material_info`
    LEFT JOIN `tbl_location`            AS `l` ON `a`.`site_location_id` = `l`.`idtbl_location`";

$status = isset($_GET['status']) ? (int)$_GET['status'] : 1;
$extraWhere = "`a`.`status` = $status";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>