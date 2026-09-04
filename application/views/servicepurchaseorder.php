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
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-truck"></i></div>
                            <span>Service Purchase Order</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>P-Order Number</th>
                                                <th>Date</th>
                                                <th>Order Type</th>
                                                <th>Supplier</th>
                                                <th>Confirm Status</th>
                                                <th>Check By</th>
                                                <th>Total</th>
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
<div class="modal fade" id="porderEditmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Edit Purchase Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
						<form id="editcreateorderform" autocomplete="off">
							<div class="form-group mb-1">
                            <input type="hidden" class="form-control form-control-sm" name="hiddenporderid"
                            id="hiddenporderid" required>
                            <input type="hidden" class="form-control form-control-sm" name="hiddenporderreqid"
                            id="hiddenporderreqid" required>
								<label class="small font-weight-bold text-dark">Order Date*</label>
								<input type="date" class="form-control form-control-sm" placeholder="" name="editorderdate"
									id="editorderdate" value="<?php echo date('Y-m-d')?>" required>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold text-dark d-none">Company*</label>
								<input type="text" id="f_company_name" name="f_company_name"
									class="form-control form-control-sm d-none" required readonly>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold text-dark d-none">Company Branch*</label>
								<input type="text" id="f_branch_name" name="f_branch_name"
									class="form-control form-control-sm d-none" required readonly>
							</div>
							<input type="hidden" name="f_company_id" id="f_company_id">
							<input type="hidden" name="f_branch_id" id="f_branch_id">

							<div id="supplierFields">
								<div class="form-group mb-1">
									<label class="small font-weight-bold text-dark">Supplier*</label>
									<select class="form-control form-control-sm" name="editsupplier" id="editsupplier">
										<option value="">Select</option>
										 <?php foreach($supplierlist->result() as $rowsupplierlist){ ?>
										<option value="<?php echo $rowsupplierlist->idtbl_supplier ?>">
											<?php echo $rowsupplierlist->suppliername ?></option>
										<?php } ?> 
									</select>
								</div>
							</div>
                            <div class="form-group mb-1">
									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">PO Type*</label>
										<select class="form-control form-control-sm" name="editordertype" id="editordertype" required>
											<option value="">Select</option>
											<?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
											<option value="<?php echo $rowordertypelist->idtbl_material_group ?>">
												<?php echo $rowordertypelist->group ?></option>
											<?php } ?>
										</select>
									</div>
							</div>
							<div class="form-row mb-1">
								<div class="col" id="productFields">
									<div class="form-group mb-1">
										<label class="small font-weight-bold text-dark">Spare Parts / Service / Material
											/ Machine *</label>
										<select class="form-control form-control-sm selecter2 px-0" name="editproduct" id="editproduct">
											<option value="">Select</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col" id="editnewQtyFields">
									<label class="small font-weight-bold text-dark">Qty*</label>
									<input type="text" id="editnewqty" name="editnewqty" class="form-control form-control-sm" required>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">UOM*</label>
									<select class="form-control form-control-sm" name="edituom"
										id="edituom">
										<option value="">Select</option>
										<?php foreach($measurelist->result() as $rowmeasurelist){ ?>
										<option value="<?php echo $rowmeasurelist->idtbl_mesurements ?>">
											<?php echo $rowmeasurelist->measure_type ?></option>
										<?php } ?>
									</select>
								</div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Convert Qty</label>
                                    <div class="input-group">
                                        <input type="text" id="editpiecesper_qty" name="editpiecesper_qty"
                                            class="form-control form-control-sm" value="0" readonly>
                                        <input type="text" id="editpiecesper_qty_uom" name="editpiecesper_qty_uom"
                                            class="form-control form-control-sm" readonly>
                                    </div>
                                </div>
							</div>

							<div class="form-row mb-1">
                                    <label class="small font-weight-bold text-dark">Unit Price</label>
                                    <input type="text" id="editunitprice" name="editunitprice" class="form-control form-control-sm"
                                        value="0" step="any">
							</div>

							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark" hidden>Vat (%)</label>
									<input type="text" id="editvat" name="editvat" class="form-control form-control-sm" value="0"
										hidden>
								</div>

								<div class="col">
									<label class="small font-weight-bold text-dark" hidden>Discount</label>
									<input type="text" id="editdiscount" name="editdiscount" class="form-control form-control-sm"
										value="0" hidden>
								</div>
							</div>


							<div class="form-group mb-1">
								<label class="small font-weight-bold text-dark">Comment</label>
								<textarea name="editcomment" id="editcomment" class="form-control form-control-sm"></textarea>
							</div>
							<div class="form-group mt-3 text-right">
								<button type="button" id="editformsubmit" class="btn btn-primary btn-sm px-4"
									<?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add
									to
									list</button>
								<input name="editsubmitBtn" type="submit" value="Save" id="editsubmitBtn" class="d-none">
							</div>
						</form>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-7 col-xl-7">
							<div class="scrollbar pb-3" id="style-3">
								<table class="table table-striped table-bordered table-sm small" id="edittableorder">
									<thead>
										<tr>
											<th>Product / Service / Machine / Spare Parts</th>
											<th class="d-none">ProductID</th>
											<th class="text-center">Qty</th>
											<th class="text-center">Uom</th>
											<th class="text-right">Unit Price</th>
											<th class="d-none">HideTotal</th>
											<th class="text-right">Total</th>

										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						<div class="row">
							<div class="col text-right">
								<h6 class="font-weight-600" id="editdivgrosstotal" style="margin-top: 10px;"> Rs. 0.00</h6>

							</div>
							<input type="hidden" id="edithidegrosstotalorder" value="0">
						</div>
						<hr>
						<div class="form-group">
							<label class="small font-weight-bold text-dark">Remark</label>
							<textarea name="editremark" id="editremark" class="form-control form-control-sm"></textarea>
						</div>
						<div class="form-group mt-2">
							<button type="button" id="editbtncreateorder" class="btn btn-outline-primary btn-sm fa-pull-right"><i
									class="fas fa-save"></i>&nbsp;Update
								Purchase Order</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div id="purchaseview">
	<div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
		aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">View Purchase Order</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">

						<div class="col-12">
							<p style="margin-bottom: 2px;" class="text-left"><span id="pordersuppliername"></span>
							</P>
							<p style="margin-bottom: 2px;" class="text-left"><span id="pordersuppliercontact"></span>
							</p>
							<p style="margin-bottom: 2px;" class="text-left"><span id="porderaddress1"></span>
							</p>
							<p style="margin-bottom: 2px;" class="text-left"><span id="porderaddress2"></span>
							</p>
							<p style="margin-bottom: 2px;" class="text-left"><span id="pordercity"></span></p>
							<p style="margin-bottom: 2px;" class="text-left"><span id="porderstate"></span></p>
						</div>
					</div>
					<div id="viewhtml"></div>
                    <div class="col-12 text-right">
                        <hr>
                        <?php if($approvecheck==1){ ?>
                        <button id="btnapprovereject" class="btn btn-primary btn-sm px-3 mb-2"><i class="fas fa-check mr-2"></i>Approve or Reject</button>
                        <?php } ?>
                        <input type="hidden" name="porderid" id="porderid">
                        <input type="hidden" id="reqestid" name="reqestid">
                    </div>
                    <div class="col-12 text-center">
                        <div id="alertdiv"></div>
                    </div> 
                    <div class="col-12 text-center">
                        <div id="checkalertdiv"></div>
                    </div>

				</div>
			</div>
			<input type="hidden" class="form-control form-control-sm" name="tableId" id="tableId" required readonly>

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

    $("#editproduct").select2({
		dropdownParent: $('#porderEditmodal'),
		width: '100%',
		ajax: {
			url: "<?php echo base_url() ?>ServicePurchaseOrder/GetProductList",
			type: "post",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					searchTerm: params.term,  // search term
                    ordertype: $('#editordertype').val()
				};
			},
			processResults: function (response) {
				return {
					results: response
				};
			},
			cache: true
		}
	});


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
                title: 'Purchase Order Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Purchase Order Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Purchase Order Information',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/servicepurchaseorderlist.php",
            type: "POST", // you can use GET
            "data": function (d) {
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
                "data": "porder_no"
            },
            {
                "data": "orderdate"
            },
            {
                "data": "group"
            },
            {
                "data": "suppliername"
            },
            {
                "targets": -1,
                "className": '',
                "data": "confirmstatus_display",
                "render": function(data, type, row) {
                    return data;
                }
            },
                        {
                "data": "name"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    return addCommas(parseFloat(full['nettotal']).toFixed(2));
                }
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    if (full['servicepo_confirm'] == 0) {
                        button += '<button data-toggle="tooltip" data-placement="bottom" title="Edit" ' +
                                'class="btn btn-primary btn-sm btnEdit mr-1 ' + (editcheck != 1 ? 'd-none' : '') + '" ' +
                                'id="' + full['idtbl_print_porder'] + '">' +
                                '<i class="fas fa-pen"></i></button>';
                    }
                    button += '<button data-toggle="tooltip" data-placement="bottom" title="View PO" class="btn btn-dark btn-sm btnview mr-1" id="' + full['idtbl_print_porder'] + '" porder_no="' + full['porder_no'] + '" aproval_id="' + full['servicepo_confirm'] + '" request_id="' + full['tbl_print_porder_req_idtbl_print_porder_req'] +'"><i class="fas fa-eye"></i></button>';

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('#dataTable tbody').on('click', '.btnEdit', function () {
    	Swal.fire({
    		title: "Are you sure?",
    		text: "You want to edit this?",
    		icon: "warning",
    		showCancelButton: true,
    		confirmButtonColor: "#3085d6",
    		cancelButtonColor: "#d33",
    		confirmButtonText: "Yes, edit it!"
    	}).then((result) => {
    		if (result.isConfirmed) {
    			console.log("User confirmed the edit");

    			$('#porderEditmodal').modal('show');

    			var id = $(this).attr('id');
    			$.ajax({
    				type: "POST",
    				data: {
    					recordID: id
    				},
    				url: '<?php echo base_url() ?>ServicePurchaseOrder/Purchaseorderedit',
    				success: function (result) {
    					try {
    						var obj = JSON.parse(result);
    						console.log(obj);

    						$('#hiddenporderid').val(obj.id);
    						$('#hiddenporderreqid').val(obj.requestid);
    						$('#editorderdate').val(obj.orderdate);
    						$('#editsupplier').val(obj.supplier);
    						$('#editordertype').val(obj.type);

    						$('#edittableorder > tbody').empty();

    						if (obj.items && Array.isArray(obj.items)) {
    							obj.items.forEach(function (item) {

                                    var productID = item.materialID;
    								var product = item.material;
    								var comment = item.comment;
    								var uom = item.measure;
    								var uomID = item.measureID;
    								var unitprice = parseFloat(item.unitprice);
    								var netprice = parseFloat(item.netprice);
    								var pieces = item.pieces;
    								var newqty = parseFloat(item.qty);
    								var newtotal = parseFloat(unitprice * newqty);
    								var total = parseFloat(newtotal);
    								var showtotal = addCommas(parseFloat(netprice).toFixed(2));

    								$('#edittableorder > tbody:last').append(
    									'<tr class="pointer"><td>' + comment +
    									'</td><td class="d-none">' + comment +
    									'</td><td class="d-none">' + productID +
    									'</td><td class="text-center">' + newqty +
    									'</td><td class="text-center">' + uom +
    									'</td><td class="d-none">' + uomID +
    									'</td><td class="text-right">' +
    									parseFloat(unitprice).toFixed(2) + '</td><td class="edittotal d-none">' + netprice +
    									'</td><td class="text-right">' +
    									showtotal + '</td><td class="text-right d-none">' +
    									pieces + '</td></tr>'
    								);

    								var sum = 0;
    								$(".edittotal").each(function () {
    									sum += parseFloat($(this).text());
    								});

    								var showsum = addCommas(parseFloat(sum).toFixed(2));
    								$('#editdivgrosstotal').html('Rs. ' + showsum);
    								$('#edithidegrosstotalorder').val(sum);
    								$('#editproduct').focus();
    							});
    						} else {
    							console.error('Error: obj.items is undefined or not an array.');
    						}

    					} catch (e) {
    						console.error('Error parsing JSON:', e);
    					}
    				},
    				error: function (xhr, status, error) {
    					console.error('AJAX request error:', error);
    				}
    			});
    		} else {
    			console.log("User canceled the edit");
    		}
    	});
    });

    $('#dataTable tbody').on('click', '.btnview', function() {
        var id = $(this).attr('id');
        $('#porderid').val(id);
        var porderno = $(this).attr('porder_no');
        $('#reqestid').val($(this).attr('request_id'));
        $('#procode').html(porderno);

        var approvestatus = $(this).attr('aproval_id');
        var checkstatus = $(this).attr('check_status');

        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Purchaseorder/Purchaseorderview',
            success: function(result) { //alert(result);

                $('#porderviewmodal').modal('show');
                $('#viewhtml').html(result);

                if (approvestatus > 0) {
                	$('#btnapprovereject').addClass('d-none').prop('disabled', true);
                	if (approvestatus == 1) {
                		$('#alertdiv').html('<div class="alert alert-success" role="alert"><i class="fas fa-check-circle mr-2"></i> Purchase Order approved</div>');
                	} else if (approvestatus == 2) {
                		$('#alertdiv').html('<div class="alert alert-danger" role="alert"><i class="fas fa-times-circle mr-2"></i> Purchase Order rejected</div>');
                	}
                }
            }
        });

            $('#porderviewmodal').on('hidden.bs.modal', function (event) {
                $('#alertdiv').html('');
                $('#btnapprovereject').removeClass('d-none').prop('disabled', false);
            });

        $.ajax({
            type: "POST",
            data: {
                recordID: id
                // status_id: statusid
            },
            url: '<?php echo base_url() ?>Purchaseorder/porderviewheader',
            success: function(result) {
                // alert(result);
                var obj = JSON.parse(result);
                $('#porderdate').text(obj.orderdate);

                $('#pordersuppliername').text(obj.suppliername);
                $('#pordersuppliercontact').text(obj.suppliercontact);
                $('#porderaddress1').text(obj.address1);
                $('#porderaddress2').text(obj.address2);
                $('#pordercity').text(obj.city);
                $('#porderstate').text(obj.state);

                $('#viewcompanyname').text(obj.companyname);
                $('#viewbranchname').text(obj.branchname);
            }
        });
    });

    $('#btnapprovereject').click(function(){
        Swal.fire({
            title: "Do you want to approve this Purchase Order?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Approve",
            denyButtonText: `Reject`
        }).then((result) => {
            if (result.isConfirmed) {
                var confirmnot = 1;
                approvejob(confirmnot);
            } else if (result.isDenied) {
                var confirmnot = 2;
                approvejob(confirmnot);
            } 
        });
    });

    $("#editformsubmit").click(function() {
        if (!$("#editcreateorderform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#editsubmitBtn").click();
        } else {

                var productID = $('#editproduct').val();
                var comment = $('#editcomment').val();
                var product = $("#editproduct option:selected").text();
                var unitprice = parseFloat($('#editunitprice').val());
                var vat = parseFloat($('#editvat').val());
                var discount = parseFloat($('#editdiscount').val());
                var newqty = parseFloat($('#editnewqty').val());
                var uomID = $('#edituom').val();
                var pieces = parseFloat($('#editpiecesper_qty').val());
                var uom = $("#edituom option:selected").text();
                var newtotal;
                var newprice;
                if (pieces !== 0) {
                    newtotal = unitprice * pieces;
                    newprice = unitprice * pieces / newqty;
                } else {
                    newtotal = unitprice * newqty;
                    newprice = 0;
                }
                var vatamount = parseFloat(((newtotal - discount) / 100) * vat);
                var finaltotal = parseFloat((newtotal + vatamount) - discount);

                var totdiscount = parseFloat(discount);
                var totvat = parseFloat(vatamount);
                var total = parseFloat(newtotal);
                var finaltot = parseFloat(finaltotal);
                var showfinaltot = addCommas(parseFloat(finaltot).toFixed(2));
                var showtotal = addCommas(parseFloat(total).toFixed(2));
                var showtotdiscount = addCommas(parseFloat(totdiscount).toFixed(2));
                var showtotvat = addCommas(parseFloat(totvat).toFixed(2));


                $('#edittableorder > tbody:last').append('<tr class="pointer"><td>' + product +
                    '</td><td class="d-none">' +
                    comment + '</td><td class="d-none">' + productID +
                    '</td><td class="text-center">' + newqty +
                    '</td><td class="text-center">' + uom +
                    '</td><td class="d-none">' + uomID +
                    '</td><td class="text-right">' +
                    parseFloat(unitprice).toFixed(2) + '</td><td class="edittotal d-none">' + total +
                    '</td><td class="text-right">' +
                    showtotal + '</td><td class="text-right d-none">' +
                    pieces + '</td></tr>');

                $('#editproduct').val('');
                $('#editunitprice').val('');
                $('#editsaleprice').val('');
                $('#editcomment').val('');
                $('#edituom').val('');
                $('#editnewqty').val('0');
                $('#editdiscount').val('0');
                $('#editpiecesper_qty').val('0');
                $('#editpiecesper_qty_uom').val('');
                $('#editporderrequest').prop('readonly', true).css('pointer-events', 'none');


                var sum = 0;
                $(".edittotal").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showgrosstot = addCommas(parseFloat(sum).toFixed(2));

                $('#editdivgrosstotal').html(
                    '<strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<strong>Rs.<strong> <strong>' +
                    showgrosstot);
                $('#edithidegrosstotalorder').val(sum);
                $('#editproduct').focus();


                var sum = 0;
                $(".total_vat").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showtotvat = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotalvat').html('Vat Total &nbsp; &nbsp; Rs.' + showtotvat);
                $('#hidevatlorder').val(sum);
                $('#product').focus();

                var sum = 0;
                $(".total_discount").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showtotdiscount = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotaldiscount').html('Discount &nbsp; &nbsp; Rs.' + showtotdiscount);
                $('#hidediscountlorder').val(sum);
                $('#product').focus();

                var sum = 0;
                $(".final_total").each(function() {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotal').html(
                    '<strong style="background-color: yellow;">Final Price</strong> &nbsp; &nbsp;<strong>Rs.<strong> <strong>' +
                    showsum + '</strong>');
                $('#hidetotalorder').val(sum);
                $('#product').focus();
        }
    });

    $('#edittableorder').on('click', 'tr', function() {
        var r = confirm("Are you sure, You want to remove this product ? ");
        if (r == true) {
            $(this).closest('tr').remove();

            var sum = 0;
            $(".edittotal").each(function() {
                sum += parseFloat($(this).text());
            });

            var showsum = addCommas(parseFloat(sum).toFixed(2));

            $('#editdivgrosstotal').html('Rs. ' + showsum);
            $('#edithidegrosstotalorder').val(sum);
            $('#editproduct').focus();
        }
    });


    $('#editbtncreateorder').click(function () {
        $('#editbtncreateorder').prop('disabled', true).html(
            '<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order'
        );

        var jsonObj = [];
        $("#edittableorder tbody tr").each(function () {
            var item = {};
            $(this).find('td').each(function (col_idx) {
                item["col_" + (col_idx + 1)] = $(this).text();
            });
            jsonObj.push(item);
        });

        // If no rows in table
        if (jsonObj.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "No Data",
                text: "Please add items before updating an order.",
            });
            $('#editbtncreateorder').prop('disabled', false).html("Create Order");
            return;
        }

        var orderData = {
            tableData: jsonObj,
            orderdate: $('#editorderdate').val(),
            ordertype: $('#editordertype').val(),
            duedate: $('#editduedate').val(),
            total: $('#edithidetotalorder').val(),
            discounttotal: $('#edithidediscountlorder').val(),
            vatamounttotal: $('#edithidevatlorder').val(),
            grosstotal: $('#edithidegrosstotalorder').val(),
            remark: $('#editremark').val(),
            supplier: $('#editsupplier').val(),
            company_id: $('#f_company_id').val(),
            branch_id: $('#f_branch_id').val(),
            porderID: $('#hiddenporderid').val(),
            porderreqID: $('#hiddenporderreqid').val()
        };

        $.ajax({
            type: "POST",
            url: "ServicePurchaseOrder/Purchaseorderupdate",
            data: orderData,
            success: function (result) {
                $('#staticBackdrop').modal('hide');
                var response = JSON.parse(result);

                if (response.status == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Order Updated!",
                        text: "Purchase order updated successfully!",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Something went wrong. Please try again later.",
                    });
                }

                action(response.action);
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong. Please try again later.",
                });
            }
        });
    });

    $('#edituom').change(function () {
        let uomID = $(this).val();
        let productId = $('#editproduct').val();
        let qty = $('#editnewqty').val();

        $.ajax({
            type: "POST",
            url: 'ServicePurchaseOrder/Getpiecesforqty',
            data: {
                recordID: uomID,
                productId: productId,
                qty: qty
            },
            success: function (result) {
                var obj = JSON.parse(result);
                $('#editpiecesper_qty').val(obj.piecesper_qty);
                $('#editpiecesper_qty_uom').val(obj.measure_type);
            }
        });
    });

    $('#editproduct').change(function () {
    	var productID = $(this).val();
    	var ordertype = $('#editordertype').val();
    	var supplier = $('#editsupplier').val();

    		$.ajax({
    			type: "POST",
    			url: 'ServicePurchaseOrder/Getproductinfoaccoproduct',
    			data: {
    				recordID: productID,
    				supplier: supplier 			
                },
    			success: function (result) {
    				var obj = JSON.parse(result);
    				$('#editunitprice').val(obj.unitprice);
    			}
    		});
    });

});



function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to confirm this purchase order?");
}

function delete_confirm() {
    return confirm("Are you sure you want to remove this?");
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

function action(data) { //alert(data);
    var obj = JSON.parse(data);
    $.notify({
        // options
        icon: obj.icon,
        title: obj.title,
        message: obj.message,
        url: obj.url,
        target: obj.target
    }, {
        // settings
        element: 'body',
        position: null,
        type: obj.type,
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: "top",
            align: "center"
        },
        offset: 100,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
    });
}
function approvejob(confirmnot){
    Swal.fire({
        title: '',
        html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
        allowOutsideClick: false,
        showConfirmButton: false, // Hide the OK button
        backdrop: `
            rgba(255, 255, 255, 0.5) 
        `,
        customClass: {
            popup: 'fullscreen-swal'
        },
        didOpen: () => {
            document.body.style.overflow = 'hidden';

            $.ajax({
                type: "POST",
                data: {
                    porderid: $('#porderid').val(),
                    reqestid: $('#reqestid').val(),
                    confirmnot: confirmnot
                },
                url: '<?php echo base_url() ?>ServicePurchaseOrder/Purchaseorderstatus',
                success: function(result) {
                    Swal.close();
                    document.body.style.overflow = 'auto';
                    var obj = JSON.parse(result);
                    if(obj.status==1){
                        actionreload(obj.action);
                    }
                    else{
                        action(obj.action);
                    }
                },
                error: function(error) {
                    // Close the SweetAlert on error
                    Swal.close();
                    document.body.style.overflow = 'auto';
                    
                    // Show an error alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again later.'
                    });
                }
            });
        }
    });
}
</script>

<?php include "include/footer.php"; ?>