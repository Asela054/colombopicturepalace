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
                            <div class="page-header-icon"><i class="fas fa-user"></i></div>
                            <span>Employee</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <form action="<?php echo base_url() ?>Employee/Employeeinsertupdate" method="post" autocomplete="off">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">EPF No*</label>
                                        <input type="text" class="form-control form-control-sm" name="emp_etfno" id="emp_etfno" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Employee ID*</label>
                                        <input type="text" class="form-control form-control-sm" name="emp_id" id="emp_id" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">First Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="emp_first_name" id="emp_first_name" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Middle Name</label>
                                        <input type="text" class="form-control form-control-sm" name="emp_med_name" id="emp_med_name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Last Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="emp_last_name" id="emp_last_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Full Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="emp_fullname" id="emp_fullname" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Name with Initial*</label>
                                        <input type="text" class="form-control form-control-sm" name="emp_name_with_initial" id="emp_name_with_initial" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Calling Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="calling_name" id="calling_name" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Identity Card No*</label>
                                        <input type="text" class="form-control form-control-sm" name="emp_national_id" id="emp_national_id" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Date of Birth*</label>
                                        <input type="date" class="form-control form-control-sm" name="emp_birthday" id="emp_birthday" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Personal Number</label>
                                        <input type="text" class="form-control form-control-sm" name="tp1" id="tp1">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Mobile Number</label>
                                        <input type="text" class="form-control form-control-sm" name="emp_mobile" id="emp_mobile">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold">Office Extension</label>
                                        <input type="text" class="form-control form-control-sm" name="emp_work_phone_no" id="emp_work_phone_no">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 text-right">
                                <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
                                 <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Add</button>
                            </div>
                            <input type="hidden" name="recordOption" id="recordOption" value="1">
                            <input type="hidden" name="recordID" id="recordID" value="">
                        </form>
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap" id="tblemployee">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>EPF No</th>
                                        <th>Employee ID</th>
                                        <th>Full Name</th>
                                        <th>Mobile Number</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Profile View Modal -->
            <div class="modal fade" id="employeeProfileModal" tabindex="-1" role="dialog" aria-labelledby="employeeProfileModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title  text-white" id="employeeProfileModalLabel"><i class="fas fa-id-badge mr-2"></i>Employee Profile</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-3 mb-3"><small class="text-muted d-block">EPF No</small><span id="pv_emp_etfno">-</span></div>
                                <div class="col-md-3 mb-3"><small class="text-muted d-block">Employee ID</small><span id="pv_emp_id">-</span></div>
                                <div class="col-md-3 mb-3"><small class="text-muted d-block">First Name</small><span id="pv_emp_first_name">-</span></div>
                                <div class="col-md-3 mb-3"><small class="text-muted d-block">Middle Name</small><span id="pv_emp_med_name">-</span></div>

                                <div class="col-md-3 mb-3"><small class="text-muted d-block">Last Name</small><span id="pv_emp_last_name">-</span></div>
                                <div class="col-md-6 mb-3"><small class="text-muted d-block">Full Name</small><span id="pv_emp_fullname">-</span></div>
                                <div class="col-md-3 mb-3"><small class="text-muted d-block">Name with Initial</small><span id="pv_emp_name_with_initial">-</span></div>

                                <div class="col-md-3 mb-3"><small class="text-muted d-block">Calling Name</small><span id="pv_calling_name">-</span></div>
                                <div class="col-md-3 mb-3"><small class="text-muted d-block">Identity Card No</small><span id="pv_emp_national_id">-</span></div>
                                <div class="col-md-3 mb-3"><small class="text-muted d-block">Date of Birth</small><span id="pv_emp_birthday">-</span></div>
                                <div class="col-md-3 mb-3"><small class="text-muted d-block">Personal Number</small><span id="pv_tp1">-</span></div>

                                <div class="col-md-3 mb-3"><small class="text-muted d-block">Mobile Number</small><span id="pv_emp_mobile">-</span></div>
                                <div class="col-md-3 mb-3"><small class="text-muted d-block">Office Extension</small><span id="pv_emp_work_phone_no">-</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Employee Profile View Modal -->

		</main>
		<?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';
        var viewcheck='<?php echo isset($viewcheck) ? $viewcheck : 1; ?>';

        $('#tblemployee').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Employee Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Employee Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                {
                    extend: 'print',
                    title: 'Employee Information',
                    className: 'btn btn-primary btn-sm',
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    },
                },
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/employeelist.php",
                type: "POST",
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.settings._iRecordsDisplay - meta.row;
                    }
                },
                { "data": "emp_etfno" },
                { "data": "emp_id" },
                { "data": "emp_fullname" },
                { "data": "emp_mobile" },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        if(viewcheck==1){
                            button+='<button type="button" data-toggle="tooltip" data-placement="bottom" title="View Profile" class="btn btn-dark btn-sm btnView mr-1" id="'+full['id']+'"><i class="fas fa-eye"></i></button>';
                        }
                        if(editcheck==1){
							button+='<button type="button" data-toggle="tooltip" data-placement="bottom" title="Edit" class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['id']+'"><i class="fas fa-pen"></i></button>';
						}
                        if (full['status'] == 1 && statuscheck == 1) {
                            button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Active" data-url="Employee/Employeestatus/' + full['id'] + '/2" data-actiontype="2" class="btn btn-success btn-sm mr-1 btntableaction"><i class="fas fa-check"></i></button>';
                        } else if (full['status'] != 1 && statuscheck == 1) {
                            button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Deactive" data-url="Employee/Employeestatus/' + full['id'] + '/1" data-actiontype="1" class="btn btn-warning btn-sm mr-1 btntableaction"><i class="fas fa-times"></i></button>';
                        }
                        if (deletecheck == 1) {
                            button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Delete" data-url="Employee/Employeestatus/' + full['id'] + '/3" data-actiontype="3" class="btn btn-danger btn-sm btntableaction"><i class="fas fa-trash-alt"></i></button>';
                        }
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#tblemployee tbody').on('click', '.btnEdit', async function () {
            var r = await Otherconfirmation("You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Employee/Employeeedit',
                    success: function(result) {
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#emp_etfno').val(obj.emp_etfno);
                        $('#emp_id').val(obj.emp_id);
                        $('#emp_first_name').val(obj.emp_first_name);
                        $('#emp_med_name').val(obj.emp_med_name);
                        $('#emp_last_name').val(obj.emp_last_name);
                        $('#emp_fullname').val(obj.emp_fullname);
                        $('#emp_name_with_initial').val(obj.emp_name_with_initial);
                        $('#calling_name').val(obj.calling_name);
                        $('#emp_national_id').val(obj.emp_national_id);
                        $('#emp_birthday').val(obj.emp_birthday);
                        $('#tp1').val(obj.tp1);
                        $('#emp_mobile').val(obj.emp_mobile);
                        $('#emp_work_phone_no').val(obj.emp_work_phone_no);

                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });

        // View Profile modal
        $('#tblemployee tbody').on('click', '.btnView', function () {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Employee/Employeeview',
                success: function(result) {
                    var obj = JSON.parse(result);

                    function setVal(elId, val) {
                        $('#' + elId).text((val === null || val === undefined || val === '') ? '-' : val);
                    }

                    setVal('pv_emp_etfno', obj.emp_etfno);
                    setVal('pv_emp_id', obj.emp_id);
                    setVal('pv_emp_national_id', obj.emp_national_id);
                    setVal('pv_emp_first_name', obj.emp_first_name);
                    setVal('pv_emp_med_name', obj.emp_med_name);
                    setVal('pv_emp_last_name', obj.emp_last_name);
                    setVal('pv_emp_fullname', obj.emp_fullname);
                    setVal('pv_emp_name_with_initial', obj.emp_name_with_initial);
                    setVal('pv_calling_name', obj.calling_name);
                    setVal('pv_emp_birthday', obj.emp_birthday);
                    setVal('pv_tp1', obj.tp1);
                    setVal('pv_emp_mobile', obj.emp_mobile);
                    setVal('pv_emp_work_phone_no', obj.emp_work_phone_no);

                    $('#employeeProfileModal').modal('show');
                }
            });
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