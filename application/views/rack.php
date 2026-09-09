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
                            <div class="page-header-icon"><i class="fas fa-boxes"></i></div>
                            <span>ZONE</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form id="zoneForm" action="<?php echo base_url() ?>Rack/Rackinsertupdate" method="post"
                                    autocomplete="off" novalidate>

                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Site / Warehouse </label>
                                        <select class="form-control form-control-sm" id="site_location"
                                            name="site_location" required>
                                            <option value="">Select Location</option>
                                            <?php foreach ($site_locations as $location): ?>
                                                <option value="<?php echo $location['idtbl_location']; ?>">
                                                    <?php echo htmlspecialchars($location['location_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold ">Zone Name*</label>
                                        <select class="form-control form-control-sm" name="zonename" id="zonename"
                                            required>
                                            <option value="" disabled selected>Select Zone</option>
                                            <option value="Incoming">Incoming</option>
                                            <option value="Processed">Processed</option>
                                            <option value="Temporary">Temporary</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold ">ZONE ID*</label>
                                        <input type="text" class="form-control form-control-sm" name="racknumber"
                                            id="racknumber" placeholder="e.g. ZONE-A" required>
                                    </div>

                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold ">Max Weight Capacity*</label>
                                        <input type="text" class="form-control form-control-sm" name="maxweight"
                                            id="maxweight" required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold ">Max Unit Capacity*</label>
                                        <input type="text" class="form-control form-control-sm" name="maxunit"
                                            id="maxunit" required>
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
                                                <th>Site / Warehouse</th>
                                                <th>Zone Name</th>
                                                <th>ZONE ID</th>
                                                <th>Max Weight</th>
                                                <th>Max Units</th>
                                                
                                                <th>Status</th>
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Zone Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Zone Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                {
                    extend: 'print',
                    title: 'Zone Information',
                    className: 'btn btn-primary btn-sm',
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function (win) {
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                },
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/racklist.php",
                type: "POST",
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
                    "data": "location",
                    "render": function (data, type, full) {
                        return data ? data : '-';
                    }
                },
              
                {
                    "data": "zone_name"
                },
                {
                    "data": "rack_number"
                },
                {
                    "data": "max_weight",
                    "render": function (data, type, full) {
                        return data ? data + ' kg' : '-';
                    }
                },
                {
                    "data": "max_unit",
                    "render": function (data, type, full) {
                        return data ? data + ' units' : '-';
                    }
                },
             
                {
                    "data": "status",
                    "render": function (data, type, full) {
                        if (data == 1) {
                            return '<span class="badge badge-success">Active</span>';
                        } else if (data == 2) {
                            return '<span class="badge badge-warning">Inactive</span>';
                        } else {
                            return '<span class="badge badge-danger">Deleted</span>';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function (data, type, full) {
                        var button = '';
                        button += '<button class="btn btn-primary btn-sm btnEdit mr-1 '; if (editcheck != 1) { button += 'd-none'; } button += '" id="' + full['idtbl_rack'] + '"><i class="fas fa-pen"></i></button>';
                        if (full['status'] == 1) {
                            button += '<a href="<?php echo base_url() ?>Rack/Rackstatus/' + full['idtbl_rack'] + '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 '; if (statuscheck != 1) { button += 'd-none'; } button += '"><i class="fas fa-check"></i></a>';
                        } else {
                            button += '<a href="<?php echo base_url() ?>Rack/Rackstatus/' + full['idtbl_rack'] + '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 '; if (statuscheck != 1) { button += 'd-none'; } button += '"><i class="fas fa-times"></i></a>';
                        }
                        button += '<a href="<?php echo base_url() ?>Rack/Rackstatus/' + full['idtbl_rack'] + '/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm '; if (deletecheck != 1) { button += 'd-none'; } button += '"><i class="fas fa-trash-alt"></i></a>';

                        return button;
                    }
                }
            ],
            drawCallback: function (settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#dataTable tbody').on('click', '.btnEdit', function () {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Rack/Rackedit',
                    success: function (result) {
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#zonename').val(obj.zone_name);
                        $('#site_location').val(obj.site_location);
                        $('#racknumber').val(obj.rack_number);
                        $('#maxweight').val(obj.max_weight);
                        $('#maxunit').val(obj.max_unit);

                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });

        function clearAllErrors() {
            $('.form-control').removeClass('is-invalid');
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

        $(document).on('input change', '.form-control', function () {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });

        $('#zoneForm').on('submit', function (e) {
            clearAllErrors();

            let hasError = false;

            let requiredFields = [
                { id: 'site_location', label: 'Site / Warehouse' },
                { id: 'zonename', label: 'Zone Name' },
                { id: 'racknumber', label: 'ZONE ID' },
                { id: 'maxweight', label: 'Max Weight Capacity' },
                { id: 'maxunit', label: 'Max Unit Capacity' }
            ];

            if (!validateFields(requiredFields)) {
                hasError = true;
            }

            // Validate numeric fields
            let maxWeight = $('#maxweight').val().trim();
            let maxUnit = $('#maxunit').val().trim();

            if (maxWeight && isNaN(maxWeight)) {
                showFieldError('maxweight', 'Max Weight must be a number');
                hasError = true;
            }

            if (maxUnit && isNaN(maxUnit)) {
                showFieldError('maxunit', 'Max Unit must be a number');
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
            }
        });
    });

    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this zone?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to active this zone?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this zone?");
    }
</script>
<?php include "include/footer.php"; ?>