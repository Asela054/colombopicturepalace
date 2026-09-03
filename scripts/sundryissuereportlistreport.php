<?php

/*
 * DataTables server-side processing for the Sundry Items Issue Report
 */

// DB table to use
$table = 'tbl_print_issue';

// Table's primary key
$primaryKey = 'idtbl_print_issue';

// Columns read and sent back to DataTables
$columns = array(
    array('db' => 'u.idtbl_print_issue', 'dt' => 'idtbl_print_issue', 'field' => 'idtbl_print_issue'),
    array('db' => 'u.issuedate', 'dt' => 'issuedate', 'field' => 'issuedate'),
    array('db' => 'um.materialname', 'dt' => 'materialname', 'field' => 'materialname'),
    array('db' => 'mg.group', 'dt' => 'materialgroup', 'field' => 'materialgroup', 'as' => 'materialgroup'),
    array('db' => 'ud.batchno', 'dt' => 'batchno', 'field' => 'batchno'),
    array('db' => 'ud.qty', 'dt' => 'qty', 'field' => 'qty'),
    array('db' => 'ud.unitprice', 'dt' => 'unitprice', 'field' => 'unitprice'),
    array('db' => 'ud.total', 'dt' => 'total', 'field' => 'total'),
    array('db' => 'ue.emp_fullname', 'dt' => 'employee', 'field' => 'employee', 'as' => 'employee'),
    array('db' => 'u.approvestatus', 'dt' => 'approvestatus', 'field' => 'approvestatus'),
    array('db' => 'u.status', 'dt' => 'status', 'field' => 'status'),
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

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die(json_encode(array('error' => 'Database connection failed')));
}

// Get company_id passed from the view (which reads it from the CI session)
$companyID = isset($_POST['company_id']) ? $conn->real_escape_string($_POST['company_id']) : 0;

// build dynamic WHERE clause based on posted filters
$whereConds = array();
$whereConds[] = "u.status IN (1)";
$whereConds[] = "u.issued_by IN (1)";
$whereConds[] = "u.ordertype = 2"; // sundry order type
$whereConds[] = "um.tbl_company_idtbl_company = '".$companyID."'";

if (!empty($_POST['search_from_date']) && !empty($_POST['search_to_date'])) {
    $from = $conn->real_escape_string($_POST['search_from_date']);
    $to = $conn->real_escape_string($_POST['search_to_date']);
    $whereConds[] = "u.issuedate BETWEEN '$from' AND '$to'";
}

if (!empty($_POST['material'])) {
    $material = $conn->real_escape_string($_POST['material']);
    $whereConds[] = "um.materialname LIKE '%$material%'";
}

$conn->close();

$extraWhere = implode(' AND ', $whereConds);

$joinQuery = "FROM tbl_print_issue AS u
            LEFT JOIN (SELECT * FROM tbl_print_issuedetail WHERE status=1) AS ud ON (ud.tbl_print_issue_idtbl_print_issue = u.idtbl_print_issue)
            LEFT JOIN tbl_print_material_info AS um ON (um.idtbl_print_material_info = ud.tbl_print_material_info_idtbl_print_material_info)
            LEFT JOIN tbl_material_group AS mg ON (mg.idtbl_material_group = um.tbl_material_group_idtbl_material_group)
            LEFT JOIN employees AS ue ON (ue.id = u.employee_id)";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);