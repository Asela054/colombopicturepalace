<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title ">
                            <div class="page-header-icon"><i class="fas fa-shopping-basket"></i></div>
                            <span>Material Details</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-4">
                                <form action="<?php echo base_url() ?>Materialdetail/Materialdetailinsertupdate"
                                    method="post" autocomplete="off">
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Company*</label>
                                            <input type="text" id="f_company_name" name="f_company_name"
                                                class="form-control form-control-sm" required readonly>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Company
                                                Branch*</label>
                                            <input type="text" id="f_branch_name" name="f_branch_name"
                                                class="form-control form-control-sm" required readonly>
                                        </div>
                                    </div>
                                    <input type="hidden" name="f_company_id" id="f_company_id">
                                    <input type="hidden" name="f_branch_id" id="f_branch_id">
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold">Material Group*</label>
                                            <select class="form-control form-control-sm" name="materialgroup" id="materialgroup" required>
                                                <option value="">Select</option>
                                                <?php foreach($materialgroup->result() as $rowmaterialgroup){ ?>
                                                <option value="<?php echo $rowmaterialgroup->idtbl_material_group ?>">
                                                    <?php echo $rowmaterialgroup->group ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold">Material Category</label>
                                            <select class="form-control form-control-sm" name="materialcategory" id="materialcategory">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold">Material Color</label>
                                            <select class="form-control form-control-sm" name="material_color"
                                                id="material_color">
                                                <option value="">Select</option>
                                                <?php foreach($materialcolor->result() as $rowmaterialcolor){ ?>
                                                <option value="<?php echo $rowmaterialcolor->idtbl_color ?>">
                                                    <?php echo $rowmaterialcolor->color ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold">Material Category Gauge</label>
                                            <select class="form-control form-control-sm" name="material_categorygauge"
                                                id="material_categorygauge">
                                                <option value="">Select</option>
                                                <?php foreach($materialcategorygauge->result() as $rowmaterialcategorygauge){ ?>
                                                <option
                                                    value="<?php echo $rowmaterialcategorygauge->idtbl_categorygauge ?>">
                                                    <?php echo $rowmaterialcategorygauge->categorygauge_type ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                            <label class="small font-weight-bold">Material Name*</label>
                                            <input type="text" class="form-control form-control-sm" name="materialname"
                                                id="materialname" required>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold">Supplier</label>
                                            <select class="form-control form-control-sm" name="supplier" id="supplier">
                                                <option value="">Select</option>
                                                <?php foreach($supplierlist->result() as $rowsupplierlist){ ?>
                                                <option value="<?php echo $rowsupplierlist->idtbl_supplier ?>">
                                                    <?php echo $rowsupplierlist->suppliername ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold">Unit Price</label>
                                            <input type="text" class="form-control form-control-sm" name="unitprice"
                                                id="unitprice">
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold">Material Code</label>
                                            <input type="text" class="form-control form-control-sm" name="materialcode"
                                                id="materialcode">
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold">Re-order Level</label>
                                            <input type="text" class="form-control form-control-sm" name="reorder" id="reorder">
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Comment</label>
                                        <textarea class="form-control form-control-sm" name="comment"
                                            id="comment"></textarea>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold">Measurement</label>
                                            <select name="measurement" id="measurement" class="form-control form-control-sm">
                                                <option value="">Select</option>
                                                <?php foreach($measurement->result() as $rowmeasurement){ ?>
                                                <option value="<?php echo $rowmeasurement->idtbl_mesurements ?>"><?php echo $rowmeasurement->measure_type ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold">Account No</label>
                                            <select name="chartofdetailaccount" id="chartofdetailaccount" class="form-control form-control-sm" style="width: 100%;" required>
                                                <option value="">Select</option>
                                            </select>
                                            <input type="hidden" name="hiddenaccounttype" id="hiddenaccounttype" value="">
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 text-right">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
                                            <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-8">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Material Name</th>
                                                <th>Unit</th>
                                                <th>Material Group</th>
                                                <th>Code</th>
                                                <th>Category</th>
                                                <th>Unit Price</th>
                                                <th>Re Order</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Upload file</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <a href="<?php echo site_url('csv/samplematerialinfo.csv') ?>" download>Click here</a> to
                        download a Sample Csv
                    </div>
                </div>
                <form action="<?php echo base_url() ?>Materialdetail/Materialdetailupload" method="post"
                    enctype="multipart/form-data">
                    <div class="input-group input-group-sm">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="csvfile" name="csvfile"
                                aria-describedby="csvfile" required>
                            <label class="custom-file-label" for="csvfile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit" id="csvfile">Upload File</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Info -->
<div class="modal fade" id="materialinfomodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="staticBackdropLabel">ADD UOM QTY</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url() ?>Materialdetail/UOMqtyinsert" method="post" autocomplete="off">
                    <input type="hidden" id="all_uom_ids" name="all_uom_ids">
                    <div id="uomCheckboxes"></div>

                    <div class="form-group mt-3 text-right">
                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
                                <?php if($addcheck == 0) { echo 'disabled'; } ?>>
                            <i class="far fa-save"></i>&nbsp;Add
                        </button>
                    </div>

                    <input type="hidden" class="form-control form-control-sm" name="hiddenmaterialID" id="hiddenmaterialID">
                </form>
            </div>
        </div>
    </div>
</div>


<?php include "include/footerscripts.php"; ?>
<script>
$(document).ready(function() {
        $('#f_company_id').val('<?php echo ($_SESSION['company_id']); ?>');
        $('#f_company_name').val('<?php echo ($_SESSION['companyname']); ?>');
        $('#f_branch_id').val('<?php echo ($_SESSION['branch_id']); ?>');
        $('#f_branch_name').val('<?php echo ($_SESSION['branchname']); ?>');
});
</script>
<script>
$(document).ready(function() {
    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';

    $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        "buttons": [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                title: 'Material Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Material Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Material Information',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },
            // 'csv', 'pdf', 'print'
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/materialdetaillist.php",
            type: "POST", // you can use GET
            "data": function(d) {
                return $.extend({}, d, {
                    "company_id": '<?php echo ($_SESSION['company_id']); ?>',
                });
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [
            {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.settings._iRecordsDisplay - meta.row;
                    }
                },
            {
                "data": "materialname"
            },
            {
                "data": "measure_type"
            },
            {
                "data": "group"
            },
            {
                "data": "materialinfocode"
            },
            {
                "data": "paper"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    return 'Rs.' + addCommas(parseFloat(full['unitprice']).toFixed(2));
                }
            },
            {
                "className": 'text-right',
                "data": "reorderlevel"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button += '<button data-toggle="tooltip" data-placement="bottom" title="Add UOM" class="btn btn-dark btn-sm btnview mr-1" id="' +
                    	full['idtbl_print_material_info'] + '"><i class="fas fa-plus"></i></button>';
                    button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
                        if(editcheck==1){
							button+='<button type="button" data-toggle="tooltip" data-placement="bottom" title="Edit" class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['idtbl_print_material_info']+'"><i class="fas fa-pen"></i></button>';
						}
                        if (full['status'] == 1 && statuscheck == 1) {
                            button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Active" data-url="Materialdetail/Materialdetailstatus/' + full['idtbl_print_material_info'] + '/2" data-actiontype="2" class="btn btn-success btn-sm mr-1 btntableaction"><i class="fas fa-check"></i></button>';
                        } else if (full['status'] != 1 && statuscheck == 1) {
                            button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Deactive" data-url="Materialdetail/Materialdetailstatus/' + full['idtbl_print_material_info'] + '/1" data-actiontype="1" class="btn btn-warning btn-sm mr-1 btntableaction"><i class="fas fa-times"></i></button>';
                        }

                        if (deletecheck == 1) {
                            button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Delete" data-url="Materialdetail/Materialdetailstatus/' + full['idtbl_print_material_info'] + '/3" data-actiontype="3" class="btn btn-danger btn-sm btntableaction"><i class="fas fa-trash-alt"></i></button>';
                        }

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    var materialCategory;
    var materialColor;
    var materialCategoryGauge;
    var concatenatedValue;

    $('#materialgroup').change(function() {
        var id = $(this).val();
        Getmaterialcategorybygroup(id, '');
        $('#chartofdetailaccount').val(null).trigger('change');

        if(id==4){ 
            $('#material_color').prop('disabled', true);
            $('#material_categorygauge').prop('disabled', true);
            $('#chartofdetailaccount').prop('disabled', false);
        } else {
            $('#material_color').prop('disabled', false);
            $('#material_categorygauge').prop('disabled', false);
            $('#chartofdetailaccount').prop('disabled', true);
        }
    });

    $('#chartofdetailaccount').change(function() {
        var selectedOption = $(this).select2('data')[0];
        if (selectedOption && selectedOption.data) {
            $('#hiddenaccounttype').val(selectedOption.data.type);
        } else {
            $('#hiddenaccounttype').val('');
        }
    });

    $('#materialcategory, #material_color, #material_categorygauge').change(function() {
        updateMaterialName();
    });

    function updateMaterialName() {

        materialCategory = $('#materialcategory option:selected').text().trim();
        materialColor = $('#material_color option:selected').text().trim();
        materialCategoryGauge = $('#material_categorygauge option:selected').text().trim();

        concatenatedValue = materialCategory + ' ' + materialColor + ' ' + materialCategoryGauge;

        $('#materialname').val(concatenatedValue);
    }
    $('#dataTable tbody').on('click', '.btnEdit', async function () {
        var r = await Otherconfirmation("You want to Edit this ? ");
        if (r == true) {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Materialdetail/Materialdetailedit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    // checkfield(obj.materialcategory);
                    $('#recordID').val(obj.id);
                    $('#materialname').val(obj.materialname);
                    // $('#materialcategory').val(obj.materialcategory);
                    $('#material_color').val(obj.materialcolor);
                    $('#material_categorygauge').val(obj.materialcategorygauge);
                    $('#unitprice').val(obj.unitprice);
                    $('#materialcode').val(obj.materialcode);
                    $('#reorder').val(obj.reorderlevel);
                    $('#comment').val(obj.comment);
                    $('#supplier').val(obj.supplier);
                    $('#materialgroup').val(obj.materialgroup);
                    Getmaterialcategorybygroup(obj.materialgroup, obj.materialcategory);

                    if(obj.materialgroup==4){ 
                        $('#material_color').prop('disabled', true);
                        $('#material_categorygauge').prop('disabled', true);
                        $('#chartofdetailaccount').prop('disabled', false);
                    } else{
                        $('#material_color').prop('disabled', false);
                        $('#material_categorygauge').prop('disabled', false);
                        $('#chartofdetailaccount').prop('disabled', true);
                    }

                    var newOption = new Option(obj.account, obj.accountid, true, true);
                    $('#chartofdetailaccount').append(newOption).trigger('change');
                    var optionData = $('#chartofdetailaccount').select2('data');
                    var lastOption = optionData[optionData.length - 1]; 
                    lastOption.data = { type: obj.accounttype };
                    $('#chartofdetailaccount').trigger('change');  
                    $('#hiddenaccounttype').val(obj.accounttype);
                    $('#measurement').val(obj.idtbl_measurements);

                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        }
    });
    $('#dataTable tbody').on('click', '.btnview', function () {

        var id = $(this).attr('id');
        $('#hiddenmaterialID').val(id);

        $.ajax({
            url: '<?php echo base_url() ?>Materialdetail/Getadduomqty',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',

            success: function (response) {

                if (response.status === 'success') {

                    $('#uomCheckboxes').empty();

                    // Track unique UOM conversions
                    const uniqueUoms = new Set();

                    // Store all UOM IDs
                    let allUomIds = [];

                    response.uom_conversions.forEach(function (uom) {

                        allUomIds.push(uom.idtbl_uom_conversions);

                        // Skip duplicate conversions
                        if (uniqueUoms.has(uom.idtbl_uom_conversions)) {
                            return;
                        }

                        uniqueUoms.add(uom.idtbl_uom_conversions);

                        var checkedAttr = uom.is_checked == 1 ? 'checked' : '';

                        var checkbox = `
                            <div class="form-check p-2 border rounded bg-light mb-2 shadow-sm">
                                <input 
                                    class="form-check-input uomcheck"
                                    type="checkbox"
                                    name="uom_options[]"
                                    value="${uom.idtbl_uom_conversions}"
                                    id="uomCheckbox_${uom.idtbl_uom_conversions}"
                                    ${checkedAttr}
                                    style="transform: scale(1.2); margin-right: 10px;">

                                <label 
                                    class="form-check-label text-dark font-weight-bold"
                                    for="uomCheckbox_${uom.idtbl_uom_conversions}"
                                    style="cursor:pointer;">

                                    1 ${uom.main_uom} 
                                    <span class="text-muted">to</span> 
                                    ${uom.convert_uom}

                                    <span class="badge badge-danger ml-2">
                                        ${uom.qty}
                                    </span>

                                </label>
                            </div>
                        `;

                        $('#uomCheckboxes').append(checkbox);

                    });

                    // Save all ids to hidden field
                    $('#all_uom_ids').val(allUomIds.join(','));

                    // Show modal
                    $('#materialinfomodal').modal('show');

                } else {

                    alert(response.message);

                }
            },

            error: function (xhr, status, error) {

                console.error('AJAX Error:', error);
                console.error('XHR Object:', xhr);
                alert('Failed to retrieve data.');

            }

        });

    });
    $("#chartofdetailaccount").select2({
            // dropdownParent: $('#modalsegregation'),
            ajax: {
                url: "<?php echo base_url() ?>Materialdetail/Getaccountlist",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
                        companyid: '<?php echo $_SESSION['company_id']; ?>',
                        branchid: '<?php echo $_SESSION['branch_id']; ?>'
                    };
                },
                processResults: function (response) {
                    return {
                        results: response.map(function (item) {
                            return {
                                id: item.id,
                                text: item.text,
                                data: {
                                    type: item.acctype
                                }
                            };
                        })
                    }
                },
                cache: true
            },
        });
});

function Getmaterialcategorybygroup(recordID, value) {
    $.ajax({
        type: "POST",
        data: {
            recordID: recordID
        },
        url: '<?php echo base_url() ?>Materialdetail/Getmaterialcaregorybygroup',
        success: function(result) {
            var obj = JSON.parse(result);
            $('#materialcategory').empty();
            $('#materialcategory').append('<option value="">Select</option>');
            obj.forEach(function(item) {
                $('#materialcategory').append('<option value="' + item.idtbl_material_type + '">' + item.paper + '</option>');
            });

            if(value){
                $('#materialcategory').val(value); 
            }
        }
    });
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to active this?");
}

function delete_confirm() {
    return confirm("Are you sure you want to remove this?");
}
</script>
<?php include "include/footer.php"; ?>