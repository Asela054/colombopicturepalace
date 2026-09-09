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
                            <span>Sorting Goods</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">

                <!-- Create Sorting Goods Card -->
                <div class="card mb-3" id="createSortingCard">


                    <div class="card-body p-2">
                        <form id="sortingGoodsForm" autocomplete="off" novalidate>

                            <!-- SORTING HEADER -->
                            <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3">Sorting Header</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="small font-weight-bold">Sorting Date *</label>
                                    <input type="date" class="form-control form-control-sm" name="sorting_date"
                                        id="sorting_date" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="small font-weight-bold">Allocation *</label>
                                    <select class="form-control form-control-sm select2" name="allocation_id"
                                        id="allocation_id" required>
                                        <option value="">Select Allocation</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="small font-weight-bold">Job Card No</label>
                                    <input type="text" class="form-control form-control-sm" name="job_card_no"
                                        id="job_card_no" readonly>
                                </div>
                            </div>
                            <h6 class="font-weight-bold text-primary border-bottom pb-2 mt-4 mb-2">SITE & WAREHOUSE
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="small font-weight-bold">Site / Warehouse </label>
                                    <select class="form-control form-control-sm" id="site_location" name="site_location"
                                        required>
                                        <option value="">Select Location</option>
                                        <?php foreach ($site_locations as $location): ?>
                                            <option value="<?php echo $location['idtbl_location']; ?>">
                                                <?php echo htmlspecialchars($location['location_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>


                            </div>

                            <!-- INPUT MATERIAL -->
                            <h6 class="font-weight-bold text-primary border-bottom pb-2 mt-4 mb-2">Input Material (Auto)
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="small font-weight-bold">Input Material</label>
                                    <input type="text" class="form-control form-control-sm" name="input_material"
                                        id="input_material" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label class="small font-weight-bold">Input Qty</label>
                                    <input type="text" class="form-control form-control-sm" name="input_qty"
                                        id="input_qty" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label class="small font-weight-bold">Site / Warehouse Location</label>
                                    <input type="text" class="form-control form-control-sm" name="sitelocation"
                                        id="sitelocation" readonly>
                                </div>
                            </div>



                            <!-- OUTPUT MATERIAL -->
                            <h6 class="font-weight-bold text-primary border-bottom pb-2 mt-4 mb-2">Output Material Entry
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="small font-weight-bold">Output Material *</label>
                                    <select class="form-control form-control-sm select2" name="output_material_id"
                                        id="output_material_id" required>
                                        <option value="">Select Material</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="small font-weight-bold">Output Qty *</label>
                                    <input type="number" class="form-control form-control-sm" name="output_qty"
                                        id="output_qty" min="0.01" step="0.01" required>
                                </div>

                                <div class="col-md-5">
                                    <label class="small font-weight-bold">Remark</label>
                                    <input type="text" class="form-control form-control-sm" name="remark" id="remark"
                                        placeholder="Good / Mixed / Waste">
                                </div>
                            </div>

                            <div class="text-right mt-3">
                                <button type="button" class="btn btn-primary btn-sm px-4" id="addBtn">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                                <button type="button" class="btn btn-info btn-sm px-4" id="updateItemBtn"
                                    style="display:none;">
                                    <i class="fas fa-sync-alt"></i> Update
                                </button>
                            </div>


                            <!-- SORTING ITEMS TABLE -->
                            <h6 class="font-weight-bold text-primary border-bottom pb-2 mt-4 mb-2">Sorting Items</h6>
                            <div id="tableError" class="alert alert-danger mt-2" style="display:none;"></div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm nowrap"
                                    id="sortingItemsTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Output Material</th>
                                            <th class="text-right">Quantity</th>
                                            <th>Remark</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            <!-- ACTION BUTTONS -->
                            <input type="hidden" id="sortingId" name="sortingId">
                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary btn-sm px-5" id="submitBtn">
                                    <i class="fas fa-save"></i> Save Sorting
                                </button>
                                <button type="button" class="btn btn-info btn-sm px-5" id="updateBtn"
                                    style="display:none;">
                                    <i class="fas fa-save"></i> Update Sorting
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm px-5" id="cancelBtn"
                                    style="display:none;">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>

                        </form>
                    </div>
                </div>


                <!-- Sorting Records Table (Combined Pending and History) -->
                <div class="card">
                    <div class="card-header bg-white">
                        <h6 class="m-0 font-weight-bold">Sorting Records</h6>
                    </div>
                    <div class="card-body p-0 p-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm nowrap" id="sortingRecordsTable"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sorting Date</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- View Details Modal -->
                <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document"> <!-- Changed to modal-xl for more space -->
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalTitle">
                                    <i class="fas fa-boxes mr-2"></i>Sorting Details
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="modalBody">
                                <!-- Details will be loaded here -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>Close
                                </button>
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
        var editMode = false;
        var editingRowId = null;
        var rowCounter = 0;

        // Initialize Select2
        $('.select2').select2({
            width: '100%'
        });


        function clearAllErrors() {
            $('.form-control, select').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $('#tableError').hide().text('');
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

        function showTableError(message) {
            $('#tableError').text(message).show();
        }

        function validateHeaderFields() {
            clearAllErrors();

            let hasError = false;
            let firstErrorField = null;

            let requiredFields = [
                { id: 'sorting_date', label: 'Sorting Date' },
                { id: 'allocation_id', label: 'Allocation' },
                { id: 'site_location', label: 'Site / Warehouse' }
            ];

            requiredFields.forEach(function (conf) {
                let field = $('#' + conf.id);
                let value = field.val() ? field.val().trim() : '';

                if (value === '') {
                    showFieldError(conf.id, conf.label + ' is required');
                    if (!firstErrorField) firstErrorField = field;
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

        function validateItemFields() {
            clearAllErrors();

            let hasError = false;
            let firstErrorField = null;

            let requiredFields = [
                { id: 'output_material_id', label: 'Output Material' },
                { id: 'remark', label: 'Remark' },
                { id: 'output_qty', label: 'Output Qty', numeric: true }
            ];

            requiredFields.forEach(function (conf) {
                let field = $('#' + conf.id);
                let value = field.val() ? field.val().trim() : '';
                let errorMsg = null;

                if (value === '') {
                    errorMsg = conf.label + ' is required';
                } else if (conf.numeric) {
                    let num = parseFloat(value);
                    if (isNaN(num) || num <= 0) {
                        errorMsg = conf.label + ' must be greater than 0';
                    }
                }

                if (errorMsg) {
                    showFieldError(conf.id, errorMsg);
                    if (!firstErrorField) firstErrorField = field;
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

        function validateTableRules(inputQty) {
            let hasError = false;

            if (sortingTable.rows().count() === 0) {
                showTableError('Please add at least one output material');
                hasError = true;
            }

            let totalOutput = 0;
            sortingTable.rows().every(function () {
                totalOutput += parseFloat(this.data().quantity) || 0;
            });

            if (totalOutput > inputQty) {
                showTableError('Total output quantity cannot exceed input quantity (' + inputQty.toFixed(2) + ')');
                hasError = true;
            }

            if (hasError) {
                $('html, body').animate({
                    scrollTop: $('#sortingItemsTable').offset().top - 150
                }, 500);
            }

            return !hasError;
        }

        $(document).on('input change', '.form-control, select', function () {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
            $('#tableError').hide();
        });

        $('#allocation_id, #output_material_id').on('select2:select select2:clear', function () {
            $(this).removeClass('is-invalid');
            $(this).nextAll('.invalid-feedback').remove();
        });


        var sortingTable = $('#sortingItemsTable').DataTable({
            responsive: true,
            paging: false,
            searching: false,
            info: false,
            ordering: false,
            columns: [
                { data: 'index' },
                { data: 'material_name' },
                {
                    data: 'quantity',
                    className: 'text-right',
                    render: function (data) {
                        return parseFloat(data).toFixed(2);
                    }
                },
                { data: 'remark' },
                {
                    data: null,
                    className: 'text-center',
                    render: function (data, type, row) {
                        return '<button class="btn btn-info btn-sm btnEditRow mr-1" data-rowid="' + row.id + '" title="Edit Item"><i class="fas fa-edit"></i></button>' +
                            '<button class="btn btn-danger btn-sm btnRemoveRow" data-rowid="' + row.id + '" title="Remove Item"><i class="fas fa-trash-alt"></i></button>';
                    }
                }
            ]
        });


        var recordsTable = $('#sortingRecordsTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>scripts/sortinggoodslist.php",
                "type": "POST"
            },
            "columns": [
                {
                    "data": null,
                    "render": function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "sorting_date",
                    "render": function (data) {
                        return formatDate(data);
                    }
                },

                {
                    "data": "status",
                    "render": function (data) {
                        if (data == 1) return '<span class="badge badge-success">Approved</span>';
                        if (data == 2) return '<span class="badge badge-warning">Pending</span>';
                        if (data == 3) return '<span class="badge badge-danger">Rejected</span>';
                        return '<span class="badge badge-secondary">Deleted</span>';
                    }
                },
                { "data": "created_by" },
                {
                    "data": null,
                    "className": "text-center",
                    "render": function (data, type, row) {
                        var actions = '';

                        actions += '<button class="btn btn-primary btn-sm btnView mr-1" data-id="' + row.id + '" title="View Details"><i class="fas fa-eye"></i></button>';

                        if (row.status == 2) {
                            if (editcheck) {
                                actions += '<button class="btn btn-primary btn-sm btnEdit mr-1" data-id="' + row.id + '" title="Edit"><i class="fas fa-pen"></i></button>';
                            }
                            if (statuscheck) {
                                actions += '<button class="btn btn-success btn-sm btnApprove mr-1" data-id="' + row.id + '" title="Approve"><i class="fas fa-check"></i></button>';
                            }
                            if (deletecheck) {
                                actions += '<button class="btn btn-danger btn-sm btnDelete" data-id="' + row.id + '" title="Delete"><i class="fas fa-trash"></i></button>';
                            }
                        } else if (row.status == 1) {
                        }
                        return actions;
                    }
                }
            ],
            "order": [[1, "desc"]]
        });

        function formatDate(dateString) {
            if (!dateString) return '';
            var date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        }

        function loadActiveAllocations(callback) {
            $.ajax({
                url: '<?php echo base_url(); ?>SortingGoods/GetActiveAllocations',
                type: 'POST',
                success: function (response) {
                    var allocations = JSON.parse(response);
                    var options = '<option value="">Select Allocation</option>';

                    $.each(allocations, function (index, alloc) {
                        options += `
                    <option value="${alloc.idtbl_allocation}"
                        data-material="${alloc.material_name || ''}"
                        data-qty="${alloc.qty || 0}"
                        data-site_location="${alloc.site_location || ''}">
                        ALLOC-${alloc.idtbl_allocation} - ${alloc.material_name} - ${alloc.qty}
                    </option>`;
                    });

                    $('#allocation_id').html(options);

                    if (callback) callback();
                }
            });
        }


        function loadOutputMaterials() {
            $.ajax({
                url: '<?php echo base_url(); ?>SortingGoods/GetRawMaterials',
                type: 'POST',
                success: function (response) {
                    try {
                        var materials = JSON.parse(response);
                        var options = '<option value="">Select Material</option>';
                        $.each(materials, function (index, material) {
                            options += '<option value="' + material.idtbl_row_material + '">' + material.material_name + '</option>';
                        });
                        $('#output_material_id').html(options).trigger('change');
                    } catch (e) {
                        console.error('Error parsing materials:', e);
                    }
                },
                error: function () {
                    alert('Error loading materials');
                }
            });
        }
        function loadNextJobCardNo() {
            $.ajax({
                url: '<?php echo base_url(); ?>SortingGoods/GetNextJobCardNo',
                type: 'POST',
                success: function (response) {
                    try {
                        var data = JSON.parse(response);
                        $('#job_card_no').val(data.job_card_no);
                    } catch (e) {
                        console.error('Error loading job card number:', e);
                        $('#job_card_no').val('SORT-001');
                    }
                },
                error: function () {
                    console.error('Error fetching job card number');
                    $('#job_card_no').val('SORT-001');
                }
            });
        }

        loadNextJobCardNo();
        loadActiveAllocations();
        loadOutputMaterials();

        $('#allocation_id').change(function () {
            var selectedOption = $(this).find('option:selected');
            if (selectedOption.val()) {
                $('#input_material').val(selectedOption.data('material') || '');
                $('#input_qty').val(selectedOption.data('qty') || '0.00');
                $('#sitelocation').val(selectedOption.data('site_location') || '');
            } else {
                $('#input_material').val('');
                $('#input_qty').val('');
                $('#sitelocation').val('');
            }
        });

        $('#addBtn').click(function () {
            if (editMode && editingRowId !== null) {
                console.log(editMode, editingRowId);
                alert('Finish updating the item first');
                return;
            }
            if (!validateHeaderFields()) return;
            if (!validateItemFields()) return;
            addNewItemToTable();
        });


        $('#updateItemBtn').click(function () {
            if (!validateItemFields()) return;
            updateItemInTable();
        });

        function addNewItemToTable() {
            var allocationId = $('#allocation_id').val();
            var materialId = $('#output_material_id').val();
            var materialName = $('#output_material_id option:selected').text();
            var quantity = parseFloat($('#output_qty').val()) || 0;
            var remark = $('#remark').val().trim();
            var inputQty = parseFloat($('#input_qty').val()) || 0;

            if (!allocationId) {
                alert('Please select an allocation first');
                return;
            }

            if (!materialId) {
                alert('Please select an output material');
                return;
            }

            if (isNaN(quantity) || quantity <= 0) {
                alert('Please enter a valid quantity');
                return;
            }

            var totalOutput = 0;
            sortingTable.rows().every(function () {
                totalOutput += parseFloat(this.data().quantity);
            });

            // if ((totalOutput + quantity) > inputQty) {
            //     alert('Total output quantity cannot exceed input quantity (' + inputQty + ')');
            //     return;
            // }

            rowCounter++;
            var rowData = {
                id: 'row-' + rowCounter,
                index: sortingTable.rows().count() + 1,
                allocation_id: allocationId,
                material_id: materialId,
                material_name: materialName,
                quantity: quantity,
                remark: remark
            };

            sortingTable.row.add(rowData).draw();
            resetOutputForm();
        }

        function updateItemInTable() {
            if (!editingRowId) return;
            event?.preventDefault?.();

            var materialId = $('#output_material_id').val();
            var materialName = $('#output_material_id option:selected').text();
            var quantity = parseFloat($('#output_qty').val()) || 0;
            var remark = $('#remark').val().trim();
            var inputQty = parseFloat($('#input_qty').val()) || 0;

            if (!materialId) {
                alert('Please select an output material');
                return;
            }

            if (isNaN(quantity) || quantity <= 0) {
                alert('Please enter a valid quantity');
                return;
            }

            var totalOutput = 0;
            var oldQuantity = 0;  // Define oldQuantity here

            sortingTable.rows().every(function () {
                var rowData = this.data();
                if (rowData.id === editingRowId) {
                    oldQuantity = parseFloat(rowData.quantity);  // Store the old quantity
                } else {
                    totalOutput += parseFloat(rowData.quantity);
                }
            });

            // if ((totalOutput + quantity) > inputQty) {
            //     alert('Total output quantity cannot exceed input quantity (' + inputQty + ')');
            //     return;
            // }

            sortingTable.rows().every(function () {
                if (this.data().id === editingRowId) {
                    var data = this.data();
                    data.material_id = materialId;
                    data.material_name = materialName;
                    data.quantity = quantity;
                    data.remark = remark;
                    this.data(data);
                    return false;
                }
            });

            sortingTable.draw(false);
            resetOutputForm();
            $('#addBtn').show();
            $('#updateItemBtn').hide();
            editingRowId = null;
        }

        function resetOutputForm() {
            $('#output_material_id').val('').trigger('change');
            $('#output_qty').val('');
            $('#remark').val('');

            editingRowId = null;

            $('#addBtn').show();
            $('#updateItemBtn').hide();
        }

        function resetAllForm() {
            $('#sorting_date').val('<?php echo date('Y-m-d'); ?>');
            $('#allocation_id').val('').trigger('change');
            $('#job_card_no').val('');

            $('#input_material').val('');
            $('#input_qty').val('');
            $('#sitelocation').val('');

            resetOutputForm();

            sortingTable.clear().draw();
            rowCounter = 0;

            $('#submitBtn').show();
            $('#updateBtn').hide();
            $('#cancelBtn').hide();
            $('#addBtn').show();
            $('#updateItemBtn').hide();
            editMode = false;
            editingRowId = null;

            loadNextJobCardNo();

        }

        $('#sortingItemsTable tbody').on('click', '.btnRemoveRow', function () {
            var rowId = $(this).data('rowid');

            if (confirm('Are you sure you want to remove this item?')) {
                sortingTable.rows().every(function () {
                    if (this.data().id === rowId) {
                        this.remove().draw();

                        sortingTable.rows().every(function (rowIdx) {
                            this.data().index = rowIdx + 1;
                        });
                        sortingTable.draw(false);
                        return false;
                    }
                });
            }
        });

        $('#sortingItemsTable tbody').on('click', '.btnEditRow', function () {
            console.log("Click itme table edit");
            var rowId = $(this).data('rowid');
            var rowData = null;

            sortingTable.rows().every(function () {
                if (this.data().id === rowId) {
                    rowData = this.data();
                    return false;
                }
            });

            if (rowData) {
                $('#output_material_id').val(rowData.material_id).trigger('change');
                $('#output_qty').val(rowData.quantity);
                $('#remark').val(rowData.remark);

                editingRowId = rowId;
                $('#addBtn').hide();
                $('#updateItemBtn').show();
            }
        });

        $('#sortingGoodsForm').submit(function (e) {

            if (!e.originalEvent || !e.originalEvent.submitter ||
                e.originalEvent.submitter.id !== 'submitBtn') {
                e.preventDefault();
                return;
            }

            console.log("Click thisone");
            e.preventDefault();

            if (!validateHeaderFields()) return;
            if (editingRowId !== null) {
                alert('Please finish updating the item first');
                return false;
            }
            if (sortingTable.rows().count() === 0) {
                alert('Please add at least one output material');
                return;
            }

            if (!confirm('Are you sure you want to save this sorting?')) {
                return;
            }

            var sortingData = {
                sorting_date: $('#sorting_date').val(),
                allocation_id: $('#allocation_id').val(),
                site_location: $('#site_location').val(),
                job_card_no: $('#job_card_no').val(),
                items: sortingTable.rows().data().toArray()
            };

            $.ajax({
                url: '<?php echo base_url(); ?>SortingGoods/ProcessSorting',
                type: 'POST',
                data: sortingData,
                success: function (response) {
                    try {
                        var result = JSON.parse(response);
                        showNotification(result.message, result.type);

                        if (result.status) {
                            resetAllForm();
                            recordsTable.ajax.reload();
                            loadActiveAllocations();
                        }
                    } catch (e) {
                        showNotification('Error saving sorting', 'danger');
                    }
                },
                error: function () {
                    showNotification('Error saving sorting', 'danger');
                }
            });
        });

        $('#sortingRecordsTable tbody').on('click', '.btnView', function () {
            var sortingId = $(this).data('id');

            $.ajax({
                url: '<?php echo base_url(); ?>SortingGoods/GetSortingDetails',
                type: 'POST',
                data: { sorting_id: sortingId },
                success: function (response) {
                    try {
                        var details = JSON.parse(response);

                        let modalContent = `
                    <div class="container-fluid">
                        <h6 class="font-weight-bold border-bottom pb-2 mb-3">Sorting Header Information</h6>
                        <table class="table table-bordered table-sm mb-4">
                            <tr>
                                <th width="20%">Sorting ID:</th>
                                <td width="30%">#${details.header.idtbl_sorting_goods || sortingId}</td>
                                <th width="20%">Job Card No:</th>
                                <td width="30%">${details.header.job_card_no || 'N/A'}</td>
                            </tr>
                            <tr>
                                <th>Sorting Date:</th>
                                <td>${formatDate(details.header.sorting_date)}</td>
                                <th>Status:</th>
                                <td>${getStatusText(details.header.status)}</td>
                            </tr>
                            <tr>
                                <th>Created By:</th>
                                <td>${details.header.created_by || 'N/A'}</td>
                                <th>Created At:</th>
                                <td>${formatDateTime(details.header.created_at)}</td>
                            </tr>
                            ${details.header.approved_by ? `
                            <tr>
                                <th>Approved By:</th>
                                <td>${details.header.approved_by}</td>
                                <th>Approved At:</th>
                                <td>${formatDateTime(details.header.approved_at)}</td>
                            </tr>
                            ` : ''}
                        </table>

                        <h6 class="font-weight-bold border-bottom pb-2 mb-3">Location Information</h6>
                        <table class="table table-bordered table-sm mb-4">
                            <tr>
                                <th width="20%">Site Location:</th>
                                <td>${details.header.site_location_name || 'N/A'}</td>
                            </tr>
                        </table>

                        <h6 class="font-weight-bold border-bottom pb-2 mb-3">Input Material Details</h6>
                        <table class="table table-bordered table-sm mb-4">
                            <tr>
                                <th width="20%">Allocation:</th>
                                <td width="30%">${details.header.allocation_text || 'ALLOC-' + details.header.allocation_id}</td>
                                <th width="20%">Input Material:</th>
                                <td width="30%">${details.header.input_material || 'N/A'}</td>
                            </tr>
                            <tr>
                                <th>Input Quantity:</th>
                                <td colspan="3"><strong>${parseFloat(details.header.input_qty || 0).toFixed(2)}</strong></td>
                            </tr>
                        </table>

                        <h6 class="font-weight-bold border-bottom pb-2 mb-3">Output Materials</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Output Material</th>
                                        <th class="text-right">Quantity</th>
                                        <th>Remark</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                        if (details.details && details.details.length > 0) {
                            let totalOutputQty = 0;

                            $.each(details.details, function (index, item) {
                                totalOutputQty += parseFloat(item.quantity || 0);

                                modalContent += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.sorted_material_name || 'N/A'}</td>
                                <td class="text-right">${parseFloat(item.quantity).toFixed(2)}</td>
                                <td>${item.remark || '-'}</td>
                                <td>${getStatusText(item.status)}</td>
                            </tr>`;
                            });

                            modalContent += `
                        <tr class="font-weight-bold">
                            <td colspan="2" class="text-right">Total Output Quantity:</td>
                            <td class="text-right">${totalOutputQty.toFixed(2)}</td>
                            <td colspan="2"></td>
                        </tr>`;
                        } else {
                            modalContent += `
                        <tr>
                            <td colspan="5" class="text-center">No output materials found</td>
                        </tr>`;
                        }

                        modalContent += `
                                </tbody>
                            </table>
                        </div>

                        
                    </div>`;

                        $('#modalTitle').text('Sorting Details #' + sortingId + (details.header.job_card_no ? ' - ' + details.header.job_card_no : ''));
                        $('#modalBody').html(modalContent);
                        $('#detailsModal').modal('show');

                    } catch (e) {
                        console.error('Error parsing details:', e);
                        alert('Error loading details');
                    }
                },
                error: function () {
                    alert('Error loading sorting details');
                }
            });
        });

        // Helper function for status text
        function getStatusText(status) {
            switch (parseInt(status)) {
                case 1: return 'Approved';
                case 2: return 'Pending';
                case 3: return 'Rejected';
                case 0: return 'Deleted';
                default: return 'Unknown';
            }
        }

        // Helper function to format date time
        function formatDateTime(dateTimeString) {
            if (!dateTimeString) return 'N/A';
            var date = new Date(dateTimeString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Helper function to calculate total output
        function calculateTotalOutput(details) {
            if (!details || details.length === 0) return 0;
            let total = 0;
            $.each(details, function (index, item) {
                total += parseFloat(item.quantity || 0);
            });
            return total;
        }



        $('#sortingRecordsTable tbody').on('click', '.btnEdit', function () {
            var sortingId = $(this).data('id');

            $.ajax({
                url: '<?php echo base_url(); ?>SortingGoods/GetSortingForEdit',
                type: 'POST',
                data: { sorting_id: sortingId },
                success: function (response) {
                    try {
                        var data = JSON.parse(response);

                        if (!data.status) {
                            alert(data.message || 'Failed to load sorting');
                            return;
                        }

                        editMode = true;

                        $('#sorting_date').val(data.header.sorting_date.split(' ')[0]);
                        $('#job_card_no').val(data.header.job_card_no || 'SORT-001');
                        $('#site_location').val(data.header.site_location_id).trigger('change');

                        loadActiveAllocations(function () {

                            var allocationId =
                                data.header.allocation_id && data.header.allocation_id != 0
                                    ? data.header.allocation_id
                                    : data.items[0].allocation_id;

                            $('#allocation_id')
                                .val(allocationId)
                                .trigger('change');
                        });


                        sortingTable.clear().draw();
                        rowCounter = 0;


                        $.each(data.items, function (index, item) {
                            rowCounter++;

                            var rowData = {
                                id: 'row-' + rowCounter,
                                index: index + 1,
                                allocation_id: item.allocation_id,
                                material_id: item.sorted_material_id,
                                material_name: item.sorted_material_name,
                                quantity: parseFloat(item.quantity),
                                remark: item.remark
                            };

                            sortingTable.row.add(rowData).draw(false);
                        });


                        $('#submitBtn').hide();
                        $('#updateBtn').show().data('sorting-id', sortingId);
                        $('#cancelBtn').show();

                        alert('Sorting loaded for editing');

                    } catch (e) {
                        console.error(e);
                        alert('Invalid response while editing');
                    }
                }
            });
        });


        // Update sorting
        $('#updateBtn').click(function () {
            console.log("Update btn click ");
            var sortingId = $(this).data('sorting-id');

            if (sortingTable.rows().count() === 0) {
                alert('Please add at least one item');
                return;
            }

            if (!confirm('Are you sure you want to update this sorting?')) {
                return;
            }

            var updateData = {
                sorting_id: sortingId,
                sorting_date: $('#sorting_date').val(),
                allocation_id: $('#allocation_id').val(),
                site_location: $('#site_location').val(),
                items: sortingTable.rows().data().toArray()
            };

            $.ajax({
                url: '<?php echo base_url(); ?>SortingGoods/UpdateSorting',
                type: 'POST',
                data: updateData,
                success: function (response) {
                    try {
                        var result = JSON.parse(response);
                        showNotification(result.message, result.type);
                        if (result.status) {
                            resetAllForm();
                            recordsTable.ajax.reload();
                            loadActiveAllocations();
                        }
                    } catch (e) {
                        showNotification('Error processing response', 'danger');

                    }
                },
                error: function () {
                    showNotification('Error updating sorting', 'danger');

                }
            });
        });


        $('#cancelBtn').click(function () {
            if (confirm('Are you sure you want to cancel editing? All changes will be lost.')) {
                resetAllForm();
            }
        });


        $('#sortingRecordsTable tbody').on('click', '.btnApprove', function () {
            var sortingId = $(this).data('id');

            if (!confirm('Are you sure you want to approve this sorting?')) {
                return;
            }

            $.ajax({
                url: '<?php echo base_url(); ?>SortingGoods/ApproveSorting',
                type: 'POST',
                data: { sorting_id: sortingId },
                success: function (response) {
                    try {
                        var result = JSON.parse(response);

                        showNotification(result.message, result.type);
                        if (result.status) {
                            recordsTable.ajax.reload();
                        }
                    } catch (e) {
                        showNotification('Error processing response', 'danger');
                    }
                }
            });
        });

        // Reject sorting
        // $('#sortingRecordsTable tbody').on('click', '.btnReject', function () {
        //     var sortingId = $(this).data('id');

        //     if (!confirm('Are you sure you want to reject this sorting?')) {
        //         return;
        //     }

        //     $.ajax({
        //         url: '<?php echo base_url(); ?>SortingGoods/RejectSorting',
        //         type: 'POST',
        //         data: { sorting_id: sortingId },
        //         success: function (response) {
        //             try {
        //                 var result = JSON.parse(response);
        //                 alert(result.message);
        //                 if (result.status) {
        //                     recordsTable.ajax.reload();
        //                 }
        //             } catch (e) {
        //                 alert('Error processing response: ' + e);
        //             }
        //         }
        //     });
        // });

        // Delete sorting
        $('#sortingRecordsTable tbody').on('click', '.btnDelete', function () {
            var sortingId = $(this).data('id');

            if (!confirm('Are you sure you want to delete this sorting? This action cannot be undone.')) {
                return;
            }

            $.ajax({
                url: '<?php echo base_url(); ?>SortingGoods/DeleteSorting',
                type: 'POST',
                data: { sorting_id: sortingId },
                success: function (response) {
                    try {
                        var result = JSON.parse(response);
                        showNotification(result.message, result.type);
                        if (result.status) {
                            recordsTable.ajax.reload();

                        }
                    } catch (e) {
                        showNotification('Error processing response', 'danger');
                    }
                }
            });
        });


        function showNotification(message, type) {
            let alertClass = '';
            switch (type) {
                case 'success':
                    alertClass = 'alert-success';
                    break;
                case 'danger':
                    alertClass = 'alert-danger';
                    break;
                case 'warning':
                    alertClass = 'alert-warning';
                    break;
                case 'info':
                    alertClass = 'alert-info';
                    break;
                default:
                    alertClass = 'alert-info';
            }

            let alertHtml = `
<div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
     style="top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; min-width: 300px;">
    ${message}
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>`;


            $('body').append(alertHtml);

            setTimeout(() => {
                $('.alert').alert('close');
            }, 5000);
        }
    });
</script>