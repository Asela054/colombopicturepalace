<?php

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

$table='tbl_print_stock';

$primaryKey='idtbl_print_stock';


$columns=array(

array(
'db'=>'mi.materialinfocode',
'dt'=>'code',
'field'=>'code',
'as'=>'code'
),


array(
'db'=>'mi.materialname',
'dt'=>'product_name',
'field'=>'product_name',
'as'=>'product_name'
),


array(
'db'=>'mg.group',
'dt'=>'category',
'field'=>'category',
'as'=>'category'
),


array(
'db'=>'s.batchno',
'dt'=>'batch',
'field'=>'batch',
'as'=>'batch'
),


array(
'db'=>'s.grndate',
'dt'=>'date',
'field'=>'date',
'as'=>'date'
),


array(
'db'=>'s.qty',
'dt'=>'qty',
'field'=>'qty',
'as'=>'qty'
),


array(
'db'=>'mt.measure_type',
'dt'=>'uom',
'field'=>'uom',
'as'=>'uom'
)

);


require('config.php');


$sql_details=array(
'user'=>$db_username,
'pass'=>$db_password,
'db'=>$db_name,
'host'=>$db_host
);


require('ssp.customized.class.php');


$conn=new mysqli($db_host,$db_username,$db_password,$db_name);

if($conn->connect_error){
	die(json_encode(array('error'=>'Database connection failed')));
}


// Get company_id passed from the view (which reads it from the CI session)
$companyID = isset($_POST['company_id']) ? $conn->real_escape_string($_POST['company_id']) : 0;


$where=array();

$where[]="s.status=1";

$where[]="mi.status=1";

$where[]="s.qty > 0";

$where[]="s.tbl_company_idtbl_company='".$companyID."'";



if(!empty($_POST['group']) && $_POST['group'] !== 'all'){

$group=$conn->real_escape_string($_POST['group']);

$where[]="mi.tbl_material_group_idtbl_material_group='".$group."'";

}



if(!empty($_POST['date_from'])){

$dateFrom=$conn->real_escape_string($_POST['date_from']);

$where[]="s.grndate >= '".$dateFrom."'";

}



if(!empty($_POST['date_to'])){

$dateTo=$conn->real_escape_string($_POST['date_to']);

$where[]="s.grndate <= '".$dateTo."'";

}



if(!empty($_POST['search'])){

$search=$conn->real_escape_string($_POST['search']);

$where[]="(
mi.materialname LIKE '%$search%'
OR
s.batchno LIKE '%$search%'
)";

}


$conn->close();


$extraWhere=implode(" AND ",$where);



$joinQuery="
FROM tbl_print_stock s

LEFT JOIN tbl_print_material_info mi
ON mi.idtbl_print_material_info=s.tbl_print_material_info_idtbl_print_material_info


LEFT JOIN tbl_material_group mg
ON mg.idtbl_material_group=mi.tbl_material_group_idtbl_material_group


LEFT JOIN tbl_measurements mt
ON mt.idtbl_mesurements=s.measure_type_id
";



echo json_encode(
SSP::simple(
$_POST,
$sql_details,
$table,
$primaryKey,
$columns,
$joinQuery,
$extraWhere
)
);