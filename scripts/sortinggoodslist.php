<?php

// Main table
$table = 'tbl_sorting_goods';

// Primary key
$primaryKey = 'idtbl_sorting_goods';

// Columns mapping (db → datatable)
$columns = array(
    array(
        'db' => 'sg.idtbl_sorting_goods',
        'dt' => 'id',
        'field' => 'idtbl_sorting_goods'
    ),
    array(
        'db' => 'sg.sorting_date',
        'dt' => 'sorting_date',
        'field' => 'sorting_date'
    ),

    array(
        'db' => 'sg.status',
        'dt' => 'status',
        'field' => 'status'
    ),
    array(
        'db' => 'u.username',
        'dt' => 'created_by',
        'field' => 'username'
    )
);

// DB connection
require('config.php');
$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db' => $db_name,
    'host' => $db_host
);

// JOIN query
$joinQuery = "
FROM tbl_sorting_goods AS sg
LEFT JOIN tbl_allocation AS al 
    ON al.idtbl_allocation = sg.allocation_id
LEFT JOIN tbl_user AS u 
    ON u.idtbl_user = sg.created_by
LEFT JOIN tbl_sorting_details AS sd
    ON sd.sorting_id = sg.idtbl_sorting_goods
";

// WHERE condition (exclude deleted)
$extraWhere = "sg.status <> 0";

// GROUP BY (important because of SUM)
$groupBy = "sg.idtbl_sorting_goods";

// Load SSP class
require('ssp.customized.class.php');

// Output
echo json_encode(
    SSP::simple(
        $_POST,
        $sql_details,
        $table,
        $primaryKey,
        $columns,
        $joinQuery,
        $extraWhere,
        $groupBy
    )
);
