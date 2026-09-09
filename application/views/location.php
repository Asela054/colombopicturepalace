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
                        <h1 class="page-header-title font-weight-light">
                            <div class="page-header-icon"><i class="fas fa-map-marker"></i></div>
                            <span>Stores Location</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="<?php echo base_url() ?>Location/Locationinsertupdate" method="post"
                                    autocomplete="off" novalidate id="locationForm">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Site name</label>
                                        <input type="text" class="form-control form-control-sm" name="name" id="name"
                                            required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Address</label>
                                        <input type="text" class="form-control form-control-sm" name="address"
                                            id="address" required>
                                    </div>

                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Warehouse Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="sublocation"
                                            id="sublocation" placeholder="e.g.WH-01 "  required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Site ID*</label>
                                        <input type="text" class="form-control form-control-sm" name="locationname"
                                            id="locationname" placeholder="e.g. SITE-DV-WG - WH-01" required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Warehouse Type</label>
                                        <select class="form-control form-control-sm" name="warehousetype"
                                            id="warehousetype" required>
                                            <option value="" disabled selected>Select Warehouse Type</option>
                                            <option value="Storage">Storage</option>
                                            <option value="Processing">Processing</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Capacity*</label>
                                        <input type="text" class="form-control form-control-sm" name="capacity"
                                            id="capacity" required>
                                    </div>



                                    <div class="form-group mt-2 text-right">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4" <?php if ($addcheck == 0) {
                                            echo 'disabled';
                                        } ?>><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1" required>
                                    <input type="hidden" name="recordID" id="recordID" value="" required>

                                </form>
                            </div>
                            <div class="col-9">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Site name </th>
                                                <th>Warehouse Name </th>
                                                <th>Site ID</th>
                                                <th>warehouse type</th>
                                                <th>capacity</th>
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
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function () {
        var addcheck = '<?php echo $addcheck; ?>';
        var editcheck = '<?php echo $editcheck; ?>';
        var statuscheck = '<?php echo $statuscheck; ?>';
        var deletecheck = '<?php echo $deletecheck; ?>';

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Location Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Location Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                {
                    extend: 'print',
                    title: 'Location Information',
                    className: 'btn btn-primary btn-sm',
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function (win) {
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                },
                // 'csv', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/locationlist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[1, "desc"]],
            "columns": [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "location"
                },
                {
                    "data": "sublocation"
                },
                {
                    "data": "code"
                },
                {
                    "data": "warehouse_type"
                },
                {
                    "data": "capacity"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function (data, type, full) {
                        var button = '';
                        button += '<button class="btn btn-primary btn-sm btnEdit mr-1 '; if (editcheck != 1) { button += 'd-none'; } button += '" id="' + full['idtbl_location'] + '"><i class="fas fa-pen"></i></button>';
                        if (full['status'] == 1) {
                            button += '<a href="<?php echo base_url() ?>Location/Locationstatus/' + full['idtbl_location'] + '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 '; if (statuscheck != 1) { button += 'd-none'; } button += '"><i class="fas fa-check"></i></a>';
                        } else {
                            button += '<a href="<?php echo base_url() ?>Location/Locationstatus/' + full['idtbl_location'] + '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 '; if (statuscheck != 1) { button += 'd-none'; } button += '"><i class="fas fa-times"></i></a>';
                        }
                        button += '<a href="<?php echo base_url() ?>Location/Locationstatus/' + full['idtbl_location'] + '/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm '; if (deletecheck != 1) { button += 'd-none'; } button += '"><i class="fas fa-trash-alt"></i></a>';

                        return button;
                    }
                }
            ],
            drawCallback: function (settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btnEdit', function () {
            var r = confirm("Are you sure, You want to Edit this? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Location/Locationedit',
                    success: function (result) {
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#name').val(obj.name);
                        $('#address').val(obj.address);
                        $('#sublocation').val(obj.sublocation);
                        $('#locationname').val(obj.locationname);
                        $('#warehousetype').val(obj.warehouse_type);
                        $('#capacity').val(obj.capacity);

                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });


        function clearAllErrors() {
            $('.form-control, textarea').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        }

        function showFieldError(fieldId, message) {
            let field = $('#' + fieldId);
            field.addClass('is-invalid');
            if (field.next('.invalid-feedback').length === 0) {
                field.after('<div class="invalid-feedback">' + message + '</div>');
            } else {
                field.next('.invalid-feedback').text(message);
            }
        }

        function validateFields(fieldConfigs) {
            let hasError = false;
            let firstErrorField = null;

            fieldConfigs.forEach(function (conf) {
                let field = $('#' + conf.id);
                let value = field.val() ? field.val().trim() : '';
                let errorMsg = null;

                if (value === '') {
                    errorMsg = conf.label + ' is required';
                } else if (conf.email) {
                    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        errorMsg = conf.label + ' must be a valid email address';
                    }
                }

                if (errorMsg) {
                    showFieldError(conf.id, errorMsg);
                    if (!firstErrorField) {
                        firstErrorField = field;
                    }
                    hasError = true;
                }
            });

            if (hasError && firstErrorField) {
                firstErrorField.focus();
                $('html, body').animate({
                    scrollTop: firstErrorField.offset().top - 150
                }, 500);
            }

            return !hasError;
        }

        $(document).on('input change', '.form-control, textarea', function () {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });

        $('#locationForm').on('submit', function (e) {
            clearAllErrors();

            let hasError = false;

            let requiredFields = [
                { id: 'name', label: 'Site name' },
                { id: 'address', label: 'Address' },
                { id: 'sublocation', label: 'Warehouse Name' },
                { id: 'locationname', label: 'Site ID' },
                { id: 'capacity', label: 'Capacity' }
            ];

            if (!validateFields(requiredFields)) {
                hasError = true;
            }

            let warehouseType = $('#warehousetype').val(); 
            if (!warehouseType) {
                showFieldError('Warehouse Type', 'Warehouse Type is required');
                if (!hasError) {
                    $('#warehousetype').focus();
                }
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
            }
        });
    });

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